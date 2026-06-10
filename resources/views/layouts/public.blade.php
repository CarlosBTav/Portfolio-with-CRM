<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('partials.seo')
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('img/favicon.png') }}?v={{ filemtime(public_path('img/favicon.png')) }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v={{ filemtime(public_path('favicon.ico')) }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,800&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite([
        'resources/css/app.css', 
        'resources/js/app.js', 
        'resources/css/spotlight.css', 
        'resources/js/spotlight.js',
        'resources/js/bg_code.js',
        'resources/js/ai-dots-touch.js',
    ])

    <!-- Estilos Globales -->
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        .skill-tag { display: inline-flex; align-items: center; padding: 0.25rem 0.75rem; background-color: #f9fafb; border: 1px solid #e5e7eb; border-radius: 9999px; font-size: 0.875rem; font-weight: 500; color: #374151; cursor: default; transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); }
        .skill-tag:hover { transform: scale(1.05); border-color: #818cf8; background-color: #eef2ff; color: #4f46e5; }
        .dark .skill-tag { background-color: #1f2937; border-color: #374151; color: #d1d5db; }
        .dark .skill-tag:hover { background-color: #312e81; border-color: #6366f1; color: #a5b4fc; }

        .footer-btn { display: inline-flex; align-items: center; gap: 0.625rem; padding: 0.5rem 0.75rem; background-color: transparent; border: 1px solid transparent; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; color: #9ca3af; transition: all 0.3s ease; cursor: pointer; }
        .group:hover .footer-btn { background-color: rgba(31, 41, 55, 0.5); }
        .group:hover .icon-linkedin { color: #0077b5; }
        .group:hover .icon-github { color: #3CCF91; }
        .group:hover .icon-email { color: #818cf8; }

        /* Evita scroll horizontal global (decoraciones blur con márgenes negativos, flex min-width:auto, etc.) */
        html { overflow-x: clip; scrollbar-width: none; -ms-overflow-style: none; }
        html::-webkit-scrollbar { display: none; }

        #scroll-progress-container { position: fixed; right: 0; top: 0; width: 4px; height: 100vh; height: 100lvh; background-color: rgba(229, 231, 235, 0.3); z-index: 100; }
        .dark #scroll-progress-container { background-color: rgba(55, 65, 81, 0.3); }
        #scroll-progress-bar { width: 100%; height: 0%; background: linear-gradient(to bottom, #818cf8, #4f46e5); box-shadow: 0 0 8px rgba(79, 70, 229, 0.5); transition: height 0.1s ease-out; }

        /* Scroll-to-top FAB */
        #scrollToTopBtn { transition: opacity 300ms ease, transform 300ms ease; will-change: opacity, transform; }

        @view-transition {
            navigation: auto;
        }

        @keyframes float-natural { 
            0%   { transform: translate(0, 0) rotate(0deg); } 
            33%  { transform: translate(2px, -5px) rotate(0.8deg); } 
            66%  { transform: translate(-2px, -7px) rotate(-0.8deg); } 
            100% { transform: translate(0, 0) rotate(0deg); } 
        }
        .animate-floating { animation: float-natural 8s cubic-bezier(0.45, 0.05, 0.55, 0.95) infinite; }

        /* Hero profile metallic sweep ring */
        /* --profile-ring-sweep-start = rotación inicial del barrido (derivada del ratón al clic) */
        @keyframes profile-ring-sweep {
            0% {
                opacity: 0.24;
                transform: rotate(var(--profile-ring-sweep-start, 0deg));
                filter: blur(0px);
            }
            18% {
                opacity: 0.2;
            }
            45% {
                opacity: 0.12;
            }
            70% {
                opacity: 0.07;
            }
            100% {
                opacity: 0;
                transform: rotate(calc(var(--profile-ring-sweep-start, 0deg) + 360deg));
                filter: blur(0.35px);
            }
        }
        .profile-ring {
            isolation: isolate;
            transition: transform 620ms cubic-bezier(0.22, 0.8, 0.2, 1), box-shadow 680ms ease;
        }
        /* Brillo = spotlight en el cursor, enmascarado solo al aro (PC la mueve el JS) */
        .profile-ring::before {
            content: "";
            position: absolute;
            /* El contenedor absoluto parte del borde interno; lo desplazamos 4px
               para alinear el brillo con el borde real (border-4) del retrato. */
            inset: -4px;
            border-radius: 9999px;
            padding: 4px;
            background:
                radial-gradient(
                    var(--profile-ring-spot-size, 86px) circle at var(--profile-ring-spot-x, 50%) var(--profile-ring-spot-y, 50%),
                    rgba(236, 238, 255, calc(0.62 * var(--profile-ring-proximity, 0))) 0%,
                    rgba(165, 175, 252, calc(0.36 * var(--profile-ring-proximity, 0))) 40%,
                    rgba(129, 140, 248, calc(0.14 * var(--profile-ring-proximity, 0))) 62%,
                    transparent 100%
                );
            opacity: 1;
            pointer-events: none;
            z-index: 2;
            transition: opacity 260ms cubic-bezier(0.22, 0.8, 0.2, 1);
            transform: rotate(0deg);
            /* Mask igual que .spotlight: pinta solo el aro, no el interior */
            -webkit-mask:
                linear-gradient(#fff 0 0) content-box,
                linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
        }
        /* Táctil / puntero grueso: barrido al hover como antes */
        @media (pointer: coarse), (hover: none) {
            .profile-ring:hover::before {
                animation: profile-ring-sweep 1.15s cubic-bezier(0.22, 0.8, 0.2, 1) 1 both;
            }
        }
        /* PC: brillo antes/durante acercamiento (sin depender solo de :hover), variable --profile-ring-proximity */
        @media (hover: hover), (any-hover: hover) {
            .profile-ring::before {
                animation: none;
                opacity: 1;
                transition: opacity 220ms cubic-bezier(0.2, 0.75, 0.25, 1);
            }
            /* Tras clic: sin brillo hasta salir del retrato y volver */
            .profile-ring.profile-ring--rim-holdoff::before {
                opacity: 0;
            }
        }
        /* Clic: barrido metálico (va después del bloque PC para ganar en cascada) */
        .profile-ring.profile-ring--sweep::before,
        .profile-ring.profile-ring--sweep:hover::before {
            animation: profile-ring-sweep 1.15s cubic-bezier(0.22, 0.8, 0.2, 1) 1 both;
            background:
                conic-gradient(
                    from 0deg,
                    rgba(255, 255, 255, 0) 0deg 300deg,
                    rgba(224, 231, 255, 0.72) 326deg,
                    rgba(129, 140, 248, 0.58) 346deg,
                    rgba(255, 255, 255, 0) 360deg
                );
        }
        .profile-ring:hover {
            transform: scale(1.004);
            box-shadow: 0 14px 30px rgba(99, 102, 241, 0.12);
        }

        /* GitHub Icon Animation (sutil pero notable) */
        .hover-wiggle {
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .group:hover .hover-wiggle, .hover-wiggle:hover {
            transform: scale(1.15) rotate(-10deg);
        }

        .hover-pop {
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .group:hover .hover-pop, .hover-pop:hover {
            transform: scale(1.15);
        }

        /* Email Icon Animation (real envelope depth behavior) */
        .hover-email .email-state-closed,
        .hover-email .email-state-open {
            transition: opacity 0.35s ease;
        }
        .hover-email .email-state-open {
            opacity: 0;
        }
        .hover-email .email-open-letter {
            transform: translateY(0);
            transition: transform 0.45s cubic-bezier(0.34, 1.56, 0.64, 1) 0.1s;
        }
        .hover-email .email-open-flap-front,
        .hover-email .email-open-flap-back {
            transform-origin: center 112px;
            transition: transform 0.42s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.2s ease;
        }
        /* Solapa visible delante cuando esta cerrado */
        .hover-email .email-open-flap-front {
            opacity: 1;
            transform: translateY(0) scaleY(1);
        }
        /* Solapa "trasera": misma geometria pero oculta al inicio */
        .hover-email .email-open-flap-back {
            opacity: 0;
            transform: translateY(-30px) scaleY(0.05);
        }
        .group:hover .hover-email .email-state-closed,
        .hover-email:hover .email-state-closed {
            opacity: 0;
        }
        .group:hover .hover-email .email-state-open,
        .hover-email:hover .email-state-open {
            opacity: 1;
        }
        .group:hover .hover-email .email-open-letter,
        .hover-email:hover .email-open-letter {
            transform: translateY(-70px);
        }
        /* La solapa delantera se abre y desaparece (pasa "hacia atras") */
        .group:hover .hover-email .email-open-flap-front,
        .hover-email:hover .email-open-flap-front {
            opacity: 0;
            transform: translateY(-30px) scaleY(0.05);
        }
        /* Aparece la solapa trasera, por detras de la carta */
        .group:hover .hover-email .email-open-flap-back,
        .hover-email:hover .email-open-flap-back {
            opacity: 1;
            transform: translateY(-30px) scaleY(0.05);
        }

        /* Footer name VFX: shimmer + cursor glow + letter stagger */
        .footer-name-wrapper {
            position: relative;
            overflow: visible;
        }
        .footer-name-wrapper::after {
            content: "";
            position: absolute;
            left: -40px; right: -40px; top: -20px; bottom: -20px;
            background: radial-gradient(
                420px circle at var(--mouse-x, 50%) var(--mouse-y, 50%),
                rgba(129, 140, 248, 0.32),
                transparent 50%
            );
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
            z-index: -1;
        }
        .footer-name-wrapper:hover::after {
            opacity: 1;
        }
        /* Capa base: color sólido, siempre visible */
        .footer-name-vfx-base {
            position: relative;
            z-index: 0;
            font-weight: inherit;
            color: inherit;
        }
        /* Capa superior: solo el barrido de luz; oculta por defecto para evitar blanco a la derecha y salto al quitar hover */
        .footer-name-vfx-sweep {
            position: absolute;
            left: 0;
            top: 0;
            z-index: 1;
            font-weight: inherit;
            pointer-events: none;
            background: linear-gradient(
                90deg,
                transparent 0%,
                transparent 50%,
                rgba(255, 255, 255, 0.98) 58%,
                rgba(255, 255, 255, 0.95) 65%,
                transparent 72%,
                transparent 100%
            );
            background-size: 200% 100%;
            background-repeat: no-repeat;
            background-position: 0 0;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            color: transparent;
            opacity: 0;
            transition: opacity 0.18s ease-out;
        }
        .footer-name-wrapper:hover .footer-name-vfx-sweep {
            opacity: 1;
            background-position: 100% 0;
            transition: opacity 0.2s ease, background-position 0.55s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .footer-name-char {
            display: inline-block;
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            transition-delay: calc(var(--char-index) * 22ms);
        }
        .footer-name-wrapper:hover .footer-name-char {
            transform: translateY(-1.2px);
        }
        /* Hero: mismo efecto de letras, sin halo externo */
        .hero-name-vfx::after {
            display: none;
        }
        /* Ajustes del split por letras en hero */
        .hero-name-vfx .footer-name-vfx-base,
        .hero-name-vfx .footer-name-vfx-sweep {
            font-size: inherit;
            line-height: inherit;
        }
        .hero-name-vfx .footer-name-char {
            font-size: inherit;
            line-height: inherit;
            transform-origin: 50% 70%;
        }
        @keyframes hero-wave-expand {
            0%, 100% { transform: translateY(0); }
            40% { transform: translateY(-2px); }
            70% { transform: translateY(-0.5px); }
        }
        .hero-name-vfx:hover .hero-wave-char {
            animation: hero-wave-expand 0.55s cubic-bezier(0.34, 1.56, 0.64, 1) both;
            animation-delay: calc(var(--char-index) * 26ms);
        }
        /* Desktop: ola guiada por ratón (sustituye a la animación hover) */
        @media (min-width: 1024px) {
            .hero-name-vfx .hero-wave-char {
                animation: none !important;
                transform: translate(
                    var(--hero-shift-x, 0px),
                    var(--hero-shift-y, 0px)
                );
                transition: transform 180ms cubic-bezier(0.22, 0.8, 0.2, 1);
            }
            .hero-name-vfx:hover .hero-wave-char {
                animation: none !important;
                transform: translate(
                    var(--hero-shift-x, 0px),
                    var(--hero-shift-y, 0px)
                );
            }
            .footer-magnetic-vfx .footer-name-char {
                animation: none !important;
                transform: translate(
                    var(--hero-shift-x, 0px),
                    var(--hero-shift-y, 0px)
                );
                transition: transform 180ms cubic-bezier(0.22, 0.8, 0.2, 1);
            }
            .footer-magnetic-vfx:hover .footer-name-char {
                animation: none !important;
                transform: translate(
                    var(--hero-shift-x, 0px),
                    var(--hero-shift-y, 0px)
                );
            }
        }
        /* "Diseño & Desarrollo": mismo color, reflejo metálico que sigue al ratón */
        .footer-design-wrapper {
            position: relative;
            overflow: visible;
        }
        .footer-design-base {
            position: relative;
            z-index: 0;
            color: inherit;
            transition: none;
        }
        .footer-design-reflection {
            position: absolute;
            left: 0;
            top: 0;
            z-index: 1;
            pointer-events: none;
            background: radial-gradient(
                120px circle at var(--mouse-x, 50%) var(--mouse-y, 50%),
                rgba(255, 255, 255, 0.9) 0%,
                rgba(255, 255, 255, 0.5) 12%,
                rgba(255, 255, 255, 0.15) 25%,
                transparent 45%
            );
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            color: transparent;
            opacity: var(--design-proximity, 0);
            transition: opacity 0.25s ease;
        }

        /* Navbar marca: relieve + spotlight centrado en el cursor (solo glifos) */
        .navbar-brand-vfx {
            width: max-content;
        }
        .navbar-brand-stack {
            position: relative;
            display: inline-block;
            isolation: isolate;
        }
        .navbar-brand-vfx .navbar-brand-shadow {
            position: absolute;
            left: 0;
            top: 0;
            z-index: 0;
            pointer-events: none;
            font-weight: inherit;
            color: rgba(15, 23, 42, 0.32);
            transform: translate(0.7px, 1.45px);
        }
        .dark .navbar-brand-vfx .navbar-brand-shadow {
            color: rgba(0, 0, 0, 0.55);
        }
        .navbar-brand-vfx .footer-design-base {
            position: relative;
            z-index: 1;
            /* Volumen tipo relieve: luz arriba-izq, sombra abajo-dcha (sin blur ancho) */
            text-shadow:
                0          1px   0 rgba(255, 255, 255, 0.38),
                0         -1px   0 rgba(15, 23, 42, 0.06),
                0.5px  0.75px   0 rgba(15, 23, 42, 0.1);
        }
        .dark .navbar-brand-vfx .footer-design-base {
            text-shadow:
                0    1px   0 rgba(255, 255, 255, 0.06),
                0    2px   4px rgba(0, 0, 0, 0.55),
                0   -1px   0 rgba(0, 0, 0, 0.35);
        }
        /*
         * Spotlight en el cursor: núcleo brillante + halo amplio (sin anillo).
         * El primero dibuja el foco; el segundo la luz ambiente sobre el texto.
         */
        .navbar-brand-vfx .footer-design-reflection {
            z-index: 1;
            background-color: transparent;
            background-image:
                radial-gradient(
                    48px circle          at var(--mouse-x, 50%) var(--mouse-y, 50%),
                    rgba(255, 255, 255, 0.95) 0%,
                    rgba(255, 255, 255, 0.42) 45%,
                    transparent             72%
                ),
                radial-gradient(
                    175px circle         at var(--mouse-x, 50%) var(--mouse-y, 50%),
                    rgba(255, 255, 255, 0.48) 0%,
                    rgba(199, 210, 254, 0.18) 32%,
                    rgba(129, 140, 248, 0.06) 52%,
                    transparent              68%
                );
            background-repeat: no-repeat, no-repeat;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            color: transparent;
        }
        .dark .navbar-brand-vfx .footer-design-reflection {
            background-image:
                radial-gradient(
                    56px circle          at var(--mouse-x, 50%) var(--mouse-y, 50%),
                    rgba(238, 242, 255, 0.88) 0%,
                    rgba(165, 180, 252, 0.38) 48%,
                    transparent              76%
                ),
                radial-gradient(
                    185px circle         at var(--mouse-x, 50%) var(--mouse-y, 50%),
                    rgba(199, 210, 254, 0.32) 0%,
                    rgba(99, 102, 241, 0.12) 38%,
                    transparent              62%
                );
        }

        /* Logo nav: colores fijos claro/oscuro (no depender solo de utilidades Tailwind en el partial) */
        .navbar-brand-vfx .navbar-logo-char-main {
            color: #111827;
        }
        .navbar-brand-vfx .navbar-logo-char-muted {
            color: #9ca3af;
        }
        .dark .navbar-brand-vfx .navbar-logo-char-main {
            color: #f9fafb;
        }
        .dark .navbar-brand-vfx .navbar-logo-char-muted {
            color: #4b5563;
        }
        /* Relieve del texto base (antes en .footer-design-base del mismo bloque navbar-brand-vfx) */
        .navbar-brand-vfx .navbar-logo-wave .footer-name-vfx-base {
            text-shadow:
                0          1px   0 rgba(255, 255, 255, 0.38),
                0         -1px   0 rgba(15, 23, 42, 0.06),
                0.5px  0.75px   0 rgba(15, 23, 42, 0.1);
        }
        .dark .navbar-brand-vfx .navbar-logo-wave .footer-name-vfx-base {
            text-shadow:
                0    1px   0 rgba(255, 255, 255, 0.06),
                0    2px   4px rgba(0, 0, 0, 0.55),
                0   -1px   0 rgba(0, 0, 0, 0.35);
        }
        /* Capa metálica encima: mismos glifos que la ola (hero-wave-char) para alinear el brillo */
        .navbar-brand-vfx .navbar-brand-metallic-overlay {
            position: absolute;
            left: 0;
            top: 0;
            z-index: 2;
            pointer-events: none;
        }
        .navbar-brand-vfx .navbar-brand-metallic-char {
            color: transparent;
            -webkit-text-fill-color: transparent;
        }
    </style>

    <script>
        /* Sync with the 'color-theme' key used by the theme-toggle component */
        if (localStorage['color-theme'] === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="@yield('body-class','antialiased bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 font-sans flex flex-col min-h-dynamic transition-colors duration-300')">
    
    <div id="scroll-progress-container"><div id="scroll-progress-bar"></div></div>

    <!-- Incluimos el Menú de navegación -->
    @include('partials.navbar')

    <!-- AQUÍ SE INYECTARÁ EL CONTENIDO DE LA VISTA -->
    <main class="relative z-10 flex-grow min-w-0">
        @yield('content')
    </main>

    <!-- Incluimos el pie de página -->
    @include('partials.footer')

    <!-- BOTÓN SCROLL TO TOP -->
    <div id="scrollToTopBtn" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="fixed right-8 z-[80] bottom-8 opacity-0 pointer-events-none translate-y-10">
        <div class="h-12 w-12 rounded-full bg-indigo-600 hover:bg-indigo-500 dark:bg-indigo-600 dark:hover:bg-indigo-500 cursor-pointer flex items-center justify-center shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/50 transition-colors duration-300" role="button" tabindex="0">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-white"><path d="m18 15-6-6-6 6"></path></svg>
        </div>
    </div>

    <!-- Scripts Generales de la Interfaz -->
    <script>
        // 1. Scroll to Top
        const scrollBtn = document.getElementById('scrollToTopBtn');
        const footer    = document.getElementById('main-footer');
        let _fabRaf = null;

        function syncScrollToTopFab() {
            if (!scrollBtn) return;
            if (_fabRaf) return;
            _fabRaf = requestAnimationFrame(() => {
                _fabRaf = null;

                // Visibilidad
                if (window.scrollY > 300) {
                    scrollBtn.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-10');
                    scrollBtn.classList.add('opacity-100', 'translate-y-0');
                } else {
                    scrollBtn.classList.add('opacity-0', 'pointer-events-none', 'translate-y-10');
                    scrollBtn.classList.remove('opacity-100', 'translate-y-0');
                }

                // Posición: sube por encima del footer si este ya es visible
                if (footer) {
                    const gap        = 32; // bottom-8
                    const footerTop  = footer.getBoundingClientRect().top;
                    const vh         = window.innerHeight;
                    scrollBtn.style.bottom = (footerTop < vh
                        ? gap + (vh - footerTop)
                        : gap) + 'px';
                }
            });
        }

        if (scrollBtn) {
            window.addEventListener('scroll', syncScrollToTopFab, { passive: true });
            window.addEventListener('resize', syncScrollToTopFab);
            syncScrollToTopFab();
        }

        // 2. Seguimiento del ratón (Tarjetas + textos con efectos)
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.js-spotlight-card, .js-project-card').forEach(card => {
                card.addEventListener('mousemove', (e) => {
                    const rect = card.getBoundingClientRect();
                    card.style.setProperty('--mouse-x', `${e.clientX - rect.left}px`);
                    card.style.setProperty('--mouse-y', `${e.clientY - rect.top}px`);
                });
            });
            const nameSpotlights = document.querySelectorAll('.js-footer-name-spotlight');
            const designSpotlights = document.querySelectorAll('.js-footer-design-spotlight');

            document.addEventListener('mousemove', (e) => {
                nameSpotlights.forEach((nameSpotlight) => {
                    const rect = nameSpotlight.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    if (x >= 0 && x <= rect.width && y >= 0 && y <= rect.height) {
                        nameSpotlight.style.setProperty('--mouse-x', `${x}px`);
                        nameSpotlight.style.setProperty('--mouse-y', `${y}px`);
                    }
                });

                designSpotlights.forEach((designSpotlight) => {
                    const rect = designSpotlight.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    designSpotlight.style.setProperty('--mouse-x', `${x}px`);
                    designSpotlight.style.setProperty('--mouse-y', `${y}px`);

                    // Proximity fade-in before entering text area (smooth approach)
                    const dx = x < 0 ? -x : (x > rect.width ? x - rect.width : 0);
                    const dy = y < 0 ? -y : (y > rect.height ? y - rect.height : 0);
                    const distance = Math.hypot(dx, dy);
                    const sigma = 95;
                    const proximity = Math.exp(-(distance * distance) / (2 * sigma * sigma));
                    designSpotlight.style.setProperty('--design-proximity', proximity.toFixed(3));
                });
            });

            nameSpotlights.forEach((nameSpotlight) => {
                const sweep = nameSpotlight.querySelector('.footer-name-vfx-sweep');
                if (!sweep) return;
                nameSpotlight.addEventListener('mouseleave', () => {
                    function resetPosition(e) {
                        if (e.propertyName === 'opacity') {
                            sweep.style.backgroundPosition = '0 0';
                            sweep.removeEventListener('transitionend', resetPosition);
                        }
                    }
                    sweep.addEventListener('transitionend', resetPosition);
                });
            });

            // Hero desktop wave: letters repel away from mouse (Y-aware)
            const heroWaveNodes = document.querySelectorAll('.js-hero-wave');
            const isDesktopWave = window.matchMedia('(min-width: 1024px)');

            function bindHeroWave(node) {
                const chars = Array.from(node.querySelectorAll('.hero-wave-char'));
                if (!chars.length) return;

                const sigmaX = 40;        // horizontal spread
                const sigmaY = 105;       // vertical spread
                const maxShiftX = 6;      // max horizontal attraction
                const maxShiftY = 11;     // max vertical attraction
                const lerp = 0.16;        // smoother easing
                const currentShifts = chars.map(() => ({ x: 0, y: 0 }));
                const targetShifts = chars.map(() => ({ x: 0, y: 0 }));
                let mouseX = null;
                let mouseY = null;

                const updateTargets = () => {
                    if (!isDesktopWave.matches || mouseX === null) {
                        for (let i = 0; i < targetShifts.length; i++) {
                            targetShifts[i].x = 0;
                            targetShifts[i].y = 0;
                        }
                        return;
                    }

                    chars.forEach((ch, i) => {
                        const rect = ch.getBoundingClientRect();
                        const centerX = rect.left + rect.width / 2;
                        const centerY = rect.top + rect.height / 2;
                        const dx = mouseX - centerX;
                        const dy = mouseY - centerY;

                        // Smooth radial influence around cursor
                        const influence = Math.exp(
                            -((dx * dx) / (2 * sigmaX * sigmaX) + (dy * dy) / (2 * sigmaY * sigmaY))
                        );

                        // Continuous attraction on both axes (no sign flip jump)
                        targetShifts[i].x = maxShiftX * Math.tanh(dx / 75) * influence;
                        targetShifts[i].y = maxShiftY * Math.tanh(dy / 70) * influence;
                    });
                };

                const animate = () => {
                    updateTargets();
                    chars.forEach((ch, i) => {
                        currentShifts[i].x += (targetShifts[i].x - currentShifts[i].x) * lerp;
                        currentShifts[i].y += (targetShifts[i].y - currentShifts[i].y) * lerp;
                        if (Math.abs(currentShifts[i].x) < 0.02) currentShifts[i].x = 0;
                        if (Math.abs(currentShifts[i].y) < 0.02) currentShifts[i].y = 0;
                        ch.style.setProperty('--hero-shift-x', currentShifts[i].x.toFixed(2) + 'px');
                        ch.style.setProperty('--hero-shift-y', currentShifts[i].y.toFixed(2) + 'px');
                    });
                    requestAnimationFrame(animate);
                };

                window.addEventListener('mousemove', (e) => {
                    mouseX = e.clientX;
                    mouseY = e.clientY;
                });
                window.addEventListener('mouseleave', () => {
                    mouseX = null;
                    mouseY = null;
                });

                requestAnimationFrame(animate);
            }

            heroWaveNodes.forEach(bindHeroWave);

            // Hero foto perfil (PC): spotlight en el ratón solo visible en el aro; se apaga hacia el centro; clic = barrido conic
            const profileRings = document.querySelectorAll('.js-profile-ring');
            const canHoverProfileRing = window.matchMedia('(hover: hover), (any-hover: hover)');
            let profileRingRaf = 0;
            let profileRingMx = 0;
            let profileRingMy = 0;

            function profileRingSweepStartFromPointer(ring, clientX, clientY) {
                const rect = ring.getBoundingClientRect();
                const cx = rect.left + rect.width / 2;
                const cy = rect.top + rect.height / 2;
                const dx = clientX - cx;
                const dy = clientY - cy;
                const jsDeg = Math.atan2(dy, dx) * (180 / Math.PI);
                const mouseAngleCss = ((jsDeg + 90) % 360 + 360) % 360;
                const wedgeCenterLocal = 336;
                const deg = ((mouseAngleCss - wedgeCenterLocal) % 360 + 360) % 360;
                return deg.toFixed(2) + 'deg';
            }

            function updateProfileRingSpotlight(ring, clientX, clientY) {
                if (ring.classList.contains('profile-ring--sweep')) return;

                const rect = ring.getBoundingClientRect();
                const cx = rect.left + rect.width / 2;
                const cy = rect.top + rect.height / 2;
                const dx = clientX - cx;
                const dy = clientY - cy;
                const dist = Math.hypot(dx, dy);
                const radius = Math.min(rect.width, rect.height) / 2;
                const rimRadius = radius - 1;

                if (ring.classList.contains('profile-ring--rim-holdoff')) {
                    ring.style.setProperty('--profile-ring-proximity', '0');
                    return;
                }

                // Centro del spotlight = posición real del ratón
                const spotX = clientX - rect.left;
                const spotY = clientY - rect.top;

                const distToRim = Math.abs(dist - rimRadius);
                const sigmaRim = Math.max(28, radius * 0.34);
                const proximity = Math.exp(-(distToRim * distToRim) / (2 * sigmaRim * sigmaRim));
                const insideFactor = dist < rimRadius ? (1 - (dist / rimRadius)) : 0;
                const centerBoost = Math.pow(insideFactor, 0.62);
                const diameter = (radius * 2) + 4;
                const spotSize = 72 + (82 * proximity) + ((diameter - 56) * centerBoost);
                const edgeIntensity = Math.pow(proximity, 1.6) * 0.5;
                const centerIntensity = centerBoost * 0.44;
                const visibleProximity = Math.min(1, Math.max(edgeIntensity, centerIntensity));

                if (visibleProximity < 0.002) {
                    ring.style.setProperty('--profile-ring-proximity', '0');
                    ring.style.setProperty('--profile-ring-spot-size', '58px');
                    return;
                }

                ring.style.setProperty('--profile-ring-spot-x', spotX.toFixed(2) + 'px');
                ring.style.setProperty('--profile-ring-spot-y', spotY.toFixed(2) + 'px');
                ring.style.setProperty('--profile-ring-proximity', visibleProximity.toFixed(4));
                ring.style.setProperty('--profile-ring-spot-size', spotSize.toFixed(2) + 'px');
            }

            function flushProfileRingsFromPointer() {
                profileRingRaf = 0;
                profileRings.forEach((ring) => {
                    updateProfileRingSpotlight(ring, profileRingMx, profileRingMy);
                });
            }

            document.addEventListener('mousemove', (e) => {
                profileRingMx = e.clientX;
                profileRingMy = e.clientY;
                if (!profileRingRaf) {
                    profileRingRaf = requestAnimationFrame(flushProfileRingsFromPointer);
                }
            });

            window.addEventListener('blur', () => {
                profileRings.forEach((ring) => {
                    ring.style.setProperty('--profile-ring-proximity', '0');
                    ring.style.setProperty('--profile-ring-spot-size', '58px');
                    ring.style.removeProperty('--profile-ring-spot-x');
                    ring.style.removeProperty('--profile-ring-spot-y');
                });
            });

            profileRings.forEach((ring) => {
                ring.addEventListener('click', () => {
                    ring.style.setProperty(
                        '--profile-ring-sweep-start',
                        profileRingSweepStartFromPointer(ring, profileRingMx, profileRingMy)
                    );
                    ring.classList.remove('profile-ring--sweep');
                    void ring.offsetWidth;
                    ring.classList.add('profile-ring--sweep');
                });

                ring.addEventListener('animationend', (e) => {
                    if (e.animationName !== 'profile-ring-sweep') return;
                    ring.classList.remove('profile-ring--sweep');
                    ring.style.removeProperty('--profile-ring-sweep-start');
                    if (canHoverProfileRing.matches) {
                        ring.classList.add('profile-ring--rim-holdoff');
                    }
                });

                ring.addEventListener('mouseleave', () => {
                    ring.classList.remove('profile-ring--rim-holdoff');
                });
            });
        });

        // 3. Barra de Progreso Vertical
        window.addEventListener('scroll', () => {
            const progressBar = document.getElementById('scroll-progress-bar');
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            progressBar.style.height = (winScroll / height) * 100 + "%";
        });
    </script>

    <!-- Espacio para inyectar scripts específicos de cada vista -->
    @stack('scripts')
</body>
</html>
