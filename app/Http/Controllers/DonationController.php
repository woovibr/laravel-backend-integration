<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Http\Requests\StoreDonationRequest;
use App\Models\Donation;
use OpenPix\PhpSdk\ApiErrorException;
use OpenPix\PhpSdk\Client;
use Psr\Http\Client\ClientExceptionInterface;

class DonationController extends Controller
{
    /**
     * Create a new `DonationController` instance.
     */
    public function __construct(private Client $openpix)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $donations = Donation::all();

        return view('donation.index', compact('donations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('donation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDonationRequest $request)
    {
        // A unique ID for the Woovi charge.
        // @see https://developers.openpix.com.br/en/docs/concepts/correlation-id
        $correlationID = Str::uuid()->toString();

        $value = $request->input('value');
        $comment = $request->input('comment', '');

        $donation = Donation::create([
            'value' => $value,
            'comment' => $comment,
            'correlationID' => $correlationID,
        ]);

        try {
            $createChargeResult = $this->openpix->charges()->create([
                'correlationID' => $correlationID,
                'value' => $value,
                'comment' => $comment,
            ]);
        } catch (ApiErrorException|ClientExceptionInterface $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', 'Unable to create Pix charge.');
        }

        $brCode = $createChargeResult['charge']['brCode'];

        $donation->brCode = $brCode;
        $donation->save();

        return redirect()->route('donation.show', [$donation]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Donation $donation)
    {
        return view('donation.show', compact('donation'));
    }
}
