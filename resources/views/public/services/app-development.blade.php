@extends('layouts.public')

@section('title', 'Desarrollo de Apps | Carlos Codex')
@section('meta_description', 'Desarrollo de aplicaciones móviles y soluciones multiplataforma con foco en experiencia de usuario, rendimiento y escalabilidad.')

@section('content')
<section class="relative mx-3 pt-32 pb-24 md:mx-6 lg:mx-10 lg:pt-36">
    <div class="max-w-screen-xl mx-auto px-4">
        <div class="rounded-3xl border border-gray-200 dark:border-gray-800 bg-white/90 dark:bg-gray-900/85 p-8 md:p-12 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600 dark:text-indigo-400">Servicio</p>
            <h1 class="mt-3 text-3xl md:text-5xl font-extrabold text-gray-900 dark:text-white leading-tight">
                Desarrollo de apps que mejoran la experiencia de tus usuarios
            </h1>
            <p class="mt-5 text-lg text-gray-600 dark:text-gray-300 max-w-3xl">
                Construyo apps Android y multiplataforma orientadas a negocio: estables, conectadas a tus sistemas y preparadas para crecer sin fricción técnica.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('home', ['service' => 'app-development']) }}#contact" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition-colors">
                    Solicitar propuesta app
                </a>
                <a href="{{ route('public.projects') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-gray-300 dark:border-gray-700 text-gray-800 dark:text-gray-200 font-semibold hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    Ver casos de uso
                </a>
            </div>
        </div>
    </div>
</section>

<section class="mx-3 md:mx-6 lg:mx-10 mb-8">
    <div class="max-w-screen-xl mx-auto px-4 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <article class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-7">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Qué suele bloquear a mis clientes</h2>
            <ul class="mt-4 space-y-3 text-gray-600 dark:text-gray-300">
                <li>- Apps lentas o inestables que dañan la percepción de marca.</li>
                <li>- Falta de integración con backend, pagos o herramientas internas.</li>
                <li>- Dificultad para definir un MVP y lanzar en tiempos razonables.</li>
                <li>- Mantenimiento costoso por decisiones técnicas iniciales incorrectas.</li>
            </ul>
        </article>
        <article class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-7">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Qué entrego</h2>
            <ul class="mt-4 space-y-3 text-gray-600 dark:text-gray-300">
                <li>- Definición funcional: pantallas, flujos y prioridades de producto.</li>
                <li>- Desarrollo móvil y conexión segura con APIs y bases de datos.</li>
                <li>- Calidad y pruebas para minimizar errores en producción.</li>
                <li>- Acompañamiento para iteraciones y mejoras según feedback real.</li>
            </ul>
        </article>
    </div>
</section>

<section class="mx-3 md:mx-6 lg:mx-10 mb-8">
    <div class="max-w-screen-xl mx-auto px-4 rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-7 md:p-10">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Cómo trabajamos</h2>
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                <p class="text-indigo-600 dark:text-indigo-400 font-semibold">01 · Descubrimiento</p>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Convertimos tu idea en funcionalidades concretas y medibles.</p>
            </div>
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                <p class="text-indigo-600 dark:text-indigo-400 font-semibold">02 · MVP</p>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Construimos una primera versión sólida para validar con usuarios.</p>
            </div>
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                <p class="text-indigo-600 dark:text-indigo-400 font-semibold">03 · Iteraciones</p>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Priorizamos mejoras por impacto y estabilidad en cada entrega.</p>
            </div>
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                <p class="text-indigo-600 dark:text-indigo-400 font-semibold">04 · Escalado</p>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Preparamos la app para crecer con nuevas funcionalidades e integraciones.</p>
            </div>
        </div>
    </div>
</section>

<section class="mx-3 md:mx-6 lg:mx-10 mb-24">
    <div class="max-w-screen-xl mx-auto px-4 grid grid-cols-1 lg:grid-cols-3 gap-6">
        <article class="lg:col-span-2 rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-7">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Preguntas frecuentes</h2>
            <div class="cc-faq-group mt-6" data-faq-group>
                <x-faq-item question="¿Trabajas solo Android?">
                    Puedo trabajar Android nativo y también propuestas multiplataforma según objetivos, presupuesto y plazos.
                </x-faq-item>
                <x-faq-item question="¿Puedes mejorar una app existente?">
                    Si. Audito el estado actual y planteo un plan progresivo para mejorar rendimiento, UX y arquitectura.
                </x-faq-item>
                <x-faq-item question="¿También haces backend para la app?">
                    Si necesitas APIs, panel admin o integraciones, puedo cubrir la solución completa de extremo a extremo.
                </x-faq-item>
            </div>
        </article>
        <aside class="rounded-2xl border border-indigo-200/70 dark:border-indigo-800 bg-indigo-50/70 dark:bg-indigo-900/20 p-7">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Lanzar con claridad</h2>
            <p class="mt-3 text-gray-700 dark:text-gray-300">Te ayudo a bajar tu idea a una app viable y una hoja de ruta realista.</p>
            <a href="{{ route('home', ['service' => 'app-development']) }}#contact" class="mt-6 inline-flex items-center justify-center w-full px-5 py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition-colors">
                Hablar sobre mi app
            </a>
        </aside>
    </div>
</section>
@endsection
