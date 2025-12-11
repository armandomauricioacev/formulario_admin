<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Solicitudes de Servicios') }}
        </h2>
    </x-slot>
    <div class="min-h-screen flex flex-col">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <style>
                        [x-cloak] { display: none !important; }
                        .table-wrapper {
                            width: 100%;
                            overflow-x: auto;
                            border-radius: 8px;
                            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                            background: white;
                            touch-action: pan-x;
                            overscroll-behavior-x: contain;
                            scrollbar-width: none;
                            -ms-overflow-style: none;
                        }

                        .table-wrapper::-webkit-scrollbar { 
                            display: none; 
                        }

                        .table-container {
                            overflow-x: hidden;
                            border-radius: 8px;
                            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                            background: white;
                            border: 1px solid #e5e7eb;
                            opacity: 0;
                            transition: opacity 0.3s ease-in-out;
                        }

                        .table-container.loaded {
                            opacity: 1;
                        }

                        .table-scroll-top {
                            width: 100%;
                            overflow-x: auto;
                            -webkit-overflow-scrolling: touch;
                            margin-bottom: 8px;
                            height: 12px;
                            touch-action: pan-x;
                        }
                        
                        .table-scroll-top::-webkit-scrollbar { 
                            height: 8px; 
                        }
                        
                        .table-scroll-top::-webkit-scrollbar-track { 
                            background: #f1f5f9; 
                            border-radius: 4px; 
                        }
                        
                        .table-scroll-top::-webkit-scrollbar-thumb { 
                            background: #cbd5e1; 
                            border-radius: 4px; 
                        }
                        
                        .table-scroll-top::-webkit-scrollbar-thumb:hover { 
                            background: #94a3b8; 
                        }
                        
                        .table-scroll-bottom {
                            width: 100%;
                            overflow-x: auto;
                            -webkit-overflow-scrolling: touch;
                            margin-top: 8px;
                            height: 12px;
                            touch-action: pan-x;
                        }
                        
                        .table-scroll-bottom::-webkit-scrollbar { 
                            height: 8px; 
                        }
                        
                        .table-scroll-bottom::-webkit-scrollbar-track { 
                            background: #f1f5f9; 
                            border-radius: 4px; 
                        }
                        
                        .table-scroll-bottom::-webkit-scrollbar-thumb { 
                            background: #cbd5e1; 
                            border-radius: 4px; 
                        }
                        
                        .table-scroll-bottom::-webkit-scrollbar-thumb:hover { 
                            background: #94a3b8; 
                        }

                        .controls-container {
                            display: flex;
                            justify-content: flex-start;
                            align-items: center;
                            margin-bottom: 20px;
                            gap: 16px;
                        }

                        .search-container {
                            position: relative;
                            max-width: 300px;
                        }

                        .search-icon {
                            position: absolute;
                            left: 12px;
                            top: 50%;
                            transform: translateY(-50%);
                            width: 16px;
                            height: 16px;
                            color: #9ca3af;
                        }

                        .search-input {
                            width: 100%;
                            padding: 8px 12px 8px 36px;
                            border: 1px solid #d1d5db;
                            border-radius: 6px;
                            font-size: 14px;
                            outline: none;
                            transition: border-color 0.2s;
                            background: white;
                        }

                        .search-input:focus {
                            border-color: #3b82f6;
                            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
                        }

                        .counter-text {
                            color: #6b7280;
                            font-size: 14px;
                        }

                        .btn-filter {
                            background: #6b7280;
                            color: #ffffff;
                            padding: 8px 12px;
                            border-radius: 6px;
                            border: none;
                            cursor: pointer;
                            font-size: 14px;
                            font-weight: 500;
                            transition: background 0.2s ease;
                        }
                        .btn-filter:hover { background: #4b5563; }

                        .filters-panel {
                            display: grid;
                            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                            gap: 12px;
                            background: #f9fafb;
                            border: 1px solid #e5e7eb;
                            border-radius: 8px;
                            padding: 12px;
                            margin-top: -8px;
                            margin-bottom: 16px;
                        }
                        .filter-group { display: flex; flex-direction: column; gap: 6px; }
                        .filter-label { font-size: 12px; color: #6b7280; }
                        .filter-input {
                            padding: 8px 10px;
                            border: 1px solid #d1d5db;
                            border-radius: 6px;
                            font-size: 14px;
                            background: white;
                        }

                        .btn-primary {
                            background: #3b82f6;
                            color: #ffffff;
                            padding: 8px 12px;
                            border-radius: 6px;
                            border: none;
                            font-size: 14px;
                            font-weight: 600;
                            cursor: pointer;
                            transition: background 0.2s ease;
                        }
                        .btn-primary:hover { background: #2563eb; }

                        .btn-secondary {
                            background: #6b7280;
                            color: #ffffff;
                            padding: 8px 12px;
                            border-radius: 6px;
                            border: none;
                            font-size: 14px;
                            font-weight: 500;
                            cursor: pointer;
                            transition: background 0.2s ease;
                        }
                        .btn-secondary:hover { background: #4b5563; }

                        .btn-excel {
                            background: #16a34a; /* verde */
                            color: #ffffff;
                            padding: 8px 12px;
                            border-radius: 6px;
                            border: none;
                            font-size: 14px;
                            font-weight: 500;
                            cursor: pointer;
                            transition: background 0.2s ease;
                        }
                        .btn-excel:hover { background: #15803d; }

                        .btn-warning {
                            background: #f59e0b;
                            color: #ffffff;
                            padding: 8px 12px;
                            border-radius: 6px;
                            border: none;
                            font-size: 14px;
                            font-weight: 600;
                            cursor: pointer;
                            transition: background 0.2s ease;
                        }
                        .btn-warning:hover { background: #d97706; }

                        .modal-overlay {
                            position: fixed;
                            inset: 0;
                            background: rgba(0, 0, 0, 0.5);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            z-index: 50;
                        }
                        .modal-content {
                            background: white;
                            border-radius: 8px;
                            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
                            max-width: 600px;
                            width: 90%;
                            max-height: 90vh;
                            overflow-y: auto;
                        }
                        .modal-header {
                            padding: 20px 24px;
                            border-bottom: 1px solid #e5e7eb;
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                        }
                        .modal-body { padding: 24px; }
                        .btn-close {
                            color: #9ca3af;
                            background: none;
                            border: none;
                            cursor: pointer;
                            padding: 4px;
                            transition: color 0.2s;
                        }
                        .btn-close:hover { color: #6b7280; }

                        .btn-delete {
                            background: #ef4444;
                            color: #ffffff;
                            padding: 8px 12px;
                            border-radius: 6px;
                            border: none;
                            font-size: 14px;
                            font-weight: 600;
                            cursor: pointer;
                            transition: background 0.2s ease;
                        }
                        .btn-delete:hover { background: #dc2626; }

                        .modal-body .btn-secondary,
                        .modal-body .btn-delete,
                        .modal-body .btn-excel {
                            min-width: 120px;
                        }

                        .data-table {
                            width: 100%;
                            min-width: 1600px;
                            border-collapse: collapse;
                            font-size: 14px;
                            background: white;
                            table-layout: auto;
                        }

                        .data-table th {
                            background: #f8fafc;
                            color: #374151;
                            font-weight: 600;
                            padding: 12px 16px;
                            text-align: left;
                            border-bottom: 1px solid #e5e7eb;
                            font-size: 12px;
                            text-transform: uppercase;
                            letter-spacing: 0.05em;
                            white-space: nowrap;
                        }

                        .data-table th:first-child {
                            border-top-left-radius: 8px;
                        }

                        .data-table th:last-child {
                            border-top-right-radius: 8px;
                        }

                        .data-table td {
                            padding: 12px;
                            border-bottom: 1px solid #f1f5f9;
                            vertical-align: middle;
                            white-space: nowrap;
                        }

                        .data-table tbody tr {
                            transition: none;
                        }

                        .data-table tbody tr:hover {
                            background: #f9fafb;
                        }

                        .compact-table th, .compact-table td {
                            padding: 8px 10px;
                            line-height: 1.25;
                        }
                        .compact-table th {
                            font-size: 11px;
                            letter-spacing: 0.03em;
                        }
                        .compact-table td {
                            font-size: 13px;
                        }
                        @media (max-width: 1024px) {
                            .compact-table th, .compact-table td { padding: 6px 8px; }
                            .compact-table th { font-size: 10.5px; }
                            .compact-table td { font-size: 12.5px; }
                        }

                        .status-badge {
                            padding: 4px 12px;
                            border-radius: 20px;
                            font-size: 12px;
                            font-weight: 500;
                            text-transform: capitalize;
                        }
                        .status-en_revision {
                            background-color: #dbeafe;
                            color: #1e40af;
                        }
                        .status-revisado {
                            background-color: #d1fae5;
                            color: #065f46;
                        }

                        .status-pendiente { background-color: #fef3c7; color: #92400e; }
                        .status-en_proceso { background-color: #dbeafe; color: #1e40af; }
                        .status-completado { background-color: #d1fae5; color: #065f46; }
                        .status-cancelado { background-color: #fee2e2; color: #991b1b; }

                        .service-badge {
                            display: inline-block;
                            background: #fef3c7;
                            color: #92400e;
                            padding: 2px 8px;
                            border-radius: 12px;
                            font-size: 11px;
                            font-weight: 500;
                            margin-left: 6px;
                        }

                        .no-results {
                            text-align: center;
                            padding: 40px 20px;
                            color: #64748b;
                            font-style: italic;
                        }

                        .loading {
                            text-align: center;
                            padding: 40px 20px;
                            color: #64748b;
                        }

                        .form-group {
                            margin-bottom: 16px;
                        }

                        .form-label {
                            display: block;
                            font-size: 14px;
                            font-weight: 500;
                            color: #374151;
                            margin-bottom: 6px;
                        }

                        .form-select {
                            width: 100%;
                            padding: 8px 12px;
                            border: 1px solid #d1d5db;
                            border-radius: 6px;
                            font-size: 14px;
                            background: white;
                            cursor: pointer;
                        }

                        .form-select:focus {
                            outline: none;
                            border-color: #3b82f6;
                            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
                        }

                        .btn-search {
                            background: #3b82f6;
                            color: #ffffff;
                            padding: 8px 16px;
                            border-radius: 6px;
                            border: none;
                            cursor: pointer;
                            font-size: 14px;
                            font-weight: 500;
                            transition: background 0.2s ease;
                            display: inline-flex;
                            align-items: center;
                            gap: 6px;
                        }
                        .btn-search:hover { background: #2563eb; }

                        .btn-clear-search {
                            background: #6b7280; /* gris como btn-secondary */
                            color: #ffffff;
                            padding: 8px 12px;
                            border-radius: 6px;
                            border: none;
                            cursor: pointer;
                            font-size: 14px;
                            font-weight: 500;
                            transition: background 0.2s ease;
                        }
                        .btn-clear-search:hover { background: #4b5563; }
                    </style>

                    <div x-data="solicitudesData()" x-init="initServerValues(); initScrollSync()"
                         data-status='@json($status ?? "todos")'
                         data-servicio='@json(request()->query("servicio", request()->query("servicio_id", "")))'
                         data-solicitudes='@json(isset($solicitudes) ? $solicitudes->items() : [])'
                         data-coordinaciones='@json(isset($coordinaciones) ? $coordinaciones : [])'
                         data-servicios='@json($servicios)'
                         data-otros-servicios='@json($otrosServicios ?? [])'
                         data-total="{{ isset($solicitudes) ? $solicitudes->total() : 0 }}"
                         data-visible="{{ isset($solicitudes) ? count($solicitudes->items()) : 0 }}"
                         data-current="{{ isset($solicitudes) ? $solicitudes->currentPage() : 1 }}"
                         data-last="{{ isset($solicitudes) ? $solicitudes->lastPage() : 1 }}"
                         data-search-param="{{ $search ?? '' }}"
                         data-total-all="{{ $totalAll ?? 0 }}">

                        @if(session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                <ul class="list-disc list-inside">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="controls-container">
                            <div style="display: flex; gap: 12px; align-items: center; flex: 1;">
                                <div class="search-container">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="search-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <input 
                                        type="text" 
                                        x-model="searchInput"
                                        @input.debounce.400ms="onSearchChange"
                                        placeholder="Buscar solicitudes..." 
                                        class="search-input"
                                    />
                                </div>
                                <button type="button" @click="clearSearch()" x-show="searchInput" x-cloak class="btn-clear-search">
                                    Limpiar
                                </button>
                                <!-- Botón Filtros a la izquierda del botón Descargar -->
                                <button type="button" class="btn-filter" @click="showFilters = !showFilters">
                                    Filtros
                                </button>
                                <!-- Botón Descargar a la derecha de la barra de búsqueda -->
                                <button type="button" class="btn-secondary" @click="openDownloadModal()">
                                    Descargar
                                </button>
                            </div>

                            <div class="counter-text">
                                <span x-text="`Mostrando ${filteredCount} de ${totalAll}`"></span>
                            </div>
                            
                        </div>

                        <div x-show="showFilters" x-cloak>
                            <div class="filters-panel">
                                <div class="filter-group">
                                    <label class="filter-label">Estatus</label>
                                    <select class="filter-input" x-model="statusFilter" @change="onFiltersChange">
                                        <template x-for="estatus in availableStatuses" :key="estatus">
                                            <option :value="estatus" x-text="formatStatus(estatus)"></option>
                                        </template>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <label class="filter-label">Fecha de solicitud "Desde"</label>
                                    <input type="date" class="filter-input" x-model="dateFrom" @change="onFiltersChange" />
                                </div>
                                <div class="filter-group">
                                    <label class="filter-label">Fecha de solicitud "Hasta"</label>
                                    <input type="date" class="filter-input" x-model="dateTo" @change="onFiltersChange" />
                                </div>
                                <div class="filter-group">
                                    <label class="filter-label">Coordinación</label>
                                    <select class="filter-input" x-model="coordinacionFilter" @change="onFiltersChange">
                                        <option value="">Todas</option>
                                        <template x-for="c in coordinaciones" :key="c.id">
                                            <option :value="c.id" x-text="c.nombre"></option>
                                        </template>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <label class="filter-label">Servicios</label>
                                    <select class="filter-input" x-model="servicioFilter" @change="onFiltersChange">
                                        <option value="">Todos</option>
                                        <template x-for="s in servicios" :key="s.id">
                                            <option :value="s.id" x-text="s.nombre"></option>
                                        </template>
                                        <option value="otros">Otros</option>
                                    </select>
                                </div>
                                <div class="filter-group" style="align-self: end; display: flex; gap: 8px;">
                                    <button type="button" class="btn-secondary" @click="clearFilters()">
                                        Limpiar
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="table-scroll-top" x-ref="topScroll">
                            <div class="table-scroll-inner" x-ref="topScrollInner"></div>
                        </div>

                        <div id="tableContainer" class="table-container">
                            <div class="table-wrapper" x-ref="tableWrapper">
                                <table class="data-table compact-table" x-ref="customTable">
                                    <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Nombre</th>
                                            <th>Teléfono</th>
                                            <th>Correo</th>
                                            <th>Entidad</th>
                                            <th>Servicio</th>
                                            <th>Coordinación</th>
                                            <th>Estatus</th>
                                            <th>Fecha de Solicitud</th>
                                            <th>Fecha atendida</th>
                                            <th style="text-align: center;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template x-for="solicitud in solicitudes" :key="solicitud.id">
                                            <tr>
                                                <td x-text="solicitud.id"></td>
                                                <td x-text="solicitud.nombres + ' ' + solicitud.apellido_paterno + ' ' + (solicitud.apellido_materno || '')"></td>
                                                <td x-text="solicitud.telefono"></td>
                                                <td x-text="solicitud.correo_electronico"></td>
                                                <td>
                                                    <span x-text="(solicitud.entidad_procedencia && solicitud.entidad_procedencia.nombre) || solicitud.entidad_otra || 'N/A'"></span>
                                                    <span x-show="solicitud.entidad_otra && solicitud.entidad_otra.trim().length > 0" class="service-badge">Otro</span>
                                                </td>
                                                <td>
                                                    <span x-text="(solicitud.servicio && solicitud.servicio.nombre) || solicitud.servicio_otro || 'N/A'"></span>
                                                    <span x-show="solicitud.servicio_otro" class="service-badge">Otro</span>
                                                </td>
                                                <td x-text="(solicitud.coordinacion && solicitud.coordinacion.nombre) || 'N/A'"></td>
                                                <td>
                                                    <span class="status-badge" :class="displayStatusClass(solicitud)" x-text="displayStatusLabel(solicitud)"></span>
                                                </td>
                                                <td x-text="formatDate(solicitud.fecha_solicitud)"></td>
                                                <td x-text="formatDate(solicitud.fecha_atendida)"></td>
                                                <td style="text-align: center;">
                                                    <!-- Asignar solo para "Otro" sin coordinación -->
                                                    <button type="button" class="btn-warning" style="margin-right:8px"
                                                        x-show="solicitud.servicio_otro && solicitud.servicio_otro.trim().length > 0 && !solicitud.coordinacion_id"
                                                        @click="openAssignModal(solicitud)">Asignar</button>

                                                    <!-- Marcar como Atendido mientras no esté revisado.
                                                         Para servicio "Otro" se muestra solo si ya tiene coordinación asignada. -->
                                                    <button type="button" class="btn-primary" style="margin-right:8px"
                                                        x-show="(solicitud.estatus || '').toLowerCase() !== 'revisado' && !(solicitud.servicio_otro && solicitud.servicio_otro.trim().length > 0 && !solicitud.coordinacion_id)"
                                                        @click="openReviewedModal(solicitud)">Atendido</button>

                                                    <!-- Revertir a Por Atender solo para "Otro" sin coordinación y que esté revisado -->
                                                    <button type="button" class="btn-primary" style="margin-right:8px"
                                                        x-show="(solicitud.estatus || '').toLowerCase() === 'revisado' && (solicitud.servicio_otro && solicitud.servicio_otro.trim().length > 0 && !solicitud.coordinacion_id)"
                                                        @click="openInReviewModal(solicitud)">Por Atender</button>

                                                    <!-- Texto Completado cuando no hay más acciones: 
                                                         - Servicio existente (no "Otro") con estatus revisado
                                                         - Servicio "Otro" con coordinación asignada y estatus revisado -->
                                                    <span style="font-weight:600;color:#374151;"
                                                        x-show="( ( !(solicitud.servicio_otro && solicitud.servicio_otro.trim().length > 0) ) && (solicitud.estatus || '').toLowerCase() === 'revisado' )
                                                              || ( (solicitud.servicio_otro && solicitud.servicio_otro.trim().length > 0 && solicitud.coordinacion_id) && (solicitud.estatus || '').toLowerCase() === 'revisado' )">
                                                        Completado
                                                    </span>
                                                </td>
                                            </tr>
                                        </template>
                                        <tr x-show="solicitudes.length === 0">
                                            <td colspan="10" class="no-results">
                                                <span x-show="searchInput">No se encontraron solicitudes que coincidan con la búsqueda.</span>
                                                <span x-show="!searchInput">No hay solicitudes registradas.</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="table-scroll-bottom" x-ref="bottomScroll">
                            <div class="table-scroll-inner" x-ref="bottomScrollInner"></div>
                        </div>

                        <br>
                        <nav class="controls-container" aria-label="Paginación">
                            <div style="display:flex;align-items:center;gap:12px;justify-content:flex-end;width:100%">
                                @php
                                    $previousPage = $solicitudes->currentPage() - 1;
                                    $nextPage = $solicitudes->currentPage() + 1;
                                    
                                    // Paginación circular
                                    if ($previousPage < 1) {
                                        $previousPage = $solicitudes->lastPage();
                                    }
                                    if ($nextPage > $solicitudes->lastPage()) {
                                        $nextPage = 1;
                                    }
                                    
                                    // Construir URLs preservando parámetros
                                    $previousUrl = $solicitudes->url($previousPage);
                                    $nextUrl = $solicitudes->url($nextPage);
                                @endphp
                                
                                <a href="{{ $previousUrl }}" class="btn-secondary" aria-label="Página anterior">Anterior</a>
                                
                                <span class="counter-text">Página {{ $solicitudes->currentPage() }} de {{ $solicitudes->lastPage() }}</span>
                                
                                <a href="{{ $nextUrl }}" class="btn-secondary" aria-label="Página siguiente">Siguiente</a>
                            </div>
                        </nav>

                        <!-- Modal Asignar Coordinación -->
                        <div x-show="showAssignModal" x-cloak class="modal-overlay" @click.self="showAssignModal = false">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="text-lg font-semibold">Asignar Coordinación</h3>
                                    <button @click="showAssignModal = false" class="btn-close" aria-label="Cerrar">
                                        <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-gray-600 mb-4">
                                        Asignar coordinación al servicio "<span x-text="assignData.servicioNombre" class="font-semibold"></span>"
                                        de la solicitud #<span x-text="assignData.id" class="font-semibold"></span>
                                    </p>
                                    <div class="form-group">
                                        <label class="form-label">Selecciona una coordinación:</label>
                                        <select x-model="assignData.selectedCoordinacion" class="form-select">
                                            <option value="">-- Selecciona --</option>
                                            <template x-for="c in coordinaciones" :key="c.id">
                                                <option :value="c.id" x-text="c.nombre"></option>
                                            </template>
                                        </select>
                                    </div>
                                    <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 20px;">
                                        <button type="button" @click="showAssignModal = false" class="btn-secondary">Cancelar</button>
                                        <button type="button" class="btn-warning" @click="confirmAssign()">Asignar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Confirmar Atendido -->
                        <div x-show="showReviewedModal" x-cloak class="modal-overlay" @click.self="showReviewedModal = false">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="text-lg font-semibold">Confirmar Atendido</h3>
                                    <button @click="showReviewedModal = false" class="btn-close" aria-label="Cerrar">
                                        <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-gray-600 mb-6">
                                        ¿Confirmas que la solicitud #<span x-text="reviewedData.id" class="font-semibold"></span> de
                                        "<span x-text="reviewedData.nombreCompleto" class="font-semibold"></span>" ya fue revisada?
                                    </p>
                                    <div style="display: flex; justify-content: flex-end; gap: 12px;">
                                        <button type="button" @click="showReviewedModal = false" class="btn-secondary">Cancelar</button>
                                        <button type="button" class="btn-primary" @click="confirmReviewed()">Confirmar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Confirmar Por Atender -->
                        <div x-show="showInReviewModal" x-cloak class="modal-overlay" @click.self="showInReviewModal = false">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="text-lg font-semibold">Confirmar Por Atender</h3>
                                    <button @click="showInReviewModal = false" class="btn-close" aria-label="Cerrar">
                                        <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-gray-600 mb-6">
                                        ¿Estás seguro de desmarcar la solicitud #<span x-text="inReviewData.id" class="font-semibold"></span> de
                                        "<span x-text="inReviewData.nombreCompleto" class="font-semibold"></span>" que ya había sido atendida? Ahora estará como <span class="font-semibold">Por atender</span>.
                                    </p>
                                    <div style="display: flex; justify-content: flex-end; gap: 12px;">
                                        <button type="button" @click="showInReviewModal = false" class="btn-secondary">Cancelar</button>
                                        <button type="button" class="btn-primary" @click="confirmInReview()">Por Atender</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Éxito Genérico -->
                        <div x-show="showSuccessModal" x-cloak class="modal-overlay" @click.self="showSuccessModal = false">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="text-lg font-semibold" x-text="successTitle || 'Operación exitosa'"></h3>
                                    <button @click="showSuccessModal = false" class="btn-close" aria-label="Cerrar">
                                        <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-gray-600 mb-6" x-text="successMessage || 'Acción realizada correctamente.'"></p>
                                    <div style="display: flex; justify-content: flex-end; gap: 12px;">
                                        <button type="button" class="btn-primary" @click="showSuccessModal = false">Aceptar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Descargar -->
                        <div x-show="showDownloadModal" x-cloak class="modal-overlay" @click.self="showDownloadModal = false">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="text-lg font-semibold">Descargar datos</h3>
                                    <button @click="showDownloadModal = false" class="btn-close" aria-label="Cerrar">
                                        <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-gray-600 mb-4">El archivo incluirá los datos según los filtros aplicados.</p>
                                    <div style="display:flex; gap: 12px; justify-content: flex-end;">
                                        <button type="button" class="btn-excel" @click="download('excel')">Descargar Excel</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function solicitudesData() {
            return {
                searchInput: '',
                showFilters: false,
                statusFilter: '',
                dateFrom: '',
                dateTo: '',
                coordinacionFilter: '',
                servicioFilter: '',
                availableStatuses: ['todos', 'en_revision', 'revisado'],
                solicitudes: [],
                coordinaciones: [],
                servicios: [],
                otrosServicios: [],
                totalRows: 0,
                filteredCount: 0,
                totalAll: 0,
                visibleRows: 0,
                currentPage: 1,
                lastPage: 1,
                showReviewedModal: false,
                reviewedData: {},
                showInReviewModal: false,
                inReviewData: {},
                showAssignModal: false,
                assignData: {},
                showSuccessModal: false,
                successTitle: '',
                successMessage: '',
                showDownloadModal: false,
                // Base absoluta robusta para subcarpetas (p.ej. /formularioadmin_imt)
                baseUrl: '{{ url('/') }}',

                initServerValues() {
                    const d = this.$el.dataset;
                    
                    try {
                        this.statusFilter = JSON.parse(d.status ?? '"todos"');
                    } catch (e) {
                        this.statusFilter = d.status || 'todos';
                    }

                    try {
                        this.servicioFilter = JSON.parse(d.servicio ?? '""');
                    } catch (e) {
                        this.servicioFilter = d.servicio || '';
                    }

                    try {
                        this.solicitudes = JSON.parse(d.solicitudes ?? '[]');
                    } catch (e) {
                        this.solicitudes = [];
                    }

                    try {
                        this.coordinaciones = JSON.parse(d.coordinaciones ?? '[]');
                    } catch (e) {
                        this.coordinaciones = [];
                    }

                    try {
                        this.servicios = JSON.parse(d.servicios ?? '[]');
                    } catch (e) {
                        this.servicios = [];
                    }

                    try {
                        this.otrosServicios = JSON.parse(d.otrosServicios ?? '[]');
                    } catch (e) {
                        this.otrosServicios = [];
                    }

                    this.totalRows = Number(d.total ?? 0);
                    this.filteredCount = Number(d.total ?? 0);
                    this.totalAll = Number(d.totalAll ?? 0);
                    this.visibleRows = Number(d.visible ?? 0);
                    this.currentPage = Number(d.current ?? 1);
                    this.lastPage = Number(d.last ?? 1);
                    
                    // Inicializar el input de búsqueda con el valor del servidor
                    this.searchInput = d.searchParam || '';

                    // Inicializar rango de fechas desde la URL (si existe)
                    try {
                        const params = new URL(window.location.href).searchParams;
                        this.dateFrom = params.get('fecha_desde') || '';
                        this.dateTo = params.get('fecha_hasta') || '';
                    } catch (e) {
                        this.dateFrom = '';
                        this.dateTo = '';
                    }
                },

                isNumeric(val) {
                    return /^[0-9]+$/.test(String(val || '').trim());
                },

                clearSearch() {
                    this.searchInput = '';
                    const url = new URL(window.location.href);
                    url.searchParams.delete('search');
                    url.searchParams.delete('page');
                    this.fetchAndUpdate(url);
                },

                onSearchChange() {
                    const url = new URL(window.location.href);
                    const q = String(this.searchInput || '').trim();
                    if (q) {
                        url.searchParams.set('search', q);
                    } else {
                        url.searchParams.delete('search');
                    }
                    url.searchParams.delete('page');
                    this.fetchAndUpdate(url);
                },

                onFiltersChange() {
                    const url = new URL(window.location.href);
                    const q = String(this.searchInput || '').trim();
                    if (q) {
                        url.searchParams.set('search', q);
                    } else {
                        url.searchParams.delete('search');
                    }

                    // Estatus
                    if (this.statusFilter && this.statusFilter !== 'todos') {
                        url.searchParams.set('status', this.statusFilter);
                    } else {
                        url.searchParams.delete('status');
                    }

                    // Fecha (rango)
                    if (this.dateFrom) {
                        url.searchParams.set('fecha_desde', this.dateFrom);
                    } else {
                        url.searchParams.delete('fecha_desde');
                    }
                    if (this.dateTo) {
                        url.searchParams.set('fecha_hasta', this.dateTo);
                    } else {
                        url.searchParams.delete('fecha_hasta');
                    }

                    // Coordinación
                    if (this.coordinacionFilter) {
                        url.searchParams.set('coordinacion_id', this.coordinacionFilter);
                    } else {
                        url.searchParams.delete('coordinacion_id');
                    }

                    // Servicio
                    if (this.servicioFilter) {
                        if (this.isNumeric(this.servicioFilter)) {
                            url.searchParams.set('servicio_id', this.servicioFilter);
                            url.searchParams.delete('servicio');
                        } else {
                            url.searchParams.set('servicio', this.servicioFilter);
                            url.searchParams.delete('servicio_id');
                        }
                    } else {
                        url.searchParams.delete('servicio_id');
                        url.searchParams.delete('servicio');
                    }

                    // Reiniciar a la primera página al cambiar filtros
                    url.searchParams.delete('page');
                    this.fetchAndUpdate(url);
                },

                async fetchAndUpdate(url) {
                    try {
                        const endpoint = url.pathname + '?' + url.searchParams.toString();
                        const res = await fetch(endpoint, {
                            headers: { 'Accept': 'application/json' }
                        });
                        if (!res.ok) throw new Error('No se pudo obtener datos');
                        const data = await res.json();
                        this.updateFromResponse(data);
                        // Actualiza la URL sin recargar para mantener navegación
                        history.replaceState(null, '', url.toString());
                    } catch (e) {
                        console.error(e);
                    }
                },

                updateFromResponse(data) {
                    this.solicitudes = Array.isArray(data.items) ? data.items : [];
                    this.filteredCount = Number(data.totalFiltered || 0);
                    this.totalRows = this.filteredCount;
                    this.visibleRows = Number(data.visibleCount || this.solicitudes.length || 0);
                    this.currentPage = Number(data.currentPage || 1);
                    this.lastPage = Number(data.lastPage || 1);
                    this.totalAll = Number(data.totalAll || this.totalAll || 0);
                },

                openAssignModal(solicitud) {
                    const servicioNombre = solicitud.servicio_otro || 'Sin nombre';
                    this.assignData = {
                        id: solicitud.id,
                        servicioNombre: servicioNombre,
                        selectedCoordinacion: solicitud.coordinacion_id || '',
                        ref: solicitud
                    };
                    this.showAssignModal = true;
                },

                async confirmAssign() {
                    if (!this.assignData.selectedCoordinacion) {
                        alert('Por favor selecciona una coordinación.');
                        return;
                    }

                    try {
                        const token = document.querySelector('meta[name=csrf-token]')?.getAttribute('content');
                        const res = await fetch(`${this.baseUrl}/solicitudes/${this.assignData.id}/asignar-coordinacion`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                coordinacion_id: this.assignData.selectedCoordinacion
                            })
                        });

                        if (!res.ok) {
                            const errorData = await res.json();
                            throw new Error(errorData.error || 'Respuesta no válida');
                        }

                        const data = await res.json();
                        
                        // Actualizar el estado local
                        this.assignData.ref.coordinacion_id = data.coordinacion_id;
                        this.assignData.ref.coordinacion = data.coordinacion;
                        this.assignData.ref.fecha_actualizacion = data.fecha_actualizacion;
                        
                        this.showAssignModal = false;
                        this.successTitle = 'Coordinación asignada';
                        this.successMessage = 'Coordinación asignada exitosamente.';
                        this.showSuccessModal = true;
                    } catch (e) {
                        console.error(e);
                        alert('Ocurrió un error al asignar la coordinación: ' + e.message);
                    }
                },

                openReviewedModal(solicitud) {
                    // Bloquear acción si es "Otro" y no tiene coordinación asignada
                    if (solicitud.servicio_otro && solicitud.servicio_otro.trim().length > 0 && !solicitud.coordinacion_id) {
                        alert('Para servicios "Otro", primero asigna una coordinación.');
                        return;
                    }
                    const nombre = `${solicitud.nombres} ${solicitud.apellido_paterno} ${solicitud.apellido_materno || ''}`.trim();
                    this.reviewedData = {
                        id: solicitud.id,
                        nombreCompleto: nombre,
                        ref: solicitud
                    };
                    this.showReviewedModal = true;
                },

                openInReviewModal(solicitud) {
                    const nombre = `${solicitud.nombres} ${solicitud.apellido_paterno} ${solicitud.apellido_materno || ''}`.trim();
                    this.inReviewData = {
                        id: solicitud.id,
                        nombreCompleto: nombre,
                        ref: solicitud
                    };
                    this.showInReviewModal = true;
                },

                openDownloadModal() {
                    this.showDownloadModal = true;
                },

                async confirmReviewed() {
                    try {
                        const token = document.querySelector('meta[name=csrf-token]')?.getAttribute('content');
                        const res = await fetch(`${this.baseUrl}/solicitudes/${this.reviewedData.id}/revisado`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({})
                        });

                        if (!res.ok) {
                            throw new Error('Respuesta no válida');
                        }

                        const data = await res.json();
                        
                        this.reviewedData.ref.estatus = 'revisado';
                        this.reviewedData.ref.fecha_actualizacion = data.fecha_actualizacion || this.reviewedData.ref.fecha_actualizacion;
                        this.reviewedData.ref.fecha_atendida = data.fecha_atendida || this.reviewedData.ref.fecha_atendida;
                        
                        this.showReviewedModal = false;
                    } catch (e) {
                        console.error(e);
                        alert('Ocurrió un error al marcar como revisado.');
                    }
                },

                async confirmInReview() {
                    try {
                        const token = document.querySelector('meta[name=csrf-token]')?.getAttribute('content');
                        const res = await fetch(`${this.baseUrl}/solicitudes/${this.inReviewData.id}/en_revision`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({})
                        });

                        if (!res.ok) {
                            throw new Error('Respuesta no válida');
                        }

                        const data = await res.json();
                        
                        this.inReviewData.ref.estatus = 'en_revision';
                        this.inReviewData.ref.fecha_actualizacion = data.fecha_actualizacion || this.inReviewData.ref.fecha_actualizacion;
                        this.inReviewData.ref.fecha_atendida = null;
                        
                        this.showInReviewModal = false;
                    } catch (e) {
                        console.error(e);
                        alert('Ocurrió un error al revertir la solicitud a En Revisión.');
                    }
                },

                formatDate(dateString) {
                    if (!dateString) return 'N/A';
                    
                    return new Date(dateString).toLocaleString('es-MX', {
                        year: 'numeric',
                        month: '2-digit',
                        day: '2-digit',
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true
                    });
                },

                formatStatus(s) {
                    const map = {
                        'todos': 'Todos',
                        'en_revision': 'Por atender',
                        'revisado': 'Atendido'
                    };
                    const k = (s || '').toLowerCase();
                    return map[k] ?? (s || 'N/A');
                },

                displayStatusLabel(solicitud) {
                    const est = (solicitud.estatus || '').toLowerCase();
                    // Solo dos estados visibles en la columna: Por atender / Atendido
                    return this.formatStatus(est);
                },

                displayStatusClass(solicitud) {
                    const est = (solicitud.estatus || '').toLowerCase();
                    // Clases coherentes con los dos estados mostrados
                    if (est === 'revisado') return 'status-revisado';
                    return 'status-en_revision';
                },

                initScrollSync() {
                    this.$nextTick(() => {
                        const top = this.$refs.topScroll;
                        const innerTop = this.$refs.topScrollInner;
                        const bottom = this.$refs.bottomScroll;
                        const innerBottom = this.$refs.bottomScrollInner;
                        const wrapper = this.$refs.tableWrapper;
                        const table = this.$refs.customTable;

                        const updateWidths = () => {
                            if (table) {
                                const w = table.scrollWidth;
                                if (innerTop) {
                                    innerTop.style.width = w + 'px';
                                    innerTop.style.height = '1px';
                                }
                                if (innerBottom) {
                                    innerBottom.style.width = w + 'px';
                                    innerBottom.style.height = '1px';
                                }
                            }
                        };

                        updateWidths();
                        window.addEventListener('resize', updateWidths);

                        let syncing = false;
                        const setScroll = (el, val) => {
                            if (el && el.scrollLeft !== val) {
                                el.scrollLeft = val;
                            }
                        };

                        const onTopScroll = () => {
                            if (syncing) return;
                            syncing = true;
                            setScroll(wrapper, top.scrollLeft);
                            setScroll(bottom, top.scrollLeft);
                            syncing = false;
                        };

                        const onBottomScroll = () => {
                            if (syncing) return;
                            syncing = true;
                            setScroll(wrapper, bottom.scrollLeft);
                            setScroll(top, bottom.scrollLeft);
                            syncing = false;
                        };

                        const onWrapperScroll = () => {
                            if (syncing) return;
                            syncing = true;
                            setScroll(top, wrapper.scrollLeft);
                            setScroll(bottom, wrapper.scrollLeft);
                            syncing = false;
                        };

                        if (top) top.addEventListener('scroll', onTopScroll);
                        if (bottom) bottom.addEventListener('scroll', onBottomScroll);
                        if (wrapper) wrapper.addEventListener('scroll', onWrapperScroll);
                    });
                },

                clearFilters() {
                    this.statusFilter = 'todos';
                    this.dateFrom = '';
                    this.dateTo = '';
                    this.coordinacionFilter = '';
                    this.servicioFilter = '';
                    
                    // URL limpia manteniendo solo la búsqueda si existe
                    const url = new URL(window.location.href);
                    url.searchParams.delete('status');
                    url.searchParams.delete('fecha_desde');
                    url.searchParams.delete('fecha_hasta');
                    url.searchParams.delete('coordinacion_id');
                    url.searchParams.delete('servicio_id');
                    url.searchParams.delete('servicio');
                    url.searchParams.delete('page');
                    this.fetchAndUpdate(url);
                },

                download(type) {
                    const url = new URL(`{{ url('/solicitudes/export') }}` + '/' + (type === 'excel' ? 'excel' : 'pdf'));
                    const q = String(this.searchInput || '').trim();
                    if (q) url.searchParams.set('search', q);

                    if (this.statusFilter && this.statusFilter !== 'todos') {
                        url.searchParams.set('status', this.statusFilter);
                    }
                    if (this.dateFrom) {
                        url.searchParams.set('fecha_desde', this.dateFrom);
                    }
                    if (this.dateTo) {
                        url.searchParams.set('fecha_hasta', this.dateTo);
                    }
                    if (this.coordinacionFilter) {
                        url.searchParams.set('coordinacion_id', this.coordinacionFilter);
                    }
                    if (this.servicioFilter) {
                        if (this.isNumeric(this.servicioFilter)) {
                            url.searchParams.set('servicio_id', this.servicioFilter);
                        } else {
                            url.searchParams.set('servicio', this.servicioFilter);
                        }
                    }

                    // Cerrar modal y navegar al endpoint de descarga
                    this.showDownloadModal = false;
                    window.location.href = url.toString();
                }
            };
        }

        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('tableContainer');
            if (container) {
                container.classList.add('loaded');
            }
        });
    </script>
    <footer class="mt-auto py-2 text-center text-xs text-gray-500">
© 2025 IMT - Desarrollado por la División de Telemática
    </footer>
    </div>
</x-app-layout>
