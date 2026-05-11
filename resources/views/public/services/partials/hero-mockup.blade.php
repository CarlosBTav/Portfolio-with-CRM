@once
<style>
    @keyframes services-desktop-idle-float {
        0%, 100% { transform: translate3d(0px, 0px, 0) rotate(-0.12deg); }
        33% { transform: translate3d(0.8px, -1.4px, 0) rotate(0deg); }
        66% { transform: translate3d(-0.9px, -2px, 0) rotate(0.14deg); }
    }

    @keyframes services-phone-idle-float {
        0%, 100% { transform: translate3d(0px, 0px, 0) rotate(0.16deg); }
        40% { transform: translate3d(0.9px, -2px, 0) rotate(0.28deg); }
        75% { transform: translate3d(-0.8px, -1.1px, 0) rotate(0.05deg); }
    }

    .services-mockup-desktop-idle {
        animation: services-desktop-idle-float 6.8s ease-in-out infinite;
    }

    .services-mockup-phone-idle {
        animation: services-phone-idle-float 5.9s ease-in-out infinite 0.45s;
    }

    .services-mockup-desktop-shell,
    .services-mockup-phone {
        --mockup-fx-x: 50%;
        --mockup-fx-y: 50%;
        --mockup-float-x: 0px;
        --mockup-float-y: 0px;
        --mockup-rot: 0deg;
        --mockup-depth: 0;
        --mockup-shine-opacity: 0;
        transform: translate3d(var(--mockup-float-x), var(--mockup-float-y), 0) rotate(var(--mockup-rot));
        will-change: transform;
    }

    .services-mockup-desktop-content,
    .services-mockup-phone-content {
        transform: translateY(calc(var(--mockup-depth) * 1.2px));
        will-change: transform;
    }

    .services-mockup-cursor-shine {
        pointer-events: none;
        opacity: var(--mockup-shine-opacity);
        will-change: opacity;
        background-repeat: no-repeat;
    }

    html.dark .services-mockup-cursor-shine {
        background-image:
            radial-gradient(
                130px circle at var(--mockup-fx-x) var(--mockup-fx-y),
                rgba(244, 247, 255, 0.16) 0%,
                rgba(191, 204, 254, 0.12) 26%,
                rgba(129, 140, 248, 0.06) 44%,
                transparent 72%
            ),
            linear-gradient(
                118deg,
                transparent 35%,
                rgba(255, 255, 255, 0.06) 49%,
                rgba(199, 210, 254, 0.03) 56%,
                transparent 65%
            );
    }

    html.dark .services-mockup-phone .services-mockup-cursor-shine {
        background-image:
            radial-gradient(
                96px circle at var(--mockup-fx-x) var(--mockup-fx-y),
                rgba(244, 247, 255, 0.18) 0%,
                rgba(191, 204, 254, 0.11) 30%,
                rgba(129, 140, 248, 0.05) 47%,
                transparent 74%
            ),
            linear-gradient(
                118deg,
                transparent 33%,
                rgba(255, 255, 255, 0.05) 48%,
                rgba(199, 210, 254, 0.02) 56%,
                transparent 65%
            );
    }

    /* Traffic lights (desktop): barra + dots al hover de todo el mockup escritorio, encendido L→R */
    .services-mockup-window-controls {
        cursor: default;
        transition:
            transform 520ms cubic-bezier(0.18, 0.8, 0.2, 1),
            background-color 500ms ease-out,
            border-color 500ms ease-out,
            box-shadow 500ms ease-out;
    }

    html:not(.dark) .services-mockup-window-controls {
        background-color: #eef2ff;
        border-bottom-color: #cbd5e1;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.92);
    }

    html.dark .services-mockup-window-controls {
        background-color: #050a1f;
        border-bottom-color: #2d2b6f;
        box-shadow: inset 0 1px 0 rgba(0, 0, 0, 0.45);
    }

    html:not(.dark) .services-mockup-desktop-shell:hover .services-mockup-window-controls {
        transform: translateY(-2px);
        background-color: #e0e7ff;
        border-bottom-color: rgba(99, 102, 241, 0.28);
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, 0.95),
            0 0 0 1px rgba(99, 102, 241, 0.1);
    }

    html.dark .services-mockup-desktop-shell:hover .services-mockup-window-controls {
        transform: translateY(-2px);
        background-color: #060d28;
        border-bottom-color: rgba(99, 102, 241, 0.42);
        box-shadow:
            inset 0 1px 0 rgba(0, 0, 0, 0.35),
            0 0 0 1px rgba(99, 102, 241, 0.12);
    }

    html:not(.dark) .services-mockup-desktop-shell {
        background: linear-gradient(180deg, #dbeafe 0%, #c7d2fe 100%);
        box-shadow:
            0 24px 60px rgba(79, 70, 229, 0.14),
            inset 0 0 0 1px rgba(99, 102, 241, 0.16);
    }

    html:not(.dark) .services-mockup-desktop-shell:hover {
        box-shadow:
            0 28px 70px rgba(79, 70, 229, 0.2),
            inset 0 0 0 1px rgba(99, 102, 241, 0.22);
    }

    html.dark .services-mockup-desktop-shell {
        background: #717397;
        box-shadow:
            0 24px 60px rgba(56, 50, 165, 0.35),
            inset 0 0 0 1px rgba(165, 180, 252, 0.18);
    }

    html.dark .services-mockup-desktop-shell:hover {
        box-shadow:
            0 28px 70px rgba(79, 70, 229, 0.42),
            inset 0 0 0 1px rgba(199, 210, 254, 0.28);
    }

    html:not(.dark) .services-mockup-desktop-inner {
        background-color: #f8fafc;
        --tw-ring-color: rgba(148, 163, 184, 0.28);
    }

    html.dark .services-mockup-desktop-inner {
        background-color: #070b22;
        --tw-ring-color: rgba(255, 255, 255, 0.06);
    }

    html:not(.dark) .services-mockup-phone-frame {
        border-color: #cbd5e1;
        background-color: #f8fafc;
        box-shadow: 0 0 0 1px #c7d2fe;
        --tw-ring-color: rgba(148, 163, 184, 0.22);
    }

    html.dark .services-mockup-phone-frame {
        border-color: #050a1f;
        background-color: #070b22;
        box-shadow: 0 0 0 1px #717397;
        --tw-ring-color: rgba(255, 255, 255, 0.05);
    }

    html:not(.dark) .services-mockup-phone-notch {
        background-color: #cbd5e1;
        box-shadow: 0 1px 0 #cbd5e1, 0 -1px 0 #cbd5e1;
        transform: translateY(-1px);
    }

    html.dark .services-mockup-phone-notch {
        background-color: #050a1f;
        box-shadow: 0 1px 0 rgba(148, 163, 184, 0.12);
        transform: translateY(-2px);
    }

    html:not(.dark) .services-mockup-desktop-overlay {
        background: linear-gradient(
            to bottom right,
            rgba(99, 102, 241, 0.08) 0%,
            rgba(129, 140, 248, 0.06) 34%,
            rgba(226, 232, 240, 0.42) 70%,
            rgba(248, 250, 252, 0.92) 100%
        );
    }

    html.dark .services-mockup-desktop-overlay {
        background: linear-gradient(
            to bottom right,
            rgba(99, 102, 241, 0.30) 0%,
            rgba(67, 56, 202, 0.30) 34%,
            rgba(15, 23, 90, 0.72) 70%,
            rgba(3, 6, 23, 0.98) 100%
        );
    }

    html:not(.dark) .services-mockup-phone-overlay {
        background: linear-gradient(
            to bottom right,
            rgba(129, 140, 248, 0.12) 0%,
            rgba(99, 102, 241, 0.08) 36%,
            rgba(226, 232, 240, 0.34) 72%,
            rgba(248, 250, 252, 0.88) 100%
        );
    }

    html.dark .services-mockup-phone-overlay {
        background: linear-gradient(
            to bottom right,
            rgba(129, 140, 248, 0.34) 0%,
            rgba(79, 70, 229, 0.22) 36%,
            rgba(18, 29, 108, 0.58) 72%,
            rgba(7, 11, 34, 0.92) 100%
        );
    }

    html:not(.dark) .services-mockup-cursor-shine {
        background-image:
            radial-gradient(
                130px circle at var(--mockup-fx-x) var(--mockup-fx-y),
                rgba(255, 255, 255, 0.72) 0%,
                rgba(199, 210, 254, 0.34) 26%,
                rgba(129, 140, 248, 0.12) 44%,
                transparent 72%
            ),
            linear-gradient(
                118deg,
                transparent 35%,
                rgba(255, 255, 255, 0.42) 49%,
                rgba(224, 231, 255, 0.24) 56%,
                transparent 65%
            );
    }

    html:not(.dark) .services-mockup-phone .services-mockup-cursor-shine {
        background-image:
            radial-gradient(
                96px circle at var(--mockup-fx-x) var(--mockup-fx-y),
                rgba(255, 255, 255, 0.78) 0%,
                rgba(199, 210, 254, 0.32) 30%,
                rgba(129, 140, 248, 0.1) 47%,
                transparent 74%
            ),
            linear-gradient(
                118deg,
                transparent 33%,
                rgba(255, 255, 255, 0.34) 48%,
                rgba(224, 231, 255, 0.18) 56%,
                transparent 65%
            );
    }

    .services-mockup-traffic-dot {
        display: block;
        transition-property: transform, box-shadow, background-color;
        transition-duration: 0.26s;
        transition-timing-function: ease-out;
        transition-delay: 0ms;
    }

    .services-mockup-desktop-shell:hover .services-mockup-traffic-dot:nth-child(1) {
        background-color: rgb(239, 68, 68);
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.22);
        transform: translateY(2px) scale(1.1);
        transition-delay: 0ms;
    }

    .services-mockup-desktop-shell:hover .services-mockup-traffic-dot:nth-child(2) {
        background-color: rgb(250, 204, 21);
        box-shadow: 0 0 0 4px rgba(250, 204, 21, 0.2);
        transform: translateY(-0.5px) scale(1.06);
        transition-delay: 115ms;
    }

    .services-mockup-desktop-shell:hover .services-mockup-traffic-dot:nth-child(3) {
        background-color: rgb(16, 185, 129);
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2);
        transform: translateY(2px) scale(1.1);
        transition-delay: 230ms;
    }

    @media (prefers-reduced-motion: reduce) {
        .services-mockup-desktop-idle,
        .services-mockup-phone-idle {
            animation: none;
        }
        .services-mockup-desktop-shell,
        .services-mockup-phone,
        .services-mockup-desktop-content,
        .services-mockup-phone-content,
        .services-mockup-cursor-shine,
        .services-mockup-hover-inner,
        .services-mockup-hover-block {
            transition: none !important;
        }
        .services-mockup-desktop-shell:hover .services-mockup-hover-inner,
        .services-mockup-desktop-shell:hover .services-mockup-hover-block,
        .services-mockup-phone:hover .services-mockup-hover-inner,
        .services-mockup-phone:hover .services-mockup-hover-block {
            transform: none !important;
        }

        .services-mockup-desktop-shell:hover .services-mockup-window-controls {
            transform: none !important;
        }

        .services-mockup-desktop-shell:hover .services-mockup-traffic-dot:nth-child(n) {
            transition-delay: 0ms !important;
            transform: none !important;
        }
    }
</style>
@endonce

<div class="services-mockup relative z-0 hidden xl:block">
                        <div class="relative isolate mx-auto w-[460px] h-[290px]">
                            {{-- Glows de fondo --}}
                            <div class="pointer-events-none absolute left-16 top-10 z-0 h-40 w-56 rounded-full bg-indigo-400/20 blur-3xl dark:bg-indigo-500/35"></div>
                            <div class="pointer-events-none absolute right-6 top-20 z-0 h-44 w-36 rounded-full bg-violet-400/15 blur-3xl dark:bg-violet-500/30"></div>
                            
                            {{-- Mock ventana escritorio (degradado aplicado sobre toda la pieza, incluido el borde) --}}
                            <div class="services-mockup-desktop-idle absolute left-0 top-5 z-10">
                            <div class="group services-mockup-desktop-shell js-services-mockup-fx relative w-[370px] overflow-hidden rounded-[22px] p-px transition-[box-shadow,border-color] duration-500 ease-out" data-mockup-device="desktop">
                                <div class="services-mockup-desktop-inner services-mockup-hover-inner relative flex min-h-0 flex-col overflow-hidden rounded-[21px] ring-1 ring-inset ring-slate-200/70 transition-transform duration-500 ease-out will-change-transform group-hover:-translate-y-1.5 group-hover:-rotate-[0.35deg] dark:ring-white/[0.06]">
                                    {{-- Barra superior: encima ya no hay overlay violeta (antes era hermano con inset-0 y aclaraba el #050a1f) --}}
                                    <div class="services-mockup-window-controls relative z-10 flex h-8 shrink-0 items-center gap-2 rounded-t-[20px] border-b px-4">
                                        <span class="services-mockup-traffic-dot h-2.5 w-2.5 shrink-0 rounded-full bg-slate-400/80 dark:bg-slate-300/90" aria-hidden="true"></span>
                                        <span class="services-mockup-traffic-dot h-2.5 w-2.5 shrink-0 rounded-full bg-slate-400/80 dark:bg-slate-300/90" aria-hidden="true"></span>
                                        <span class="services-mockup-traffic-dot h-2.5 w-2.5 shrink-0 rounded-full bg-slate-400/80 dark:bg-slate-300/90" aria-hidden="true"></span>
                                    </div>
                                    <div class="relative min-h-0 flex-1 overflow-hidden rounded-b-[20px]">
                                        <div class="services-mockup-desktop-content relative z-10 p-4 space-y-3 transition-transform duration-500 ease-out group-hover:-translate-y-0.5">
                                            <div class="grid grid-cols-[1.1fr_1fr] gap-3 transition-transform duration-500 ease-out group-hover:translate-x-0.5">
                                                <div class="services-mockup-hover-block relative h-20 overflow-hidden rounded-xl bg-indigo-100 transition-all duration-500 ease-out group-hover:translate-x-1.5 group-hover:bg-indigo-200 dark:bg-indigo-800 dark:group-hover:bg-indigo-700">
                                                    <div class="pointer-events-none absolute left-1/2 top-1/2 z-[1] h-10 w-10 -translate-x-1/2 -translate-y-1/2 rounded-full bg-indigo-300 transition-all duration-500 ease-out group-hover:scale-110 group-hover:bg-indigo-400 dark:bg-indigo-400 dark:group-hover:bg-violet-300"></div>
                                                </div>
                                                <div class="space-y-3 pt-1 transition-transform duration-500 ease-out group-hover:-translate-y-0.5">
                                                    <div class="services-mockup-hover-block h-3 rounded-full bg-indigo-200 transition-all duration-500 ease-out group-hover:h-[13px] group-hover:w-[92%] group-hover:translate-x-2 group-hover:bg-indigo-300 dark:bg-indigo-700 dark:group-hover:bg-indigo-500/80"></div>
                                                    <div class="services-mockup-hover-block h-3 rounded-full bg-indigo-100 transition-all duration-500 ease-out group-hover:w-[88%] group-hover:translate-x-1 group-hover:bg-slate-300 dark:bg-indigo-800 dark:group-hover:bg-slate-600"></div>
                                                    <div class="services-mockup-hover-block h-3 w-3/4 rounded-full bg-slate-200 transition-all duration-500 ease-out group-hover:w-[82%] group-hover:-translate-y-0.5 group-hover:bg-slate-300 dark:bg-slate-800 dark:group-hover:bg-slate-600"></div>
                                                </div>
                                            </div>
                                            <div class="services-mockup-hover-block h-3 w-[88%] rounded-full bg-slate-200 transition-all duration-500 ease-out group-hover:w-[93%] group-hover:translate-x-1 group-hover:bg-indigo-200 dark:bg-slate-800 dark:group-hover:bg-indigo-900/85"></div>
                                            <div class="services-mockup-hover-block h-3 w-[72%] rounded-full bg-slate-200 transition-all duration-500 ease-out group-hover:w-[66%] group-hover:bg-indigo-200/80 dark:bg-slate-800 dark:group-hover:bg-indigo-500/35"></div>
                                            <div class="grid grid-cols-[104px_64px_1fr] gap-3 pt-1 transition-transform duration-500 ease-out group-hover:translate-x-0.5">
                                                <div class="services-mockup-hover-block h-7 rounded-lg bg-indigo-200 transition-all duration-500 ease-out group-hover:-translate-y-0.5 group-hover:bg-indigo-300 dark:bg-indigo-700 dark:group-hover:bg-indigo-500/70"></div>
                                                <div class="services-mockup-hover-block h-7 rounded-lg bg-slate-200 transition-all duration-500 ease-out group-hover:translate-y-0.5 group-hover:bg-slate-300 dark:bg-slate-800 dark:group-hover:bg-slate-600"></div>
                                                <div class="services-mockup-hover-block h-7 rounded-lg bg-slate-200 transition-all duration-500 ease-out group-hover:h-6 group-hover:translate-x-1.5 group-hover:bg-indigo-200/80 dark:bg-slate-800 dark:group-hover:bg-indigo-600/40"></div>
                                            </div>
                                        </div>
                                        <div class="services-mockup-desktop-overlay pointer-events-none absolute inset-0 z-20 rounded-b-[20px] transition-opacity duration-500 ease-out group-hover:opacity-90"></div>
                                        <div class="services-mockup-cursor-shine pointer-events-none absolute inset-0 z-30 rounded-b-[20px]"></div>
                                    </div>
                                </div>
                            </div>
                            </div>

                            {{-- Mock teléfono (aro claro pegado al bisel oscuro mediante box-shadow) --}}
                            <div class="services-mockup-phone-idle absolute right-0 z-20 h-[250px] w-[132px]" style="top: 76px;">
                                <div class="group services-mockup-phone js-services-mockup-fx relative isolate h-full w-full" data-mockup-device="phone">
                                    <div class="pointer-events-none absolute inset-2 -z-10 rounded-[30px] bg-indigo-400/15 blur-xl transition-transform duration-500 group-hover:scale-105 dark:bg-indigo-500/20"></div>
                                    {{-- Notch dentro del mismo elemento que usa transform en hover, para que no parezca desplazarse respecto al marco --}}
                                    <div class="services-mockup-phone-frame services-mockup-hover-inner relative block h-full overflow-hidden rounded-[30px] border-[5px] px-3 pb-3 pt-10 dark:ring-1 dark:ring-inset transition-transform duration-500 ease-out will-change-transform group-hover:-translate-y-1.5 group-hover:-rotate-[0.9deg]">
                                        <div class="services-mockup-phone-content relative z-10 space-y-2.5 transition-transform duration-500 ease-out group-hover:translate-y-0.5">
                                            <div class="services-mockup-hover-block rounded-lg bg-indigo-100 p-2.5 transition-all duration-500 ease-out group-hover:translate-x-1 group-hover:bg-gradient-to-br group-hover:from-indigo-200 group-hover:to-indigo-100 dark:bg-indigo-800 dark:group-hover:from-indigo-600/90 dark:group-hover:to-indigo-950/80">
                                                <div class="grid grid-cols-[24px_1fr] gap-2 transition-transform duration-500 ease-out group-hover:translate-x-0.5">
                                                    <div class="services-mockup-hover-block h-6 w-6 rounded-full bg-indigo-300 transition-all duration-500 ease-out group-hover:-translate-y-0.5 group-hover:bg-indigo-400 dark:bg-indigo-400 dark:group-hover:bg-violet-300"></div>
                                                    <div class="space-y-1.5 pt-0.5 transition-transform duration-500 ease-out group-hover:translate-y-0.5">
                                                        <div class="services-mockup-hover-block h-2 rounded-full bg-indigo-200 transition-all duration-500 ease-out group-hover:w-[92%] group-hover:translate-x-1.5 group-hover:bg-indigo-300 dark:bg-indigo-700 dark:group-hover:bg-indigo-500/85"></div>
                                                        <div class="services-mockup-hover-block h-2 w-2/3 rounded-full bg-slate-300 transition-all duration-500 ease-out group-hover:w-3/4 group-hover:bg-slate-400 dark:bg-slate-700 dark:group-hover:bg-slate-500"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="services-mockup-hover-block h-2.5 w-4/5 rounded-full bg-slate-200 transition-all duration-500 ease-out group-hover:w-[88%] group-hover:bg-slate-300 dark:bg-slate-800 dark:group-hover:bg-slate-600"></div>
                                            <div class="services-mockup-hover-block h-2.5 rounded-full bg-slate-200 transition-all duration-500 ease-out group-hover:h-2 group-hover:translate-x-2 group-hover:bg-indigo-200/80 dark:bg-slate-800 dark:group-hover:bg-indigo-500/30"></div>
                                            <div class="services-mockup-hover-block h-2.5 w-5/6 rounded-full bg-slate-200 transition-all duration-500 ease-out group-hover:w-[78%] group-hover:bg-indigo-200/70 dark:bg-slate-800 dark:group-hover:bg-indigo-400/25"></div>
                                            <div class="services-mockup-hover-block h-7 w-4/5 rounded-lg bg-indigo-200 transition-all duration-500 ease-out group-hover:h-6 group-hover:w-[86%] group-hover:-translate-y-0.5 group-hover:bg-indigo-300 dark:bg-indigo-700 dark:group-hover:bg-indigo-500/65"></div>
                                        </div>
                                        <div class="services-mockup-phone-overlay pointer-events-none absolute inset-0 z-20 rounded-[24px] transition-opacity duration-500 ease-out group-hover:opacity-85"></div>
                                        <div class="services-mockup-cursor-shine pointer-events-none absolute inset-0 z-30 rounded-[24px]"></div>
                                        {{-- Notch: después de overlay/brillo y z alto; items-start para no estirar el pill (antes quedaba tapado/anulado por capas inferiores) --}}
                                        <div class="pointer-events-none absolute left-1/2 -top-px z-[60] -translate-x-1/2" aria-hidden="true">
                                            <div class="services-mockup-phone-notch h-[18px] w-16 shrink-0 rounded-b-[14px]"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

@once
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const surfaceNodes = Array.from(document.querySelectorAll('.js-services-mockup-fx'));
        if (!surfaceNodes.length) return;

        const mouse = {
            x: window.innerWidth * 0.5,
            y: window.innerHeight * 0.5,
            active: false,
        };

        const clamp = (value, min, max) => Math.min(max, Math.max(min, value));
        const lerp = (from, to, amount) => from + (to - from) * amount;

        const surfaces = surfaceNodes.map((node) => {
            const device = node.dataset.mockupDevice || 'desktop';
            const cfg = device === 'phone'
                ? { maxShiftX: 2.8, maxShiftY: 4.4, maxRotate: 1.2, sigma: 150 }
                : { maxShiftX: 4.2, maxShiftY: 3.2, maxRotate: 0.9, sigma: 205 };

            return {
                node,
                cfg,
                current: { fxX: 0, fxY: 0, floatX: 0, floatY: 0, rot: 0, depth: 0, shine: 0.04 },
                target: { fxX: 0, fxY: 0, floatX: 0, floatY: 0, rot: 0, depth: 0, shine: 0.04 },
            };
        });

        const setState = (surface) => {
            surface.node.style.setProperty('--mockup-fx-x', `${surface.current.fxX.toFixed(2)}px`);
            surface.node.style.setProperty('--mockup-fx-y', `${surface.current.fxY.toFixed(2)}px`);
            surface.node.style.setProperty('--mockup-float-x', `${surface.current.floatX.toFixed(2)}px`);
            surface.node.style.setProperty('--mockup-float-y', `${surface.current.floatY.toFixed(2)}px`);
            surface.node.style.setProperty('--mockup-rot', `${surface.current.rot.toFixed(2)}deg`);
            surface.node.style.setProperty('--mockup-depth', surface.current.depth.toFixed(4));
            surface.node.style.setProperty('--mockup-shine-opacity', surface.current.shine.toFixed(4));
        };

        const computeTargets = (surface) => {
            const rect = surface.node.getBoundingClientRect();
            if (rect.width < 1 || rect.height < 1) return;

            const x = mouse.active ? (mouse.x - rect.left) : (rect.width * 0.5);
            const y = mouse.active ? (mouse.y - rect.top) : (rect.height * 0.5);
            const nx = ((x / rect.width) - 0.5) * 2;
            const ny = ((y / rect.height) - 0.5) * 2;

            const outsideDx = x < 0 ? -x : (x > rect.width ? x - rect.width : 0);
            const outsideDy = y < 0 ? -y : (y > rect.height ? y - rect.height : 0);
            const outsideDistance = Math.hypot(outsideDx, outsideDy);

            const proximity = mouse.active
                ? Math.exp(-(outsideDistance * outsideDistance) / (2 * surface.cfg.sigma * surface.cfg.sigma))
                : 0;

            surface.target.fxX = clamp(x, -rect.width * 0.18, rect.width * 1.18);
            surface.target.fxY = clamp(y, -rect.height * 0.18, rect.height * 1.18);
            surface.target.floatX = clamp(nx, -1.3, 1.3) * surface.cfg.maxShiftX * proximity;
            surface.target.floatY = clamp(ny, -1.3, 1.3) * surface.cfg.maxShiftY * proximity;
            surface.target.rot = clamp(nx, -1.2, 1.2) * surface.cfg.maxRotate * proximity;
            surface.target.depth = proximity;
                surface.target.shine = proximity * 0.3;
        };

        const animate = () => {
            surfaces.forEach((surface) => {
                computeTargets(surface);

                surface.current.fxX = lerp(surface.current.fxX || surface.target.fxX, surface.target.fxX, 0.15);
                surface.current.fxY = lerp(surface.current.fxY || surface.target.fxY, surface.target.fxY, 0.15);
                surface.current.floatX = lerp(surface.current.floatX, surface.target.floatX, 0.1);
                surface.current.floatY = lerp(surface.current.floatY, surface.target.floatY, 0.1);
                surface.current.rot = lerp(surface.current.rot, surface.target.rot, 0.1);
                surface.current.depth = lerp(surface.current.depth, surface.target.depth, 0.11);
                surface.current.shine = lerp(surface.current.shine, surface.target.shine, 0.09);

                setState(surface);
            });

            requestAnimationFrame(animate);
        };

        window.addEventListener('mousemove', (e) => {
            mouse.x = e.clientX;
            mouse.y = e.clientY;
            mouse.active = true;
        });

        window.addEventListener('mouseleave', () => {
            mouse.active = false;
        });

        animate();
    });
</script>
@endpush
@endonce
