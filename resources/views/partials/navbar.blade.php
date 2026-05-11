@php
    $currentRoute = Route::currentRouteName();
    $isHome = $currentRoute === 'home';
    $isAbout = $currentRoute === 'public.about';
    $isServicePage = request()->routeIs('public.services', 'public.services.*');
    $navLogo = 'CARLOS.CODEX';
@endphp

<style>
  #site-redesign-nav {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 60;
    padding: 14px 18px;
    pointer-events: none;
  }
  /* Cristal tipo main (GitHub): bg-white/38 · dark #0a0a0a/46 · blur-3xl · saturate-150 */
  #site-redesign-nav .srn-shell {
    max-width: 1280px;
    margin: 0 auto;
    pointer-events: all;
    border: 1px solid rgba(255, 255, 255, 0.16);
    border-radius: 1.25rem;
    background: rgba(10, 10, 10, 0.46);
    backdrop-filter: blur(64px) saturate(150%);
    -webkit-backdrop-filter: blur(64px) saturate(150%);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.28);
    padding-top: 14px;
    padding-bottom: 14px;
    transition: padding .22s ease, background .22s ease, border-color .22s ease, box-shadow .22s ease;
  }
  #site-redesign-nav .srn-shell.is-scrolled {
    padding-top: 0;
    padding-bottom: 0;
    box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
  }
  #site-redesign-nav .srn-row {
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    align-items: center;
    gap: 24px;
    padding: 18px 24px;
    transition: padding .22s ease;
  }
  #site-redesign-nav .srn-shell.is-scrolled .srn-row {
    padding-top: 12px;
    padding-bottom: 12px;
  }
  #site-redesign-nav .srn-left {
    justify-self: start;
  }
  #site-redesign-nav .srn-center {
    justify-self: center;
  }
  #site-redesign-nav .srn-right {
    justify-self: end;
    display: flex;
    align-items: center;
    gap: 14px;
  }
  /* Logo: colores por glifo (.navbar-logo-char-*) en public.blade.php; sin color heredado aquí */
  #site-redesign-nav .srn-brand {
    font-family: 'JetBrains Mono', ui-monospace, monospace;
    font-weight: 700;
    font-size: 16px;
    letter-spacing: 0.04em;
    text-decoration: none;
    white-space: nowrap;
  }
  #site-redesign-nav .srn-links {
    display: flex;
    align-items: center;
    gap: 36px;
    margin: 0;
    padding: 0;
    list-style: none;
  }
  #site-redesign-nav .srn-link {
    font-family: 'Geist', system-ui, sans-serif;
    font-size: 14.5px;
    font-weight: 500;
    color: #9aa0ad;
    text-decoration: none;
    padding: 6px 2px;
    border-bottom: 2px solid transparent;
    transition: color .2s ease, border-color .2s ease;
    white-space: nowrap;
  }
  #site-redesign-nav .srn-link:hover {
    color: #e8ecf2;
  }
  #site-redesign-nav .srn-link.is-active {
    color: #e8ecf2;
    border-bottom-color: #818cf8;
  }
  #site-redesign-nav #theme-toggle {
    width: 36px !important;
    height: 36px !important;
    border-radius: 999px !important;
    border: 1px solid rgba(255, 255, 255, 0.12) !important;
    background: transparent !important;
    color: #9aa0ad !important;
    transition:
      color .22s ease,
      border-color .22s ease,
      background .22s ease,
      transform .28s cubic-bezier(0.34, 1.56, 0.64, 1),
      box-shadow .28s ease !important;
    padding: 0 !important;
    box-shadow: none !important;
  }
  #site-redesign-nav #theme-toggle:hover {
    color: #e8ecf2 !important;
    border-color: rgba(129, 140, 248, 0.45) !important;
    background: rgba(129, 140, 248, 0.12) !important;
    transform: scale(1.08) rotate(-4deg) !important;
    box-shadow: 0 6px 18px rgba(99, 102, 241, 0.28) !important;
  }
  #site-redesign-nav .srn-cta {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px 8px 12px;
    border-radius: 999px;
    border: 1px solid #818cf8;
    color: #f5f6fa;
    text-decoration: none;
    font-family: 'Geist', system-ui, sans-serif;
    font-size: 14px;
    font-weight: 500;
    transition:
      background .22s ease,
      border-color .22s ease,
      color .22s ease,
      transform .28s cubic-bezier(0.34, 1.56, 0.64, 1),
      box-shadow .28s ease;
  }
  #site-redesign-nav .srn-cta:hover {
    background: #6366f1;
    border-color: #6366f1;
    transform: translateY(-2px) scale(1.045);
    box-shadow: 0 10px 28px rgba(99, 102, 241, 0.38);
  }
  #site-redesign-nav .srn-cta svg {
    width: 18px;
    height: 18px;
    transition: transform 0.28s cubic-bezier(0.34, 1.56, 0.64, 1);
  }
  #site-redesign-nav .srn-cta:hover svg {
    transform: translateX(3px);
  }
  /* ── Light theme (html sin .dark): contrast vs shell claro — !important evita utilidades Tailwind en hijos ── */
  html:not(.dark) #site-redesign-nav .srn-shell {
    border: 1px solid rgba(255, 255, 255, 0.45);
    background: rgba(255, 255, 255, 0.38);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
  }
  html:not(.dark) #site-redesign-nav .srn-shell.is-scrolled {
    box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
  }
  html:not(.dark) #site-redesign-nav .srn-link {
    color: #475569 !important;
  }
  html:not(.dark) #site-redesign-nav .srn-link:hover,
  html:not(.dark) #site-redesign-nav .srn-link.is-active {
    color: #0f172a !important;
    border-bottom-color: #6366f1;
  }
  /* CTA «Hablemos»: antes color #f5f6fa → invisible sobre fondo claro */
  html:not(.dark) #site-redesign-nav .srn-cta {
    color: #0f172a !important;
    border-color: #6366f1 !important;
  }
  html:not(.dark) #site-redesign-nav .srn-cta:hover {
    color: #ffffff !important;
    background: #6366f1 !important;
    border-color: #6366f1 !important;
    transform: translateY(-2px) scale(1.045) !important;
    box-shadow: 0 10px 28px rgba(99, 102, 241, 0.35) !important;
  }
  html:not(.dark) #site-redesign-nav #theme-toggle {
    border-color: rgba(15, 23, 42, 0.12) !important;
    color: #64748b !important;
  }
  html:not(.dark) #site-redesign-nav #theme-toggle:hover {
    color: #3730a3 !important;
    border-color: rgba(79, 70, 229, 0.35) !important;
    background: rgba(99, 102, 241, 0.1) !important;
    transform: scale(1.08) rotate(-4deg) !important;
    box-shadow: 0 6px 18px rgba(99, 102, 241, 0.22) !important;
  }
  html:not(.dark) #site-redesign-nav .srn-mobile-btn {
    border-color: rgba(15, 23, 42, 0.12);
    color: #475569 !important;
  }
  html:not(.dark) #site-redesign-nav .srn-mobile-links {
    border-top-color: rgba(255, 255, 255, 0.45);
  }
  html:not(.dark) #site-redesign-nav .srn-mobile-link {
    color: #475569 !important;
  }
  html:not(.dark) #site-redesign-nav .srn-mobile-link:hover {
    color: #0f172a !important;
    background: rgba(15, 23, 42, 0.04);
  }
  html:not(.dark) #site-redesign-nav .srn-mobile-link.is-active {
    color: #0f172a !important;
    border-left-color: #6366f1;
    background: rgba(99, 102, 241, 0.08);
  }

  #site-redesign-nav .srn-mobile-btn {
    display: none;
    width: 36px;
    height: 36px;
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.12);
    color: #9aa0ad;
    background: transparent;
    align-items: center;
    justify-content: center;
    cursor: pointer;
  }
  #site-redesign-nav .srn-mobile-btn svg {
    width: 18px;
    height: 18px;
  }
  #site-redesign-nav .srn-mobile {
    display: grid;
    grid-template-rows: 0fr;
    transition: grid-template-rows .28s cubic-bezier(0.4, 0, 0.2, 1);
  }
  #site-redesign-nav .srn-mobile.is-open {
    grid-template-rows: 1fr;
  }
  #site-redesign-nav .srn-mobile > div {
    overflow: hidden;
  }
  #site-redesign-nav .srn-mobile-links {
    border-top: 1px solid rgba(255, 255, 255, 0.16);
    margin: 0;
    margin-top: 8px;
    padding: 8px 0 2px;
    list-style: none;
  }
  #site-redesign-nav .srn-mobile-link {
    display: block;
    font-family: 'Geist', system-ui, sans-serif;
    font-size: 15px;
    font-weight: 500;
    color: #9aa0ad;
    text-decoration: none;
    padding: 10px 12px;
    border-left: 3px solid transparent;
    border-radius: 10px;
    transition: color .2s ease, border-color .2s ease, background .2s ease;
  }
  #site-redesign-nav .srn-mobile-link:hover {
    color: #e8ecf2;
    background: rgba(255, 255, 255, 0.04);
  }
  #site-redesign-nav .srn-mobile-link.is-active {
    color: #e8ecf2;
    border-left-color: #818cf8;
    background: rgba(99, 102, 241, 0.1);
  }
  @media (max-width: 900px) {
    #site-redesign-nav .srn-row {
      display: flex;
      justify-content: space-between;
      gap: 14px;
      padding: 12px 16px;
    }
    #site-redesign-nav .srn-shell.is-scrolled .srn-row {
      padding-top: 10px;
      padding-bottom: 10px;
    }
    #site-redesign-nav .srn-center,
    #site-redesign-nav .srn-right .srn-cta {
      display: none;
    }
    #site-redesign-nav .srn-mobile-btn {
      display: inline-flex;
    }
  }
</style>

<nav
    id="site-redesign-nav"
    x-data="{
        scrolled: typeof window !== 'undefined' && window.scrollY > 20,
        open: false,
        isHome: @json($isHome),
        isAboutPage: @json($isAbout),
        activeHomeSection: null,
        init() {
            const syncScroll = () => {
                this.scrolled = window.scrollY > 20;
                this.updateHomeSection();
            };
            window.addEventListener('scroll', syncScroll, { passive: true });
            window.addEventListener('resize', syncScroll, { passive: true });
            syncScroll();
        },
        updateHomeSection() {
            if (!this.isHome) {
                this.activeHomeSection = null;
                return;
            }
            const trackedIds = ['services', 'projects', 'about', 'contact'];
            const tracked = trackedIds
                .map((id) => ({ id, el: document.getElementById(id) }))
                .filter((item) => item.el);
            const refY = window.innerHeight * 0.5;
            for (const item of tracked) {
                const r = item.el.getBoundingClientRect();
                if (refY >= r.top && refY <= r.bottom) {
                    this.activeHomeSection = item.id;
                    return;
                }
            }
            this.activeHomeSection = null;
        },
    }"
    @click.outside="open = false"
>
    <div class="srn-shell js-header-border-spotlight" :class="{ 'is-scrolled': scrolled }">
        <div class="srn-row">
            <div class="srn-left">
                {{-- Misma marca interactiva que en main: ola magnética + brillo al cursor (layout public.blade.php) --}}
                <a href="{{ route('home') }}" class="srn-brand leading-none">
                    <span class="js-footer-design-spotlight footer-design-wrapper navbar-brand-vfx relative inline-block whitespace-nowrap">
                        <span class="js-footer-name-spotlight js-hero-wave hero-name-vfx footer-name-wrapper footer-magnetic-vfx navbar-logo-wave relative inline-block leading-none">
                            <span class="footer-name-vfx-base">@foreach (mb_str_split($navLogo) as $i => $char)<span class="footer-name-char hero-wave-char {{ $i < 6 ? 'navbar-logo-char-main' : 'navbar-logo-char-muted' }}" style="--char-index: {{ $i }}">{{ $char }}</span>@endforeach</span>
                            <span class="footer-design-reflection navbar-brand-metallic-overlay" aria-hidden="true">@foreach (mb_str_split($navLogo) as $i => $char)<span class="footer-name-char hero-wave-char navbar-brand-metallic-char" style="--char-index: {{ $i }}">{{ $char }}</span>@endforeach</span>
                        </span>
                    </span>
                </a>
            </div>

            <div class="srn-center">
                <ul class="srn-links">
                    <li>
                        <a href="{{ route('public.services') }}"
                           class="srn-link {{ $isServicePage ? 'is-active' : '' }}"
                           @if($isServicePage) aria-current="page" @endif>Servicios</a>
                    </li>
                    <li>
                        <a href="{{ route('public.about') }}"
                           class="srn-link {{ $isAbout ? 'is-active' : '' }}"
                           :class="(isHome && activeHomeSection === 'about') ? 'is-active' : ''"
                           @if($isAbout) aria-current="page" @endif>Sobre mí</a>
                    </li>
                    <li>
                        <a href="{{ $isHome ? '#projects' : route('home') . '#projects' }}"
                           class="srn-link"
                           :class="(isHome && activeHomeSection === 'projects') ? 'is-active' : ''">Portfolio</a>
                    </li>
                    <li>
                        <a href="{{ $isHome ? '#contact' : route('home') . '#contact' }}"
                           class="srn-link"
                           :class="(isHome && activeHomeSection === 'contact') ? 'is-active' : ''">Contacto</a>
                    </li>
                </ul>
            </div>

            <div class="srn-right">
                <x-theme-toggle />
                <a href="{{ $isHome ? '#contact' : route('home') . '#contact' }}" class="srn-cta">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                    Hablemos
                </a>
                <button @click="open = !open" type="button" class="srn-mobile-btn" aria-label="Menú">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path x-show="!open" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path x-show="open" style="display:none" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div class="srn-mobile" :class="{ 'is-open': open }">
            <div>
                <ul class="srn-mobile-links">
                    <li>
                        <a href="{{ route('public.services') }}"
                           @click="open = false"
                           class="srn-mobile-link {{ $isServicePage ? 'is-active' : '' }}">Servicios</a>
                    </li>
                    <li>
                        <a href="{{ route('public.about') }}"
                           @click="open = false"
                           class="srn-mobile-link {{ $isAbout ? 'is-active' : '' }}"
                           :class="(isHome && activeHomeSection === 'about') ? 'is-active' : ''">Sobre mí</a>
                    </li>
                    <li>
                        <a href="{{ $isHome ? '#projects' : route('home') . '#projects' }}"
                           @click="open = false"
                           class="srn-mobile-link"
                           :class="(isHome && activeHomeSection === 'projects') ? 'is-active' : ''">Portfolio</a>
                    </li>
                    <li>
                        <a href="{{ $isHome ? '#contact' : route('home') . '#contact' }}"
                           @click="open = false"
                           class="srn-mobile-link"
                           :class="(isHome && activeHomeSection === 'contact') ? 'is-active' : ''">Contacto</a>
                    </li>
                    <li style="padding: 8px 12px 10px;">
                        <a href="{{ $isHome ? '#contact' : route('home') . '#contact' }}" @click="open = false" class="srn-cta">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                            Hablemos
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
