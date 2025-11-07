<?php

namespace App\Http\Controllers;

use App\Models\Coordinaciones;
use App\Models\Servicios;
use App\Models\SolicitudesServicio;
use App\Models\EntidadesProcedencia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        try {
            // Actualizar representante global en todas las coordinaciones
            Coordinaciones::query()->update([
                'representante' => $request->representante,
                'correo_representante' => $request->correo_representante,
            ]);

            $newName = $request->representante;
            $newEmail = $request->correo_representante;
            $newPassword = $request->password;
            $message = 'Representante actualizado exitosamente.';

            if (!empty($newEmail)) {
                // Demote cualquier admin previo que no sea el nuevo representante
                User::where('role', 'admin')
                    ->where('email', '!=', $newEmail)
                    ->update(['role' => 'superadmin']);

                // Promover/crear el usuario admin con el correo del representante
                $repUser = User::where('email', $newEmail)->first();
                if ($repUser) {
                    if (!empty($newName)) {
                        $repUser->name = $newName;
                    }
                    if (!empty($newPassword)) {
                        $repUser->password = Hash::make($newPassword);
                    }
                    $repUser->role = 'admin';
                    $repUser->save();
                    $message = 'Representante actualizado y usuario asignado/actualizado con rol administrador.';
                } else {
                    if (empty($newPassword)) {
                        return redirect()->route('coordinaciones')
                            ->with('error', 'Para crear el usuario del representante, ingrese una contraseña.');
                    }

                    User::create([
                        'name' => !empty($newName) ? $newName : 'Representante',
                        'email' => $newEmail,
                        'password' => Hash::make($newPassword),
                        'role' => 'admin',
                    ]);

                    $message = 'Representante actualizado y usuario administrador creado.';
                }
            } else {
                // Si se elimina el correo del representante, remover privilegios de admin
                User::where('role', 'admin')->update(['role' => 'superadmin']);
                $message = 'Representante eliminado. Se removieron privilegios de administrador.';
            }

            return redirect()->route('coordinaciones')
                ->with('success', $message);
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
    public function solicitudesServiciosIndex(Request $request)
    {
        // Parámetros de filtro desde la URL
        $status = $request->query('status');
        $servicioId = $request->query('servicio_id');
        $servicioFlag = $request->query('servicio'); // cuando es "otros"
        $coordinacionId = $request->query('coordinacion_id');
        $fecha = $request->query('fecha'); // YYYY-MM-DD
        $q = $request->query('q');

        $query = SolicitudesServicio::with(['entidadProcedencia', 'servicio', 'coordinacion'])
            ->orderBy('fecha_solicitud', 'desc');

        // Filtro de estatus
        if (!empty($status) && $status !== 'todos') {
            $query->where('estatus', $status);
        }

        // Filtro de servicio
        if (!empty($servicioId)) {
            $query->where('servicio_id', $servicioId);
        } elseif (!empty($servicioFlag) && $servicioFlag === 'otros') {
            // "Otros" = tiene servicio_otro o el servicio catalogado se llama "otro"
            $query->where(function ($qq) {
                $qq->whereNotNull('servicio_otro')
                   ->where('servicio_otro', '!=', '');
            })->orWhereHas('servicio', function ($s) {
                $s->whereRaw('LOWER(nombre) = ?', ['otro']);
            });
        }

        // Filtro de coordinación
        if (!empty($coordinacionId)) {
            $query->where('coordinacion_id', $coordinacionId);
        }

        // Filtro por fecha exacta (día)
        if (!empty($fecha)) {
            $query->whereDate('fecha_solicitud', $fecha);
        }

        // Búsqueda global en varias columnas y relaciones
        if (!empty($q)) {
            $like = '%' . $q . '%';
            $query->where(function ($w) use ($like) {
                $w->where('nombres', 'like', $like)
                  ->orWhere('apellido_paterno', 'like', $like)
                  ->orWhere('apellido_materno', 'like', $like)
                  ->orWhere('telefono', 'like', $like)
                  ->orWhere('correo_electronico', 'like', $like)
                  ->orWhere('servicio_otro', 'like', $like)
                  ->orWhere('estatus', 'like', $like);
            })
            ->orWhereHas('entidadProcedencia', function ($q2) use ($like) {
                $q2->where('nombre', 'like', $like);
            })
            ->orWhereHas('servicio', function ($q3) use ($like) {
                $q3->where('nombre', 'like', $like);
            })
            ->orWhereHas('coordinacion', function ($q4) use ($like) {
                $q4->where('nombre', 'like', $like);
            });
        }

        // Paginación, preservando los parámetros
        $solicitudes = $query->paginate(15)->appends($request->query());

        // Listas para filtros en la vista
        $coordinaciones = Coordinaciones::orderBy('nombre')->get();
        $servicios = Servicios::orderBy('nombre')->get();
        $otrosServicios = SolicitudesServicio::whereNotNull('servicio_otro')
            ->where('servicio_otro', '!=', '')
            ->distinct()
            ->orderBy('servicio_otro')
            ->pluck('servicio_otro');

        return view('solicitudes_servicios', [
            'solicitudes' => $solicitudes,
            'coordinaciones' => $coordinaciones,
            'servicios' => $servicios,
            'otrosServicios' => $otrosServicios,
            'status' => $status,
        ]);
    }

    // Nuevo endpoint JSON para filtrar/paginar en tiempo real
    public function solicitudesServiciosData(Request $request)
    {
        $status = $request->query('status');
        $servicioId = $request->query('servicio_id');
        $servicioFlag = $request->query('servicio');
        $coordinacionId = $request->query('coordinacion_id');
        $fecha = $request->query('fecha');
        $q = $request->query('q');
        $perPage = (int) ($request->query('per_page', 15));

        $query = SolicitudesServicio::with(['entidadProcedencia', 'servicio', 'coordinacion'])
            ->orderBy('fecha_solicitud', 'desc');

        if (!empty($status) && $status !== 'todos') {
            $query->where('estatus', $status);
        }
        if (!empty($servicioId)) {
            $query->where('servicio_id', $servicioId);
        } elseif (!empty($servicioFlag) && $servicioFlag === 'otros') {
            $query->where(function ($qq) {
                $qq->whereNotNull('servicio_otro')
                   ->where('servicio_otro', '!=', '');
            })->orWhereHas('servicio', function ($s) {
                $s->whereRaw('LOWER(nombre) = ?', ['otro']);
            });
        }
        if (!empty($coordinacionId)) {
            $query->where('coordinacion_id', $coordinacionId);
        }
        if (!empty($fecha)) {
            $query->whereDate('fecha_solicitud', $fecha);
        }
        if (!empty($q)) {
            $like = '%' . $q . '%';
            $query->where(function ($w) use ($like) {
                $w->where('nombres', 'like', $like)
                  ->orWhere('apellido_paterno', 'like', $like)
                  ->orWhere('apellido_materno', 'like', $like)
                  ->orWhere('telefono', 'like', $like)
                  ->orWhere('correo_electronico', 'like', $like)
                  ->orWhere('servicio_otro', 'like', $like)
                  ->orWhere('estatus', 'like', $like);
            })
            ->orWhereHas('entidadProcedencia', function ($q2) use ($like) {
                $q2->where('nombre', 'like', $like);
            })
            ->orWhereHas('servicio', function ($q3) use ($like) {
                $q3->where('nombre', 'like', $like);
            })
            ->orWhereHas('coordinacion', function ($q4) use ($like) {
                $q4->where('nombre', 'like', $like);
            });
        }

        $page = (int) $request->query('page', 1);
        $paginator = $query->paginate($perPage, ['*'], 'page', $page);

        // Calcular total global sin filtros (para mostrar "X de Y")
        $totalAll = \App\Models\SolicitudesServicio::count();

        return response()->json([
            'data' => $paginator->items(),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'total_all' => $totalAll,
            ],
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
