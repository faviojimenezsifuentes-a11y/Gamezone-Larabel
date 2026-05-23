<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TipoCambioService
{
    public function obtenerTipoCambio(): float
    {
        try {
            $response = Http::get('https://open.er-api.com/v6/latest/USD');

            if ($response->successful()) {
                $data = $response->json();

                return $data['rates']['PEN'] ?? 3.75;
            }
        } catch (\Exception $e) {
            return 3.75;
        }

        return 3.75;
    }

    public function solesADolares(float $precioSoles): float
    {
        $tipoCambio = $this->obtenerTipoCambio();

        return round($precioSoles / $tipoCambio, 2);
    }
}
