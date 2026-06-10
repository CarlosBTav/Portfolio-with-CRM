<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $client->exists ? __('Editar Cliente') : __('Registrar Nuevo Cliente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Formulario Inteligente -->
                    <form action="{{ $client->exists ? route('clients.update', $client) : route('clients.store') }}" 
                          method="POST" 
                          class="space-y-6">
                        
                        @csrf
                        
                        @if($client->exists)
                            @method('PUT')
                        @endif

                        @if(! $client->exists && ($linkProject ?? null))
                            <input type="hidden" name="project_id" value="{{ $linkProject->id }}">
                            <p class="rounded-lg border border-indigo-100 bg-indigo-50 px-4 py-3 text-sm text-indigo-900">
                                Este cliente se vinculará al proyecto <span class="font-semibold">{{ $linkProject->title }}</span> al guardarlo.
                            </p>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nombre Comercial -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nombre Comercial / Razón Social</label>
                                <input type="text" name="commercial_name" value="{{ old('commercial_name', $client->commercial_name) }}" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <!-- Tipo de Cliente -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tipo</label>
                                <select name="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="company" {{ old('type', $client->type) == 'company' ? 'selected' : '' }}>Empresa</option>
                                    <option value="individual" {{ old('type', $client->type) == 'individual' ? 'selected' : '' }}>Particular / Autónomo</option>
                                </select>
                            </div>

                            <!-- CIF / NIF -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">CIF / NIF</label>
                                <input type="text" name="tax_id" value="{{ old('tax_id', $client->tax_id) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Notas Internas -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Notas Internas (Privado)</label>
                            <textarea name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes', $client->notes) }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">Información visible solo para administradores.</p>
                        </div>

                        @if(($documentationVersionOptions ?? []) !== [])
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Documentación pública vinculada</label>
                                <select name="documentation_slug" class="mt-1 block w-full max-w-xl rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">{{ __('Ninguna') }}</option>
                                    @foreach($documentationVersionOptions as $documentationSlugOption => $documentationTitleOption)
                                        <option value="{{ $documentationSlugOption }}" @selected(old('documentation_slug', $client->documentation_slug) === $documentationSlugOption)>{{ $documentationTitleOption }}</option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-gray-500 mt-1">{{ __('Opcional: aparece como enlace desde esta ficha hacia una página tipo /documentacion/{slug}.') }}</p>
                            </div>
                        @endif

                        <!-- Botones -->
                        <div class="flex justify-end gap-4 pt-4 border-t border-gray-100">
                            <a href="{{ ($linkProject ?? null) ? route('projects.edit', $linkProject) : route('clients.index') }}" class="bg-gray-200 py-2 px-4 rounded hover:bg-gray-300 text-gray-700 transition">Cancelar</a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition shadow-md">
                                {{ $client->exists ? 'Actualizar Cliente' : 'Guardar Cliente' }}
                            </button>
                        </div>
                    </form>

                    <!-- FIN DEL FORMULARIO PRINCIPAL -->
                    
                    
                    <!-- SECCIÓN DE CONTACTOS (Solo visible al editar) -->
                    @if($client->exists)
                        <div class="mt-12 pt-8 border-t border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Agenda de Contactos</h3>
                            
                            <!-- Lista de Contactos -->
                            <div class="bg-gray-50 rounded-lg border border-gray-200 overflow-hidden mb-6">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                                            
                                            <!-- OCULTAR CARGO SI ES PARTICULAR -->
                                            @if($client->type === 'company')
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cargo</th>
                                            @endif

                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Datos de Contacto</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Notas</th>
                                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($client->contacts as $contact)
                                            <!-- Inicializamos Alpine para controlar el modal de esta fila -->
                                            <tr x-data="{ openEditModal: false }">
                                                <td class="px-4 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                                    {{ $contact->first_name }} {{ $contact->last_name }}
                                                </td>

                                                @if($client->type === 'company')
                                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $contact->position ?? '-' }}
                                                    </td>
                                                @endif

                                                <td class="px-4 py-4 text-sm text-gray-600">
                                                    <div class="flex flex-col gap-1">
                                                        @php 
                                                            $email = $contact->contactMethods->where('type', 'email')->first();
                                                            $phone = $contact->contactMethods->where('type', 'phone')->first();
                                                        @endphp
                                                        
                                                        @if($email)
                                                            <div class="flex items-center gap-2">
                                                                <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                                                <span>{{ $email->value }}</span>
                                                            </div>
                                                        @endif

                                                        @if($phone)
                                                            <div class="flex items-center gap-2">
                                                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                                                <span>{{ $phone->value }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                                
                                                <td class="px-4 py-4 text-sm text-gray-500 italic max-w-xs truncate">
                                                    {{ $contact->notes ?? '-' }}
                                                </td>

                                                <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <div class="flex items-center justify-end gap-2">
                                                        <!-- BOTÓN EDITAR (Abre Modal) -->
                                                        <button type="button" @click="openEditModal = true" class="text-indigo-600 hover:text-indigo-900 font-bold">
                                                            Editar
                                                        </button>

                                                        <span class="text-gray-300">|</span>

                                                        <form action="{{ route('contacts.destroy', $contact) }}" method="POST" class="inline">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Eliminar a {{ $contact->first_name }}?')">
                                                                Borrar
                                                            </button>
                                                        </form>
                                                    </div>

                                                    <!-- MODAL DE EDICIÓN -->
                                                    <div x-show="openEditModal" 
                                                        style="display: none;"
                                                        class="fixed inset-0 z-50 overflow-y-auto" 
                                                        aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                                        
                                                        <!-- Fondo Oscuro -->
                                                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                            <div x-show="openEditModal" 
                                                                @click="openEditModal = false"
                                                                class="fixed inset-0 bg-gray-500/75 transition-opacity"></div>

                                                            <!-- Contenido del Modal -->
                                                            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                                                                <form action="{{ route('contacts.update', $contact) }}" method="POST">
                                                                    @csrf @method('PUT')
                                                                    
                                                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                                                                            Editar Contacto
                                                                        </h3>
                                                                        
                                                                        <div class="grid grid-cols-2 gap-4">
                                                                            <div class="col-span-1">
                                                                                <label class="block text-xs text-gray-500 mb-1">Nombre</label>
                                                                                <input type="text" name="first_name" value="{{ $contact->first_name }}" required class="w-full text-sm rounded-md border-gray-300">
                                                                            </div>
                                                                            <div class="col-span-1">
                                                                                <label class="block text-xs text-gray-500 mb-1">Apellidos</label>
                                                                                <input type="text" name="last_name" value="{{ $contact->last_name }}" class="w-full text-sm rounded-md border-gray-300">
                                                                            </div>
                                                                            
                                                                            @if($client->type === 'company')
                                                                                <div class="col-span-2">
                                                                                    <label class="block text-xs text-gray-500 mb-1">Cargo</label>
                                                                                    <input type="text" name="position" value="{{ $contact->position }}" class="w-full text-sm rounded-md border-gray-300">
                                                                                </div>
                                                                            @endif

                                                                            <div class="col-span-2">
                                                                                <label class="block text-xs text-gray-500 mb-1">Email</label>
                                                                                <input type="email" name="email" value="{{ $email->value ?? '' }}" class="w-full text-sm rounded-md border-gray-300">
                                                                            </div>

                                                                            <div class="col-span-2">
                                                                                <label class="block text-xs text-gray-500 mb-1">Teléfono</label>
                                                                                <input type="text" name="phone" value="{{ $phone->value ?? '' }}" class="w-full text-sm rounded-md border-gray-300">
                                                                            </div>

                                                                            <div class="col-span-2">
                                                                                <label class="block text-xs text-gray-500 mb-1">Notas</label>
                                                                                <textarea name="notes" rows="2" class="w-full text-sm rounded-md border-gray-300">{{ $contact->notes }}</textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                                                            Guardar Cambios
                                                                        </button>
                                                                        <button type="button" @click="openEditModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                                            Cancelar
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- FIN DEL MODAL -->
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 italic">
                                                    No hay contactos asociados a este cliente.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- FORMULARIO RÁPIDO -->
                            <div class="bg-gray-100 p-5 rounded-lg border border-gray-200">
                                <h4 class="text-sm font-bold text-gray-700 mb-4 uppercase flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                    Añadir Nuevo Contacto
                                </h4>
                                
                                <form action="{{ route('client.contacts.store', $client) }}" method="POST">
                                    @csrf
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                        <div>
                                            <label class="block text-xs text-gray-500 mb-1">Nombre *</label>
                                            <input type="text" name="first_name" required class="w-full text-sm rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        <div>
                                            <label class="block text-xs text-gray-500 mb-1">Apellidos</label>
                                            <input type="text" name="last_name" class="w-full text-sm rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        
                                        <!-- OCULTAR INPUT CARGO SI ES PARTICULAR -->
                                        @if($client->type === 'company')
                                            <div>
                                                <label class="block text-xs text-gray-500 mb-1">Cargo</label>
                                                <input type="text" name="position" class="w-full text-sm rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                        @else
                                            <!-- Input oculto o vacío para mantener el grid alineado si quieres, o simplemente omitirlo -->
                                            <div class="hidden md:block"></div> 
                                        @endif

                                        <div>
                                            <label class="block text-xs text-gray-500 mb-1">Notas Rápidas</label>
                                            <input type="text" name="notes" placeholder="Ej: Llamar solo mañanas" class="w-full text-sm rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                                        <div class="md:col-span-2">
                                            <label class="block text-xs text-gray-500 mb-1">Email</label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                                                </div>
                                                <input type="email" name="email" class="pl-10 w-full text-sm rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                        </div>

                                        <div class="md:col-span-1">
                                            <label class="block text-xs text-gray-500 mb-1">Teléfono</label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                                </div>
                                                <input type="text" name="phone" class="pl-10 w-full text-sm rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                        </div>

                                        <button type="submit" class="w-full bg-gray-800 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-bold transition flex justify-center items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                            Añadir Contacto
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Mensaje si es nuevo cliente -->
                        <div class="mt-8 p-4 bg-yellow-50 text-yellow-800 rounded-lg text-sm border border-yellow-200 flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Guarda el cliente primero para poder añadir su agenda de contactos.</span>
                        </div>
                    @endif

                    <!-- SECCIÓN DE DOCUMENTACIÓN COMPARTIDA -->
                    @if($client->exists)
                        <div class="mt-12 pt-8 border-t border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Documentación compartida</h3>

                            @if(($documentationLinks ?? collect())->isNotEmpty())
                                <div class="space-y-3">
                                    @foreach($documentationLinks as $documentationLink)
                                        <div class="flex flex-col gap-3 rounded-lg border border-indigo-100 bg-indigo-50/50 p-4 md:flex-row md:items-center md:justify-between">
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">{{ $documentationLink['title'] }}</p>
                                                @if(!empty($documentationLink['updated_at']))
                                                    <p class="text-xs text-gray-500">Actualizado: {{ $documentationLink['updated_at'] }}</p>
                                                @endif
                                            </div>
                                            <a
                                                href="{{ route('public.documentation', $documentationLink['slug']) }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700"
                                            >
                                                Ver documentación
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="rounded-lg border border-yellow-200 bg-yellow-50 p-4 text-sm text-yellow-800">
                                    Este cliente todavía no tiene una versión de documentación compartida vinculada.
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- SECCIÓN DE MENSAJES (HISTORIAL) -->
                    @if($client->exists)
                        <div class="mt-12 pt-8 border-t border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Historial de Mensajes</h3>

                            @if($client->messages->count() > 0)
                                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Remitente</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Asunto</th>
                                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Estado</th>
                                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($client->messages->sortByDesc('created_at') as $msg)
                                                <tr class="hover:bg-gray-50 transition">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $msg->created_at->format('d/m/Y') }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ $msg->sender_name }}
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-gray-600 truncate max-w-xs">
                                                        {{ $msg->subject }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                                        @if($msg->is_read)
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Leído</span>
                                                        @else
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Nuevo</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <a href="{{ route('messages.show', $msg) }}" class="text-indigo-600 hover:text-indigo-900">Ver</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="p-4 bg-gray-50 rounded-lg text-sm text-gray-500 italic border border-gray-200">
                                    No hay mensajes registrados de este cliente.
                                </div>
                            @endif
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
