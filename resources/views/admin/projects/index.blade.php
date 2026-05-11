<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Proyectos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Botón Crear -->
            <div class="flex justify-end mb-4">
                <a href="{{ route('projects.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    + Nuevo Proyecto
                </a>
            </div>

            <!-- FILTRO POR ESTADO (PASTILLAS) -->
            <div class="mb-6 bg-white p-4 rounded-lg shadow-sm border border-gray-100 flex flex-wrap items-center gap-2 justify-between">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="text-sm text-gray-600 font-medium mr-1">Estado:</span>

                    <a href="{{ request('visibility') === 'public' ? route('projects.index', request()->except('visibility')) : request()->fullUrlWithQuery(['visibility' => 'public']) }}"
                       class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold border transition {{ request('visibility') === 'public' ? 'bg-green-600 text-white border-green-600' : 'bg-green-50 text-green-700 border-green-200 hover:bg-green-100' }}">
                        Público
                    </a>

                    <a href="{{ request('visibility') === 'private' ? route('projects.index', request()->except('visibility')) : request()->fullUrlWithQuery(['visibility' => 'private']) }}"
                       class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold border transition {{ request('visibility') === 'private' ? 'bg-gray-700 text-white border-gray-700' : 'bg-gray-100 text-gray-700 border-gray-300 hover:bg-gray-200' }}">
                        Privado
                    </a>

                    <a href="{{ request('visibility') === 'draft' ? route('projects.index', request()->except('visibility')) : request()->fullUrlWithQuery(['visibility' => 'draft']) }}"
                       class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold border transition {{ request('visibility') === 'draft' ? 'bg-amber-200 text-amber-900 border-amber-400' : 'bg-amber-50 text-amber-700 border-amber-200 hover:bg-amber-100' }}">
                        Borrador
                    </a>
                </div>

                @if(request('visibility') || request('client_id'))
                    <a href="{{ route('projects.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900 underline">
                        Limpiar filtros
                    </a>
                @endif
            </div>

            @if($canReorder)
                <p class="mb-3 text-sm text-gray-600 flex items-center gap-2">
                    <span class="inline-flex h-6 w-6 shrink-0 items-center justify-center rounded border border-dashed border-gray-300 text-gray-400" aria-hidden="true">⋮⋮</span>
                    Arrastra las filas por el asa para definir el orden en la web (portada y página de proyectos).
                </p>
            @else
                <p class="mb-3 text-sm text-amber-700 bg-amber-50 border border-amber-200 rounded-lg px-3 py-2">
                    Los filtros están activos: el orden solo se puede cambiar con la lista completa.
                    <a href="{{ route('projects.index') }}" class="font-semibold underline">Quitar filtros</a>
                </p>
            @endif

            <!-- Tabla -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                @if($canReorder)
                                <th class="p-3 border-b-2 border-gray-200 bg-gray-100 text-sm font-semibold text-gray-600 uppercase tracking-wider w-12">
                                    <span class="sr-only">Orden</span>
                                </th>
                                @endif
                                <th class="p-3 border-b-2 border-gray-200 bg-gray-100 text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                    Título
                                </th>
                                <th class="p-3 border-b-2 border-gray-200 bg-gray-100 text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                    Etiquetas
                                </th>
                                <th class="p-3 border-b-2 border-gray-200 bg-gray-100 text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th class="p-3 border-b-2 border-gray-200 bg-gray-100 text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                    <form method="GET" action="{{ route('projects.index') }}" class="flex items-center gap-2">
                                        <span>Cliente</span>
                                        <input type="hidden" name="visibility" value="{{ request('visibility') }}">
                                        <select name="client_id" onchange="this.form.submit()" class="text-xs rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 normal-case font-medium">
                                            <option value="">Todos</option>
                                            @foreach($clients as $client)
                                                <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                                    {{ $client->commercial_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </th>
                                <th class="p-3 border-b-2 border-gray-200 bg-gray-100 text-sm font-semibold text-gray-600 uppercase tracking-wider w-12">
                                    <span class="sr-only">Web</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody
                            @if($canReorder)
                                id="project-sortable-tbody"
                                data-reorder-url="{{ route('projects.reorder') }}"
                            @endif
                        >
                            @foreach($projects as $project)
                            <tr
                                class="hover:bg-gray-50 cursor-pointer {{ $canReorder ? 'bg-white' : '' }}"
                                role="link"
                                tabindex="0"
                                onclick="window.location='{{ route('projects.edit', $project) }}'"
                                onkeydown="if (event.key === 'Enter') { window.location='{{ route('projects.edit', $project) }}'; }"
                                @if($canReorder) data-project-id="{{ $project->id }}" @endif
                            >
                                @if($canReorder)
                                <td class="p-2 border-b border-gray-200 align-middle" onclick="event.stopPropagation();">
                                    <button type="button" class="project-drag-handle cursor-grab active:cursor-grabbing p-2 text-gray-400 hover:text-gray-600 rounded hover:bg-gray-100" title="Arrastrar para reordenar">
                                        <span class="sr-only">Arrastrar para reordenar</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8 6a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm0 6a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm0 6a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm10-12a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm0 6a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm0 6a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/></svg>
                                    </button>
                                </td>
                                @endif
                                <td class="p-3 border-b border-gray-200 text-sm">
                                    <div class="font-bold text-gray-900">{{ $project->title }}</div>
                                    <div class="text-xs text-gray-500">{{ Str::limit($project->description, 50) }}</div>
                                </td>
                                <td class="p-3 border-b border-gray-200 text-sm">
                                    @forelse($project->categories ?? [] as $category)
                                        <span class="inline-flex items-center px-2 py-0.5 mr-1 mb-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800">
                                            {{ $category }}
                                        </span>
                                    @empty
                                        <span class="text-gray-400 italic text-xs">Sin etiquetas</span>
                                    @endforelse
                                </td>
                                <td class="p-3 border-b border-gray-200 text-sm">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $project->visibility === 'public' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($project->visibility) }}
                                    </span>
                                </td>
                                <td class="p-3 border-b border-gray-200 text-sm" onclick="event.stopPropagation();">
                                    @if($project->clients->isNotEmpty())
                                        @foreach($project->clients as $client)
                                            <a href="{{ route('clients.edit', $client) }}" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 hover:bg-blue-200 transition">
                                                {{ $client->commercial_name }}
                                            </a>
                                        @endforeach
                                    @elseif($project->is_internal)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                            Interno
                                        </span>
                                    @else
                                        <span class="text-gray-400 italic text-xs">Sin asignar</span>
                                    @endif
                                </td>
                                <td class="p-3 border-b border-gray-200 text-sm text-right align-middle" onclick="event.stopPropagation();">
                                    @php
                                        $websiteLink = $project->links->first(fn ($link) => ! $link->isGitHub());
                                    @endphp
                                    @if($websiteLink)
                                        <a href="{{ $websiteLink->url }}" target="_blank" rel="noopener noreferrer"
                                           class="inline-flex items-center justify-center p-2 text-indigo-600 hover:text-indigo-900 rounded hover:bg-indigo-50"
                                           title="Abrir web del proyecto">
                                            <span class="sr-only">Abrir web del proyecto</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                            </svg>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>