@extends('layouts.public')

@section('title', 'Desarrollo de Apps | Carlos Codex')
@section('meta_description', 'Desarrollo de aplicaciones móviles y soluciones multiplataforma con foco en experiencia de usuario, rendimiento y escalabilidad.')
@section('body-class', 'antialiased bg-white text-gray-900 dark:bg-slate-950 dark:text-slate-100 font-sans flex flex-col min-h-dynamic transition-colors duration-300')

@php
    $contactUrl = route('public.contact', ['interest' => 'mobile']);
    $whatsappUrl = filled($whatsappPhone ?? null)
        ? 'https://wa.me/' . $whatsappPhone . '?text=' . rawurlencode('Hola Carlos, me interesa el servicio de desarrollo de apps.')
        : null;
@endphp

<style>
    .web-dev-process__grid {
        --process-line-duration: 3.25s;
        position: relative;
    }

    @keyframes web-dev-process-step-enter {
        from {
            opacity: 0;
            transform: translateX(-1.25rem);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes web-dev-process-line-reveal {
        to {
            clip-path: inset(0 0 0 0);
        }
    }

    @keyframes web-dev-process-line-glow {
        0%,
        100% {
            filter: drop-shadow(0 0 2px rgba(129, 140, 248, 0.35)) drop-shadow(0 0 6px rgba(129, 140, 248, 0.18));
        }

        50% {
            filter: drop-shadow(0 0 5px rgba(129, 140, 248, 0.85)) drop-shadow(0 0 14px rgba(99, 102, 241, 0.45));
        }
    }

    .web-dev-process__step {
        opacity: 0;
        animation: web-dev-process-step-enter 0.55s cubic-bezier(0.22, 0.61, 0.36, 1) forwards;
    }

    .web-dev-process__step:nth-child(2) {
        animation-delay: var(--process-step-1-delay, 0s);
    }

    .web-dev-process__step:nth-child(3) {
        animation-delay: var(--process-step-2-delay, 0.55s);
    }

    .web-dev-process__step:nth-child(4) {
        animation-delay: var(--process-step-3-delay, 0.95s);
    }

    .web-dev-process__step:nth-child(5) {
        animation-delay: var(--process-step-4-delay, 1.35s);
    }

    @media (min-width: 1024px) {
        .web-dev-process__grid {
            --process-step-1-delay: 0s;
            --process-step-2-delay: calc(var(--process-line-duration) * 0.32);
            --process-step-3-delay: calc(var(--process-line-duration) * 0.64);
            --process-step-4-delay: calc(var(--process-line-duration) - 0.05s);
        }

        .web-dev-process__track {
            position: absolute;
            top: calc(1.5rem - 1px);
            left: calc(12.5% + 2.25rem);
            right: calc(12.5% + 2.25rem);
            height: 2px;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .web-dev-process__track::before {
            content: '';
            display: block;
            width: 100%;
            height: 100%;
            background-image: repeating-linear-gradient(
                to right,
                rgba(99, 102, 241, 0.72) 0 10px,
                transparent 10px 18px
            );
            background-size: 18px 2px;
            clip-path: inset(0 100% 0 0);
            animation:
                web-dev-process-line-reveal var(--process-line-duration) linear forwards,
                web-dev-process-line-glow 3s ease-in-out calc(var(--process-line-duration) + 0.2s) infinite;
        }

        html.dark .web-dev-process__track::before {
            background-image: repeating-linear-gradient(
                to right,
                rgba(148, 163, 184, 0.42) 0 10px,
                transparent 10px 18px
            );
        }

        .web-dev-process__step {
            z-index: 1;
        }

        .web-dev-process__icon {
            position: relative;
            z-index: 1;
        }

        html.dark .web-dev-process__icon {
            background-color: color-mix(in srgb, rgb(99 102 241) 15%, rgb(2 6 23));
        }
    }

    @media (max-width: 1023px) {
        .web-dev-process__step:nth-child(2) {
            animation-delay: 0.15s;
        }

        .web-dev-process__step:nth-child(3) {
            animation-delay: 0.55s;
        }

        .web-dev-process__step:nth-child(4) {
            animation-delay: 0.95s;
        }

        .web-dev-process__step:nth-child(5) {
            animation-delay: 1.35s;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .web-dev-process__step {
            opacity: 1;
            transform: none;
            animation: none;
        }

        .web-dev-process__track::before {
            animation: none;
            clip-path: none;
            filter: none;
        }
    }

</style>

@section('content')
<section class="relative w-full pt-32 pb-20 lg:pt-36 lg:pb-24">
    <div class="pointer-events-none absolute inset-0 bg-white dark:bg-slate-950"></div>
    <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_18%_12%,rgba(129,140,248,0.14),transparent_40%),radial-gradient(circle_at_82%_18%,rgba(139,92,246,0.1),transparent_36%)] dark:bg-[radial-gradient(circle_at_18%_12%,rgba(129,140,248,0.2),transparent_40%),radial-gradient(circle_at_82%_18%,rgba(139,92,246,0.16),transparent_36%)]"></div>

    <div class="relative z-10 mx-auto max-w-screen-xl space-y-20 px-4 sm:px-6 lg:px-10 lg:space-y-24">
        <div class="grid grid-cols-1 items-center gap-10 xl:grid-cols-[minmax(0,1.05fr)_minmax(0,0.95fr)] xl:gap-12">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-indigo-600 dark:text-indigo-300">Servicio</p>
                <h1 class="mt-3 max-w-2xl text-3xl font-extrabold leading-tight text-gray-900 dark:text-white md:text-5xl">
                    Desarrollo de apps para <span class="text-indigo-600 dark:text-indigo-400">experiencias fluidas y negocio real</span>
                </h1>
                <p class="mt-5 max-w-2xl text-base leading-relaxed text-gray-600 dark:text-gray-300 md:text-lg">
                    Construyo apps Android y multiplataforma orientadas a negocio: estables, conectadas a tus sistemas y preparadas para crecer sin fricción técnica.
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ $contactUrl }}" class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-indigo-500">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-4l-4 4v-4Z" />
                        </svg>
                        Abrir asistente de contacto
                    </a>
                    <a href="{{ route('public.projects') }}" class="inline-flex items-center gap-2 rounded-xl border border-gray-300 bg-white px-6 py-3 text-sm font-semibold text-gray-800 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-transparent dark:text-gray-200 dark:hover:bg-gray-900">
                        Ver proyectos
                    </a>
                </div>

                <div class="mt-8 flex flex-wrap gap-x-6 gap-y-3 text-sm text-gray-600 dark:text-gray-300">
                    <div class="inline-flex items-center gap-2">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-indigo-50 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-300">
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5M8 21h8a2 2 0 0 0 2-2v-1a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 13V9a4 4 0 1 0-4 4h4Z"/></svg>
                        </span>
                        Android y multiplataforma
                    </div>
                    <div class="inline-flex items-center gap-2">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-indigo-50 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-300">
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7Z"/></svg>
                        </span>
                        Integración con APIs y backend
                    </div>
                    <div class="inline-flex items-center gap-2">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-indigo-50 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-300">
                            <svg viewBox="0 0 20 20" class="h-4 w-4 fill-current" aria-hidden="true"><path d="M7.63 13.23 4.4 10l-1.4 1.41 4.63 4.62L17 6.66l-1.41-1.41z"/></svg>
                        </span>
                        MVP con roadmap claro
                    </div>
                </div>
            </div>

            @include('public.services.partials.hero-mockup')
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <article class="rounded-2xl border border-gray-200 bg-gray-50 p-7 dark:border-gray-800 dark:bg-gray-900/70">
                <div class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-rose-100 text-rose-600 dark:bg-rose-500/15 dark:text-rose-300">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" d="M18 6 6 18M6 6l12 12"/></svg>
                </div>
                <h2 class="mt-4 text-xl font-bold text-gray-900 dark:text-white">Qué suele bloquear a mis clientes</h2>
                <ul class="mt-5 space-y-3 text-sm leading-relaxed text-gray-600 dark:text-gray-300">
                    <li class="flex gap-3"><span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-rose-400"></span>Apps lentas o inestables que dañan la percepción de marca.</li>
                    <li class="flex gap-3"><span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-rose-400"></span>Falta de integración con backend, pagos o herramientas internas.</li>
                    <li class="flex gap-3"><span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-rose-400"></span>Dificultad para definir un MVP y lanzar en tiempos razonables.</li>
                    <li class="flex gap-3"><span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-rose-400"></span>Mantenimiento costoso por decisiones técnicas iniciales incorrectas.</li>
                </ul>
            </article>

            <article class="rounded-2xl border border-gray-200 bg-gray-50 p-7 dark:border-gray-800 dark:bg-gray-900/70">
                <div class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-emerald-100 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-300">
                    <svg viewBox="0 0 20 20" class="h-5 w-5 fill-current" aria-hidden="true"><path d="M7.63 13.23 4.4 10l-1.4 1.41 4.63 4.62L17 6.66l-1.41-1.41z"/></svg>
                </div>
                <h2 class="mt-4 text-xl font-bold text-gray-900 dark:text-white">Qué entrego</h2>
                <ul class="mt-5 space-y-3 text-sm leading-relaxed text-gray-600 dark:text-gray-300">
                    <li class="flex gap-3"><span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-emerald-400"></span>Definición funcional: pantallas, flujos y prioridades de producto.</li>
                    <li class="flex gap-3"><span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-emerald-400"></span>Desarrollo móvil y conexión segura con APIs y bases de datos.</li>
                    <li class="flex gap-3"><span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-emerald-400"></span>Calidad y pruebas para minimizar errores en producción.</li>
                    <li class="flex gap-3"><span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-emerald-400"></span>Acompañamiento para iteraciones y mejoras según feedback real.</li>
                </ul>
            </article>
        </div>

        <div class="text-center">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white md:text-3xl">Proceso de trabajo</h2>
            <p class="mx-auto mt-3 max-w-2xl text-sm leading-relaxed text-gray-600 dark:text-gray-300 md:text-base">
                Un proceso claro y colaborativo para que sepas qué esperar en cada fase del proyecto.
            </p>

            <div class="web-dev-process__grid mt-10 grid grid-cols-1 gap-8 text-center md:grid-cols-2 lg:grid-cols-4">
                <div class="web-dev-process__track hidden lg:block" aria-hidden="true"></div>
                <div class="web-dev-process__step relative flex flex-col items-center">
                    <div class="web-dev-process__icon flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-300">
                        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m20 20-3.5-3.5"/></svg>
                    </div>
                    <p class="mt-4 text-sm font-semibold text-indigo-700 dark:text-indigo-300">01. Descubrimiento</p>
                    <p class="mt-2 text-sm leading-relaxed text-gray-600 dark:text-gray-300">Convertimos tu idea en funcionalidades concretas y medibles.</p>
                </div>
                <div class="web-dev-process__step relative flex flex-col items-center">
                    <div class="web-dev-process__icon flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-300">
                        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2"/><path stroke-linecap="round" d="M9 12h6M9 16h6"/></svg>
                    </div>
                    <p class="mt-4 text-sm font-semibold text-indigo-700 dark:text-indigo-300">02. MVP</p>
                    <p class="mt-2 text-sm leading-relaxed text-gray-600 dark:text-gray-300">Construimos una primera versión sólida para validar con usuarios reales.</p>
                </div>
                <div class="web-dev-process__step relative flex flex-col items-center">
                    <div class="web-dev-process__icon flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-300">
                        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m8 9-3 3 3 3"/><path stroke-linecap="round" stroke-linejoin="round" d="m16 15 3-3-3-3"/></svg>
                    </div>
                    <p class="mt-4 text-sm font-semibold text-indigo-700 dark:text-indigo-300">03. Iteraciones</p>
                    <p class="mt-2 text-sm leading-relaxed text-gray-600 dark:text-gray-300">Priorizamos mejoras por impacto y estabilidad en cada entrega.</p>
                </div>
                <div class="web-dev-process__step relative flex flex-col items-center">
                    <div class="web-dev-process__icon flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-300">
                        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09Z"/><path stroke-linecap="round" stroke-linejoin="round" d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/></svg>
                    </div>
                    <p class="mt-4 text-sm font-semibold text-indigo-700 dark:text-indigo-300">04. Escalado</p>
                    <p class="mt-2 text-sm leading-relaxed text-gray-600 dark:text-gray-300">Preparamos la app para crecer con nuevas funcionalidades e integraciones.</p>
                </div>
            </div>
        </div>

        @php
            $singleFeaturedMobile = $featuredProjects->count() === 1;
        @endphp
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-[minmax(0,0.9fr)_minmax(0,1.1fr)] lg:items-start">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white md:text-3xl">
                    {{ $singleFeaturedMobile ? 'Proyecto destacado' : 'Proyectos destacados' }}
                </h2>
                <p class="mt-3 max-w-md text-sm leading-relaxed text-gray-600 dark:text-gray-300">
                    @if ($singleFeaturedMobile)
                        Un proyecto móvil reciente con foco en experiencia de usuario, rendimiento y integración con tus sistemas.
                    @else
                        Una muestra de proyectos móviles recientes con foco en experiencia de usuario, rendimiento y integración con tus sistemas.
                    @endif
                </p>
                <a href="{{ route('public.projects') }}" class="mt-6 inline-flex items-center gap-2 rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-800 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-transparent dark:text-gray-200 dark:hover:bg-gray-900">
                    Ver todos los proyectos
                    <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 10h11M11 6l4 4-4 4"/></svg>
                </a>
            </div>

            <div @class([
                'grid grid-cols-1 gap-5',
                'md:grid-cols-3' => ! $singleFeaturedMobile,
            ])>
                @forelse ($featuredProjects as $project)
                    @php
                        $images = $project->images ?? [];
                        $coverImage = $images[0] ?? ($project->image_url ?? null);
                    @endphp
                    <article class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900/70">
                        <div class="aspect-[4/3] overflow-hidden bg-gray-100 dark:bg-gray-800">
                            @if ($coverImage)
                                <img src="{{ asset($coverImage) }}" alt="{{ $project->title }}" class="h-full w-full object-cover" loading="lazy">
                            @else
                                <div class="flex h-full items-center justify-center text-sm text-gray-400">Sin imagen</div>
                            @endif
                        </div>
                        <div class="space-y-3 p-4">
                            <div>
                                <h3 class="text-base font-bold text-gray-900 dark:text-white">{{ $project->title }}</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">App móvil</p>
                            </div>
                            @if ($project->technologies->isNotEmpty())
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($project->technologies->take(3) as $technology)
                                        <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-300">{{ $technology->name }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </article>
                @empty
                    <p class="col-span-full rounded-2xl border border-dashed border-gray-300 px-6 py-10 text-center text-sm text-gray-500 dark:border-gray-700">Aún no hay proyectos públicos para mostrar.</p>
                @endforelse
            </div>
        </div>

        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white md:text-3xl">Inversión</h2>
            <p class="mt-3 max-w-2xl text-sm leading-relaxed text-gray-600 dark:text-gray-300">
                Rangos orientativos para MVPs, apps con integraciones y productos en evolución. El presupuesto final depende del alcance, tiendas de distribución y complejidad del backend.
            </p>

            <div class="mt-8 grid grid-cols-1 gap-5 overflow-visible xl:grid-cols-4 xl:pt-12">
                <article class="flex h-full flex-col rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900/70">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">MVP Android</p>
                    <p class="mt-2 text-2xl font-bold tracking-tight text-indigo-600 dark:text-indigo-400">Desde 490€</p>
                    <ul class="mt-4 flex-1 space-y-2.5 text-sm text-gray-600 dark:text-gray-300">
                        <li class="flex gap-2.5"><svg class="mt-0.5 h-4 w-4 shrink-0 text-indigo-600 dark:text-indigo-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M7.63 13.23 4.4 10l-1.4 1.41 4.63 4.62L17 6.66l-1.41-1.41z"/></svg>Pantallas clave y flujo validado</li>
                        <li class="flex gap-2.5"><svg class="mt-0.5 h-4 w-4 shrink-0 text-indigo-600 dark:text-indigo-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M7.63 13.23 4.4 10l-1.4 1.41 4.63 4.62L17 6.66l-1.41-1.41z"/></svg>Integración básica con API o datos</li>
                        <li class="flex gap-2.5"><svg class="mt-0.5 h-4 w-4 shrink-0 text-indigo-600 dark:text-indigo-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M7.63 13.23 4.4 10l-1.4 1.41 4.63 4.62L17 6.66l-1.41-1.41z"/></svg>Build listo para pruebas internas</li>
                    </ul>
                </article>

                <div class="relative flex h-full flex-col overflow-visible xl:block">
                    <div class="flex shrink-0 items-center justify-center rounded-t-2xl rounded-b-none border border-b-0 border-indigo-600 bg-indigo-600 px-5 py-4 text-center shadow-sm xl:absolute xl:inset-x-0 xl:top-0 xl:z-10 xl:-translate-y-full">
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-white">Más elegido</p>
                    </div>
                    <article class="flex h-full flex-col rounded-t-none rounded-b-2xl border border-indigo-600 bg-white shadow-sm dark:bg-gray-900/70">
                        <div class="flex flex-1 flex-col p-5">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">App + integraciones</p>
                            <p class="mt-2 text-2xl font-bold tracking-tight text-indigo-600 dark:text-indigo-400">Desde 890€</p>
                            <ul class="mt-4 flex-1 space-y-2.5 text-sm text-gray-600 dark:text-gray-300">
                                <li class="flex gap-2.5"><svg class="mt-0.5 h-4 w-4 shrink-0 text-indigo-600 dark:text-indigo-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M7.63 13.23 4.4 10l-1.4 1.41 4.63 4.62L17 6.66l-1.41-1.41z"/></svg>Autenticación, roles y panel ligero</li>
                                <li class="flex gap-2.5"><svg class="mt-0.5 h-4 w-4 shrink-0 text-indigo-600 dark:text-indigo-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M7.63 13.23 4.4 10l-1.4 1.41 4.63 4.62L17 6.66l-1.41-1.41z"/></svg>Pagos, notificaciones o CRM</li>
                                <li class="flex gap-2.5"><svg class="mt-0.5 h-4 w-4 shrink-0 text-indigo-600 dark:text-indigo-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M7.63 13.23 4.4 10l-1.4 1.41 4.63 4.62L17 6.66l-1.41-1.41z"/></svg>Preparación para publicación</li>
                            </ul>
                        </div>
                    </article>
                </div>

                <article class="flex h-full flex-col rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900/70">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">Producto en evolución</p>
                    <p class="mt-2 text-2xl font-bold tracking-tight text-indigo-600 dark:text-indigo-400">Desde 1800€</p>
                    <ul class="mt-4 flex-1 space-y-2.5 text-sm text-gray-600 dark:text-gray-300">
                        <li class="flex gap-2.5"><svg class="mt-0.5 h-4 w-4 shrink-0 text-indigo-600 dark:text-indigo-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M7.63 13.23 4.4 10l-1.4 1.41 4.63 4.62L17 6.66l-1.41-1.41z"/></svg>Roadmap por fases y métricas</li>
                        <li class="flex gap-2.5"><svg class="mt-0.5 h-4 w-4 shrink-0 text-indigo-600 dark:text-indigo-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M7.63 13.23 4.4 10l-1.4 1.41 4.63 4.62L17 6.66l-1.41-1.41z"/></svg>Backend robusto y escalable</li>
                        <li class="flex gap-2.5"><svg class="mt-0.5 h-4 w-4 shrink-0 text-indigo-600 dark:text-indigo-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M7.63 13.23 4.4 10l-1.4 1.41 4.63 4.62L17 6.66l-1.41-1.41z"/></svg>Soporte y mejoras continuas</li>
                    </ul>
                </article>

                <aside class="flex h-full flex-col justify-between rounded-2xl bg-[#111827] p-6 text-white dark:bg-[#0b1024]">
                    <div>
                        <h3 class="text-xl font-bold">¿Listo para empezar?</h3>
                        <p class="mt-3 text-sm leading-relaxed text-slate-300">Cuéntame tu idea y te devuelvo una propuesta clara con alcance, tiempos y próximos pasos.</p>
                    </div>
                    <div class="mt-6 space-y-4">
                        <a href="{{ $contactUrl }}" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-500">
                            <svg viewBox="0 0 24 24" class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-4l-4 4v-4Z" />
                            </svg>
                            Abrir asistente de contacto
                        </a>
                        @if ($whatsappUrl)
                            <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-white/20 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                                <svg viewBox="0 0 24 24" class="h-5 w-5 shrink-0" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.435 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                                Escribir por WhatsApp
                            </a>
                        @endif
                        <ul class="space-y-2 text-sm text-slate-300">
                            <li class="flex items-center gap-2"><svg class="h-4 w-4 text-emerald-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M7.63 13.23 4.4 10l-1.4 1.41 4.63 4.62L17 6.66l-1.41-1.41z"/></svg>Respuesta en menos de 24hs</li>
                            <li class="flex items-center gap-2"><svg class="h-4 w-4 text-emerald-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M7.63 13.23 4.4 10l-1.4 1.41 4.63 4.62L17 6.66l-1.41-1.41z"/></svg>Primera consulta sin costo</li>
                        </ul>
                    </div>
                </aside>
            </div>
        </div>

        <div class="mx-auto grid grid-cols-1 gap-8 lg:max-w-3xl">
            <article class="rounded-2xl border border-gray-200 bg-white p-7 dark:border-gray-800 dark:bg-gray-900/70">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Preguntas frecuentes</h2>
                <div class="cc-faq-group mt-6" data-faq-group>
                    <x-faq-item question="¿Trabajas solo Android?">
                        Puedo trabajar Android nativo y también propuestas multiplataforma según objetivos, presupuesto y plazos.
                    </x-faq-item>
                    <x-faq-item question="¿Puedes mejorar una app existente?">
                        Sí. Audito el estado actual y planteo un plan progresivo para mejorar rendimiento, UX y arquitectura.
                    </x-faq-item>
                    <x-faq-item question="¿También haces backend para la app?">
                        Si necesitas APIs, panel admin o integraciones, puedo cubrir la solución completa de extremo a extremo.
                    </x-faq-item>
                </div>
            </article>
        </div>

        <div class="grid grid-cols-1 gap-4 border-t border-gray-200 pt-10 sm:grid-cols-2 lg:grid-cols-4 dark:border-gray-800">
            <div class="flex items-start gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-300">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7Z"/></svg>
                </span>
                <div>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">Rendimiento</p>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Animaciones fluidas y consumo controlado.</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-300">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5M8 21h8a2 2 0 0 0 2-2v-1a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 13V9a4 4 0 1 0-4 4h4Z"/></svg>
                </span>
                <div>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">UX nativa</p>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Patrones de plataforma y accesibilidad.</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-300">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="5" y="11" width="14" height="10" rx="2"/><path stroke-linecap="round" d="M8 11V8a4 4 0 1 1 8 0v3"/></svg>
                </span>
                <div>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">Seguridad</p>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Datos y comunicaciones protegidas.</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-300">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09Z"/><path stroke-linecap="round" stroke-linejoin="round" d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2Z"/></svg>
                </span>
                <div>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">Publicación</p>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Acompañamiento hacia tienda y releases.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
