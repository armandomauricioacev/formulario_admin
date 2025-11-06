<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Correos de Notificación
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 rounded bg-green-100 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('correos.update') }}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Solicitante -->
                    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800 border-b border-gray-200 pb-2">
                            Correo para Solicitante
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                                <input type="text" name="solicitante[titulo]" value="{{ old('solicitante.titulo', $correos['solicitante']->titulo ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" />
                                @error('solicitante.titulo')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Contenido</label>
                                <textarea name="solicitante[cuerpo]" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('solicitante.cuerpo', $correos['solicitante']->cuerpo ?? '') }}</textarea>
                                @error('solicitante.cuerpo')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Despedida</label>
                                <input type="text" name="solicitante[despedida]" value="{{ old('solicitante.despedida', $correos['solicitante']->despedida ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" />
                                @error('solicitante.despedida')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Coordinador -->
                    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800 border-b border-gray-200 pb-2">
                            Correo para Coordinador
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                                <input type="text" name="coordinador[titulo]" value="{{ old('coordinador.titulo', $correos['coordinador']->titulo ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" />
                                @error('coordinador.titulo')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Contenido</label>
                                <textarea name="coordinador[cuerpo]" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('coordinador.cuerpo', $correos['coordinador']->cuerpo ?? '') }}</textarea>
                                @error('coordinador.cuerpo')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Despedida</label>
                                <input type="text" name="coordinador[despedida]" value="{{ old('coordinador.despedida', $correos['coordinador']->despedida ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" />
                                @error('coordinador.despedida')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Asistente -->
                    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800 border-b border-gray-200 pb-2">
                            Correo para Asistente
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                                <input type="text" name="asistente[titulo]" value="{{ old('asistente.titulo', $correos['asistente']->titulo ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" />
                                @error('asistente.titulo')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Contenido</label>
                                <textarea name="asistente[cuerpo]" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('asistente.cuerpo', $correos['asistente']->cuerpo ?? '') }}</textarea>
                                @error('asistente.cuerpo')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Despedida</label>
                                <input type="text" name="asistente[despedida]" value="{{ old('asistente.despedida', $correos['asistente']->despedida ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" />
                                @error('asistente.despedida')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Representante -->
                    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800 border-b border-gray-200 pb-2">
                            Correo para Representante
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                                <input type="text" name="representante[titulo]" value="{{ old('representante.titulo', $correos['representante']->titulo ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" />
                                @error('representante.titulo')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Contenido</label>
                                <textarea name="representante[cuerpo]" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('representante.cuerpo', $correos['representante']->cuerpo ?? '') }}</textarea>
                                @error('representante.cuerpo')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Despedida</label>
                                <input type="text" name="representante[despedida]" value="{{ old('representante.despedida', $correos['representante']->despedida ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" />
                                @error('representante.despedida')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <x-primary-button class="bg-green-600 hover:bg-green-700 focus:bg-green-700">
                        Guardar cambios
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>