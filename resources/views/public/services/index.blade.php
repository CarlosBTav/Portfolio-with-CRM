@extends('layouts.public')

@section('title', 'Servicios | Carlos Codex')
@section('meta_description', 'Servicios de desarrollo web, apps y soluciones a medida para convertir ideas en productos digitales reales.')
@section('body-class', 'antialiased bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100 font-sans flex flex-col min-h-dynamic transition-colors duration-300')

<style>

    /* CTA inferior: panel claro / oscuro + icono agenda + botón con borde luminoso */
    html:not(.dark) .services-bottom-cta {
        background-color: #ffffff;
        border: 1px solid rgba(99, 102, 241, 0.18);
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.05);
    }

    html.dark .services-bottom-cta {
        background-color: #111133;
        border: 1px solid rgba(129, 140, 248, 0.22);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.04);
    }

    .services-bottom-cta__icon-ring {
        width: 3.5rem;
        height: 3.5rem;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    html:not(.dark) .services-bottom-cta__icon-ring {
        background-color: #e0e7ff;
    }

    html.dark .services-bottom-cta__icon-ring {
        background-color: #9999ff;
    }

    html:not(.dark) .services-bottom-cta__icon-ring svg {
        color: #4338ca;
    }

    html.dark .services-bottom-cta__icon-ring svg {
        color: #0b0b2a;
    }

    html:not(.dark) .services-bottom-cta__btn {
        color: #ffffff;
        background: #4f46e5;
        border: 1px solid rgba(79, 70, 229, 0.35);
        box-shadow: 0 10px 24px rgba(79, 70, 229, 0.18);
    }

    html:not(.dark) .services-bottom-cta__btn:hover {
        background: #4338ca;
        border-color: rgba(67, 56, 202, 0.45);
        box-shadow: 0 12px 28px rgba(79, 70, 229, 0.24);
    }

    html.dark .services-bottom-cta__btn {
        color: #fff;
        background: rgba(10, 12, 45, 0.45);
        border: 1px solid rgba(255, 255, 255, 0.28);
        box-shadow:
            0 0 0 1px rgba(199, 210, 254, 0.12),
            0 0 14px rgba(255, 255, 255, 0.08),
            0 0 28px rgba(129, 140, 248, 0.12);
    }

    html.dark .services-bottom-cta__btn:hover {
        border-color: rgba(255, 255, 255, 0.55);
        background: rgba(20, 24, 70, 0.55);
        box-shadow:
            0 0 0 1px rgba(226, 232, 255, 0.35),
            0 0 18px rgba(255, 255, 255, 0.14),
            0 0 36px rgba(165, 180, 252, 0.22);
    }

    .services-bottom-cta__btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1.35rem;
        border-radius: 9999px;
        font-weight: 600;
        font-size: 0.9375rem;
        transition: border-color 0.25s ease, box-shadow 0.25s ease, background-color 0.25s ease;
    }

    .services-bottom-cta__btn:focus-visible {
        outline: 2px solid rgba(199, 210, 254, 0.75);
        outline-offset: 3px;
    }

    /* Precios: sombra lineal más oscura hacia abajo en cada tarjeta */
    .services-price-card {
        position: relative;
        isolation: isolate;
        overflow: hidden;
    }

    html:not(.dark) .services-price-card::after {
        background: linear-gradient(
            to bottom,
            transparent 0%,
            transparent 38%,
            rgba(15, 23, 42, 0.06) 72%,
            rgba(15, 23, 42, 0.12) 100%
        );
    }

    html.dark .services-price-card::after {
        background: linear-gradient(
            to bottom,
            transparent 0%,
            transparent 38%,
            rgba(6, 8, 24, 0.45) 72%,
            rgba(0, 0, 0, 0.68) 100%
        );
    }

    .services-price-card::after {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: inherit;
        pointer-events: none;
        z-index: 1;
    }

    .services-price-card > * {
        position: relative;
        z-index: 2;
    }

    [x-cloak] {
        display: none !important;
    }

    /* Overlay de agenda in-page (sin cambio de pantalla) */
    html.services-booking-open,
    body.services-booking-open {
        overscroll-behavior: none;
    }

    body.services-booking-open {
        overflow: hidden !important;
    }

    .services-booking-overlay {
        position: fixed !important;
        inset: 0 !important;
        z-index: 2147483000 !important;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        overflow: hidden;
        isolation: isolate;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: opacity 0.4s ease, visibility 0.4s ease;
    }

    .services-booking-overlay__backdrop {
        position: absolute;
        inset: 0;
        z-index: 0;
        background:
            radial-gradient(circle at 20% 20%, rgba(129, 140, 248, 0.3), transparent 45%),
            radial-gradient(circle at 78% 16%, rgba(167, 139, 250, 0.26), transparent 40%),
            rgba(3, 6, 22, 0.86);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }

    .services-booking-overlay__stage {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 760px;
        max-height: min(92dvh, 760px);
        min-height: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: visible;
        pointer-events: none;
        padding: 4px;
    }

    .services-booking-overlay__panel {
        position: relative;
        z-index: 2;
        width: 100%;
        max-height: calc(min(92dvh, 760px) - 8px);
        overflow-y: auto;
        overscroll-behavior: contain;
        scrollbar-width: none;
        pointer-events: auto;
        border-radius: 1.5rem;
        border: 1px solid rgba(129, 140, 248, 0.35);
        background:
            linear-gradient(160deg, rgba(14, 22, 52, 0.97) 0%, rgba(8, 13, 36, 0.98) 100%);
        box-shadow:
            0 32px 80px rgba(2, 6, 23, 0.65),
            inset 0 1px 0 rgba(255, 255, 255, 0.08);
        transform: translateY(28px) scale(0.985);
        opacity: 0;
        transition: transform 0.5s cubic-bezier(0.2, 0.7, 0.2, 1), opacity 0.45s ease;
        will-change: transform, opacity;
    }

    .services-booking-overlay__panel::-webkit-scrollbar {
        display: none;
    }

    .services-booking-overlay__entry {
        opacity: 0;
        transform: translateY(12px);
        transition: transform 0.42s ease, opacity 0.35s ease;
    }

    .services-booking-overlay.is-open {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
    }

    .services-booking-overlay.is-open .services-booking-overlay__panel {
        transform: translateY(0) scale(1);
        opacity: 1;
    }

    .services-booking-overlay.is-open .services-booking-overlay__entry {
        opacity: 1;
        transform: translateY(0);
    }

    .services-booking-overlay.is-open .services-booking-overlay__entry:nth-child(1) {
        transition-delay: 0.09s;
    }
    .services-booking-overlay.is-open .services-booking-overlay__entry:nth-child(2) {
        transition-delay: 0.16s;
    }
    .services-booking-overlay.is-open .services-booking-overlay__entry:nth-child(3) {
        transition-delay: 0.23s;
    }

    .services-booking-step {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 0.5rem;
    }

    .services-booking-choice {
        display: flex;
        min-height: 4.25rem;
        flex-direction: column;
        justify-content: center;
        border-radius: 1rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(255, 255, 255, 0.04);
        padding: 0.85rem;
        text-align: left;
        color: rgb(226, 232, 240);
        transition: border-color 0.2s ease, background-color 0.2s ease, transform 0.2s ease;
    }

    .services-booking-choice:hover,
    .services-booking-choice.is-selected {
        border-color: rgba(129, 140, 248, 0.75);
        background: rgba(99, 102, 241, 0.2);
        transform: translateY(-1px);
    }

    @media (max-width: 640px) {
        .services-booking-step {
            grid-template-columns: 1fr;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .services-booking-overlay,
        .services-booking-overlay__stage,
        .services-booking-overlay__panel,
        .services-booking-overlay__entry {
            transition: none !important;
        }
    }

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
{{-- Página servicios: fondo full-bleed + contenido anclado al max-width --}}
<section class="relative min-h-screen w-full pt-32 pb-20 lg:pt-36 text-slate-900 dark:text-slate-100">
    {{-- Capas de fondo (sólido + gradientes decorativos): claro / oscuro --}}
    <div class="pointer-events-none absolute inset-0 bg-slate-50 dark:bg-slate-950"></div>
    <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_20%_18%,rgba(129,140,248,0.18),transparent_42%),radial-gradient(circle_at_80%_28%,rgba(139,92,246,0.14),transparent_38%),linear-gradient(180deg,rgba(248,250,252,0.98)_0%,rgba(241,245,249,1)_100%)] dark:bg-[radial-gradient(circle_at_20%_18%,rgba(129,140,248,0.25),transparent_42%),radial-gradient(circle_at_80%_28%,rgba(139,92,246,0.20),transparent_38%),linear-gradient(180deg,rgba(6,12,36,0.94)_0%,rgba(4,8,28,0.98)_100%)]"></div>

    <div class="relative isolate z-10 max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-10 space-y-6 py-2 md:py-4">
                {{-- Hero: copy + ilustración desktop (xl) --}}
                <div class="relative z-0 grid grid-cols-1 xl:grid-cols-2 gap-8 items-center">
                    {{-- Columna texto y badges --}}
                    <div class="relative z-20">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-indigo-600 dark:text-indigo-300">Servicios</p>
                        <h1 class="mt-3 text-3xl md:text-5xl font-extrabold leading-tight text-slate-900 dark:text-white max-w-2xl">
                            Soluciones digitales a medida para tu negocio
                        </h1>
                        <p class="mt-4 text-slate-600 dark:text-slate-300 text-base md:text-lg max-w-2xl">
                            Desarrollo webs, apps y productos escalables con enfoque en negocio, claridad técnica y resultados reales.
                        </p>
                        <div class="mt-6 flex flex-wrap items-center gap-5 text-sm text-slate-700 dark:text-slate-200">
                            <div class="inline-flex items-center gap-2">
                                <span class="inline-flex h-5 w-5 items-center justify-center rounded-full border border-indigo-400/60 text-indigo-700 dark:border-indigo-300/70 dark:text-indigo-200">
                                    <svg viewBox="0 0 20 20" class="h-3.5 w-3.5 fill-current" aria-hidden="true"><path d="M7.63 13.23 4.4 10l-1.4 1.41 4.63 4.62L17 6.66l-1.41-1.41z"/></svg>
                                </span>
                                Código limpio y escalable
                            </div>
                            <div class="inline-flex items-center gap-2">
                                <span class="inline-flex h-5 w-5 items-center justify-center rounded-full border border-indigo-400/60 text-indigo-700 dark:border-indigo-300/70 dark:text-indigo-200">
                                    <svg viewBox="0 0 20 20" class="h-3.5 w-3.5 fill-current" aria-hidden="true"><path d="M7.63 13.23 4.4 10l-1.4 1.41 4.63 4.62L17 6.66l-1.41-1.41z"/></svg>
                                </span>
                                Entrega a tiempo
                            </div>
                        </div>
                    </div>

                    @include('public.services.partials.hero-mockup')

                </div>

                {{-- Grid principal: dos cards de servicios --}}
                <div class="relative z-30 grid grid-cols-1 lg:grid-cols-2 gap-5">
                    {{-- Card: desarrollo web --}}
                    <article class="rounded-2xl border border-indigo-200/80 bg-white shadow-sm dark:border-indigo-400/20 dark:bg-[#0f172a] dark:shadow-none p-6 md:p-7">
                        <div class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-100 text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-200">
                            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M2.8 9h18.4M2.8 15h18.4M12 3a15.3 15.3 0 0 1 0 18M12 3a15.3 15.3 0 0 0 0 18"/></svg>
                        </div>
                        <h2 class="mt-4 text-2xl font-bold text-slate-900 dark:text-white">Desarrollo Web</h2>
                        <p class="mt-3 text-slate-600 dark:text-slate-300">
                            Sitios y aplicaciones web modernas, rápidas y optimizadas para convertir visitantes en clientes.
                        </p>
                        <ul class="mt-5 list-none space-y-3 text-sm text-slate-600 dark:text-slate-300">
                            <li class="flex items-start gap-3">
                                <span class="mt-0.5 inline-flex h-6 w-6 shrink-0 items-center justify-center rounded border border-indigo-300/55 bg-indigo-50 text-indigo-700 dark:border-indigo-500/35 dark:bg-indigo-950 dark:text-indigo-200" aria-hidden="true">
                                    <svg viewBox="0 0 20 20" class="h-4 w-4 fill-current"><path d="M7.63 13.23 4.4 10l-1.4 1.41 4.63 4.62L17 6.66l-1.41-1.41z"/></svg>
                                </span>
                                <span>Páginas institucionales y landing pages</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="mt-0.5 inline-flex h-6 w-6 shrink-0 items-center justify-center rounded border border-indigo-300/55 bg-indigo-50 text-indigo-700 dark:border-indigo-500/35 dark:bg-indigo-950 dark:text-indigo-200" aria-hidden="true">
                                    <svg viewBox="0 0 20 20" class="h-4 w-4 fill-current"><path d="M7.63 13.23 4.4 10l-1.4 1.41 4.63 4.62L17 6.66l-1.41-1.41z"/></svg>
                                </span>
                                <span>E-commerce y tiendas online</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="mt-0.5 inline-flex h-6 w-6 shrink-0 items-center justify-center rounded border border-indigo-300/55 bg-indigo-50 text-indigo-700 dark:border-indigo-500/35 dark:bg-indigo-950 dark:text-indigo-200" aria-hidden="true">
                                    <svg viewBox="0 0 20 20" class="h-4 w-4 fill-current"><path d="M7.63 13.23 4.4 10l-1.4 1.41 4.63 4.62L17 6.66l-1.41-1.41z"/></svg>
                                </span>
                                <span>Web apps y dashboards</span>
                            </li>
                        </ul>
                        <a href="{{ route('public.services.web') }}" class="mt-6 inline-flex w-full items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 font-semibold text-white transition hover:bg-indigo-500">
                            Ver más sobre desarrollo web
                        </a>
                    </article>

                    {{-- Card: desarrollo de apps --}}
                    <article class="rounded-2xl border border-indigo-200/80 bg-white shadow-sm dark:border-indigo-400/20 dark:bg-[#0f172a] dark:shadow-none p-6 md:p-7">
                        <div class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-100 text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-200">
                            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="7" y="2.5" width="10" height="19" rx="2.5"/><path d="M11 18.5h2"/></svg>
                        </div>
                        <h2 class="mt-4 text-2xl font-bold text-slate-900 dark:text-white">Desarrollo de Apps</h2>
                        <p class="mt-3 text-slate-600 dark:text-slate-300">
                            Apps móviles nativas y multiplataforma para iOS y Android, listas para escalar tu idea.
                        </p>
                        <ul class="mt-5 list-none space-y-3 text-sm text-slate-600 dark:text-slate-300">
                            <li class="flex items-start gap-3">
                                <span class="mt-0.5 inline-flex h-6 w-6 shrink-0 items-center justify-center rounded border border-indigo-300/55 bg-indigo-50 text-indigo-700 dark:border-indigo-500/35 dark:bg-indigo-950 dark:text-indigo-200" aria-hidden="true">
                                    <svg viewBox="0 0 20 20" class="h-4 w-4 fill-current"><path d="M7.63 13.23 4.4 10l-1.4 1.41 4.63 4.62L17 6.66l-1.41-1.41z"/></svg>
                                </span>
                                <span>Apps nativas y multiplataforma</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="mt-0.5 inline-flex h-6 w-6 shrink-0 items-center justify-center rounded border border-indigo-300/55 bg-indigo-50 text-indigo-700 dark:border-indigo-500/35 dark:bg-indigo-950 dark:text-indigo-200" aria-hidden="true">
                                    <svg viewBox="0 0 20 20" class="h-4 w-4 fill-current"><path d="M7.63 13.23 4.4 10l-1.4 1.41 4.63 4.62L17 6.66l-1.41-1.41z"/></svg>
                                </span>
                                <span>APIs y conexiones con servicios</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="mt-0.5 inline-flex h-6 w-6 shrink-0 items-center justify-center rounded border border-indigo-300/55 bg-indigo-50 text-indigo-700 dark:border-indigo-500/35 dark:bg-indigo-950 dark:text-indigo-200" aria-hidden="true">
                                    <svg viewBox="0 0 20 20" class="h-4 w-4 fill-current"><path d="M7.63 13.23 4.4 10l-1.4 1.41 4.63 4.62L17 6.66l-1.41-1.41z"/></svg>
                                </span>
                                <span>Publicación en stores</span>
                            </li>
                        </ul>
                        <a href="{{ route('public.services.app') }}" class="mt-6 inline-flex w-full items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 font-semibold text-white transition hover:bg-indigo-500">
                            Ver más sobre apps
                        </a>
                    </article>
                </div>

                {{-- Proceso de trabajo con el cliente --}}
                <div class="relative z-30 rounded-2xl border border-indigo-200/80 bg-slate-100 dark:border-indigo-400/20 dark:bg-slate-950 p-5 md:p-6">
                    <h3 class="text-center text-xl font-bold text-slate-900 dark:text-white">Así trabajo contigo</h3>
                    <div class="web-dev-process__grid mt-8 grid grid-cols-1 gap-8 text-center md:grid-cols-2 lg:grid-cols-4">
                        <div class="web-dev-process__track hidden lg:block" aria-hidden="true"></div>
                        <div class="web-dev-process__step relative flex flex-col items-center">
                            <div class="web-dev-process__icon flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-300">
                                <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m20 20-3.5-3.5"/></svg>
                            </div>
                            <p class="mt-4 text-sm font-semibold text-indigo-700 dark:text-indigo-300">01. Descubrimiento</p>
                            <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-300">Entiendo tu idea, objetivo y necesidades.</p>
                        </div>

                        <div class="web-dev-process__step relative flex flex-col items-center">
                            <div class="web-dev-process__icon flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-300">
                                <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2"/><path stroke-linecap="round" d="M9 12h6M9 16h6"/></svg>
                            </div>
                            <p class="mt-4 text-sm font-semibold text-indigo-700 dark:text-indigo-300">02. Propuesta</p>
                            <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-300">Te presento solución, plan y presupuesto.</p>
                        </div>

                        <div class="web-dev-process__step relative flex flex-col items-center">
                            <div class="web-dev-process__icon flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-300">
                                <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m8 9-3 3 3 3"/><path stroke-linecap="round" stroke-linejoin="round" d="m16 15 3-3-3-3"/></svg>
                            </div>
                            <p class="mt-4 text-sm font-semibold text-indigo-700 dark:text-indigo-300">03. Desarrollo</p>
                            <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-300">Construyo, pruebo y te mantengo al tanto.</p>
                        </div>

                        <div class="web-dev-process__step relative flex flex-col items-center">
                            <div class="web-dev-process__icon flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-300">
                                <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09Z"/><path stroke-linecap="round" stroke-linejoin="round" d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/></svg>
                            </div>
                            <p class="mt-4 text-sm font-semibold text-indigo-700 dark:text-indigo-300">04. Entrega y soporte</p>
                            <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-300">Lanzo, asesoro y sigo acompañándote.</p>
                        </div>
                    </div>
                </div>

                {{-- Precios orientativos (tres columnas; sombra inferior en cada tarjeta) --}}
                <div class="relative z-30 rounded-[20px] border border-indigo-200/80 bg-white px-5 py-8 shadow-sm sm:px-8 sm:py-9 lg:px-10 lg:py-10 dark:border-indigo-400/25 dark:bg-[#080c24] dark:shadow-[inset_0_1px_0_rgba(255,255,255,0.06)]">
                    <h2 class="text-xl font-bold text-slate-900 sm:text-2xl dark:text-white">Precios orientativos</h2>
                    <p class="mt-2 max-w-2xl text-sm leading-relaxed text-slate-600 dark:text-slate-400">Proyectos a medida adaptados a tu presupuesto.</p>
                    <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-3 md:gap-5 lg:gap-6">
                        <div class="services-price-card flex h-full flex-col rounded-2xl border border-indigo-200/80 bg-white p-5 shadow-sm ring-1 ring-inset ring-slate-900/[0.04] dark:border-white/[0.08] dark:bg-[#0f142e] dark:shadow-none dark:ring-white/[0.04]">
                            <p class="text-sm font-medium text-slate-900 dark:text-white">Página web</p>
                            <p class="mt-2 text-2xl font-bold tracking-tight text-indigo-600 dark:text-indigo-400">desde 190€</p>
                            <ul class="mt-4 flex-1 space-y-2.5 text-sm text-slate-600 dark:text-slate-300">
                                <li class="flex gap-2.5"><svg class="mt-0.5 h-4 w-4 shrink-0 text-indigo-600 dark:text-white/90" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M7.63 13.23 4.4 10l-1.4 1.41 4.63 4.62L17 6.66l-1.41-1.41z"/></svg>Diseño responsive</li>
                                <li class="flex gap-2.5"><svg class="mt-0.5 h-4 w-4 shrink-0 text-indigo-600 dark:text-white/90" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M7.63 13.23 4.4 10l-1.4 1.41 4.63 4.62L17 6.66l-1.41-1.41z"/></svg>Hasta 5 secciones</li>
                                <li class="flex gap-2.5"><svg class="mt-0.5 h-4 w-4 shrink-0 text-indigo-600 dark:text-white/90" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M7.63 13.23 4.4 10l-1.4 1.41 4.63 4.62L17 6.66l-1.41-1.41z"/></svg>Formulario de contacto</li>
                                <li class="flex gap-2.5"><svg class="mt-0.5 h-4 w-4 shrink-0 text-indigo-600 dark:text-white/90" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M7.63 13.23 4.4 10l-1.4 1.41 4.63 4.62L17 6.66l-1.41-1.41z"/></svg>SEO básico</li>
                            </ul>
                        </div>
                        <div class="services-price-card flex h-full flex-col rounded-2xl border border-indigo-200/80 bg-white p-5 shadow-sm ring-1 ring-inset ring-slate-900/[0.04] dark:border-white/[0.08] dark:bg-[#0f142e] dark:shadow-none dark:ring-white/[0.04]">
                            <p class="text-sm font-medium text-slate-900 dark:text-white">Tienda online</p>
                            <p class="mt-2 text-2xl font-bold tracking-tight text-indigo-600 dark:text-indigo-400">desde 490€</p>
                            <ul class="mt-4 flex-1 space-y-2.5 text-sm text-slate-600 dark:text-slate-300">
                                <li class="flex gap-2.5"><svg class="mt-0.5 h-4 w-4 shrink-0 text-indigo-600 dark:text-white/90" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M7.63 13.23 4.4 10l-1.4 1.41 4.63 4.62L17 6.66l-1.41-1.41z"/></svg>Catálogo de productos</li>
                                <li class="flex gap-2.5"><svg class="mt-0.5 h-4 w-4 shrink-0 text-indigo-600 dark:text-white/90" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M7.63 13.23 4.4 10l-1.4 1.41 4.63 4.62L17 6.66l-1.41-1.41z"/></svg>Carrito y pagos</li>
                                <li class="flex gap-2.5"><svg class="mt-0.5 h-4 w-4 shrink-0 text-indigo-600 dark:text-white/90" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M7.63 13.23 4.4 10l-1.4 1.41 4.63 4.62L17 6.66l-1.41-1.41z"/></svg>Gestión de pedidos</li>
                                <li class="flex gap-2.5"><svg class="mt-0.5 h-4 w-4 shrink-0 text-indigo-600 dark:text-white/90" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M7.63 13.23 4.4 10l-1.4 1.41 4.63 4.62L17 6.66l-1.41-1.41z"/></svg>SEO básico</li>
                            </ul>
                        </div>
                        <div class="services-price-card flex h-full flex-col rounded-2xl border border-indigo-200/80 bg-white p-5 shadow-sm ring-1 ring-inset ring-slate-900/[0.04] dark:border-white/[0.08] dark:bg-[#0f142e] dark:shadow-none dark:ring-white/[0.04]">
                            <p class="text-sm font-medium text-slate-900 dark:text-white">App móvil</p>
                            <p class="mt-2 text-2xl font-bold tracking-tight text-indigo-600 dark:text-indigo-400">desde 490€</p>
                            <ul class="mt-4 flex-1 space-y-2.5 text-sm text-slate-600 dark:text-slate-300">
                                <li class="flex gap-2.5"><svg class="mt-0.5 h-4 w-4 shrink-0 text-indigo-600 dark:text-white/90" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M7.63 13.23 4.4 10l-1.4 1.41 4.63 4.62L17 6.66l-1.41-1.41z"/></svg>iOS y Android</li>
                                <li class="flex gap-2.5"><svg class="mt-0.5 h-4 w-4 shrink-0 text-indigo-600 dark:text-white/90" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M7.63 13.23 4.4 10l-1.4 1.41 4.63 4.62L17 6.66l-1.41-1.41z"/></svg>MVP funcional</li>
                                <li class="flex gap-2.5"><svg class="mt-0.5 h-4 w-4 shrink-0 text-indigo-600 dark:text-white/90" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M7.63 13.23 4.4 10l-1.4 1.41 4.63 4.62L17 6.66l-1.41-1.41z"/></svg>API y base de datos</li>
                                <li class="flex gap-2.5"><svg class="mt-0.5 h-4 w-4 shrink-0 text-indigo-600 dark:text-white/90" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M7.63 13.23 4.4 10l-1.4 1.41 4.63 4.62L17 6.66l-1.41-1.41z"/></svg>Publicación en stores</li>
                            </ul>
                        </div>
                    </div>
                    <p class="mt-6 text-xs text-slate-500">Precios orientativos. Cada proyecto es único.</p>
                </div>

                {{-- Resumen FAQ + enlace a página completa --}}
                <div class="relative z-30 rounded-[20px] border border-indigo-200/80 bg-white px-5 py-8 shadow-sm sm:px-8 sm:py-9 lg:px-10 lg:py-10 dark:border-indigo-400/25 dark:bg-[#080c24] dark:shadow-[inset_0_1px_0_rgba(255,255,255,0.06)]">
                    <h2 class="text-xl font-bold text-slate-900 sm:text-2xl dark:text-white">Preguntas frecuentes</h2>
                    <p class="mt-2 max-w-2xl text-sm text-slate-600 dark:text-slate-400">Respuestas rápidas antes de escribirme. La lista completa está organizada por tipo de proyecto.</p>
                    <div class="cc-faq-group mt-6" data-faq-group>
                        <x-faq-item question="¿Cuánto tarda un proyecto?">
                            <p>Depende del tipo de proyecto:</p>
                            <ul class="mt-3 list-disc space-y-2 pl-5">
                                <li><strong>Webs básicas:</strong> prototipo en 1-2 días; después, unos días de pulido e integración de tu feedback.</li>
                                <li><strong>Tienda online:</strong> prototipo en 2-3 días; luego, alrededor de una semana de pulido e integración de feedback.</li>
                                <li><strong>ERP/CRM:</strong> según la complejidad; el prototipo puede empezar desde el primer día.</li>
                            </ul>
                        </x-faq-item>
                        <x-faq-item question="¿Cómo trabajamos?">
                            Fases de descubrimiento, propuesta, desarrollo con revisiones y entrega. Mantienes visibilidad del progreso y puedes dar feedback en cada etapa.
                        </x-faq-item>
                        <x-faq-item question="¿Puedo pagar por fases?">
                            Sí: en la propuesta se pueden definir pagos ligados a hitos o entregas, para que encaje con tu flujo de caja.
                        </x-faq-item>
                    </div>
                    <p class="mt-6">
                        <a href="{{ route('public.services.faq') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 transition hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                            Ver más preguntas frecuentes
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 10h11M11 6l4 4-4 4"/></svg>
                        </a>
                    </p>
                </div>

                {{-- Contacto --}}
                <div id="servicios-contacto" class="relative z-30 flex flex-col rounded-[20px] border border-indigo-200/80 bg-white px-5 py-8 shadow-sm sm:px-8 sm:py-9 dark:border-indigo-400/25 dark:bg-[#080c24] dark:shadow-[inset_0_1px_0_rgba(255,255,255,0.06)]">
                    <div class="rounded-2xl border border-indigo-200/80 bg-slate-50 p-6 shadow-sm ring-1 ring-inset ring-slate-900/[0.04] sm:p-7 dark:border-white/[0.08] dark:bg-[#0f142e] dark:shadow-none dark:ring-white/[0.04]">
                            <h2 class="text-xl font-bold text-slate-900 sm:text-2xl dark:text-white">Hablemos de tu proyecto</h2>
                            <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Cuéntame tu idea y te responderé en menos de 24h.</p>

                            @if (session('status'))
                                <div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 dark:border-emerald-500/30 dark:bg-emerald-950/40 dark:text-emerald-200" role="status">
                                    {{ session('status') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="mt-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800 dark:border-rose-500/30 dark:bg-rose-950/40 dark:text-rose-100" role="alert">
                                    <p class="font-semibold text-rose-900 dark:text-white">Revisa el formulario</p>
                                    <ul class="mt-2 list-disc space-y-1 pl-5 text-rose-700 dark:text-rose-200/95">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @php
                                $oldInquiryType = old('inquiry_type');
                                $oldWebProducts = collect(old('web_products', []));
                                $initialSvcProjectType = match (true) {
                                    $oldInquiryType === 'mobile' => 'mobile',
                                    $oldInquiryType === 'business' => 'business',
                                    $oldInquiryType === 'web' && $oldWebProducts->contains('other') => 'web_shop',
                                    $oldInquiryType === 'web' => 'web_site',
                                    default => '',
                                };
                            @endphp

                            <form
                                action="{{ route('contact.store') }}"
                                method="post"
                                class="mt-6 space-y-4"
                                novalidate
                                x-data="{
                                    projectType: @js($initialSvcProjectType),
                                    get inquiryType() {
                                        if (this.projectType === 'mobile') return 'mobile';
                                        if (this.projectType === 'business') return 'business';
                                        if (this.projectType === 'web_site' || this.projectType === 'web_shop') return 'web';
                                        return '';
                                    },
                                    webProductValues() {
                                        if (this.projectType === 'web_site') return ['basic_web'];
                                        if (this.projectType === 'web_shop') return ['other'];
                                        return [];
                                    }
                                }"
                            >
                                @csrf
                                <input type="hidden" name="form_context" value="services">
                                <input type="hidden" name="inquiry_type" :value="inquiryType">

                                <template x-for="prod in webProductValues()" :key="prod">
                                    <input type="hidden" name="web_products[]" :value="prod">
                                </template>

                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div>
                                        <label for="svc-contact-name" class="mb-1.5 block text-xs font-medium text-slate-700 dark:text-slate-300">Nombre</label>
                                        <input id="svc-contact-name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Tu nombre"
                                            class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-1 focus:ring-indigo-400 dark:border-white/10 dark:bg-[#070b22] dark:text-white dark:placeholder:text-slate-500" />
                                    </div>
                                    <div>
                                        <label for="svc-contact-email" class="mb-1.5 block text-xs font-medium text-slate-700 dark:text-slate-300">Email</label>
                                        <input id="svc-contact-email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Tu email"
                                            class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-1 focus:ring-indigo-400 dark:border-white/10 dark:bg-[#070b22] dark:text-white dark:placeholder:text-slate-500" />
                                    </div>
                                </div>

                                <div>
                                    <label for="svc-project-type" class="mb-1.5 block text-xs font-medium text-slate-700 dark:text-slate-300">Tipo de proyecto</label>
                                    <select id="svc-project-type" x-model="projectType" required
                                        class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 focus:border-indigo-400 focus:outline-none focus:ring-1 focus:ring-indigo-400 dark:border-white/10 dark:bg-[#070b22] dark:text-white">
                                        <option value="" disabled>Selecciona una opción</option>
                                        <option value="web_site">Página web</option>
                                        <option value="web_shop">Tienda online</option>
                                        <option value="mobile">App móvil</option>
                                        <option value="business">Otro / consultoría</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="svc-contact-content" class="mb-1.5 block text-xs font-medium text-slate-700 dark:text-slate-300">Cuéntame tu proyecto</label>
                                    <textarea id="svc-contact-content" name="content" rows="4" required minlength="10" placeholder="Cuéntame brevemente tu idea..."
                                        class="w-full resize-none rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-1 focus:ring-indigo-400 dark:border-white/10 dark:bg-[#070b22] dark:text-white dark:placeholder:text-slate-500">{{ old('content') }}</textarea>
                                    <p class="mt-1 text-xs text-slate-500">Mínimo 10 caracteres.</p>
                                </div>

                                <button type="submit" class="w-full rounded-xl bg-indigo-500 px-4 py-3.5 text-sm font-bold text-white shadow-lg shadow-indigo-900/30 transition hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-300">
                                    Enviar mensaje
                                </button>

                                <p class="text-center text-xs text-slate-500">Sin compromiso. 100% confidencial.</p>
                            </form>
                    </div>
                </div>

                {{-- CTA final: barra oscura, icono agenda, botón con brillo de borde --}}
                <div class="services-bottom-cta relative z-30 flex flex-col gap-6 rounded-[20px] px-6 py-7 sm:px-9 sm:py-8 md:flex-row md:items-center md:justify-between md:gap-8">
                    <div class="flex min-w-0 flex-1 items-center gap-4 sm:gap-5">
                        <div class="services-bottom-cta__icon-ring" aria-hidden="true">
                            <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <path d="M16 2v4M8 2v4M3 10h18"></path>
                                <path d="M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01M16 18h.01"></path>
                            </svg>
                        </div>
                        <div class="min-w-0 space-y-1">
                            <h3 class="text-xl font-bold leading-snug text-slate-900 sm:text-2xl dark:text-white">
                                ¿Listo para llevar tu negocio al siguiente nivel?
                            </h3>
                            <p class="text-sm leading-relaxed text-slate-600 sm:text-[0.95rem] dark:text-slate-300">
                                Agendemos una llamada y veamos cómo puedo ayudarte.
                            </p>
                        </div>
                    </div>
                    <button type="button" data-open-booking class="services-bottom-cta__btn shrink-0 self-stretch text-center md:self-auto md:whitespace-nowrap">
                        Agendar llamada de 15 min
                        <span class="text-lg font-light opacity-95" aria-hidden="true">&rarr;</span>
                    </button>
                </div>
    </div>
</section>

<div x-data>
    <template x-teleport="body">
        <div class="services-booking-overlay" data-booking-overlay aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="booking-panel-title">
            <div class="services-booking-overlay__backdrop" data-close-booking></div>
            <div class="services-booking-overlay__stage">
                <section
                    class="services-booking-overlay__panel p-6 sm:p-8 lg:p-9"
                    x-data="{
            step: 1,
            sent: false,
            sending: false,
            error: '',
            day: '',
            time: '',
            callType: 'Videollamada',
            stripTime(d) {
                const x = new Date(d);
                x.setHours(12, 0, 0, 0);
                return x;
            },
            isWeekendDate(d) {
                const wd = this.stripTime(d).getDay();
                return wd === 0 || wd === 6;
            },
            todayBase() {
                return this.stripTime(new Date());
            },
            weekendNow() {
                return this.isWeekendDate(this.todayBase());
            },
            addDays(d, n) {
                const x = new Date(this.stripTime(d));
                x.setDate(x.getDate() + n);
                return x;
            },
            sameDay(a, b) {
                return this.stripTime(a).getTime() === this.stripTime(b).getTime();
            },
            get bookingDayChoices() {
                const today = this.todayBase();
                const out = [];
                let d = new Date(today);
                while (out.length < 3) {
                    if (!this.isWeekendDate(d)) {
                        let label;
                        let subtitle = 'Día laborable';
                        if (this.sameDay(d, today)) {
                            label = 'Hoy';
                            subtitle = 'Si hay hueco disponible';
                        } else if (this.sameDay(d, this.addDays(today, 1))) {
                            label = 'Mañana';
                            subtitle = 'Sin prisa, pero pronto';
                        } else {
                            label = new Intl.DateTimeFormat(
                                'es-ES',
                                { weekday: 'long', day: 'numeric', month: 'short' }
                            ).format(d);
                            label = label.charAt(0).toUpperCase() + label.slice(1);
                            subtitle = 'Día laborable';
                        }
                        out.push({ label, subtitle });
                        if (out.length >= 3) break;
                    }
                    d = this.addDays(d, 1);
                }
                return out;
            },
            next() {
                if (this.step === 1 && !this.day) return;
                if (this.step === 2 && !this.time) return;
                this.step = Math.min(this.step + 1, 3);
            },
            back() {
                this.step = Math.max(this.step - 1, 1);
            },
            summary() {
                return `Quiero agendar una llamada de 15 min. Preferencia: ${this.day || 'sin indicar'}. Franja: ${this.time || 'sin indicar'}. Canal: ${this.callType}.`;
            },
            needsPhone() {
                return this.callType === 'Llamada telefónica' || this.callType === 'WhatsApp';
            }
        }"
        @booking-sending.window="sending = true; error = ''"
        @booking-sent.window="sending = false; sent = true; step = 4"
        @booking-error.window="sending = false; error = $event.detail || 'No se ha podido enviar. Inténtalo de nuevo.'"
        @booking-reset.window="step = 1; sent = false; sending = false; error = ''; day = ''; time = ''; callType = 'Videollamada'"
                >
        <div class="flex items-center justify-between gap-3">
            <p class="inline-flex items-center gap-2 rounded-full border border-indigo-300/35 bg-indigo-400/10 px-3 py-1 text-[0.7rem] font-semibold uppercase tracking-[0.14em] text-indigo-200">
                Llamada de 15 min
            </p>
            <button type="button" data-close-booking class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-white/20 bg-white/5 text-slate-200 transition hover:bg-white/10 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-300" aria-label="Cerrar agenda">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="m5 5 10 10M15 5 5 15"></path>
                </svg>
            </button>
        </div>

        <form action="{{ route('contact.store') }}" method="post" data-booking-form class="mt-6 space-y-6">
            @csrf
            <input type="hidden" name="form_context" value="booking">
            <input type="hidden" name="inquiry_type" value="business">
            <input type="hidden" name="booking_channel" :value="callType">
            <input type="hidden" name="content" :value="summary()">

            <div class="services-booking-overlay__entry">
                <div class="flex items-center gap-2 text-xs font-semibold text-slate-400">
                    <span :class="step >= 1 ? 'bg-indigo-400 text-slate-950' : 'bg-white/10 text-slate-300'" class="inline-flex h-6 w-6 items-center justify-center rounded-full">1</span>
                    <span class="h-px flex-1 bg-white/10"></span>
                    <span :class="step >= 2 ? 'bg-indigo-400 text-slate-950' : 'bg-white/10 text-slate-300'" class="inline-flex h-6 w-6 items-center justify-center rounded-full">2</span>
                    <span class="h-px flex-1 bg-white/10"></span>
                    <span :class="step >= 3 ? 'bg-indigo-400 text-slate-950' : 'bg-white/10 text-slate-300'" class="inline-flex h-6 w-6 items-center justify-center rounded-full">3</span>
                </div>
            </div>

            <div class="services-booking-overlay__entry">
                <template x-if="!sent">
                    <div>
                        <h3 id="booking-panel-title" class="text-2xl font-bold tracking-tight text-white sm:text-[2rem]">
                            Reserva una llamada rápida
                        </h3>
                        <p class="mt-2 max-w-2xl text-sm leading-relaxed text-slate-300 sm:text-[0.95rem]">
                            Te haré 2 preguntas sencillas para encontrar el mejor hueco. Después solo pediré el dato necesario según el canal que elijas.
                        </p>
                    </div>
                </template>

                <template x-if="sent">
                    <div class="rounded-2xl border border-emerald-400/30 bg-emerald-500/10 p-5 text-emerald-100">
                        <h3 id="booking-panel-title" class="text-2xl font-bold tracking-tight text-white">
                            Solicitud recibida
                        </h3>
                        <p class="mt-2 text-sm leading-relaxed text-emerald-100/90">
                            Gracias. Te responderé con el hueco confirmado o con una alternativa cercana.
                        </p>
                    </div>
                </template>
            </div>

            <div class="services-booking-overlay__entry">
                <div x-show="step === 1 && !sent" x-cloak>
                    <p class="text-sm font-semibold text-white">¿Cuándo te viene mejor?</p>
                    <p x-show="weekendNow()" class="mt-2 rounded-xl border border-amber-400/25 bg-amber-500/10 px-3 py-2 text-xs leading-relaxed text-amber-100">
                        Los sábados y domingos no agendo citas. Elige uno de estos días laborables.
                    </p>
                    <div class="services-booking-step mt-4">
                        <template x-for="(opt, idx) in bookingDayChoices" :key="opt.label + idx">
                            <button
                                type="button"
                                class="services-booking-choice"
                                :class="{ 'is-selected': day === opt.label }"
                                :data-booking-first="idx === 0 ? '' : undefined"
                                @click="day = opt.label; next()"
                            >
                                <span class="text-sm font-semibold" x-text="opt.label"></span>
                                <span class="mt-1 text-xs text-slate-400" x-text="opt.subtitle"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <div x-show="step === 2 && !sent" x-cloak>
                    <p class="text-sm font-semibold text-white">¿Qué franja prefieres?</p>
                    <div class="services-booking-step mt-4">
                        <button type="button" class="services-booking-choice" :class="{ 'is-selected': time === 'Mañana' }" @click="time = 'Mañana'; next()">
                            <span class="text-sm font-semibold">Mañana</span>
                            <span class="mt-1 text-xs text-slate-400">9:00 - 12:00</span>
                        </button>
                        <button type="button" class="services-booking-choice" :class="{ 'is-selected': time === 'Tarde' }" @click="time = 'Tarde'; next()">
                            <span class="text-sm font-semibold">Tarde</span>
                            <span class="mt-1 text-xs text-slate-400">16:00 - 19:00</span>
                        </button>
                        <button type="button" class="services-booking-choice" :class="{ 'is-selected': time === 'Me adapto' }" @click="time = 'Me adapto'; next()">
                            <span class="text-sm font-semibold">Me adapto</span>
                            <span class="mt-1 text-xs text-slate-400">Te propongo opciones</span>
                        </button>
                    </div>
                </div>

                <div x-show="step === 3 && !sent" x-cloak class="space-y-4">
                    <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-4 text-sm text-slate-200">
                        <p class="font-semibold text-white">Resumen</p>
                        <p class="mt-1 text-slate-300"><span x-text="day"></span> · <span x-text="time"></span> · 15 minutos</p>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="booking-name" class="mb-1.5 block text-xs font-medium text-slate-300">Tu nombre</label>
                            <input id="booking-name" type="text" name="name" required autocomplete="name" placeholder="Nombre"
                                class="w-full rounded-xl border border-white/10 bg-[#070b22] px-3.5 py-2.5 text-sm text-white placeholder:text-slate-500 focus:border-indigo-400 focus:outline-none focus:ring-1 focus:ring-indigo-400" />
                        </div>
                        <div>
                            <label for="booking-call-type" class="mb-1.5 block text-xs font-medium text-slate-300">Canal</label>
                            <select id="booking-call-type" name="booking_channel_select" x-model="callType"
                                class="w-full rounded-xl border border-white/10 bg-[#070b22] px-3.5 py-2.5 text-sm text-white focus:border-indigo-400 focus:outline-none focus:ring-1 focus:ring-indigo-400">
                                <option>Videollamada</option>
                                <option>Llamada telefónica</option>
                                <option>WhatsApp</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div x-show="callType === 'Videollamada'" x-cloak>
                            <label for="booking-email" class="mb-1.5 block text-xs font-medium text-slate-300">Email para enviarte el enlace</label>
                            <input id="booking-email" type="email" name="email" autocomplete="email" placeholder="tu@email.com" :required="callType === 'Videollamada'"
                                class="w-full rounded-xl border border-white/10 bg-[#070b22] px-3.5 py-2.5 text-sm text-white placeholder:text-slate-500 focus:border-indigo-400 focus:outline-none focus:ring-1 focus:ring-indigo-400" />
                        </div>
                        <div x-show="needsPhone()" x-cloak>
                            <label for="booking-phone" class="mb-1.5 block text-xs font-medium text-slate-300" x-text="callType === 'WhatsApp' ? 'Número de WhatsApp' : 'Teléfono para llamarte'"></label>
                            <input id="booking-phone" type="tel" name="phone" autocomplete="tel" placeholder="+34 600 000 000" :required="needsPhone()"
                                class="w-full rounded-xl border border-white/10 bg-[#070b22] px-3.5 py-2.5 text-sm text-white placeholder:text-slate-500 focus:border-indigo-400 focus:outline-none focus:ring-1 focus:ring-indigo-400" />
                        </div>
                    </div>

                    <p x-show="error" x-text="error" class="rounded-xl border border-rose-500/30 bg-rose-950/40 px-4 py-3 text-sm text-rose-100"></p>
                </div>
            </div>

            <div class="services-booking-overlay__entry flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <button type="button" x-show="step > 1 && step < 4 && !sent" x-cloak @click="back()" class="inline-flex items-center justify-center rounded-xl border border-white/15 px-4 py-3 text-sm font-semibold text-slate-200 transition hover:bg-white/10">
                    Volver
                </button>
                <div class="hidden sm:block" x-show="step === 1"></div>

                <button type="button" x-show="step < 3 && !sent" x-cloak @click="next()" :disabled="(step === 1 && !day) || (step === 2 && !time)" class="inline-flex items-center justify-center rounded-xl bg-indigo-500 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:bg-indigo-400 disabled:cursor-not-allowed disabled:opacity-50">
                    Continuar
                </button>

                <button type="submit" x-show="step === 3 && !sent" x-cloak :disabled="sending" class="inline-flex items-center justify-center rounded-xl bg-indigo-500 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:bg-indigo-400 disabled:cursor-wait disabled:opacity-70">
                    <span x-show="!sending">Solicitar llamada</span>
                    <span x-show="sending">Enviando...</span>
                </button>

                <button type="button" x-show="sent" x-cloak data-close-booking class="inline-flex items-center justify-center rounded-xl bg-emerald-500 px-5 py-3 text-sm font-bold text-slate-950 transition hover:bg-emerald-400">
                    Perfecto, cerrar
                </button>
            </div>
        </form>
                </section>
            </div>
        </div>
    </template>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const overlay = document.querySelector('[data-booking-overlay]');
        const openButtons = Array.from(document.querySelectorAll('[data-open-booking]'));
        if (!overlay || !openButtons.length) return;

        const closeButtons = Array.from(overlay.querySelectorAll('[data-close-booking]'));
        const bookingForm = overlay.querySelector('[data-booking-form]');

        const setOverlayState = (isOpen) => {
            if (isOpen) {
                document.documentElement.classList.add('services-booking-open');
                document.body.classList.add('services-booking-open');
                window.dispatchEvent(new CustomEvent('booking-reset'));
            } else {
                document.documentElement.classList.remove('services-booking-open');
                document.body.classList.remove('services-booking-open');
            }

            overlay.classList.toggle('is-open', isOpen);
            overlay.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
        };

        const closeOverlay = () => setOverlayState(false);

        openButtons.forEach((button) => {
            button.addEventListener('click', (event) => {
                event.preventDefault();
                setOverlayState(true);
            });
        });

        closeButtons.forEach((button) => {
            button.addEventListener('click', () => closeOverlay());
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && overlay.classList.contains('is-open')) {
                closeOverlay();
            }
        });

        bookingForm?.addEventListener('submit', async (event) => {
            event.preventDefault();

            if (!bookingForm.reportValidity()) return;

            overlay.dispatchEvent(new CustomEvent('booking-sending', { bubbles: true }));

            try {
                const response = await fetch(bookingForm.action, {
                    method: 'POST',
                    body: new FormData(bookingForm),
                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });

                const payload = await response.json().catch(() => ({}));

                if (!response.ok) {
                    const firstError = payload.errors
                        ? Object.values(payload.errors).flat()[0]
                        : payload.message;
                    throw new Error(firstError || 'No se ha podido enviar. Inténtalo de nuevo.');
                }

                bookingForm.reset();
                overlay.dispatchEvent(new CustomEvent('booking-sent', { bubbles: true }));
            } catch (error) {
                overlay.dispatchEvent(new CustomEvent('booking-error', {
                    bubbles: true,
                    detail: error.message,
                }));
            }
        });
    });
</script>
@endpush
