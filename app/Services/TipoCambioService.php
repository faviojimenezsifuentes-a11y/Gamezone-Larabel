<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class TipoCambioService
{
    public function obtenerTipoCambio(): float
    {
        return Cache::remember('tipo_cambio_usd_pen', 3600, function () {
            try {
                $response = Http::timeout(5)->get('https://open.er-api.com/v6/latest/USD');

                if ($response->successful()) {
                    $data = $response->json();

                    return (float) ($data['rates']['PEN'] ?? 3.75);
                }
            } catch (\Exception $e) {
                return 3.75;
            }

            return 3.75;
        });
    }

    public function solesADolares(float $precioSoles): float
    {
        $tipoCambio = $this->obtenerTipoCambio();

        return round($precioSoles / $tipoCambio, 2);
    }
}
