<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
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

        // Prefill solo si el correo corresponde a un usuario con rol admin
        $globalRepresentante = '';
        $globalCorreoRepresentante = '';
        if ($global && !empty($global->correo_representante)) {
            $u = User::where('email', $global->correo_representante)->first();
            if ($u && $u->role === 'admin') {
                $globalRepresentante = $global->representante ?? ($u->name ?? '');
                $globalCorreoRepresentante = $global->correo_representante ?? ($u->email ?? '');
            }
        }

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
            DB::transaction(function () use ($request) {
                $nombre = $request->input('representante');
                $email = $request->input('correo_representante');

                // 1) Actualizar usuario representante basado en el correo global previo
                $prevGlobal = Coordinaciones::select('correo_representante')
                    ->whereNotNull('correo_representante')
                    ->orderByDesc('id')
                    ->first();
                $prevEmail = $prevGlobal->correo_representante ?? null;
                $prevUser = $prevEmail ? User::where('email', $prevEmail)->where('role', 'admin')->first() : null;

                if ($prevUser) {
                    if ($nombre) {
                        $prevUser->name = $nombre;
                    }
                    if ($email && $email !== $prevUser->email) {
                        $emailTaken = User::where('email', $email)->where('id', '!=', $prevUser->id)->exists();
                        if ($emailTaken) {
                            throw new \RuntimeException('El correo ya está en uso por otro usuario.');
                        }
                        $prevUser->email = $email;
                    }
                    $prevUser->save();
                } else if ($email) {
                    // Si no existe usuario previo, pero el correo proporcionado corresponde a un usuario con rol admin, actualizar su nombre
                    $user = User::where('email', $email)->first();
                    if ($user && $user->role !== 'admin') {
                        throw new \RuntimeException('El correo pertenece a un usuario con rol distinto de admin.');
                    }
                    if ($user && $nombre) {
                        $user->name = $nombre;
                        $user->save();
                    }
                }

                // 2) Actualiza los campos globales en todas las coordinaciones (solo los enviados)
                $updates = [];
                if (!is_null($nombre)) {
                    $updates['representante'] = $nombre;
                }
                if (!is_null($email)) {
                    $updates['correo_representante'] = $email;
                }
                if (!empty($updates)) {
                    Coordinaciones::query()->update($updates);
                }
            });

            return redirect()->route('coordinaciones')
                ->with('success', 'Representante actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('coordinaciones')
                ->with('error', 'Error al actualizar el representante: ' . $e->getMessage());
        }
    }

    /**
     * Actualiza la contraseña del usuario representante
     */
    public function coordinacionesRepresentativeUpdatePassword(Request $request)
    {
        $request->validate([
            'correo_representante' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $user = User::where('email', $request->correo_representante)
                        ->where('role', 'admin')
                        ->firstOrFail();
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->route('coordinaciones')
                ->with('success', 'Contraseña actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('coordinaciones')
                ->with('error', 'Error al actualizar la contraseña: ' . $e->getMessage());
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
    public function solicitudesServiciosIndex(Request $request)
{
    // Filtros por query params
    $status = $request->query('status');
    $servicioId = $request->query('servicio_id');
    $servicio = $request->query('servicio');
    $coordinacionId = $request->query('coordinacion_id');
    $fechaFilter = $request->query('fecha');
    $search = trim($request->query('search', ''));

    $query = SolicitudesServicio::with(['entidadProcedencia', 'servicio', 'coordinacion'])
        ->orderBy('id', 'desc'); // Ordenar por ID descendente

    // Filtro de estatus
    if (!empty($status) && $status !== 'todos') {
        $query->where('estatus', $status);
    }

    // Filtro de servicio por ID
    if (!empty($servicioId) && is_numeric($servicioId)) {
        $query->where('servicio_id', $servicioId);
    }
    // Filtro de servicio "otros"
    elseif (!empty($servicio) && $servicio === 'otros') {
        $query->where(function($q) {
            $q->whereNotNull('servicio_otro')
              ->where('servicio_otro', '!=', '');
        });
    }

    // Filtro de coordinación
    if (!empty($coordinacionId) && is_numeric($coordinacionId)) {
        $query->where('coordinacion_id', $coordinacionId);
    }

    // Filtro de fecha
    if (!empty($fechaFilter)) {
        $query->whereDate('fecha_solicitud', $fechaFilter);
    }

    // Búsqueda global en TODA la base de datos - CORREGIDO
    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $like = '%' . $search . '%';
            $q->where('nombres', 'like', $like)
              ->orWhere('apellido_paterno', 'like', $like)
              ->orWhere('apellido_materno', 'like', $like)
              ->orWhere('telefono', 'like', $like)
              ->orWhere('correo_electronico', 'like', $like)
              ->orWhere('entidad_otra', 'like', $like)
              ->orWhere('servicio_otro', 'like', $like)
              ->orWhere('estatus', 'like', $like)
              ->orWhereHas('entidadProcedencia', function ($qq) use ($like) {
                  $qq->where('nombre', 'like', $like);
              })
              ->orWhereHas('servicio', function ($qq) use ($like) {
                  $qq->where('nombre', 'like', $like);
              })
              ->orWhereHas('coordinacion', function ($qq) use ($like) {
                  $qq->where('nombre', 'like', $like);
              });
        });
    }

    // Paginación de 15 por página, preservando parámetros
    $solicitudes = $query->paginate(15)->appends($request->query());

    // Total global (sin filtros) para el contador en la vista
    $totalAll = SolicitudesServicio::count();

    // Listas para filtros en la vista
    $coordinaciones = Coordinaciones::orderBy('nombre')->get();
    $servicios = Servicios::orderBy('nombre')->get();
    $otrosServicios = SolicitudesServicio::whereNotNull('servicio_otro')
        ->where('servicio_otro', '!=', '')
        ->distinct()
        ->orderBy('servicio_otro')
        ->pluck('servicio_otro');

    // Respuesta JSON para actualizaciones dinámicas sin recargar la página
    if ($request->expectsJson()) {
        return response()->json([
            'items' => $solicitudes->items(),
            'totalFiltered' => $solicitudes->total(),
            'currentPage' => $solicitudes->currentPage(),
            'lastPage' => $solicitudes->lastPage(),
            'visibleCount' => count($solicitudes->items()),
            'totalAll' => $totalAll,
        ]);
    }

    return view('solicitudes_servicios', [
        'solicitudes' => $solicitudes,
        'coordinaciones' => $coordinaciones,
        'servicios' => $servicios,
        'otrosServicios' => $otrosServicios,
        'status' => $status,
        'search' => $search,
        'totalAll' => $totalAll,
    ]);
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
            $solicitud->fecha_atendida = now();
            $solicitud->fecha_actualizacion = now();
            $solicitud->save();

            // Respuesta JSON para facilitar actualización con Alpine
            return response()->json([
                'id' => $solicitud->id,
                'estatus' => $solicitud->estatus,
                'fecha_actualizacion' => optional($solicitud->fecha_actualizacion)->toIso8601String(),
                'fecha_atendida' => optional($solicitud->fecha_atendida)->toIso8601String(),
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
            $solicitud->fecha_atendida = null;
            $solicitud->fecha_actualizacion = now();
            $solicitud->save();

            return response()->json([
                'id' => $solicitud->id,
                'estatus' => $solicitud->estatus,
                'fecha_actualizacion' => optional($solicitud->fecha_actualizacion)->toIso8601String(),
                'fecha_atendida' => null,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al revertir a en revisión: ' . $e->getMessage()], 422);
        }
    }

    /**
     * Asigna una coordinación a una solicitud con servicio "Otro".
     */
    public function solicitudesServiciosAsignarCoordinacion(Request $request, $id)
    {
        $request->validate([
            'coordinacion_id' => 'required|exists:coordinaciones,id',
        ]);

        try {
            $solicitud = SolicitudesServicio::findOrFail($id);
            
            // Verificar que sea un servicio "Otro"
            if (empty($solicitud->servicio_otro)) {
                return response()->json([
                    'error' => 'Solo se puede asignar coordinación a servicios "Otro".'
                ], 422);
            }

            $solicitud->coordinacion_id = $request->coordinacion_id;
            $solicitud->fecha_actualizacion = now();
            $solicitud->save();

            // Recargar la relación para obtener los datos actualizados
            $solicitud->load('coordinacion');

            return response()->json([
                'id' => $solicitud->id,
                'coordinacion_id' => $solicitud->coordinacion_id,
                'coordinacion' => $solicitud->coordinacion ? [
                    'id' => $solicitud->coordinacion->id,
                    'nombre' => $solicitud->coordinacion->nombre,
                ] : null,
                'fecha_actualizacion' => optional($solicitud->fecha_actualizacion)->toIso8601String(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al asignar coordinación: ' . $e->getMessage()
            ], 422);
        }
    }
}