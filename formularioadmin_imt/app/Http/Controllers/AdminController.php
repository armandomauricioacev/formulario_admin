<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coordinaciones;
use App\Models\EntidadesProcedencia;
use App\Models\Servicios;
use App\Models\SolicitudesServicio;

class AdminController extends Controller
{
    // ========== MÉTODOS EXISTENTES (STUB) ==========
    public function dependenciasIndex()
    {
        // Método stub para evitar errores
        return view('dashboard');
    }

    public function dependenciaStore(Request $request)
    {
        // Método stub para evitar errores
        return redirect()->back();
    }

    public function dependenciaUpdate(Request $request, $dependencia)
    {
        // Método stub para evitar errores
        return redirect()->back();
    }

    public function dependenciaDestroy($dependencia)
    {
        // Método stub para evitar errores
        return redirect()->back();
    }

    public function tramitesIndex()
    {
        // Método stub para evitar errores
        return view('dashboard');
    }

    public function tramitesStore(Request $request)
    {
        // Método stub para evitar errores
        return redirect()->back();
    }

    public function tramitesEdit($tramite)
    {
        // Método stub para evitar errores
        return view('dashboard');
    }

    public function tramitesUpdate(Request $request, $tramite)
    {
        // Método stub para evitar errores
        return redirect()->back();
    }

    public function tramitesDestroy($tramite)
    {
        // Método stub para evitar errores
        return redirect()->back();
    }

    public function lineasCapturadasIndex()
    {
        // Método stub para evitar errores
        return view('dashboard');
    }

    public function lineasCapturaDeleteFiltered(Request $request)
    {
        // Método stub para evitar errores
        return redirect()->back();
    }

    public function lineaCapturaDestroy($linea)
    {
        // Método stub para evitar errores
        return redirect()->back();
    }

    // ========== MÉTODOS PARA COORDINACIONES ==========
    public function coordinacionesIndex()
    {
        $coordinaciones = Coordinaciones::orderBy('nombre')->get();

        // Obtener valores globales de representante (si existen en alguna coordinación)
        $global = Coordinaciones::select('representante', 'correo_representante')
            ->where(function ($q) {
                $q->whereNotNull('representante')
                  ->orWhereNotNull('correo_representante');
            })
            ->orderByDesc('id')
            ->first();

        $globalRepresentante = $global->representante ?? '';
        $globalCorreoRepresentante = $global->correo_representante ?? '';

        return view('coordinacion', compact('coordinaciones', 'globalRepresentante', 'globalCorreoRepresentante'));
    }

    public function coordinacionesStore(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:coordinaciones,nombre',
            'coordinador' => 'nullable|string|max:255',
            'correo_coordinador' => 'nullable|email|max:255',
            'asistente' => 'nullable|string|max:255',
            'correo_asistente' => 'nullable|email|max:255',
            'representante' => 'nullable|string|max:255',
            'correo_representante' => 'nullable|email|max:255',
        ]);

        try {
            // Tomar valores globales de representante si no vienen en la petición
            $global = Coordinaciones::select('representante', 'correo_representante')
                ->where(function ($q) {
                    $q->whereNotNull('representante')
                      ->orWhereNotNull('correo_representante');
                })
                ->orderByDesc('id')
                ->first();

            $rep = $request->input('representante', $global->representante ?? null);
            $repCorreo = $request->input('correo_representante', $global->correo_representante ?? null);

            Coordinaciones::create([
                'nombre' => $request->nombre,
                'coordinador' => $request->coordinador,
                'correo_coordinador' => $request->correo_coordinador,
                'asistente' => $request->asistente,
                'correo_asistente' => $request->correo_asistente,
                'representante' => $rep,
                'correo_representante' => $repCorreo,
                'fecha_creacion' => now(),
            ]);

            return redirect()->route('coordinaciones')
                ->with('success', 'Coordinación creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('coordinaciones')
                ->with('error', 'Error al crear la coordinación: ' . $e->getMessage());
        }
    }

    public function coordinacionesUpdate(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:coordinaciones,nombre,' . $id,
            'coordinador' => 'nullable|string|max:255',
            'correo_coordinador' => 'nullable|email|max:255',
            'asistente' => 'nullable|string|max:255',
            'correo_asistente' => 'nullable|email|max:255',
        ]);

        try {
            $coordinacion = Coordinaciones::findOrFail($id);
            $coordinacion->update([
                'nombre' => $request->nombre,
                'coordinador' => $request->coordinador,
                'correo_coordinador' => $request->correo_coordinador,
                'asistente' => $request->asistente,
                'correo_asistente' => $request->correo_asistente,
            ]);

            return redirect()->route('coordinaciones')
                ->with('success', 'Coordinación actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('coordinaciones')
                ->with('error', 'Error al actualizar la coordinación: ' . $e->getMessage());
        }
    }

    public function coordinacionesDestroy($id)
    {
        try {
            $coordinacion = Coordinaciones::findOrFail($id);
            $coordinacion->delete();

            return redirect()->route('coordinaciones')
                ->with('success', 'Coordinación eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('coordinaciones')
                ->with('error', 'Error al eliminar la coordinación: ' . $e->getMessage());
        }
    }

    /**
     * Actualiza el representante y correo representante de forma global
     * aplicándolo a todas las coordinaciones.
     */
    public function coordinacionesRepresentativeUpdate(Request $request)
    {
        $request->validate([
            'representante' => 'nullable|string|max:255',
            'correo_representante' => 'nullable|email|max:255',
        ]);

        try {
            Coordinaciones::query()->update([
                'representante' => $request->representante,
                'correo_representante' => $request->correo_representante,
            ]);

            return redirect()->route('coordinaciones')
                ->with('success', 'Representante actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('coordinaciones')
                ->with('error', 'Error al actualizar el representante: ' . $e->getMessage());
        }
    }

    // ========== MÉTODOS PARA ENTIDADES DE PROCEDENCIA ==========
    public function entidadesProcedenciaIndex()
    {
        $entidades = EntidadesProcedencia::orderBy('nombre')->get();
        return view('entidadprocedencia', compact('entidades'));
    }

    public function entidadesProcedenciaStore(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        try {
            EntidadesProcedencia::create([
                'nombre' => $request->nombre,
                'fecha_creacion' => now(),
            ]);

            return redirect()->route('entidades-procedencia')
                ->with('success', 'Entidad de procedencia creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('entidades-procedencia')
                ->with('error', 'Error al crear la entidad: ' . $e->getMessage());
        }
    }

    public function entidadesProcedenciaUpdate(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        try {
            $entidad = EntidadesProcedencia::findOrFail($id);
            $entidad->update([
                'nombre' => $request->nombre,
            ]);

            return redirect()->route('entidades-procedencia')
                ->with('success', 'Entidad de procedencia actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('entidades-procedencia')
                ->with('error', 'Error al actualizar la entidad: ' . $e->getMessage());
        }
    }

    public function entidadesProcedenciaDestroy($id)
    {
        try {
            $entidad = EntidadesProcedencia::findOrFail($id);
            $entidad->delete();

            return redirect()->route('entidades-procedencia')
                ->with('success', 'Entidad de procedencia eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('entidades-procedencia')
                ->with('error', 'Error al eliminar la entidad: ' . $e->getMessage());
        }
    }

    // ========== MÉTODOS PARA SERVICIOS ==========
    public function serviciosIndex()
    {
        $servicios = Servicios::with('coordinacionPredeterminada')->orderBy('nombre')->get();
        $coordinaciones = Coordinaciones::orderBy('nombre')->get();
        return view('servicios', compact('servicios', 'coordinaciones'));
    }

    public function serviciosStore(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'coordinacion_predeterminada_id' => 'nullable|exists:coordinaciones,id',
            'descripcion' => 'nullable|string',
        ]);

        try {
            Servicios::create([
                'nombre' => $request->nombre,
                'coordinacion_predeterminada_id' => $request->coordinacion_predeterminada_id,
                'descripcion' => $request->descripcion,
                'fecha_creacion' => now(),
            ]);

            return redirect()->route('servicios')
                ->with('success', 'Servicio creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('servicios')
                ->with('error', 'Error al crear el servicio: ' . $e->getMessage());
        }
    }

    public function serviciosUpdate(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'coordinacion_predeterminada_id' => 'nullable|exists:coordinaciones,id',
            'descripcion' => 'nullable|string',
        ]);

        try {
            $servicio = Servicios::findOrFail($id);
            $servicio->update([
                'nombre' => $request->nombre,
                'coordinacion_predeterminada_id' => $request->coordinacion_predeterminada_id,
                'descripcion' => $request->descripcion,
            ]);

            return redirect()->route('servicios')
                ->with('success', 'Servicio actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('servicios')
                ->with('error', 'Error al actualizar el servicio: ' . $e->getMessage());
        }
    }

    public function serviciosDestroy($id)
    {
        try {
            $servicio = Servicios::findOrFail($id);
            $servicio->delete();

            return redirect()->route('servicios')
                ->with('success', 'Servicio eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('servicios')
                ->with('error', 'Error al eliminar el servicio: ' . $e->getMessage());
        }
    }

    // ========== MÉTODOS PARA SOLICITUDES DE SERVICIOS ==========
    public function solicitudesServiciosIndex()
    {
        $solicitudes = SolicitudesServicio::with(['entidadProcedencia', 'servicio', 'coordinacion'])
            ->orderBy('fecha_solicitud', 'desc')
            ->get();

        // Lista de coordinaciones para el filtro del select en la vista
        $coordinaciones = Coordinaciones::orderBy('nombre')->get();

        return view('solicitudes_servicios', compact('solicitudes', 'coordinaciones'));
    }

    public function solicitudesServiciosDestroy($id)
    {
        try {
            $solicitud = SolicitudesServicio::findOrFail($id);
            $solicitud->delete();

            return redirect()->route('solicitudes')
                ->with('success', 'Solicitud eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('solicitudes')
                ->with('error', 'Error al eliminar la solicitud: ' . $e->getMessage());
        }
    }

    /**
     * Marca una solicitud como revisada.
     */
    public function solicitudesServiciosMarkReviewed($id)
    {
        try {
            $solicitud = SolicitudesServicio::findOrFail($id);
            $solicitud->estatus = SolicitudesServicio::ESTATUS_REVISADO;
            $solicitud->fecha_actualizacion = now();
            $solicitud->save();

            // Respuesta JSON para facilitar actualización con Alpine
            return response()->json([
                'id' => $solicitud->id,
                'estatus' => $solicitud->estatus,
                'fecha_actualizacion' => optional($solicitud->fecha_actualizacion)->toIso8601String(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al marcar como revisado: ' . $e->getMessage()], 422);
        }
    }

    /**
     * Revierte una solicitud a "En revisión".
     */
    public function solicitudesServiciosMarkInReview($id)
    {
        try {
            $solicitud = SolicitudesServicio::findOrFail($id);
            $solicitud->estatus = SolicitudesServicio::ESTATUS_EN_REVISION;
            $solicitud->fecha_actualizacion = now();
            $solicitud->save();

            return response()->json([
                'id' => $solicitud->id,
                'estatus' => $solicitud->estatus,
                'fecha_actualizacion' => optional($solicitud->fecha_actualizacion)->toIso8601String(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al revertir a en revisión: ' . $e->getMessage()], 422);
        }
    }
}
