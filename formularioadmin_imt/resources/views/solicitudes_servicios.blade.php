<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Solicitudes de Servicios') }}
        </h2>
    </x-slot>

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
                            scrollbar-width: none; /* Firefox */
                            -ms-overflow-style: none; /* IE y Edge */
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

                        /* Scrolls superiores e inferiores */
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

                        /* Botón y panel de filtros (estilo igual a Líneas de Captura) */
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

                        /* Botones primario/secundario (consistentes con Líneas de Captura) */
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

                        /* Modales (consistentes con otras vistas) */
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

                        /* Igualar tamaño de botones en modales de eliminación */
                        .modal-body .btn-secondary,
                        .modal-body .btn-delete {
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

                        /* Estilos compactos y uniformes */
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
                        /* Badges de los estatus permitidos */
                        .status-en_revision {
                            background-color: #dbeafe; /* azul claro */
                            color: #1e40af; /* azul oscuro */
                        }
                        .status-revisado {
                            background-color: #d1fae5; /* verde claro */
                            color: #065f46; /* verde oscuro */
                        }

                        /* Compatibilidad temporal con estados anteriores */
                        .status-pendiente { background-color: #fef3c7; color: #92400e; }
                        .status-en_proceso { background-color: #dbeafe; color: #1e40af; }
                        .status-completado { background-color: #d1fae5; color: #065f46; }
                        .status-cancelado { background-color: #fee2e2; color: #991b1b; }

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
                         data-last="{{ isset($solicitudes) ? $solicitudes->lastPage() : 1 }}">

                        <!-- Mensajes de sesión -->
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

                        <!-- Controles: búsqueda + contador -->
                        <div class="controls-container">
                            <div class="search-container">
                                <svg xmlns="http://www.w3.org/2000/svg" class="search-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <input 
                                    type="text" 
                                    x-model="search" 
                                    placeholder="Buscar solicitudes..." 
                                    class="search-input"
                                    @input="onSearchInput"
                                />
                            </div>
                            <div class="counter-text">
                                <span x-text="`Mostrando ${visibleRows} de ${totalRowsAll}`"></span>
                            </div>
                            <div>
                                <button type="button" class="btn-filter" @click="showFilters = !showFilters">
                                    Filtros
                                </button>
                            </div>
                        </div>

                        <!-- Panel de filtros -->
                        <div class="filters-panel" x-show="showFilters" x-cloak>
                            <div class="filter-group">
                                <label class="filter-label">Estatus</label>
                                <select class="filter-input" x-model="statusFilter" @change="onStatusChange">
                                    <template x-for="estatus in availableStatuses" :key="estatus">
                                        <option :value="estatus" x-text="formatStatus(estatus)"></option>
                                    </template>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label class="filter-label">Fecha de solicitud</label>
                                <input type="date" class="filter-input" x-model="dateFilter" @change="onDateChange" />
                            </div>
                            <div class="filter-group">
                                <label class="filter-label">Coordinación</label>
                                <select class="filter-input" x-model="coordinacionFilter" @change="onCoordinacionChange">
                                    <option value="">Todas</option>
                                    <template x-for="c in coordinaciones" :key="c.id">
                                        <option :value="c.id" x-text="c.nombre"></option>
                                    </template>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label class="filter-label">Servicios</label>
                                <select class="filter-input" x-model="servicioFilter" @change="onServiceChange">
                                    <option value="">Todos</option>
                                    <template x-for="s in servicios" :key="s.id">
                                        <option :value="s.id" x-text="s.nombre"></option>
                                    </template>
                                    <option value="otros">Otros</option>
                                </select>
                            </div>
                            <div class="filter-group" style="align-self: end;">
                                <label class="filter-label">&nbsp;</label>
                                <button type="button" class="btn-secondary" @click="clearFilters()">
                                    Limpiar filtros
                                </button>
                            </div>
                        </div>

                        <!-- Scroll superior -->
                        <div class="table-scroll-top" x-ref="topScroll">
                            <div class="table-scroll-inner" x-ref="topScrollInner"></div>
                        </div>

                        <!-- Tabla -->
                        <div id="tableContainer" class="table-container">
                            <div class="table-wrapper" x-ref="tableWrapper">
                                <table class="data-table compact-table" x-ref="customTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Teléfono</th>
                                            <th>Correo</th>
                                            <th>Entidad</th>
                                            <th>Servicio</th>
                                            <th>Coordinación</th>
                                            <th>Estatus</th>
                                            <th>Fecha de Solicitud</th>
                                            <th style="text-align: center;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template x-for="solicitud in filteredSolicitudes" :key="solicitud.id">
                                            <tr>
                                                <td x-text="solicitud.id"></td>
                                                <td x-text="solicitud.nombres + ' ' + solicitud.apellido_paterno + ' ' + (solicitud.apellido_materno || '')"></td>
                                                <td x-text="solicitud.telefono"></td>
                                                <td x-text="solicitud.correo_electronico"></td>
                                                <td x-text="(solicitud.entidad_procedencia && solicitud.entidad_procedencia.nombre) || solicitud.entidad_otra || 'N/A'"></td>
                                                <td x-text="(solicitud.servicio && solicitud.servicio.nombre) || solicitud.servicio_otro || 'N/A'"></td>
                                                <td x-text="(solicitud.coordinacion && solicitud.coordinacion.nombre) || 'N/A'"></td>
                                                <td>
                                                    <span class="status-badge" :class="'status-' + solicitud.estatus" x-text="formatStatus(solicitud.estatus)"></span>
                                                </td>
                                                <td x-text="formatDate(solicitud.fecha_solicitud)"></td>
                                                <td style="text-align: center;">
                                                    <button type="button" class="btn-primary" style="margin-right:8px"
                                                        x-show="(solicitud.estatus || '').toLowerCase() !== 'revisado'"
                                                        @click="openReviewedModal(solicitud)">Revisado</button>
                                                    <button type="button" class="btn-primary" style="margin-right:8px"
                                                        x-show="(solicitud.estatus || '').toLowerCase() === 'revisado'"
                                                        @click="openInReviewModal(solicitud)">En Revisión</button>
                                                </td>
                                            </tr>
                                        </template>
                                        <tr x-show="filteredSolicitudes.length === 0">
                                            <td colspan="10" class="no-results">
                                                <span x-show="search">No se encontraron solicitudes que coincidan con la búsqueda.</span>
                                                <span x-show="!search">No hay solicitudes registradas.</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Scroll inferior -->
                        <div class="table-scroll-bottom" x-ref="bottomScroll">
                            <div class="table-scroll-inner" x-ref="bottomScrollInner"></div>
                        </div>

                        <br>
                        <!-- Paginación accesible (sin recargar) -->
                        <nav class="controls-container" aria-label="Paginación">
                            <div style="display:flex;align-items:center;gap:12px;justify-content:flex-end;width:100%">
                                <button type="button" class="btn-secondary" x-show="currentPage > 1" @click="goToPage(currentPage - 1)" aria-label="Página anterior">Anterior</button>
                                <span class="counter-text" x-text="`Página ${currentPage} de ${lastPage}`"></span>
                                <button type="button" class="btn-secondary" x-show="currentPage < lastPage" @click="goToPage(currentPage + 1)" aria-label="Página siguiente">Siguiente</button>
                            </div>
                        </nav>

                        <!-- Modal Confirmar Revisado -->
                        <div x-show="showReviewedModal" x-cloak class="modal-overlay" @click.self="showReviewedModal = false">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="text-lg font-semibold">Confirmar Revisado</h3>
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

                        <!-- Modal Confirmar En Revisión -->
                        <div x-show="showInReviewModal" x-cloak class="modal-overlay" @click.self="showInReviewModal = false">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="text-lg font-semibold">Confirmar En Revisión</h3>
                                    <button @click="showInReviewModal" class="btn-close" aria-label="Cerrar">
                                        <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-gray-600 mb-6">
                                        ¿Estás seguro de desmarcar la solicitud #<span x-text="inReviewData.id" class="font-semibold"></span> de
                                        "<span x-text="inReviewData.nombreCompleto" class="font-semibold"></span>" que ya había sido revisada? Ahora estará como <span class="font-semibold">En revisión</span>.
                                    </p>
                                    <div style="display: flex; justify-content: flex-end; gap: 12px;">
                                        <button type="button" @click="showInReviewModal = false" class="btn-secondary">Cancelar</button>
                                        <button type="button" class="btn-primary" @click="confirmInReview()">En Revisión</button>
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
                // Estado inicial (vacío, se llenará desde data attributes)
                search: '',
                showFilters: false,
                statusFilter: '',
                dateFilter: '',
                coordinacionFilter: '',
                servicioFilter: '',
                availableStatuses: ['todos', 'en_revision', 'revisado'],
                solicitudes: [],
                coordinaciones: [],
                servicios: [],
                otrosServicios: [],
                totalRows: 0,
                totalRowsAll: 0,
                visibleRows: 0,
                currentPage: 1,
                lastPage: 1,
                showReviewedModal: false,
                reviewedData: {},
                showInReviewModal: false,
                inReviewData: {},
                apiUrl: '/solicitudes/data',
                loading: false,

                /**
                 * Inicializa todos los valores desde los data attributes del elemento
                 */
                initServerValues() {
                    const d = this.$el.dataset;
                    
                    // Parsear valores JSON de forma segura
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

                    // Parsear valores numéricos
                    this.totalRows = Number(d.total ?? 0);
                    this.totalRowsAll = Number(d.total ?? 0);
                    this.visibleRows = Number(d.visible ?? 0);
                    this.currentPage = Number(d.current ?? 1);
                    this.lastPage = Number(d.last ?? 1);

                    // Cargar parámetros actuales del URL en los filtros para mantenerlos visibles
                    const url = new URL(window.location.href);
                    this.search = url.searchParams.get('q') || '';
                    this.dateFilter = url.searchParams.get('fecha') || '';
                    this.coordinacionFilter = url.searchParams.get('coordinacion_id') || '';
                    // No abrir panel de filtros automáticamente
                    // this.showFilters = false;
                    // Obtener totales globales y datos iniciales del endpoint
                    this.fetchSolicitudes(this.currentPage);
                 },

                /** Construye los parámetros de consulta según el estado actual */
                buildParams(page = 1) {
                    const params = new URLSearchParams();
                    if (this.search) params.set('q', this.search.trim());
                    if (this.dateFilter) params.set('fecha', this.dateFilter);
                    if (this.coordinacionFilter) params.set('coordinacion_id', this.coordinacionFilter);
                    if (this.statusFilter && this.statusFilter !== 'todos') params.set('status', this.statusFilter);
                    const val = String(this.servicioFilter || '').trim();
                    if (val) {
                        const isNumeric = /^[0-9]+$/.test(val);
                        if (isNumeric) {
                            params.set('servicio_id', val);
                        } else if (val === 'otros') {
                            params.set('servicio', 'otros');
                        }
                    }
                    if (page && page > 1) params.set('page', String(page));
                    return params;
                },

                /** Actualiza la URL sin recargar la página */
                updateUrlParams(params) {
                    const url = new URL(window.location.href);
                    url.search = params.toString();
                    history.replaceState({}, '', url.toString());
                },

                /** Obtiene solicitudes del servidor con filtros actuales */
                async fetchSolicitudes(page = 1) {
                    try {
                        this.loading = true;
                        const params = this.buildParams(page);
                        this.updateUrlParams(params);
                        const res = await fetch(`${this.apiUrl}?${params.toString()}`, {
                            headers: { 'Accept': 'application/json' }
                        });
                        if (!res.ok) throw new Error('Error al obtener datos');
                        const json = await res.json();
                        this.solicitudes = Array.isArray(json.data) ? json.data : [];
                        const meta = json.meta || {};
                        this.currentPage = meta.current_page || 1;
                        this.lastPage = meta.last_page || 1;
                        this.totalRows = meta.total || this.solicitudes.length;
                        this.totalRowsAll = (meta.total_all !== undefined) ? meta.total_all : this.totalRowsAll;
                        this.visibleRows = this.solicitudes.length;
                    } catch (e) {
                        console.error(e);
                        alert('Ocurrió un error al aplicar filtros.');
                    } finally {
                        this.loading = false;
                    }
                },

                /** Aplica filtros y recarga datos de la página 1 */
                applyFilters() {
                    this.fetchSolicitudes(1);
                },

                /** Navega a una página específica sin recargar */
                goToPage(page) {
                    if (!page || page < 1 || page > this.lastPage) return;
                    this.fetchSolicitudes(page);
                },

                /** Maneja cambios en el filtro de estatus */
                onStatusChange() {
                    this.applyFilters();
                },

                /** Maneja cambios en el filtro de servicio */
                onServiceChange() {
                    this.applyFilters();
                },

                /** Maneja cambios en coordinación */
                onCoordinacionChange() {
                    this.applyFilters();
                },

                /** Maneja cambios en fecha */
                onDateChange() {
                    this.applyFilters();
                },

                /** Maneja búsqueda con debounce */
                searchDebounceId: null,
                onSearchInput() {
                    clearTimeout(this.searchDebounceId);
                    this.searchDebounceId = setTimeout(() => this.applyFilters(), 300);
                },

                /**
                 * Abre el modal para marcar como revisado
                 */
                openReviewedModal(solicitud) {
                    const nombre = `${solicitud.nombres} ${solicitud.apellido_paterno} ${solicitud.apellido_materno || ''}`.trim();
                    this.reviewedData = {
                        id: solicitud.id,
                        nombreCompleto: nombre,
                        ref: solicitud
                    };
                    this.showReviewedModal = true;
                },

                /**
                 * Abre el modal para revertir a "En Revisión"
                 */
                openInReviewModal(solicitud) {
                    const nombre = `${solicitud.nombres} ${solicitud.apellido_paterno} ${solicitud.apellido_materno || ''}`.trim();
                    this.inReviewData = {
                        id: solicitud.id,
                        nombreCompleto: nombre,
                        ref: solicitud
                    };
                    this.showInReviewModal = true;
                },

                /**
                 * Confirma y marca la solicitud como revisada
                 */
                async confirmReviewed() {
                    try {
                        const token = document.querySelector('meta[name=csrf-token]')?.getAttribute('content');
                        const res = await fetch(`/solicitudes/${this.reviewedData.id}/revisado`, {
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
                        
                        // Actualizar el estado local
                        this.reviewedData.ref.estatus = 'revisado';
                        this.reviewedData.ref.fecha_actualizacion = data.fecha_actualizacion || this.reviewedData.ref.fecha_actualizacion;
                        
                        this.showReviewedModal = false;
                    } catch (e) {
                        console.error(e);
                        alert('Ocurrió un error al marcar como revisado.');
                    }
                },

                /**
                 * Confirma y revierte la solicitud a "En Revisión"
                 */
                async confirmInReview() {
                    try {
                        const token = document.querySelector('meta[name=csrf-token]')?.getAttribute('content');
                        const res = await fetch(`/solicitudes/${this.inReviewData.id}/en_revision`, {
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
                        
                        // Actualizar el estado local
                        this.inReviewData.ref.estatus = 'en_revision';
                        this.inReviewData.ref.fecha_actualizacion = data.fecha_actualizacion || this.inReviewData.ref.fecha_actualizacion;
                        
                        this.showInReviewModal = false;
                    } catch (e) {
                        console.error(e);
                        alert('Ocurrió un error al revertir la solicitud a En Revisión.');
                    }
                },

                /**
                 * Computed property: solicitudes filtradas
                 */
                get filteredSolicitudes() {
                    // Los datos ya vienen filtrados y paginados desde el servidor
                    this.visibleRows = this.solicitudes.length;
                    return [...this.solicitudes].sort((a, b) => b.id - a.id);
                },

                /**
                 * Formatea una fecha para mostrarla
                 */
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

                /**
                 * Formatea el texto de un estatus
                 */
                formatStatus(s) {
                    const map = {
                        'todos': 'Todos',
                        'en_revision': 'En revisión',
                        'revisado': 'Revisado'
                    };
                    const k = (s || '').toLowerCase();
                    return map[k] ?? (s || 'N/A');
                },

                /**
                 * Inicializa la sincronización de scrolls
                 */
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

                /**
                 * Limpia todos los filtros
                 */
                clearFilters() {
                    this.statusFilter = 'todos';
                    this.dateFilter = '';
                    this.coordinacionFilter = '';
                    this.servicioFilter = '';
                    this.search = '';
                    // No abrir panel de filtros automáticamente
                    this.showFilters = false;
                    // Actualizar URL sin parámetros y cargar primera página sin recargar
                    const params = new URLSearchParams();
                    this.updateUrlParams(params);
                    this.fetchSolicitudes(1);
                }
            };
        }

        /**
         * Inicializa la animación de carga de la tabla
         */
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('tableContainer');
            if (container) {
                container.classList.add('loaded');
            }
        });
    </script>
</x-app-layout>