<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use OpenPix\PhpSdk\Client;

class WebhookController extends Controller
{
    const SIGNATURE_HEADER = "x-webhook-signature";

    const TEST_WEBHOOK_EVENT = "teste_webhook";

    const OPENPIX_CHARGE_COMPLETED_EVENT = "OPENPIX:CHARGE_COMPLETED";

    const OPENPIX_TRANSACTION_RECEIVED_EVENT = "OPENPIX:TRANSACTION_RECEIVED";

    /**
     * Create a new `WebhookController` instance.
     */
    public function __construct(protected Client $openpix)
    {
    }

    /**
     * Main endpoint to receive webhooks.
     */
    public function receive(Request $request)
    {
        if ($response = $this->allowRequestOnlyFromOpenPix($request)) return $response;

        return $this->handleWebhook($request);
    }

    /**
     * Allow requests only from OpenPix.
     */
    private function allowRequestOnlyFromOpenPix(Request $request)
    {
        $rawPayload = $request->getContent();
        $signature = $request->header(self::SIGNATURE_HEADER);

        $isWebhookValid = ! empty($rawPayload)
            && ! empty($signature)
            && $this->openpix->webhooks()->isWebhookValid($rawPayload, $signature);

        if ($isWebhookValid) return null;

        return response()->json([
            "errors" => [
                [
                    "message" => "Invalid webhook signature."
                ],
            ],
        ], 400);
    }

    /**
     * Handle webhook when a charge was paid.
     */
    public function handleChargePaidWebhook(Request $request)
    {
        $correlationID = $request->input("charge.correlationID");

        $donation = Donation::where("correlationID", $correlationID)->first();

        if (empty($donation)) {
            return response()->json([
                "errors" => [
                    [
                        "message" => "Donation not found.",
                    ],
                ],
            ], 404);
        }

        $donation->status = "PAID";
        $donation->save();

        return response()->json(["message" => "Success."]);
    }

    /**
     * Handles the test webhook.
     */
    private function handleTestWebhook()
    {
        return response()->json(["message" => "Success."]);
    }

    /**
     * Checks if the webhook is from when a charge was paid.
     */
    private function isChargePaidPayload(Request $request)
    {
        $event = $request->input("evento");

        $allowedEvents = [
            self::OPENPIX_CHARGE_COMPLETED_EVENT,
            self::OPENPIX_TRANSACTION_RECEIVED_EVENT,
        ];

        $isChargePaidEvent = ! empty($event) && in_array($event, $allowedEvents);

        return $isChargePaidEvent
            && ! empty($request->input("charge.correlationID"));
    }

    /**
     * Checks if the webhook is of test type.
     *
     * The OpenPix platform can send a test webhook to verify the webhook URL.
     */
    private function isTestPayload(Request $request)
    {
        $event = $request->input("evento");

        return ! empty($event) && $event === self::TEST_WEBHOOK_EVENT;
    }

    /**
     * Dispatch a webhook handler by the webhook type.
     */
    private function handleWebhook(Request $request)
    {
        if ($this->isChargePaidPayload($request)) {
            return $this->handleChargePaidWebhook($request);
        }

        if ($this->isTestPayload($request)) {
            return $this->handleTestWebhook();
        }

        return response()->json([
            "errors" => [
                [
                    "message" => "Invalid webhook type.",
                ],
            ]
        ], 400);
    }
}
