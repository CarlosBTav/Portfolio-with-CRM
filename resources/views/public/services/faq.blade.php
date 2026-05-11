@extends('layouts.public')

@section('title', 'Preguntas frecuentes | Servicios | Carlos Codex')
@section('meta_description', 'Respuestas sobre desarrollo web, tiendas online y apps móviles: plazos, precios, mantenimiento y publicación en tiendas.')

@section('content')
<section class="relative mx-3 pb-24 pt-32 md:mx-6 lg:mx-10 lg:pt-36">
    <div class="mx-auto max-w-screen-xl px-4">
        <nav class="text-sm text-gray-600 dark:text-gray-400" aria-label="Migas de pan">
            <a href="{{ route('public.services') }}" class="font-medium text-indigo-600 transition hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">Servicios</a>
            <span class="mx-2 text-gray-400" aria-hidden="true">/</span>
            <span class="text-gray-900 dark:text-gray-200">Preguntas frecuentes</span>
        </nav>

        <header class="mt-8 rounded-3xl border border-gray-200 bg-white/90 p-8 shadow-sm dark:border-gray-800 dark:bg-gray-900/85 md:p-12">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600 dark:text-indigo-400">Ayuda</p>
            <h1 class="mt-3 text-3xl font-extrabold leading-tight text-gray-900 dark:text-white md:text-4xl">
                Preguntas frecuentes
            </h1>
            <p class="mt-4 max-w-3xl text-lg text-gray-600 dark:text-gray-300">
                Aquí están las dudas más habituales, separadas por si tu proyecto es una solución web o una app para móvil.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="#web" class="inline-flex items-center gap-2 rounded-xl border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-800 transition hover:bg-gray-100 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-800">
                    Web
                </a>
                <a href="#phone-app" class="inline-flex items-center gap-2 rounded-xl border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-800 transition hover:bg-gray-100 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-800">
                    Phone App
                </a>
                <a href="{{ route('public.services') }}#servicios-contacto" class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">
                    Contactar desde servicios
                </a>
            </div>
        </header>

        <div class="mt-10 space-y-12">
            <article id="web" class="scroll-mt-32 rounded-2xl border border-gray-200 bg-white p-7 dark:border-gray-800 dark:bg-gray-900 md:p-8 lg:scroll-mt-36">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Web</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Sitios, tiendas online y herramientas en el navegador.</p>
                <div class="cc-faq-group mt-8" data-faq-group>
                    <x-faq-item question="¿Trabajas con webs nuevas o rediseños?">
                        Ambas opciones. Primero evalúo si conviene optimizar lo existente o reconstruir para ganar rendimiento y escalabilidad.
                    </x-faq-item>
                    <x-faq-item question="¿Incluyes mantenimiento en proyectos web?">
                        Sí, puedo incluir soporte evolutivo para mejoras, contenidos y nuevas integraciones.
                    </x-faq-item>
                    <x-faq-item question="¿Cómo se define el precio de una web o tienda?">
                        Según alcance, diseño, integraciones y catálogo. Te doy una propuesta clara con fases y entregables.
                    </x-faq-item>
                    <x-faq-item question="¿Cuánto suele tardar un proyecto web?">
                        Una landing o web pequeña puede ser cuestión de semanas; e-commerce y plataformas a medida suelen llevar más. Los hitos y fechas quedan reflejados en la propuesta.
                    </x-faq-item>
                    <x-faq-item question="¿Qué necesito aportar para arrancar?">
                        Contenidos o briefing de textos, branding si lo hay y acceso a dominio/hosting cuando toque integrar o desplegar. Si falta algo, te indico opciones.
                    </x-faq-item>
                </div>
            </article>

            <article id="phone-app" class="scroll-mt-32 rounded-2xl border border-gray-200 bg-white p-7 dark:border-gray-800 dark:bg-gray-900 md:p-8 lg:scroll-mt-36">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Phone App</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Apps para iOS, Android y productos relacionados.</p>
                <div class="cc-faq-group mt-8" data-faq-group>
                    <x-faq-item question="¿Trabajas solo Android?">
                        Puedo trabajar Android nativo y también propuestas multiplataforma según objetivos, presupuesto y plazos.
                    </x-faq-item>
                    <x-faq-item question="¿Puedes mejorar una app existente?">
                        Sí. Audito el estado actual y planteo un plan progresivo para mejorar rendimiento, UX y arquitectura.
                    </x-faq-item>
                    <x-faq-item question="¿También haces backend para la app?">
                        Si necesitas APIs, panel de administración o integraciones, puedo cubrir la solución de extremo a extremo.
                    </x-faq-item>
                    <x-faq-item question="¿Qué implica publicar en App Store y Google Play?">
                        Cuentas de desarrollador, assets, políticas de las tiendas y revisiones. Te guío en el proceso y preparo builds listos para enviar.
                    </x-faq-item>
                    <x-faq-item question="¿Cuánto tarda un MVP móvil?">
                        Depende del alcance y de si hay backend nuevo. Priorizamos un núcleo usable y bien probado antes de escalar funcionalidades.
                    </x-faq-item>
                </div>
            </article>
        </div>

        <p class="mt-10 text-center text-sm text-gray-600 dark:text-gray-400">
            <a href="{{ route('public.services') }}" class="font-semibold text-indigo-600 transition hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">← Volver a Servicios</a>
        </p>
    </div>
</section>
@endsection
