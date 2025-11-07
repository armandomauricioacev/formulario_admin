<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Coordinaciones') }}
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
            min-width: 1400px;
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
        /* Igualar tamaño de botones en modales de eliminación */
        .modal-body .btn-secondary,
        .modal-body .btn-delete {
            padding: 8px 12px;
            font-size: 14px;
            border-radius: 6px;
            min-width: 120px;
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
                            coordinaciones: {{ json_encode($coordinaciones) }},
                            searchQuery: '',
                            totalRows: {{ $coordinaciones->count() }},
                            visibleRows: {{ $coordinaciones->count() }},
                            showCreateModal: false,
                            showEditModal: false,
                            showDeleteModal: false,
                            showRepresentanteModal: false,
                            editData: {},
                            deleteData: {},
                            createData: { nombre: '', coordinador: '', correo_coordinador: '', asistente: '', correo_asistente: '' },
                            createErrors: {},
                            repData: { representante: '', correo_representante: '' },
                            globalRepresentante: {{ json_encode($globalRepresentante ?? '') }},
                            globalCorreoRepresentante: {{ json_encode($globalCorreoRepresentante ?? '') }},
                            
                            normalize(text) {
                                return String(text || '').toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
                            },
                            
                            get filteredCoordinaciones() {
                                if (!this.searchQuery) {
                                    this.visibleRows = this.totalRows;
                                    return [...this.coordinaciones].sort((a, b) => b.id - a.id);
                                }
                                
                                const query = this.normalize(this.searchQuery);
                            const filtered = this.coordinaciones.filter(coordinacion => {
                                return this.normalize(coordinacion.nombre).includes(query) ||
                                       this.normalize(coordinacion.id.toString()).includes(query) ||
                                       this.normalize(coordinacion.coordinador).includes(query) ||
                                       this.normalize(coordinacion.asistente).includes(query) ||
                                       this.normalize(coordinacion.correo_coordinador).includes(query) ||
                                       this.normalize(coordinacion.correo_asistente).includes(query);
                            });
                                
                                this.visibleRows = filtered.length;
                                return filtered.sort((a, b) => b.id - a.id);
                            },
                            
                            openEditModal(coordinacion) {
                                this.editData = {
                                    id: coordinacion.id,
                                    nombre: coordinacion.nombre,
                                    coordinador: coordinacion.coordinador || '',
                                    correo_coordinador: coordinacion.correo_coordinador || '',
                                    asistente: coordinacion.asistente || '',
                                    correo_asistente: coordinacion.correo_asistente || ''
                                };
                                this.showEditModal = true;
                            },
                            
                            openDeleteModal(coordinacion) {
                                this.deleteData = {
                                    id: coordinacion.id,
                                    nombre: coordinacion.nombre
                                };
                                this.showDeleteModal = true;
                            },
                            openRepresentanteModal() {
                                this.repData = {
                                    representante: this.globalRepresentante || '',
                                    correo_representante: this.globalCorreoRepresentante || ''
                                };
                                this.showRepresentanteModal = true;
                            },

                            validateEmail(email) {
                                if (!email) return true;
                                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                                return re.test(String(email).toLowerCase());
                            },

                            validateAndSubmitCreate() {
                                this.createErrors = {};
                                if (!this.createData.nombre || !this.createData.nombre.trim()) {
                                    this.createErrors.nombre = 'El nombre es obligatorio.';
                                }
                                if (this.createData.correo_coordinador && !this.validateEmail(this.createData.correo_coordinador)) {
                                    this.createErrors.correo_coordinador = 'Correo de coordinador inválido.';
                                }
                                if (this.createData.correo_asistente && !this.validateEmail(this.createData.correo_asistente)) {
                                    this.createErrors.correo_asistente = 'Correo de asistente inválido.';
                                }
                                if (this.createData.correo_representante && !this.validateEmail(this.createData.correo_representante)) {
                                    this.createErrors.correo_representante = 'Correo de representante inválido.';
                                }
                                if (Object.keys(this.createErrors).length === 0) {
                                    this.$refs.createForm.submit();
                                }
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
                                + Agregar Coordinación
                            </button>
                            <button @click="openRepresentanteModal()" class="btn-secondary" style="margin-left: 8px;">
                                Representante
                            </button>
                            
                            
                            <div class="search-container">
                                <svg xmlns="http://www.w3.org/2000/svg" class="search-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <input 
                                    type="text" 
                                    x-model="searchQuery"
                                    placeholder="Buscar por nombre, rol o correo..." 
                                    class="search-input"
                                />
                            </div>
                            
                            <div class="counter-text">
                                <span x-text="`Mostrando ${visibleRows} de ${totalRows}`"></span>
                            </div>
                        </div>

                        @if($coordinaciones->count() > 0)
                            <div class="table-scroll-top" x-ref="topScroll">
                                <div class="table-scroll-inner" x-ref="topScrollInner"></div>
                            </div>
                            <div class="table-wrapper" x-ref="tableWrapper">
                                <table class="custom-table compact-table" x-ref="customTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Coordinador</th>
                                            <th>Correo Coordinador</th>
                                            <th>Asistente</th>
                                            <th>Correo Asistente</th>
                                            <th>Fecha de Creación</th>
                                            <th style="text-align: center;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template x-for="coordinacion in filteredCoordinaciones" :key="coordinacion.id">
                                            <tr>
                                                <td x-text="coordinacion.id"></td>
                                                <td x-text="coordinacion.nombre"></td>
                                                <td x-text="coordinacion.coordinador || '—'"></td>
                                                <td x-text="coordinacion.correo_coordinador || '—'"></td>
                                                <td x-text="coordinacion.asistente || '—'"></td>
                                                <td x-text="coordinacion.correo_asistente || '—'"></td>
                                                <td x-text="formatDate(coordinacion.fecha_creacion)"></td>
                                                <td style="text-align: center;">
                                                    <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                                                        <button 
                                                            @click="openEditModal(coordinacion)"
                                                            class="btn-edit"
                                                        >
                                                            Editar
                                                        </button>
                                                        <button 
                                                            @click="openDeleteModal(coordinacion)"
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
                                <p class="text-gray-500">No hay coordinaciones registradas.</p>
                            </div>
                        @endif

                        <!-- Modal Crear -->
                        <div x-show="showCreateModal" x-cloak class="modal-overlay" @click.self="showCreateModal = false">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="text-lg font-semibold">Crear Nueva Coordinación</h3>
                                    <button @click="showCreateModal = false" class="btn-close" aria-label="Cerrar">
                                        <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <form x-ref="createForm" method="POST" action="{{ route('coordinaciones.store') }}" class="modal-body" @submit.prevent="validateAndSubmitCreate()">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label">Nombre *</label>
                                        <input type="text" name="nombre" class="form-input" x-model="createData.nombre" required />
                                        <p class="text-red-600 text-sm" x-show="createErrors.nombre" x-text="createErrors.nombre"></p>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Coordinador</label>
                                        <input type="text" name="coordinador" class="form-input" x-model="createData.coordinador" />
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Correo Coordinador</label>
                                        <input type="email" name="correo_coordinador" class="form-input" x-model="createData.correo_coordinador" />
                                        <p class="text-red-600 text-sm" x-show="createErrors.correo_coordinador" x-text="createErrors.correo_coordinador"></p>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Asistente</label>
                                        <input type="text" name="asistente" class="form-input" x-model="createData.asistente" />
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Correo Asistente</label>
                                        <input type="email" name="correo_asistente" class="form-input" x-model="createData.correo_asistente" />
                                        <p class="text-red-600 text-sm" x-show="createErrors.correo_asistente" x-text="createErrors.correo_asistente"></p>
                                    </div>
                                    <!-- Los nuevos registros heredan el representante global automáticamente -->
                                    
                                    
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
                                    <h3 class="text-lg font-semibold">Editar Coordinación #<span x-text="editData.id"></span></h3>
                                    <button @click="showEditModal = false" class="btn-close" aria-label="Cerrar">
                                        <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <form method="POST" :action="`/coordinaciones/${editData.id}`" class="modal-body">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label class="form-label">Nombre *</label>
                                        <input type="text" name="nombre" x-model="editData.nombre" class="form-input" required />
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Coordinador</label>
                                        <input type="text" name="coordinador" x-model="editData.coordinador" class="form-input" />
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Correo Coordinador</label>
                                        <input type="email" name="correo_coordinador" x-model="editData.correo_coordinador" class="form-input" />
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Asistente</label>
                                        <input type="text" name="asistente" x-model="editData.asistente" class="form-input" />
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Correo Asistente</label>
                                        <input type="email" name="correo_asistente" x-model="editData.correo_asistente" class="form-input" />
                                    </div>
                                    
                                    
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
                                        ¿Estás seguro de que deseas eliminar la coordinación "<span x-text="deleteData.nombre" class="font-semibold"></span>"?
                                    </p>
                                    <p class="text-sm text-red-600 mb-6">
                                        Esta acción no se puede deshacer.
                                    </p>
                                    <div style="display: flex; justify-content: flex-end; gap: 12px;">
                                        <button type="button" @click="showDeleteModal = false" class="btn-secondary">Cancelar</button>
                                        <form method="POST" :action="`/coordinaciones/${deleteData.id}`" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Representante Global -->
                        <div x-show="showRepresentanteModal" x-cloak class="modal-overlay" @click.self="showRepresentanteModal = false">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="text-lg font-semibold">Actualizar Representante Global</h3>
                                    <button @click="showRepresentanteModal = false" class="btn-close" aria-label="Cerrar">
                                        <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <form method="POST" action="{{ route('coordinaciones.representante.update') }}" class="modal-body">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label">Nombre del Representante</label>
                                        <input type="text" name="representante" class="form-input" x-model="repData.representante" />
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Correo del Representante</label>
                                        <input type="email" name="correo_representante" class="form-input" x-model="repData.correo_representante" />
                                    </div>
                                    <!-- Nueva sección: contraseña para crear/actualizar usuario admin -->
                                    <div class="form-group">
                                        <label class="form-label">Contraseña del Admin</label>
                                        <input type="password" name="password" class="form-input" placeholder="Mínimo 8 caracteres" />
                                        <p class="text-xs text-gray-500 mt-1">Si el usuario no existe, esta contraseña se usará para crearlo. Si ya existe y desea actualizarla, ingrésela aquí.</p>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Confirmar Contraseña</label>
                                        <input type="password" name="password_confirmation" class="form-input" />
                                    </div>
                                    <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px;">
                                        <button type="button" @click="showRepresentanteModal = false" class="btn-secondary">Cancelar</button>
                                        <button type="submit" class="btn-primary">Confirmar</button>
                                    </div>
                                </form>
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