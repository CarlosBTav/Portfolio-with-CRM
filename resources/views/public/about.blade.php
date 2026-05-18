@extends('layouts.public')

@section('title', 'Sobre Mí')

@section('body-class', 'antialiased font-sans flex flex-col min-h-dynamic transition-colors duration-300 text-gray-900 dark:text-gray-100 about-ai-dots-page')

@section('content')
<div class="relative w-full min-h-dynamic overflow-x-hidden bg-transparent dark:bg-transparent">
    {{-- section: el fondo cubre toda la altura del contenido (viewport fijo cortaba al hacer scroll) --}}
    <div class="pointer-events-none absolute inset-0 z-0 overflow-hidden" aria-hidden="true">
        <x-ai-dots-background variant="section" />
    </div>
    <!-- CONTENEDOR PRINCIPAL -->
    <div class="relative z-10 max-w-4xl mx-auto px-6 lg:px-8 pt-28 pb-12 lg:pt-32 lg:pb-20">

        <!-- 1. SECCIÓN INTRODUCCIÓN (NARRATIVA) -->
        <section class="mb-20">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white mb-8 tracking-tight">
                👨‍💻 Sobre <span class="text-indigo-600 dark:text-indigo-400">mí</span>
            </h1>
            
            <div class="prose prose-lg dark:prose-invert text-gray-600 dark:text-gray-300 leading-relaxed max-w-none">
                <p class="mb-6">
                    Llevo más de <span class="font-bold text-gray-900 dark:text-white">7 años escribiendo código</span> (y borrando también, prueba y error). Mi recorrido fue tal que así:
                </p>
                <p class="mb-6">
                    Empecé mi carrera como técnico en electrónica aeroespacial y diseño de PCBs. Aunque me encantaba el hardware, desde los 17 años mi pasión era programar videojuegos en mi tiempo libre.
                     Al final, el lado del software me pudo: Dejé mi trabajo, me licencié en <span class="font-semibold text-indigo-600 dark:text-indigo-400">Desarrollo de Aplicaciones Web (DAW)</span> y <span class="font-semibold text-indigo-600 dark:text-indigo-400">Multiplataforma (DAM)</span>, y cambié la electrónica por el código.
                </p>
                <p>
                    Al principio trabajé desarrollando sistemas de control remoto para iOS y actualmente me especializo en desarrollo <strong>Web Fullstack</strong> (Especialmente Servidores, ERPs y CRMs) y <strong>Aplicaciones Multiplataforma</strong> (Android Studio con Compose Multiplatform).
                </p>
            </div>
        </section>

        <hr class="border-gray-200 dark:border-gray-800 mb-20">

        <!-- 2. EL HUMANO DETRÁS DEL CÓDIGO (GRID DE TARJETAS) -->
        <section class="mb-20">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-10 flex items-center gap-3">
                <span>🎸</span> El Humano detrás del código
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Card Música -->
                <div class="js-spotlight-card group !bg-gray-50 dark:!bg-gray-800/50 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                    <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center text-2xl mb-4">🎹</div>
                    <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-2">Soy músico</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Toco el piano, la guitarra y el saxofón. Me lo paso bien componiendo y estudiando teoría musical cuando no estoy compilando.
                    </p>
                </div>

                <!-- Card Idiomas -->
                <div class="js-spotlight-card group !bg-gray-50 dark:!bg-gray-800/50 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center text-2xl mb-4">🌍</div>
                    <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-2">Intento de políglota</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Hablo <strong>Inglés</strong> avanzado y <strong>Coreano</strong> intermedio. Actualmente en plena batalla estudiando <strong>Chino</strong> (¡Pregúntame sobre los palacios mentales!).
                    </p>
                </div>

                <!-- Card Mecanografía -->
                <div class="js-spotlight-card group !bg-gray-50 dark:!bg-gray-800/50 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center text-2xl mb-4">⌨️</div>
                    <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-2">Mecanografía</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Top mundial español con un récord de <span class="text-indigo-600 dark:text-indigo-400 font-bold">147 palabras por minuto</span>. Sí, pico código bastante rápido jaja.
                    </p>
                </div>
            </div>
        </section>

        <!-- 3. EXPERIENCIA PROFESIONAL (TIMELINE VERTICAL) -->
        <section class="mb-20">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-10 flex items-center gap-3">
                <span>💼</span> Experiencia Profesional
            </h2>

            <div class="relative ml-3 md:ml-6 space-y-12">
                <div class="absolute left-0 top-3 bottom-6 w-1 -translate-x-1/2 bg-indigo-100 dark:bg-gray-800 transition-colors duration-300"></div>
                <div class="absolute left-0 bottom-0 h-6 w-1 -translate-x-1/2 bg-gradient-to-b from-indigo-100 to-transparent dark:from-gray-800 dark:to-transparent transition-colors duration-300"></div>
                
                <!-- Item 0 -->
                <div class="relative pl-8 md:pl-12">
                    <!-- Bolita del timeline -->
                    <div class="absolute -left-[10px] top-1 w-5 h-5 bg-indigo-600 dark:bg-indigo-500 rounded-full border-4 border-white dark:border-gray-900 transition-colors duration-300 shadow-[0_0_0_2px_rgba(79,70,229,0.28),0_0_0_6px_rgba(79,70,229,0.14),0_0_0_10px_rgba(79,70,229,0.06)] dark:shadow-[0_0_0_2px_rgba(129,140,248,0.24),0_0_0_6px_rgba(129,140,248,0.12),0_0_0_10px_rgba(129,140,248,0.05)]"></div>
                    
                    <span class="inline-block py-1 px-3 mb-2 rounded-full bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-300 text-xs font-bold uppercase tracking-wider">
                        2025 - Actualidad
                    </span>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Desarrollador de Apps Web y Móvil</h3>
                    <p class="text-indigo-600 dark:text-indigo-400 font-medium mb-2">Freelancer</p>
                    <p class="text-gray-600 dark:text-gray-400">Creación de apps web de gestión de empresa y portfolios (ERP, CRM, CMS) y desarrollo de apps móviles.</p>
                </div>

                <!-- Item 1 -->
                <div class="relative pl-8 md:pl-12">
                    <!-- Bolita del timeline -->
                    <div class="absolute -left-[10px] top-1 w-5 h-5 bg-gray-300 dark:bg-gray-600 rounded-full border-4 border-white dark:border-gray-900 transition-colors duration-300"></div>
                    
                    <span class="inline-block py-1 px-3 mb-2 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-xs font-bold uppercase tracking-wider">
                        2023 (prácticas) - 2024 (Contratación por Proyecto)
                    </span>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Programador Web Fullstack</h3>
                    <p class="text-indigo-600 dark:text-indigo-400 font-medium mb-2">Al Rescate Asistencia Informática</p>
                    <p class="text-gray-600 dark:text-gray-400">Desarrollo de aplicaciones web ERP y CRM fullstack. Desarrollo, despliegue y mantenimiento.</p>
                </div>

                <!-- Item 2 -->
                <div class="relative pl-8 md:pl-12">
                    <div class="absolute -left-[10px] top-1 w-5 h-5 bg-gray-300 dark:bg-gray-600 rounded-full border-4 border-white dark:border-gray-900 transition-colors duration-300"></div>
                    
                    <span class="inline-block py-1 px-3 mb-2 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-xs font-bold uppercase tracking-wider">
                        2022
                    </span>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Técnico Informático en Ecosistema IOS</h3>
                    <p class="text-indigo-600 dark:text-indigo-400 font-medium mb-2">Goldenmac EDU (Grupo K-tuin)</p>
                    <p class="text-gray-600 dark:text-gray-400">Gestión remota de dispositivos Apple para uso académico y servicio técnico.</p>
                </div>

                <!-- Item 3 -->
                <div class="relative pl-8 md:pl-12">
                    <div class="absolute -left-[10px] top-1 w-5 h-5 bg-gray-300 dark:bg-gray-600 rounded-full border-4 border-white dark:border-gray-900 transition-colors duration-300"></div>
                    
                    <span class="inline-block py-1 px-3 mb-2 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-xs font-bold uppercase tracking-wider">
                        2021 - 2022
                    </span>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Técnico Electrónico</h3>
                    <p class="text-indigo-600 dark:text-indigo-400 font-medium mb-2">NEED TECH</p>
                    <p class="text-gray-600 dark:text-gray-400">Análisis, diseño de circuitos, montaje automático SMD, soldadura por ola y testeo de PCBs. Resolución de problemas a nivel de componente.</p>
                </div>

                <div class="relative pl-8 md:pl-12">
                    <div class="absolute -left-[10px] top-1 w-5 h-5 bg-gray-300 dark:bg-gray-600 rounded-full border-4 border-white dark:border-gray-900 transition-colors duration-300"></div>
                    
                    <span class="inline-block py-1 px-3 mb-2 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-xs font-bold uppercase tracking-wider">
                        2019 - 2020
                    </span>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Técnico Informático en Ecosistema IOS</h3>
                    <p class="text-indigo-600 dark:text-indigo-400 font-medium mb-2">Goldenmac EDU (Grupo K-tuin)</p>
                    <p class="text-gray-600 dark:text-gray-400">Gestión remota de dispositivos Apple para uso académico y servicio técnico.</p>
                </div>

                <!-- Item 4 -->
                <div class="relative pl-8 md:pl-12">
                    <div class="absolute -left-[10px] top-1 w-5 h-5 bg-gray-300 dark:bg-gray-600 rounded-full border-4 border-white dark:border-gray-900 transition-colors duration-300"></div>
                    
                    <span class="inline-block py-1 px-3 mb-2 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-xs font-bold uppercase tracking-wider">
                        2018
                    </span>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Testing Electrónico</h3>
                    <p class="text-indigo-600 dark:text-indigo-400 font-medium mb-2">ALTER TECHNOLOGY TÜV NORD</p>
                    <p class="text-gray-600 dark:text-gray-400">Testeo riguroso y pruebas de estrés de componentes electrónicos para uso aeroespacial.</p>
                </div>
            </div>
        </section>

        <!-- 4. EDUCACIÓN (GRID SIMPLE) -->
        <section>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-10 flex items-center gap-3">
                <span>🎓</span> Educación
            </h2>
            
            <div class="grid gap-6 md:grid-cols-2">
                <!-- Grado Superior DAW -->
                <div class="js-spotlight-card group !bg-gray-50 dark:!bg-gray-800/50 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 flex items-start gap-4 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                    <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center text-2xl shrink-0">🖥️</div>
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-white">Desarrollo de Aplicaciones Web (DAW)</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Sep 2025 - Ene 2026</p>
                    </div>
                </div>

                <!-- Grado Superior DAM -->
                <div class="js-spotlight-card group !bg-gray-50 dark:!bg-gray-800/50 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 flex items-start gap-4 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center text-2xl shrink-0">📱</div>
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-white">Desarrollo de Aplicaciones Multiplataforma (DAM)</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Ago 2021 - Jun 2023</p>
                    </div>
                </div>

                <!-- Mantenimiento -->
                <div class="js-spotlight-card group !bg-gray-50 dark:!bg-gray-800/50 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 flex items-start gap-4 md:col-span-2 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center text-2xl shrink-0">⚡</div>
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-white">Mantenimiento Electrónico</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Formación técnica previa</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA FINAL -->
        <div class="mt-20 text-center">
            <a href="{{ route('public.contact') }}" class="inline-flex items-center justify-center px-8 py-4 text-base font-bold text-white transition-all duration-200 bg-indigo-600 rounded-lg hover:bg-indigo-700 hover:shadow-lg hover:-translate-y-1">
                ¿Hablamos?
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>

    </div>
</div>
@endsection