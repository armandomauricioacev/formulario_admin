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
        $coordinaciones = Coordinaciones::orderBy('id', 'desc')->get();
        return view('coordinacion', compact('coordinaciones'));
    }

    public function coordinacionesStore(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'coordinador' => 'nullable|string|max:255',
            'correo_coordinador' => 'nullable|email|max:255',
            'asistente' => 'nullable|string|max:255',
            'correo_asistente' => 'nullable|email|max:255',
            'representante' => 'nullable|string|max:255',
            'correo_representante' => 'nullable|email|max:255',
        ]);

        try {
            // Obtener valores globales actuales (si existen)
            $globalRepresentante = Coordinaciones::whereNotNull('representante')->value('representante');
            $globalCorreoRepresentante = Coordinaciones::whereNotNull('correo_representante')->value('correo_representante');

            // Si se envía representante/correo, se actualiza de forma global
            if ($request->filled('representante')) {
                $globalRepresentante = $request->representante;
                Coordinaciones::query()->update(['representante' => $globalRepresentante]);
            }
            if ($request->filled('correo_representante')) {
                $globalCorreoRepresentante = $request->correo_representante;
                Coordinaciones::query()->update(['correo_representante' => $globalCorreoRepresentante]);
            }

            // Crear registro con campos individuales + globales (si existen)
            Coordinaciones::create([
                'nombre' => $request->nombre,
                'coordinador' => $request->coordinador,
                'correo_coordinador' => $request->correo_coordinador,
                'asistente' => $request->asistente,
                'correo_asistente' => $request->correo_asistente,
                'representante' => $globalRepresentante,
                'correo_representante' => $globalCorreoRepresentante,
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
            'nombre' => 'required|string|max:255',
            'coordinador' => 'nullable|string|max:255',
            'correo_coordinador' => 'nullable|email|max:255',
            'asistente' => 'nullable|string|max:255',
            'correo_asistente' => 'nullable|email|max:255',
            'representante' => 'nullable|string|max:255',
            'correo_representante' => 'nullable|email|max:255',
        ]);

        try {
            $coordinacion = Coordinaciones::findOrFail($id);

            // Actualización global del representante si viene en la solicitud
            $updateAll = [];
            if ($request->filled('representante')) {
                $updateAll['representante'] = $request->representante;
            }
            if ($request->filled('correo_representante')) {
                $updateAll['correo_representante'] = $request->correo_representante;
            }
            if (!empty($updateAll)) {
                Coordinaciones::query()->update($updateAll);
            }

            // Actualizar campos del registro actual (individuales + reflejar global si vino)
            $coordinacion->update([
                'nombre' => $request->nombre,
                'coordinador' => $request->coordinador,
                'correo_coordinador' => $request->correo_coordinador,
                'asistente' => $request->asistente,
                'correo_asistente' => $request->correo_asistente,
            ] + $updateAll);

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

    // ========== MÉTODOS PARA ENTIDADES DE PROCEDENCIA ==========
    public function entidadesProcedenciaIndex()
    {
        $entidades = EntidadesProcedencia::orderBy('id', 'desc')->get();
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
        $servicios = Servicios::with('coordinacionPredeterminada')->orderBy('id', 'desc')->get();
        $coordinaciones = Coordinaciones::orderBy('nombre')->get();
        return view('servicios', compact('servicios', 'coordinaciones'));
    }

    public function serviciosStore(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'coordinacion_predeterminada_id' => 'nullable|exists:coordinaciones,id',
        ]);

        try {
            Servicios::create([
                'nombre' => $request->nombre,
                'coordinacion_predeterminada_id' => $request->coordinacion_predeterminada_id,
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
        ]);

        try {
            $servicio = Servicios::findOrFail($id);
            $servicio->update([
                'nombre' => $request->nombre,
                'coordinacion_predeterminada_id' => $request->coordinacion_predeterminada_id,
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
            ->orderBy('id', 'desc')
            ->get();

        // Listas dinámicas para filtros
        $coordinaciones = Coordinaciones::orderBy('nombre')->get(['id', 'nombre']);
        $servicios = Servicios::orderBy('nombre')->get(['id', 'nombre']);

        return view('solicitudes_servicios', compact('solicitudes', 'coordinaciones', 'servicios'));
    }
}
