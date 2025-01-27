<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller {
    public function comprasCliente($clienteId) {
        try {
            $compras = Order::with(['tipoEnvio'])->where('cliente_id', $clienteId)->orderBy('fecha', 'desc')->get();
            $compras->load('productosCompra.producto');

            if ($compras->isEmpty()) {
                return response()->json(['message' => 'No se encontraron compras para este cliente.'], 404);
            }

            $compras->transform(function ($order) {
                $order->tipo_envio_info = [
                    'id' => $order->tipoEnvio->id,
                    'nombre' => $order->tipoEnvio->nombre
                ];

                return $order;
            });

            return response()->json($compras, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al obtener las compras: ' . $e->getMessage()], 500);
        }
    }

    public function detalleCompra($clienteId) {
        try {
            $compras = Order::with(['tipoEnvio'])->where('cliente_id', $clienteId)->orderBy('fecha', 'desc')->get();
            $compras->load('productosCompra.producto');

            if ($compras->isEmpty()) {
                return response()->json(['message' => 'No se encontraron compras para este cliente.'], 404);
            }

            $compras->transform(function ($order) {
                $order->tipo_envio_info = [
                    'id' => $order->tipoEnvio->id,
                    'nombre' => $order->tipoEnvio->nombre
                ];

                return $order;
            });
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al obtener las compras: ' . $e->getMessage()], 500);
        }
    }
}
