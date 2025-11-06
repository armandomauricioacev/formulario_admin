<?php

namespace App\Http\Controllers;

use App\Models\Correo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CorreoController extends Controller
{
    /**
     * Muestra la vista de edición de correos (4 apartados, 2x2).
     */
    public function index()
    {
        $tipos = ['solicitante', 'coordinador', 'asistente', 'representante'];
        $registros = Correo::whereIn('tipo', $tipos)->get()->keyBy('tipo');

        $correos = [];
        foreach ($tipos as $t) {
            $correos[$t] = $registros[$t] ?? new Correo(['tipo' => $t]);
        }

        return view('correos', compact('correos'));
    }

    /**
     * Actualiza los correos para los cuatro tipos.
     */
    public function update(Request $request)
    {
        $tipos = ['solicitante', 'coordinador', 'asistente', 'representante'];

        // Validación básica por tipo (si viene, valida formato)
        foreach ($tipos as $t) {
            $request->validate([
                $t . '.titulo' => ['nullable', 'string', 'max:255'],
                $t . '.cuerpo' => ['nullable', 'string'],
                $t . '.despedida' => ['nullable', 'string', 'max:255'],
            ]);
        }

        DB::transaction(function () use ($request, $tipos) {
            foreach ($tipos as $t) {
                $data = $request->input($t, []);
                $registro = Correo::firstOrCreate(['tipo' => $t]);
                $registro->titulo = $data['titulo'] ?? '';
                $registro->cuerpo = $data['cuerpo'] ?? '';
                $registro->despedida = $data['despedida'] ?? '';
                $registro->save();
            }
        });

        return redirect()->route('correos')->with('success', 'Correos actualizados exitosamente.');
    }
}