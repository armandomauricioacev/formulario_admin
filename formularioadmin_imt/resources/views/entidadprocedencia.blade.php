<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Entidades de Procedencia') }}
        </h2>
    </x-slot>

    <style>
        [x-cloak] { display: none !important; }
        
        .table-container {
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }
        .table-container.loaded {
            opacity: 1;
        }
        
        .custom-table {
            width: 100%;
            min-width: 1100px;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            table-layout: auto;
        }
        
        .custom-table th {
            background: #f8fafc;
            padding: 12px 16px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            white-space: nowrap;
        }
        
        .custom-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 14px;
            white-space: nowrap;
        }
        
        .custom-table tr:hover {
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
        
        .btn-edit {
            background: #10b981;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.2s;
            margin-right: 8px;
        }
        
        .btn-edit:hover {
            background: #059669;
        }
        
        .btn-delete {
            background: #ef4444;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .btn-delete:hover {
            background: #dc2626;
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
        }
        
        .search-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .counter-text {
            color: #6b7280;
            font-size: 14px;
        }
        
        .controls-container {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-bottom: 20px;
            gap: 16px;
        }
        
        .table-wrapper {
            width: 100%;
            overflow-x: auto;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
        }
        
        .table-wrapper::-webkit-scrollbar {
            height: 8px;
        }
        
        .table-wrapper::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }
        
        .table-wrapper::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        
        .table-wrapper::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        .btn-primary {
            background: #3b82f6;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .btn-primary:hover {
            background: #2563eb;
        }
        
        .btn-secondary {
            background: #6b7280;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .btn-secondary:hover {
            background: #4b5563;
        }
        
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
        
        .modal-body {
            padding: 24px;
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
        
        .form-input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }
        
        .form-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }
        
        .btn-close {
            color: #9ca3af;
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            transition: color 0.2s;
        }
        
        .btn-close:hover {
            color: #6b7280;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
        }/* Scrolls superiores e inferiores, igual que en Trámites */
        .table-scroll-top {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 8px;
            height: 12px;
            touch-action: pan-x;
        }
        .table-scroll-top::-webkit-scrollbar { height: 8px; }
        .table-scroll-top::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 4px; }
        .table-scroll-top::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .table-scroll-top::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        .table-scroll-bottom {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-top: 8px;
            height: 12px;
            touch-action: pan-x;
        }
        .table-scroll-bottom::-webkit-scrollbar { height: 8px; }
        .table-scroll-bottom::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 4px; }
        .table-scroll-bottom::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .table-scroll-bottom::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* Ocultar scrollbar del contenedor principal como en Trámites */
        .table-wrapper {
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE y Edge */
            touch-action: pan-x;
            overscroll-behavior-x: contain;
        }
        .table-wrapper::-webkit-scrollbar { display: none; }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="min-height: 600px;">
                <div class="p-6 text-gray-900 table-container" id="tableContainer">
                    
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-error">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-error">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <div class="w-full min-w-0" 
                         x-data="{
                            entidades: {{ json_encode($entidades) }},
                            searchQuery: '',
                            totalRows: {{ $entidades->count() }},
                            visibleRows: {{ $entidades->count() }},
                            showCreateModal: false,
                            showEditModal: false,
                            showDeleteModal: false,
                            editData: {},
                            deleteData: {},
                            
                            normalize(text) {
                                return String(text || '').toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
                            },
                            
                            get filteredEntidades() {
                                if (!this.searchQuery) {
                                    this.visibleRows = this.totalRows;
                                    return [...this.entidades].sort((a, b) => b.id - a.id);
                                }
                                
                                const query = this.normalize(this.searchQuery);
                                const filtered = this.entidades.filter(entidad => {
                                    return this.normalize(entidad.nombre).includes(query)
                                        || this.normalize(entidad.id.toString()).includes(query)
                                        || this.normalize(entidad.descripcion).includes(query);
                                });
                                
                                this.visibleRows = filtered.length;
                                return filtered.sort((a, b) => b.id - a.id);
                            },
                            
                            openEditModal(entidad) {
                                this.editData = {
                                    id: entidad.id,
                                    nombre: entidad.nombre,
                                    descripcion: entidad.descripcion || ''
                                };
                                this.showEditModal = true;
                            },
                            
                            openDeleteModal(entidad) {
                                this.deleteData = {
                                    id: entidad.id,
                                    nombre: entidad.nombre
                                };
                                this.showDeleteModal = true;
                            },
                            
                            formatDate(dateString) {
                                if (!dateString) return 'N/A';
                                return new Date(dateString).toLocaleString('es-MX', {
                                    year: 'numeric',
                                    month: '2-digit',
                                    day: '2-digit',
                                    hour: '2-digit',
                                    minute: '2-digit'
                                });
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
                                            if (innerTop) { innerTop.style.width = w + 'px'; innerTop.style.height = '1px'; }
                                            if (innerBottom) { innerBottom.style.width = w + 'px'; innerBottom.style.height = '1px'; }
                                        }
                                    };
                                    updateWidths();
                                    window.addEventListener('resize', updateWidths);

                                    let syncing = false;
                                    const setScroll = (el, val) => { if (el && el.scrollLeft !== val) el.scrollLeft = val; };

                                    const onTopScroll = () => {
                                        if (syncing) return; syncing = true;
                                        setScroll(wrapper, top.scrollLeft);
                                        setScroll(bottom, top.scrollLeft);
                                        syncing = false;
                                    };
                                    const onBottomScroll = () => {
                                        if (syncing) return; syncing = true;
                                        setScroll(wrapper, bottom.scrollLeft);
                                        setScroll(top, bottom.scrollLeft);
                                        syncing = false;
                                    };
                                    const onWrapperScroll = () => {
                                        if (syncing) return; syncing = true;
                                        setScroll(top, wrapper.scrollLeft);
                                        setScroll(bottom, wrapper.scrollLeft);
                                        syncing = false;
                                    };

                                    if (top) top.addEventListener('scroll', onTopScroll);
                                    if (bottom) bottom.addEventListener('scroll', onBottomScroll);
                                    if (wrapper) wrapper.addEventListener('scroll', onWrapperScroll);
                                });
                            }
                         }" x-init="initScrollSync()">
                        
                        <div class="controls-container">
                            <button @click="showCreateModal = true" class="btn-primary">
                                + Agregar Entidad de Procedencia
                            </button>
                            
                            <div class="search-container">
                                <svg xmlns="http://www.w3.org/2000/svg" class="search-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <input 
                                    type="text" 
                                    x-model="searchQuery"
                                    placeholder="Buscar entidades..." 
                                    class="search-input"
                                />
                            </div>
                            
                            <div class="counter-text">
                                <span x-text="`Mostrando ${visibleRows} de ${totalRows}`"></span>
                            </div>
                        </div>

                        @if($entidades->count() > 0)
                            <div class="table-scroll-top" x-ref="topScroll">
                                <div class="table-scroll-inner" x-ref="topScrollInner"></div>
                            </div>
                            <div class="table-wrapper" x-ref="tableWrapper">
                                <table class="custom-table compact-table" x-ref="customTable">
                                    <thead>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Fecha de Creación</th>
        <th style="text-align: center;">Acciones</th>
    </tr>
</thead>
                                    <tbody>
                                        <template x-for="entidad in filteredEntidades" :key="entidad.id">
                                            <tr>
                                                <td x-text="entidad.id"></td>
                                                <td x-text="entidad.nombre"></td>
                                                <td x-text="formatDate(entidad.fecha_creacion)"></td>
                                                <td style="text-align: center;">
                                                    <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                                                        <button 
                                                            @click="openEditModal(entidad)"
                                                            class="btn-edit"
                                                        >
                                                            Editar
                                                        </button>
                                                        <button 
                                                            @click="openDeleteModal(entidad)"
                                                            class="btn-delete"
                                                        >
                                                            Eliminar
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-scroll-bottom" x-ref="bottomScroll">
                                <div class="table-scroll-inner" x-ref="bottomScrollInner"></div>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500">No hay entidades de procedencia registradas.</p>
                            </div>
                        @endif

                        <!-- Modal Crear -->
                        <div x-show="showCreateModal" x-cloak class="modal-overlay" @click.self="showCreateModal = false">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="text-lg font-semibold">Crear Nueva Entidad de Procedencia</h3>
                                    <button @click="showCreateModal = false" class="btn-close" aria-label="Cerrar">
                                        <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <form method="POST" action="{{ route('entidades-procedencia.store') }}" class="modal-body">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label">Nombre *</label>
                                        <input type="text" name="nombre" class="form-input" required />
                                    </div>
                                    
                                    <!-- Sección de descripción eliminada -->

                                    <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px;">
                                        <button type="button" @click="showCreateModal = false" class="btn-secondary">Cancelar</button>
                                        <button type="submit" class="btn-primary">Crear</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Modal Editar -->
                        <div x-show="showEditModal" x-cloak class="modal-overlay" @click.self="showEditModal = false">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="text-lg font-semibold">Editar Entidad de Procedencia #<span x-text="editData.id"></span></h3>
                                    <button @click="showEditModal = false" class="btn-close" aria-label="Cerrar">
                                        <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <form method="POST" :action="`/entidades-procedencia/${editData.id}`" class="modal-body">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label class="form-label">Nombre *</label>
                                        <input type="text" name="nombre" x-model="editData.nombre" class="form-input" required />
                                    </div>
                                    
                                    <!-- Sección de descripción eliminada -->

                                    <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px;">
                                        <button type="button" @click="showEditModal = false" class="btn-secondary">Cancelar</button>
                                        <button type="submit" class="btn-primary">Actualizar</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Modal Eliminar -->
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
                                        ¿Estás seguro de que deseas eliminar la entidad de procedencia "<span x-text="deleteData.nombre" class="font-semibold"></span>"?
                                    </p>
                                    <p class="text-sm text-red-600 mb-6">
                                        Esta acción no se puede deshacer.
                                    </p>
                                    <div style="display: flex; justify-content: flex-end; gap: 12px;">
                                        <button type="button" @click="showDeleteModal = false" class="btn-secondary">Cancelar</button>
                                        <form method="POST" :action="`/entidades-procedencia/${deleteData.id}`" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete">Eliminar</button>
                                        </form>
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
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                const container = document.getElementById('tableContainer');
                if (container) {
                    container.classList.add('loaded');
                }
            }, 100);
        });
    </script>
</x-app-layout>









