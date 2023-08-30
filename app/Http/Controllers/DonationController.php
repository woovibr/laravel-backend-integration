<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenPix\PhpSdk\Client;

class DonationController extends Controller
{
    public function __construct(private Client $openpix)
    {}

    public function create()
    {
        $this->openpix->charges()->create([
            // Cria uma cobrança de 1 centavo.
            "value" => 1,
        ]);
    }
}
