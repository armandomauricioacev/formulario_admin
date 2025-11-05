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

                        /* (El modal de limpiar filtros fue retirado por requerimiento) */
                    </style>

                    <div x-data="{
                        search: '',
                        showFilters: false,
                        statusFilter: 'en_revision',
                        dateFilter: '',
                        coordinacionFilter: '',
                        availableStatuses: [],
                        solicitudes: {{ json_encode($solicitudes ?? []) }},
                        coordinaciones: {{ json_encode($coordinaciones ?? []) }},
                        serverError: {{ json_encode(session('error') ?? '') }},
                        totalRows: {{ isset($solicitudes) ? $solicitudes->count() : 0 }},
                        visibleRows: {{ isset($solicitudes) ? $solicitudes->count() : 0 }},
                        showDeleteModal: false,
                        deleteData: {},
                        showErrorModal: false,
                        errorData: { title: '', message: '', coordinacionId: null, associatedCount: 0 },
                        openDeleteModal(solicitud) {
                            const nombre = `${solicitud.nombres} ${solicitud.apellido_paterno} ${solicitud.apellido_materno || ''}`.trim();
                            this.deleteData = { id: solicitud.id, nombreCompleto: nombre };
                            this.showDeleteModal = true;
                        },
                        get filteredSolicitudes() {
                            let items = [...this.solicitudes];

                            // Filtro por estatus
                            if (this.statusFilter) {
                                const sf = this.statusFilter.toLowerCase();
                                items = items.filter(s => (s.estatus || '').toLowerCase() === sf);
                            }

                            // Filtro por fecha única de solicitud (día exacto)
                            if (this.dateFilter) {
                                const start = new Date(this.dateFilter + 'T00:00:00');
                                const end = new Date(this.dateFilter + 'T23:59:59');
                                items = items.filter(s => {
                                    const d = s.fecha_solicitud ? new Date(s.fecha_solicitud) : null;
                                    return d && d >= start && d <= end;
                                });
                            }

                            // Filtro por coordinación
                            if (this.coordinacionFilter) {
                                const cf = parseInt(this.coordinacionFilter, 10);
                                items = items.filter(s => Number(s.coordinacion_id) === cf);
                            }

                            // (Filtro por servicio eliminado por requerimiento)

                            if (!this.search) {
                                this.visibleRows = items.length;
                                return items.sort((a, b) => b.id - a.id);
                            }
                            const filtered = items.filter(solicitud => {
                                const searchTerm = this.search.toLowerCase();
                                const fullName = (solicitud.nombres + ' ' + solicitud.apellido_paterno + ' ' + (solicitud.apellido_materno || '')).toLowerCase();
                                return fullName.includes(searchTerm) ||
                                       (solicitud.telefono && solicitud.telefono.toLowerCase().includes(searchTerm)) ||
                                       (solicitud.correo_electronico && solicitud.correo_electronico.toLowerCase().includes(searchTerm)) ||
                                       (solicitud.entidad_procedencia && solicitud.entidad_procedencia.nombre && solicitud.entidad_procedencia.nombre.toLowerCase().includes(searchTerm)) ||
                                       (solicitud.entidad_otra && solicitud.entidad_otra.toLowerCase().includes(searchTerm)) ||
                                       (solicitud.servicio && solicitud.servicio.nombre && solicitud.servicio.nombre.toLowerCase().includes(searchTerm)) ||
                                       (solicitud.servicio_otro && solicitud.servicio_otro.toLowerCase().includes(searchTerm)) ||
                                       (solicitud.coordinacion && solicitud.coordinacion.nombre && solicitud.coordinacion.nombre.toLowerCase().includes(searchTerm)) ||
                                       (solicitud.estatus && solicitud.estatus.toLowerCase().includes(searchTerm));
                            });
                            this.visibleRows = filtered.length;
                            return filtered.sort((a, b) => b.id - a.id);
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
                            const map = { 'en_revision': 'En revisión', 'revisado': 'Revisado' };
                            const k = (s || '').toLowerCase();
                            return map[k] ?? (s || 'N/A');
                        },
                        initStatuses() {
                            // Lista de estatus permitidos
                            this.availableStatuses = ['en_revision', 'revisado'];
                        },
                        initErrorModal() {
                            const err = String(this.serverError || '');
                            if (!err) return;
                            const isFkErr = err.includes('FOREIGN KEY') || err.includes('1451') || err.includes('solicitudes_servicios_ibfk_3');
                            if (!isFkErr) return;
                            const match = err.match(/id\s*=\s*(\d+)/i);
                            const coordId = match ? parseInt(match[1], 10) : null;
                            let count = 0;
                            if (coordId) {
                                count = this.solicitudes.filter(s => Number(s.coordinacion_id) === coordId).length;
                            }
                            this.errorData = {
                                title: 'La coordinación está referenciada por solicitudes.',
                                message: 'No se puede eliminar porque existen solicitudes asociadas en la tabla Solicitudes de Servicios. Debe gestionar estas solicitudes antes de eliminar la coordinación.',
                                coordinacionId: coordId,
                                associatedCount: count
                            };
                            this.showErrorModal = true;
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
                                    if (el && el.scrollLeft !== val) el.scrollLeft = val; 
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
                            // Limpieza inmediata sin confirmación
                            this.statusFilter = 'en_revision';
                            this.dateFilter = '';
                            this.coordinacionFilter = '';
                            this.search = '';
                            this.showFilters = false;
                        }
                    }" x-init="initStatuses(); initScrollSync(); initErrorModal()">

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
                                />
                            </div>
                            <div class="counter-text">
                                <span x-text="`Mostrando ${visibleRows} de ${totalRows}`"></span>
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
                                <select class="filter-input" x-model="statusFilter">
                                    <template x-for="estatus in availableStatuses" :key="estatus">
                                        <option :value="estatus" x-text="formatStatus(estatus)"></option>
                                    </template>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label class="filter-label">Fecha de solicitud</label>
                                <input type="date" class="filter-input" x-model="dateFilter" />
                            </div>
                            <div class="filter-group">
                                <label class="filter-label">Coordinación</label>
                                <select class="filter-input" x-model="coordinacionFilter">
                                    <option value="">Todas</option>
                                    <template x-for="c in coordinaciones" :key="c.id">
                                        <option :value="c.id" x-text="c.nombre"></option>
                                    </template>
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
                                                    <button type="button" class="btn-delete" @click="openDeleteModal(solicitud)">Eliminar</button>
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

                        <!-- Modal Confirmar Eliminación de Solicitud -->
                        <div x-show="showDeleteModal" x-cloak class="modal-overlay" @click.self="showDeleteModal = false">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="text-lg font-semibold">Confirmar Eliminación</h3>
                                    <button @click="showDeleteModal = false" class="btn-close" aria-label="Cerrar">
                                        <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-gray-600 mb-6">
                                        ¿Estás seguro de eliminar la solicitud #<span x-text="deleteData.id" class="font-semibold"></span> de
                                        "<span x-text="deleteData.nombreCompleto" class="font-semibold"></span>"?
                                    </p>
                                    <p class="text-sm text-red-600 mb-6">Esta acción no se puede deshacer.</p>
                                    <div style="display: flex; justify-content: flex-end; gap: 12px;">
                                        <button type="button" @click="showDeleteModal = false" class="btn-secondary">Cancelar</button>
                                        <form method="POST" :action="`/solicitudes/${deleteData.id}`" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Error por Integridad Referencial (Coordinación) -->
                        <div x-show="showErrorModal" x-cloak class="modal-overlay" @click.self="showErrorModal = false">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="text-lg font-semibold">No se puede eliminar la coordinación</h3>
                                    <button @click="showErrorModal = false" class="btn-close" aria-label="Cerrar">
                                        <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div style="display:flex; align-items:center; gap:12px; margin-bottom:12px;">
                                        <svg style="width: 24px; height: 24px; color: #dc2626;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M4.93 4.93a10 10 0 1114.14 14.14A10 10 0 014.93 4.93z" />
                                        </svg>
                                        <span class="text-red-700" x-text="errorData.title"></span>
                                    </div>
                                    <p class="text-gray-700 mb-4" x-text="errorData.message"></p>
                                    <template x-if="errorData.coordinacionId">
                                        <p class="text-gray-600 mb-4">
                                            Coordinación afectada: #<span x-text="errorData.coordinacionId"></span>. Solicitudes asociadas: 
                                            <span class="font-semibold" x-text="errorData.associatedCount"></span>.
                                        </p>
                                    </template>
                                    <div class="text-sm text-gray-600 mb-6">
                                        Alternativas:
                                        <ul class="list-disc list-inside">
                                            <li>Desvincular primero las solicitudes o reasignarlas a otra coordinación.</li>
                                            <li>Eliminar las solicitudes asociadas antes de eliminar la coordinación.</li>
                                            <li>Configurar eliminación en cascada (requiere cambio de esquema, p.ej. ON DELETE SET NULL/CASCADE).</li>
                                        </ul>
                                    </div>
                                    <div style="display: flex; justify-content: flex-end; gap: 12px;">
                                        <button type="button" class="btn-secondary" @click="if (errorData.coordinacionId) { coordinacionFilter = String(errorData.coordinacionId); showErrorModal = false; } else { showErrorModal = false; }">Ver solicitudes asociadas</button>
                                        <button type="button" class="btn-primary" @click="showErrorModal = false">Entendido</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- (Modal de limpiar filtros removido por requerimiento) -->

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('tableContainer');
            if (container) {
                container.classList.add('loaded');
            }
        });
    </script>
</x-app-layout>