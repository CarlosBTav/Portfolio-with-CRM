<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $project->exists ? __('Editar Proyecto') : __('Crear Nuevo Proyecto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ $project->exists ? route('projects.update', $project) : route('projects.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data" 
                          class="space-y-8">
                        
                        @csrf
                        <x-form-errors :errors="$errors" class="mb-6" />
                        @if($project->exists)
                            @method('PUT')
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Título y Descripción -->
                            <div class="col-span-2 space-y-6">
                                <div>
                                    <label for="title" class="block text-sm font-bold text-gray-700">Título del Proyecto</label>
                                    <input type="text" name="title" id="title" value="{{ old('title', $project->title) }}" required
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label for="description" class="block text-sm font-bold text-gray-700">Descripción</label>
                                    <textarea name="description" id="description" rows="4" required
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $project->description) }}</textarea>
                                </div>
                            </div>

                            <div class="col-span-2" x-data="projectLinksManager(@js($initialLinks), @js($linkTypeOptions))" x-init="$el.closest('form')?.addEventListener('submit', (event) => prepareLinksForSubmit(event))">
                                <div class="flex flex-wrap items-center justify-between gap-3 mb-3">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700">Enlaces del proyecto</label>
                                        <p class="mt-1 text-xs text-gray-500">Añade tantos enlaces como necesites. Los marcados como privados no se mostrarán en la web pública.</p>
                                    </div>
                                    <button type="button" @click="addLink()"
                                        class="inline-flex items-center px-3 py-2 bg-white border border-gray-300 rounded-md text-xs font-semibold text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                                        + Añadir enlace
                                    </button>
                                </div>

                                <div class="space-y-2">
                                    <template x-for="(link, index) in items" :key="index">
                                        <div class="grid grid-cols-1 lg:grid-cols-[auto_minmax(10rem,1fr)_minmax(0,2fr)_auto] gap-2 items-center py-1 transition-colors"
                                            :class="link.visibility === 'private' ? 'text-gray-500' : 'text-gray-900'">
                                            <button type="button"
                                                @click="toggleLinkVisibility(link)"
                                                class="inline-flex h-10 items-center gap-2 rounded-lg border px-3 text-xs font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                                :class="link.visibility === 'public' ? 'border-green-200 bg-green-50 text-green-800 hover:bg-green-100' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50'">
                                                <x-icons.eye class="w-4 h-4 shrink-0" x-show="link.visibility === 'public'" />
                                                <x-icons.eye-closed class="w-4 h-4 shrink-0" x-show="link.visibility === 'private'" />
                                                <span x-text="link.visibility === 'public' ? 'Público' : 'Privado'"></span>
                                            </button>

                                            <div class="min-w-0">
                                                <select x-show="editingIndex === index" x-model="link.type"
                                                    class="h-10 w-full min-w-0 rounded-lg border border-gray-300 bg-white px-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                    :class="link.visibility === 'private' ? 'bg-gray-100 text-gray-600' : ''">
                                                    <template x-for="option in linkTypes" :key="option.value">
                                                        <option :value="option.value" x-text="option.label"></option>
                                                    </template>
                                                </select>
                                                <div x-show="editingIndex !== index"
                                                    class="h-10 w-full min-w-0 flex items-center rounded-lg border border-gray-300 px-3 text-sm"
                                                    :class="link.visibility === 'private' ? 'bg-gray-100 text-gray-600' : 'bg-white text-gray-700'">
                                                    <span class="truncate" x-text="typeLabel(link.type)"></span>
                                                </div>
                                            </div>

                                            <div class="min-w-0">
                                                <input type="text" inputmode="url" x-show="editingIndex === index" x-model="link.url" placeholder="https://"
                                                    class="h-10 w-full min-w-0 rounded-lg border border-gray-300 bg-white px-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                    :class="link.visibility === 'private' ? 'bg-gray-100 text-gray-600 placeholder:text-gray-400' : ''">
                                                <a x-show="editingIndex !== index" :href="link.url" target="_blank" rel="noopener noreferrer"
                                                    class="h-10 w-full min-w-0 flex items-center rounded-lg border border-gray-300 px-3 text-sm font-medium truncate hover:underline"
                                                    :class="link.visibility === 'private' ? 'bg-gray-100 text-gray-600 hover:text-gray-700' : 'bg-white text-indigo-600 hover:text-indigo-800'"
                                                    x-text="link.url"></a>
                                            </div>

                                            <input type="hidden" :name="`links[${index}][type]`" :value="link.type">
                                            <input type="hidden" :name="`links[${index}][url]`" :value="link.url">
                                            <input type="hidden" :name="`links[${index}][visibility]`" :value="link.visibility">

                                            <div class="flex items-center justify-end gap-1">
                                                <template x-if="editingIndex === index">
                                                    <button type="button" @click="confirmEdit()"
                                                        class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-green-200 bg-green-50 text-green-700 hover:bg-green-100"
                                                        title="Guardar cambios">
                                                        <span class="sr-only">Guardar cambios</span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </button>
                                                    <button type="button" @click="cancelEdit()"
                                                        class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 bg-white text-gray-500 hover:bg-gray-100"
                                                        title="Cancelar">
                                                        <span class="sr-only">Cancelar</span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                    <button type="button" @click="removeLink(index)"
                                                        class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-red-200 bg-red-50 text-red-600 hover:bg-red-100"
                                                        title="Eliminar enlace">
                                                        <span class="sr-only">Eliminar enlace</span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </template>
                                                <template x-if="editingIndex !== index">
                                                    <button type="button" @click="startEdit(index)"
                                                        class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 bg-white text-gray-600 hover:bg-gray-50"
                                                        title="Editar enlace">
                                                        <span class="sr-only">Editar enlace</span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </button>
                                                    <button type="button" @click="removeLink(index)"
                                                        class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-red-200 bg-red-50 text-red-600 hover:bg-red-100"
                                                        title="Eliminar enlace">
                                                        <span class="sr-only">Eliminar enlace</span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </template>
                                            </div>
                                        </div>
                                    </template>

                                    <div x-show="draftLink" x-cloak class="grid grid-cols-1 lg:grid-cols-[auto_minmax(10rem,1fr)_minmax(0,2fr)_auto] gap-2 items-center py-1 text-gray-900">
                                        <button type="button"
                                            @click="toggleLinkVisibility(draftLink)"
                                            class="inline-flex h-10 items-center gap-2 rounded-lg border px-3 text-xs font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                            :class="draftLink?.visibility === 'public' ? 'border-green-200 bg-green-50 text-green-800 hover:bg-green-100' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50'">
                                            <x-icons.eye class="w-4 h-4 shrink-0" x-show="draftLink?.visibility === 'public'" />
                                            <x-icons.eye-closed class="w-4 h-4 shrink-0" x-show="draftLink?.visibility === 'private'" />
                                            <span x-text="draftLink?.visibility === 'public' ? 'Público' : 'Privado'"></span>
                                        </button>
                                        <select x-model="draftLink.type"
                                            class="h-10 w-full min-w-0 rounded-lg border border-gray-300 bg-white px-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <template x-for="option in linkTypes" :key="option.value">
                                                <option :value="option.value" x-text="option.label"></option>
                                            </template>
                                        </select>
                                        <input type="text" inputmode="url" x-model="draftLink.url" placeholder="https://"
                                            class="h-10 w-full min-w-0 rounded-lg border border-gray-300 bg-white px-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <div class="flex items-center justify-end gap-1">
                                            <button type="button" @click="confirmDraft()"
                                                class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-green-200 bg-green-50 text-green-700 hover:bg-green-100"
                                                title="Añadir enlace">
                                                <span class="sr-only">Añadir enlace</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                            <button type="button" @click="cancelDraft()"
                                                class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 bg-white text-gray-500 hover:bg-gray-100"
                                                title="Cancelar">
                                                <span class="sr-only">Cancelar</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <p x-show="items.length === 0 && !draftLink" class="text-sm text-gray-500 italic">
                                        Todavía no hay enlaces. Usa “Añadir enlace” para crear el primero.
                                    </p>
                                </div>
                            </div>

                            <!-- Visibilidad -->
                            <div x-data="projectVisibilityManager(@js(old('visibility', $project->visibility ?? 'draft')))">
                                <label class="block text-sm font-bold text-gray-700">Visibilidad</label>
                                <input type="hidden" name="visibility" :value="visibility">
                                <button type="button"
                                    @click="cycleVisibility()"
                                    class="mt-1 inline-flex w-full items-center gap-2 rounded-lg border px-3 py-2 min-h-[42px] text-sm font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                    :class="visibility === 'public'
                                        ? 'border-green-200 bg-green-50 text-green-800 hover:bg-green-100'
                                        : (visibility === 'private'
                                            ? 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50'
                                            : 'border-amber-200 bg-amber-50 text-amber-800 hover:bg-amber-100')">
                                    <x-icons.eye class="w-4 h-4 shrink-0" x-show="visibility === 'public'" />
                                    <x-icons.eye-closed class="w-4 h-4 shrink-0" x-show="visibility !== 'public'" />
                                    <span x-text="visibilityLabel()"></span>
                                </button>
                            </div>

                            <div class="col-span-2">
                                <label class="block text-sm font-bold text-gray-700 mb-3">Etiquetas del proyecto</label>
                                <p class="text-xs text-gray-500 mb-4">Clasificación del proyecto, independiente de las tecnologías.</p>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    @foreach($projectCategories as $projectCategory)
                                        <div class="flex items-center">
                                            <input type="checkbox" name="categories[]" value="{{ $projectCategory }}" id="category_{{ $projectCategory }}"
                                                @if((is_array(old('categories')) && in_array($projectCategory, old('categories'))) || in_array($projectCategory, $project->categories ?? [], true)) checked @endif
                                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                            <label for="category_{{ $projectCategory }}" class="ml-2 block text-sm text-gray-900 cursor-pointer">
                                                {{ $projectCategory }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- SECCIÓN: IMÁGENES (DRAG & DROP) -->
                        <div class="col-span-2 pt-6 border-t border-gray-100" 
                             x-data="imageUploader({{ json_encode($project->images ??[]) }})">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Galería de Imágenes</label>
                            <p class="text-xs text-gray-500 mb-4">Sube imágenes y arrástralas para cambiar el orden de aparición. La primera será la portada.</p>
                            
                            <!-- Hidden Inputs para procesar en el Backend -->
                            <input type="file" name="images[]" id="real_file_input" multiple class="hidden" accept="image/*">
                            
                            <template x-for="(item, index) in items" :key="index">
                                <input type="hidden" name="order[]" :value="getOrderValue(item)">
                            </template>

                            <!-- Botón "Añadir Archivos" -->
                            <div class="mb-4">
                                <button type="button" @click="$refs.fileInput.click()" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Añadir Imágenes
                                </button>
                                <input type="file" x-ref="fileInput" @change="addFiles" multiple accept="image/*" class="hidden">
                            </div>

                            <!-- Grid de Previsualización y Drag&Drop -->
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                                <!-- Fíjate en el :key="item.id" -->
                                <template x-for="(item, index) in items" :key="item.id">
                                    <div class="relative aspect-video rounded-lg overflow-hidden border-2 border-transparent hover:border-indigo-500 transition-colors shadow-sm cursor-move bg-gray-100 flex items-center justify-center group"
                                        draggable="true"
                                        @dragstart="dragstart($event, index)"
                                        @dragover.prevent="dragover($event, index)"
                                        @drop.prevent="drop($event, index)"
                                        @dragend="dragend($event)"
                                        :class="{'opacity-50 border-dashed border-gray-400': draggedIndex === index}">
                                        
                                        <!-- Aquí usamos el URL del blob o la ruta del server -->
                                        <img :src="item.type === 'old' ? '/' + item.url : item.url" class="w-full h-full object-cover pointer-events-none">
                                        
                                        <!-- Insignia de Portada -->
                                        <div x-show="index === 0" class="absolute top-2 left-2 bg-indigo-600 text-white text-[10px] font-bold px-2 py-1 rounded shadow pointer-events-none">
                                            PORTADA
                                        </div>

                                        <!-- Botón Eliminar -->
                                        <button type="button" @click.stop="removeItem(index)" class="absolute top-2 right-2 bg-red-600/90 hover:bg-red-700 text-white p-1.5 rounded-full opacity-0 group-hover:opacity-100 transition-opacity transform hover:scale-110">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- SECCIÓN: TECNOLOGÍAS (Buscador Reactivo) -->
                        <div class="pt-6 border-t border-gray-100" 
                             x-data="techManager(
                                 {{ $technologies->map(fn($t) => ['id' => $t->id, 'name' => $t->name])->toJson() }},
                                 {{ $project->technologies->map(fn($t) =>['id' => $t->id, 'name' => $t->name])->toJson() }}
                             )">
                             
                            <label class="block text-sm font-bold text-gray-700 mb-2">Tecnologías Utilizadas</label>
                            
                            <!-- Hidden inputs para enviar al servidor -->
                            <template x-for="tech in selected" :key="tech.id">
                                <input type="hidden" name="technologies[]" :value="tech.id">
                            </template>

                            <div class="relative">
                                <!-- Input Buscador -->
                                <input type="text" 
                                    x-model="search" 
                                    @focus="isOpen = true" 
                                    @click.away="isOpen = false" 
                                    @keydown.enter.prevent="addFirstMatch()" 
                                    placeholder="Buscar tecnología (ej: Laravel, React...)"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                
                                <!-- Dropdown de sugerencias -->
                                <ul x-show="isOpen && search.length > 0" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-48 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                                    
                                    <template x-for="tech in filteredTechs" :key="tech.id">
                                        <li @click="addTech(tech)" class="text-gray-900 cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-indigo-600 hover:text-white transition-colors">
                                            <span x-text="tech.name" class="font-normal block truncate"></span>
                                        </li>
                                    </template>
                                    
                                    <li x-show="filteredTechs.length === 0" class="text-gray-500 cursor-default select-none relative py-2 pl-3 pr-9">
                                        No se encontraron resultados.
                                    </li>
                                </ul>
                            </div>

                            <!-- Etiquetas Seleccionadas -->
                            <div class="mt-4 flex flex-wrap gap-2">
                                <template x-for="tech in selected" :key="tech.id">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 border border-indigo-200 shadow-sm">
                                        <span x-text="tech.name"></span>
                                        <button type="button" @click="removeTech(tech.id)" class="ml-1.5 inline-flex items-center justify-center w-4 h-4 rounded-full text-indigo-400 hover:bg-indigo-200 hover:text-indigo-600 focus:outline-none transition-colors">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </span>
                                </template>
                            </div>
                        </div>

                        <!-- Clientes -->
                        @php
                            $hasOldClients = is_array(old('clients')) && count(old('clients')) > 0;
                            $hasSelectedClients = $hasOldClients || $project->clients->isNotEmpty();
                            $isInternalClient = (bool) old('is_internal', $project->is_internal) && ! $hasSelectedClients;
                        @endphp
                        <div class="pt-6 border-t border-gray-100" x-data="{ internal: {{ $isInternalClient ? 'true' : 'false' }} }">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-3">
                                <label class="block text-sm font-bold text-gray-700">Cliente Asociado (Opcional)</label>
                                @if($project->exists)
                                    <a href="{{ route('clients.create', ['project' => $project]) }}"
                                       class="inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        Nuevo cliente
                                    </a>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 mb-4">Marca Interno para proyectos propios sin cliente. Si no eliges nada, el proyecto queda sin asignar.</p>
                            <label class="flex items-center mb-4 p-4 bg-amber-50 border border-amber-200 rounded-lg cursor-pointer">
                                <input type="checkbox" name="is_internal" value="1" x-model="internal"
                                    @change="if (internal) { $refs.clientCheckbox.forEach((checkbox) => { checkbox.checked = false; }); }"
                                    class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300 rounded">
                                <span class="ml-2 block text-sm font-medium text-amber-900">Interno</span>
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-48 overflow-y-auto p-4 bg-gray-50 rounded-lg border border-gray-200">
                                @foreach($clients as $client)
                                    <div class="flex items-center">
                                        <input type="checkbox" name="clients[]" value="{{ $client->id }}" id="client_{{ $client->id }}" x-ref="clientCheckbox"
                                            @if((is_array(old('clients')) && in_array($client->id, old('clients'))) || ($project->clients->contains($client->id))) checked @endif
                                            :disabled="internal"
                                            @change="if ($event.target.checked) { internal = false; }"
                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded disabled:opacity-50">
                                        <label for="client_{{ $client->id }}" class="ml-2 block text-sm text-gray-900 cursor-pointer">
                                            {{ $client->commercial_name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Botones Submit -->
                        <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('projects.index') }}" class="px-6 py-2.5 rounded-lg font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors border border-gray-300 shadow-sm">Cancelar</a>
                            <button type="submit" class="px-6 py-2.5 rounded-lg font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition-colors shadow-md hover:shadow-lg">
                                {{ $project->exists ? 'Actualizar Proyecto' : 'Crear Proyecto' }}
                            </button>
                        </div>
                    </form>

                    @if($project->exists)
                        <div class="mt-8 border-t border-gray-200 pt-6">
                            <h3 class="text-sm font-bold text-gray-700">Zona de peligro</h3>
                            <p class="mt-2 text-sm text-gray-500">
                                El proyecto pasará a la papelera durante 30 días. Después se eliminará de forma permanente junto con su documentación compartida vinculada, si la tiene.
                            </p>
                            <form action="{{ route('projects.destroy', $project) }}" method="POST" class="mt-4"
                                  onsubmit="return confirm('¿Enviar este proyecto a la papelera? Podrá eliminarse definitivamente en 30 días.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center rounded-lg border border-red-200 bg-red-50 px-4 py-2 text-sm font-semibold text-red-700 transition hover:bg-red-100">
                                    Borrar
                                </button>
                            </form>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Scripts de AlpineJS -->
    <script>
        document.addEventListener('alpine:init', () => {

            // 1. GESTOR DE IMÁGENES
            Alpine.data('imageUploader', (existingImages) => ({
                items: [],         
                newFiles:[],      
                draggedIndex: null,
                errors: [],

                init() {
                    if (existingImages && Array.isArray(existingImages)) {
                        existingImages.forEach((url, index) => {
                            this.items.push({
                                id: 'old_' + index + '_' + Date.now(), // ID único
                                type: 'old',
                                url: url, 
                                value: url 
                            });
                        });
                    }
                },

                addFiles(event) {
                    const files = Array.from(event.target.files);
                    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
                    const maxBytes = 5 * 1024 * 1024;

                    this.errors = [];

                    files.forEach(file => {
                        const isValidType = allowedTypes.includes(file.type);
                        const isValidSize = file.size <= maxBytes;

                        if (!isValidType) {
                            this.errors.push(`Unsupported file type: ${file.name}`);
                            return;
                        }

                        if (!isValidSize) {
                            this.errors.push(`File too large (max 5MB): ${file.name}`);
                            return;
                        }

                        const originalIndex = this.newFiles.length;
                        this.newFiles.push(file);

                        // Solo guardamos datos simples en 'items' para no romper la reactividad de Alpine
                        this.items.push({
                            id: 'new_' + originalIndex + '_' + Date.now(), // ID único esencial para el HTML
                            type: 'new',
                            url: URL.createObjectURL(file), // Genera el Blob para ver la foto
                            originalIndex: originalIndex
                        });
                    });

                    this.updateFileInput();
                    event.target.value = ''; 

                    if (this.errors.length > 0) {
                        window.alert(this.errors.join('\n'));
                    }
                },

                removeItem(index) {
                    const [removed] = this.items.splice(index, 1);

                    if (removed && removed.type === 'new') {
                        const survivingNewIndexes = this.items
                            .filter(item => item.type === 'new')
                            .map(item => item.originalIndex);

                        this.newFiles = this.newFiles.filter((_, idx) => survivingNewIndexes.includes(idx));

                        let newCounter = 0;
                        this.items = this.items.map(item => {
                            if (item.type !== 'new') {
                                return item;
                            }

                            return {
                                ...item,
                                originalIndex: newCounter++,
                            };
                        });
                    }

                    this.updateFileInput();
                },

                updateFileInput() {
                    const dataTransfer = new DataTransfer();
                    this.newFiles.forEach(file => {
                        dataTransfer.items.add(file);
                    });
                    document.getElementById('real_file_input').files = dataTransfer.files;
                },

                dragstart(event, index) {
                    this.draggedIndex = index;
                    event.dataTransfer.effectAllowed = 'move';
                },
                dragover(event, index) {
                    event.preventDefault(); 
                },
                drop(event, index) {
                    event.preventDefault();
                    if (this.draggedIndex === null || this.draggedIndex === index) return;

                    const item = this.items.splice(this.draggedIndex, 1)[0];
                    this.items.splice(index, 0, item);
                    this.draggedIndex = null;
                },
                dragend(event) {
                    this.draggedIndex = null;
                },
                
                getOrderValue(item) {
                    if (item.type === 'old') {
                        return 'old:' + item.url;
                    } else {
                        return 'new:' + item.originalIndex;
                    }
                }
            }));

            Alpine.data('projectLinksManager', (initialLinks, linkTypes) => ({
                items: Array.isArray(initialLinks) ? initialLinks : [],
                linkTypes: Array.isArray(linkTypes) ? linkTypes : [],
                draftLink: null,
                editingIndex: null,
                editSnapshot: null,

                addLink() {
                    if (this.draftLink || this.editingIndex !== null) {
                        return;
                    }

                    this.draftLink = {
                        url: '',
                        type: this.linkTypes[0]?.value ?? 'demo',
                        visibility: 'public',
                    };
                },

                confirmDraft() {
                    const url = (this.draftLink?.url || '').trim();

                    if (!url) {
                        return;
                    }

                    this.items.push({
                        url,
                        type: this.draftLink.type,
                        visibility: this.draftLink.visibility || 'public',
                    });

                    this.draftLink = null;
                },

                cancelDraft() {
                    this.draftLink = null;
                },

                startEdit(index) {
                    if (this.draftLink) {
                        return;
                    }

                    this.cancelEdit();
                    this.editingIndex = index;
                    this.editSnapshot = { ...this.items[index] };
                },

                confirmEdit() {
                    if (this.editingIndex === null) {
                        return;
                    }

                    const url = (this.items[this.editingIndex].url || '').trim();

                    if (!url) {
                        return;
                    }

                    this.items[this.editingIndex].url = url;
                    this.editingIndex = null;
                    this.editSnapshot = null;
                },

                cancelEdit() {
                    if (this.editingIndex === null) {
                        return;
                    }

                    this.items[this.editingIndex] = { ...this.editSnapshot };
                    this.editingIndex = null;
                    this.editSnapshot = null;
                },

                removeLink(index) {
                    if (this.editingIndex === index) {
                        this.editingIndex = null;
                        this.editSnapshot = null;
                    } else if (this.editingIndex !== null && index < this.editingIndex) {
                        this.editingIndex -= 1;
                    }

                    this.items.splice(index, 1);
                },

                toggleLinkVisibility(link) {
                    if (!link) {
                        return;
                    }

                    link.visibility = link.visibility === 'public' ? 'private' : 'public';
                },

                typeLabel(type) {
                    return this.linkTypes.find((option) => option.value === type)?.label ?? type;
                },

                prepareLinksForSubmit(event) {
                    if (this.draftLink) {
                        const url = (this.draftLink.url || '').trim();

                        if (!url) {
                            this.draftLink = null;
                            return;
                        }

                        event.preventDefault();
                        this.confirmDraft();
                        this.$nextTick(() => {
                            const form = this.$el.closest('form');

                            if (!form) {
                                return;
                            }

                            if (typeof form.requestSubmit === 'function') {
                                form.requestSubmit();
                            } else {
                                form.submit();
                            }
                        });

                        return;
                    }

                    if (this.editingIndex !== null) {
                        const url = (this.items[this.editingIndex].url || '').trim();

                        if (!url) {
                            event.preventDefault();
                            return;
                        }

                        this.confirmEdit();
                    }
                },
            }));

            Alpine.data('projectVisibilityManager', (initialVisibility) => ({
                visibility: initialVisibility || 'draft',

                cycleVisibility() {
                    const order = ['public', 'private', 'draft'];
                    const currentIndex = order.indexOf(this.visibility);

                    this.visibility = order[(currentIndex + 1) % order.length];
                },

                visibilityLabel() {
                    return {
                        public: 'Público',
                        private: 'Privado',
                        draft: 'Borrador',
                    }[this.visibility] ?? 'Borrador';
                },
            }));

            // 2. GESTOR DE TECNOLOGÍAS
            Alpine.data('techManager', (allTechs, initialSelected) => ({
                search: '',
                isOpen: false,
                source: allTechs,      
                selected: initialSelected ||[], 

                get filteredTechs() {
                    if (this.search === '') return[];
                    return this.source.filter(tech => {
                        const matchesSearch = tech.name.toLowerCase().includes(this.search.toLowerCase());
                        const notSelected = !this.selected.find(s => s.id === tech.id);
                        return matchesSearch && notSelected;
                    });
                },

                addTech(tech) {
                    this.selected.push(tech);
                    this.search = '';   
                    this.isOpen = false; 
                },

                removeTech(idToRemove) {
                    this.selected = this.selected.filter(tech => tech.id !== idToRemove);
                },

                // NUEVA FUNCIÓN: Al dar Enter
                addFirstMatch() {
                    if (this.filteredTechs.length > 0) {
                        this.addTech(this.filteredTechs[0]);
                    } else {
                        this.search = ''; // Opcional: limpiar si no hay coincidencias
                    }
                }
            }));
        });
    </script>
</x-app-layout>