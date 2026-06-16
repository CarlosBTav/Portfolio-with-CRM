@props([
    'variant' => 'viewport',
    'interactive' => true,
    'wavesOverlay' => true,
    /*
     * Optional theme overrides (defaults match original /cv look).
     * backgroundColor: any CSS color (e.g. #f9fafb, rgb(...))
     * dotColor: comma-separated R,G,B for canvas dots (e.g. 99, 102, 241)
     */
    'backgroundColor' => null,
    'dotColor' => null,
])

@php
    $stackClass = match ($variant) {
        'section' => 'ai-dots-bg-stack ai-dots-bg-stack--section',
        'hero' => 'ai-dots-bg-stack ai-dots-bg-stack--hero',
        default => 'ai-dots-bg-stack ai-dots-bg-stack--viewport',
    };

    $styleParts = [];
    if ($backgroundColor !== null && $backgroundColor !== '') {
        $bg = e($backgroundColor);
        $styleParts[] = '--ai-dots-canvas-bg: ' . $bg;
        $styleParts[] = '--ai-dots-mask-bg: ' . $bg;
    }
    if ($dotColor !== null && $dotColor !== '') {
        $styleParts[] = '--ai-dots-dot: ' . e($dotColor);
    }
    $inlineStyle = count($styleParts) ? implode('; ', $styleParts) : null;
@endphp

@once
    <style>
        .ai-dots-bg-stack {
            pointer-events: none;
            --ai-dots-canvas-bg: rgb(245, 245, 240);
            --ai-dots-mask-bg: rgb(245, 245, 240);
            /* R,G,B — used as rgb(var(--ai-dots-dot)) in script */
            --ai-dots-dot: 232, 118, 74;
            /* Blurred wave ribbons (SVG strokes, wide → narrow) */
            --ai-dots-wave-wide: #d8d8d2;
            --ai-dots-wave-mid: #77776f;
            --ai-dots-wave-core: #000000;
            --ai-dots-mask-blend: lighten;
            --ai-dots-glow-blend: multiply;
            --ai-dots-glow-gradient: radial-gradient(circle at 50% 50%, #9a9a92 0%, #d8d8d4 52%, transparent 84%);
        }
        .ai-dots-bg-stack--viewport {
            position: fixed;
            left: 0;
            top: 0;
            width: 100vw;
            max-width: 100vw;
            height: 100vh;
            height: 100lvh;
            box-sizing: border-box;
            z-index: 0;
            overflow: hidden;
            transform: translateZ(0);
            -webkit-transform: translateZ(0);
        }
        .ai-dots-bg-stack--section {
            position: absolute;
            inset: 0;
            z-index: 0;
            overflow: hidden;
        }
        .ai-dots-bg-stack--hero {
            position: absolute;
            left: -30%;
            right: -30%;
            top: 0;
            bottom: 0;
            z-index: 1;
            overflow: hidden;
            background: transparent;
            --ai-dots-canvas-bg: transparent;
            --ai-dots-mask-bg: transparent;
            --ai-dots-dot: var(--hr-dots-dot, 99, 102, 241);
            --ai-dots-fade-w: var(--hr-dots-fade-w, 22%);
            --ai-dots-fade-h: var(--hr-dots-fade-h, 16%);
            -webkit-mask-image:
                linear-gradient(to bottom, transparent 0%, #000 var(--ai-dots-fade-h), #000 calc(100% - var(--ai-dots-fade-h)), transparent 100%),
                linear-gradient(to right, transparent 0%, #000 var(--ai-dots-fade-w), #000 calc(100% - var(--ai-dots-fade-w)), transparent 100%);
            mask-image:
                linear-gradient(to bottom, transparent 0%, #000 var(--ai-dots-fade-h), #000 calc(100% - var(--ai-dots-fade-h)), transparent 100%),
                linear-gradient(to right, transparent 0%, #000 var(--ai-dots-fade-w), #000 calc(100% - var(--ai-dots-fade-w)), transparent 100%);
            -webkit-mask-composite: source-in;
            mask-composite: intersect;
            mask-mode: alpha;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
        }
        .ai-dots-bg-stack .js-ai-dots-canvas {
            display: block;
            width: 100%;
            height: 100%;
            background-color: var(--ai-dots-canvas-bg);
        }
        .ai-dots-bg-stack--hero .js-ai-dots-canvas {
            background-color: transparent;
        }
        .ai-dots-bg-stack--viewport .js-ai-dots-canvas {
            position: absolute;
            inset: 0;
        }
        .ai-dots-bg-stack .ai-dots-mask-layer {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            background-color: var(--ai-dots-mask-bg);
            mix-blend-mode: var(--ai-dots-mask-blend);
            z-index: 1;
            overflow: hidden;
        }
        .ai-dots-bg-stack .ai-dots-wave-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: rotate(-10deg);
            filter: blur(32px);
            z-index: 1;
        }
        .ai-dots-bg-stack--viewport .ai-dots-wave-container {
            width: 200vw;
            height: 100vh;
            height: 100lvh;
            margin-left: -100vw;
            margin-top: -50vh;
            margin-top: -50lvh;
        }
        .ai-dots-bg-stack--section .ai-dots-wave-container {
            width: 200%;
            height: 100%;
            margin-left: -100%;
            margin-top: -50%;
        }
        .ai-dots-bg-stack .ai-dots-wave-path {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            will-change: transform;
        }
        .ai-dots-bg-stack .ai-dots-wave-1 {
            animation: aiDotsMoveWave1 7.5s ease-in-out infinite alternate;
        }
        .ai-dots-bg-stack .ai-dots-wave-2 {
            animation: aiDotsMoveWave2 9.5s ease-in-out infinite alternate-reverse;
        }
        .ai-dots-bg-stack .ai-dots-wave-3 {
            animation: aiDotsMoveWave3 11s ease-in-out infinite alternate;
        }
        @keyframes aiDotsMoveWave1 {
            0%   { transform: translate(-30vw, -10vh) rotate(-5deg) scale(0.95, 0.72); }
            50%  { transform: translate(0vw, 15vh) rotate(3deg) scale(1.08, 1.2); }
            100% { transform: translate(30vw, -15vh) rotate(-2deg) scale(1.02, 0.86); }
        }
        @keyframes aiDotsMoveWave2 {
            0%   { transform: translate(30vw, 15vh) rotate(5deg) scale(1.08, 1.12); }
            50%  { transform: translate(0vw, -10vh) rotate(-2deg) scale(0.92, 0.84); }
            100% { transform: translate(-30vw, 10vh) rotate(3deg) scale(1.12, 1.28); }
        }
        @keyframes aiDotsMoveWave3 {
            0%   { transform: translate(-18vw, 18vh) rotate(7deg) scale(1.1, 0.78); }
            50%  { transform: translate(12vw, -6vh) rotate(-5deg) scale(0.88, 1.22); }
            100% { transform: translate(24vw, 14vh) rotate(4deg) scale(1.04, 0.96); }
        }
        .ai-dots-bg-stack .js-ai-dots-glow,
        .ai-dots-bg-stack .js-ai-dots-ripple-glow {
            position: absolute;
            width: 680px;
            height: 680px;
            background: var(--ai-dots-glow-gradient);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            mix-blend-mode: var(--ai-dots-glow-blend);
            filter: blur(40px);
            z-index: 2;
            opacity: 0;
            will-change: transform, opacity;
        }
        body:has(> .ai-dots-bg-stack--viewport) .page {
            position: relative;
            z-index: 10;
        }
        @media print {
            .ai-dots-bg-stack { display: none !important; }
        }
    </style>
@endonce

@if($interactive)
<div {{ $attributes->merge(['class' => $stackClass]) }} @if($inlineStyle) style="{{ $inlineStyle }}" @endif data-ai-dots-root="{{ $variant }}" @if($variant === 'hero') data-ai-dots-hit="stage" data-spacing="22" @endif aria-hidden="true">
    <canvas class="js-ai-dots-canvas"></canvas>
    @if($wavesOverlay)
    <div class="ai-dots-mask-layer">
        <div class="ai-dots-wave-container">
            <svg class="ai-dots-wave-path ai-dots-wave-1" viewBox="0 0 1000 400" preserveAspectRatio="none">
                <path d="M -200,200 C 100,50 300,350 600,200 C 900,50 1100,350 1400,200" fill="none" stroke="var(--ai-dots-wave-wide)" stroke-width="128" stroke-linecap="round"/>
                <path d="M -200,200 C 100,50 300,350 600,200 C 900,50 1100,350 1400,200" fill="none" stroke="var(--ai-dots-wave-mid)" stroke-width="86" stroke-linecap="round"/>
                <path d="M -200,200 C 100,50 300,350 600,200 C 900,50 1100,350 1400,200" fill="none" stroke="var(--ai-dots-wave-core)" stroke-width="46" stroke-linecap="round"/>
            </svg>
            <svg class="ai-dots-wave-path ai-dots-wave-2" viewBox="0 0 1000 400" preserveAspectRatio="none">
                <path d="M -200,200 C 200,350 400,50 700,200 C 1000,350 1200,50 1400,200" fill="none" stroke="var(--ai-dots-wave-wide)" stroke-width="102" stroke-linecap="round"/>
                <path d="M -200,200 C 200,350 400,50 700,200 C 1000,350 1200,50 1400,200" fill="none" stroke="var(--ai-dots-wave-mid)" stroke-width="68" stroke-linecap="round"/>
                <path d="M -200,200 C 200,350 400,50 700,200 C 1000,350 1200,50 1400,200" fill="none" stroke="var(--ai-dots-wave-core)" stroke-width="38" stroke-linecap="round"/>
            </svg>
            <svg class="ai-dots-wave-path ai-dots-wave-3" viewBox="0 0 1000 400" preserveAspectRatio="none">
                <path d="M -200,180 C 80,310 280,90 540,210 C 800,330 980,80 1400,180" fill="none" stroke="var(--ai-dots-wave-wide)" stroke-width="112" stroke-linecap="round"/>
                <path d="M -200,180 C 80,310 280,90 540,210 C 800,330 980,80 1400,180" fill="none" stroke="var(--ai-dots-wave-mid)" stroke-width="74" stroke-linecap="round"/>
                <path d="M -200,180 C 80,310 280,90 540,210 C 800,330 980,80 1400,180" fill="none" stroke="var(--ai-dots-wave-core)" stroke-width="40" stroke-linecap="round"/>
            </svg>
        </div>
        <div class="js-ai-dots-glow ai-dots-glow"></div>
    </div>
    @endif
</div>

@pushOnce('scripts', 'portfolio-ai-dots-background')
@vite('resources/js/ai-dots-touch.js')
<script>
(function () {
    function initAiDotsRoots() {
        document.querySelectorAll('[data-ai-dots-root]').forEach(function (root) {
            if (root.dataset.aiDotsInit === '1') return;
            root.dataset.aiDotsInit = '1';
            initOneRoot(root);
        });
    }
    function resolveTouchHitElement(root, canvas) {
        if (root.dataset.aiDotsHit === 'stage') {
            return root.closest('.hr-photo-stage') || root.parentElement || canvas;
        }
        return canvas;
    }

    function initOneRoot(root) {
        var canvas = root.querySelector('.js-ai-dots-canvas');
        var glow = root.querySelector('.js-ai-dots-glow');
        var maskLayer = root.querySelector('.ai-dots-mask-layer');
        if (!canvas || !canvas.getContext) return;

        var ctx = canvas.getContext('2d');
        var dots = [];
        var spacing = 28;
        var spacingAttr = parseInt(root.dataset.spacing, 10);
        if (spacingAttr >= 8 && spacingAttr <= 60) spacing = spacingAttr;
        var touchHitEl = resolveTouchHitElement(root, canvas);
        var mouse = { x: -1000, y: -1000, px: -1000, py: -1000, speed: 0, radius: 140, ready: false };
        // Trail of recent pointer positions (desktop). Dots light up along it and fade out.
        var TRAIL_LIFE = 650;   // ms each trail point stays lit
        var TRAIL_MAX = 60;     // max stored points
        var TRAIL_MIN_STEP = 4; // min px between sampled points
        var TRAIL_SIGMA = 24;   // px base radius of light around each point (small = tight spots)
        var trail = [];
        var touch = window.AiDotsTouch;
        var ripples = touch ? touch.createRippleState() : { list: [] };
        var touchPrimary = touch ? touch.isTouchPrimary() : false;
        var unbindRipples = null;
        var mouseMoveHandler = null;

        var waveDefs = [
            {
                duration: 7500,
                alternateReverse: false,
                radius: 68,
                radiusPulse: 0.16,
                phase: 0.2,
                keys: [
                    { x: -0.3, y: -0.1, rotate: -5, scaleX: 0.95, scaleY: 0.72 },
                    { x: 0, y: 0.15, rotate: 3, scaleX: 1.08, scaleY: 1.2 },
                    { x: 0.3, y: -0.15, rotate: -2, scaleX: 1.02, scaleY: 0.86 }
                ],
                segments: [
                    [[-200, 200], [100, 50], [300, 350], [600, 200]],
                    [[600, 200], [900, 50], [1100, 350], [1400, 200]]
                ]
            },
            {
                duration: 9500,
                alternateReverse: true,
                radius: 54,
                radiusPulse: 0.18,
                phase: 2.1,
                keys: [
                    { x: 0.3, y: 0.15, rotate: 5, scaleX: 1.08, scaleY: 1.12 },
                    { x: 0, y: -0.1, rotate: -2, scaleX: 0.92, scaleY: 0.84 },
                    { x: -0.3, y: 0.1, rotate: 3, scaleX: 1.12, scaleY: 1.28 }
                ],
                segments: [
                    [[-200, 200], [200, 350], [400, 50], [700, 200]],
                    [[700, 200], [1000, 350], [1200, 50], [1400, 200]]
                ]
            },
            {
                duration: 11000,
                alternateReverse: false,
                radius: 61,
                radiusPulse: 0.2,
                phase: 4.2,
                keys: [
                    { x: -0.18, y: 0.18, rotate: 7, scaleX: 1.1, scaleY: 0.78 },
                    { x: 0.12, y: -0.06, rotate: -5, scaleX: 0.88, scaleY: 1.22 },
                    { x: 0.24, y: 0.14, rotate: 4, scaleX: 1.04, scaleY: 0.96 }
                ],
                segments: [
                    [[-200, 180], [80, 310], [280, 90], [540, 210]],
                    [[540, 210], [800, 330], [980, 80], [1400, 180]]
                ]
            }
        ];

        function smoothstep(t) {
            if (t < 0) return 0;
            if (t > 1) return 1;
            return t * t * (3 - 2 * t);
        }

        function easeInOut(t) {
            return 0.5 - Math.cos(t * Math.PI) * 0.5;
        }

        function lerp(a, b, t) {
            return a + (b - a) * t;
        }

        function rotatePoint(x, y, degrees) {
            var a = degrees * Math.PI / 180;
            var c = Math.cos(a);
            var s = Math.sin(a);
            return { x: x * c - y * s, y: x * s + y * c };
        }

        function interpolateKeyframes(keys, progress) {
            var start = keys[0];
            var end = keys[1];
            var local = progress / 0.5;
            if (progress > 0.5) {
                start = keys[1];
                end = keys[2];
                local = (progress - 0.5) / 0.5;
            }
            local = easeInOut(local);
            return {
                x: lerp(start.x, end.x, local),
                y: lerp(start.y, end.y, local),
                rotate: lerp(start.rotate, end.rotate, local),
                scaleX: lerp(start.scaleX, end.scaleX, local),
                scaleY: lerp(start.scaleY, end.scaleY, local)
            };
        }

        function waveMotion(def, now) {
            var total = now / def.duration;
            var iteration = Math.floor(total);
            var progress = total - iteration;
            if ((def.alternateReverse && iteration % 2 === 0) || (!def.alternateReverse && iteration % 2 === 1)) {
                progress = 1 - progress;
            }
            return interpolateKeyframes(def.keys, progress);
        }

        function cubicPoint(points, t) {
            var mt = 1 - t;
            return [
                mt * mt * mt * points[0][0] + 3 * mt * mt * t * points[1][0] + 3 * mt * t * t * points[2][0] + t * t * t * points[3][0],
                mt * mt * mt * points[0][1] + 3 * mt * mt * t * points[1][1] + 3 * mt * t * t * points[2][1] + t * t * t * points[3][1]
            ];
        }

        function distanceToSegment(px, py, ax, ay, bx, by) {
            var vx = bx - ax;
            var vy = by - ay;
            var wx = px - ax;
            var wy = py - ay;
            var len = vx * vx + vy * vy || 1;
            var t = (wx * vx + wy * vy) / len;
            if (t < 0) t = 0;
            else if (t > 1) t = 1;
            var x = ax + vx * t;
            var y = ay + vy * t;
            return Math.hypot(px - x, py - y);
        }

        function distanceToPath(px, py, segments) {
            var closest = Infinity;
            for (var s = 0; s < segments.length; s++) {
                var last = cubicPoint(segments[s], 0);
                for (var i = 1; i <= 26; i++) {
                    var next = cubicPoint(segments[s], i / 26);
                    var d = distanceToSegment(px, py, last[0], last[1], next[0], next[1]);
                    if (d < closest) closest = d;
                    last = next;
                }
            }
            return closest;
        }

        function toWaveViewBox(gx, gy, def, now, cw, ch) {
            var p = rotatePoint(gx - cw * 0.5, gy - ch * 0.5, 10);
            var localX = p.x + cw;
            var localY = p.y + ch * 0.5;
            var motion = waveMotion(def, now);
            var x = localX - cw - motion.x * cw;
            var y = localY - ch * 0.5 - motion.y * ch;
            p = rotatePoint(x, y, -motion.rotate);
            x = p.x / motion.scaleX + cw;
            y = p.y / motion.scaleY + ch * 0.5;
            return {
                x: x / Math.max(cw * 2, 1) * 1000,
                y: y / Math.max(ch, 1) * 400
            };
        }

        function waveBandFactor(gx, gy, cw, ch, now) {
            var strongest = 0;
            for (var i = 0; i < waveDefs.length; i++) {
                var def = waveDefs[i];
                var p = toWaveViewBox(gx, gy, def, now, cw, ch);
                var d = distanceToPath(p.x, p.y, def.segments);
                var radius = def.radius * (1 + Math.sin(now * 0.00055 + def.phase) * def.radiusPulse);
                var band = 1 - smoothstep(d / radius);
                if (band > strongest) strongest = band;
            }
            return strongest;
        }

        function visibilityForDot(gx, gy, cw, ch, now) {
            var v = waveBandFactor(gx, gy, cw, ch, now);
            if (touch && ripples.list.length > 0) {
                v += touch.visibilityBoost(gx, gy, ripples, now, { maxRadius: 280 });
            }
            if (!touchPrimary && trail.length > 0) {
                var tb = 0;
                for (var ti = 0; ti < trail.length; ti++) {
                    var pt = trail[ti];
                    var age = now - pt.t;
                    if (age >= TRAIL_LIFE) continue;
                    var fade = 1 - age / TRAIL_LIFE;
                    var tdx = pt.x - gx;
                    var tdy = pt.y - gy;
                    var d2 = tdx * tdx + tdy * tdy;
                    // Irregular, organic blob: deform the radius by angle so edges are blotchy.
                    var ang = Math.atan2(tdy, tdx);
                    var wobble = 1 + 0.34 * Math.sin(ang * 3 + pt.seed) + 0.2 * Math.sin(ang * 5 - pt.seed * 1.7);
                    var sig = TRAIL_SIGMA * pt.s * wobble;
                    tb += Math.exp(-d2 / (sig * sig)) * fade * pt.a;
                }
                if (tb > 1) tb = 1;
                v += tb * 0.95;
            }
            if (v > 1) v = 1;
            else if (v < 0) v = 0;
            return v;
        }

        function Dot(x, y) {
            this.x = x;
            this.y = y;
            this.baseX = x;
            this.baseY = y;
            this.vx = 0;
            this.vy = 0;
        }
        Dot.prototype.update = function (now) {
            if (touch && ripples.list.length > 0) {
                touch.applyRippleForces(this, ripples, now);
            }
            if (!touchPrimary) {
                var dx = mouse.x - this.x;
                var dy = mouse.y - this.y;
                var distance = Math.sqrt(dx * dx + dy * dy);
                if (distance < mouse.radius && mouse.speed > 0.5) {
                    var force = (mouse.radius - distance) / mouse.radius;
                    var angle = Math.atan2(dy, dx);
                    var power = mouse.speed * 0.005;
                    if (power > 1.2) power = 1.2;
                    this.vx -= Math.cos(angle) * force * power;
                    this.vy -= Math.sin(angle) * force * power;
                }
            }
            this.x += this.vx;
            this.y += this.vy;
            this.vx *= 0.9;
            this.vy *= 0.9;
            this.x += (this.baseX - this.x) * 0.007;
            this.y += (this.baseY - this.y) * 0.007;
        };
        Dot.prototype.draw = function (now, dotRgbTriplet) {
            var v = visibilityForDot(this.baseX, this.baseY, canvas.width, canvas.height, now);
            var rMin = 0.55;
            var rMax = 1.62;
            var r = rMin + (rMax - rMin) * v;
            var aMin = 0.16;
            var aMax = 1;
            ctx.globalAlpha = aMin + (aMax - aMin) * v;
            ctx.fillStyle = 'rgb(' + dotRgbTriplet + ')';
            ctx.beginPath();
            ctx.arc(this.x, this.y, r, 0, Math.PI * 2);
            ctx.fill();
            ctx.globalAlpha = 1;
        };

        var layoutW = 0;
        var layoutH = 0;

        function syncSize() {
            var w = Math.max(1, Math.floor(canvas.clientWidth));
            var h = Math.max(1, Math.floor(canvas.clientHeight));
            if (w === layoutW && h === layoutH && dots.length > 0) {
                return;
            }

            var prevByBase = {};
            for (var i = 0; i < dots.length; i++) {
                var d = dots[i];
                prevByBase[d.baseX + ',' + d.baseY] = d;
            }

            layoutW = w;
            layoutH = h;
            if (canvas.width !== w || canvas.height !== h) {
                canvas.width = w;
                canvas.height = h;
            }

            dots = [];
            var x = 0;
            for (; x <= canvas.width; x += spacing) {
                var y = 0;
                for (; y <= canvas.height; y += spacing) {
                    var dot = new Dot(x, y);
                    var prev = prevByBase[x + ',' + y];
                    if (prev) {
                        dot.x = prev.x;
                        dot.y = prev.y;
                        dot.vx = prev.vx;
                        dot.vy = prev.vy;
                    }
                    dots.push(dot);
                }
            }
        }

        function animate() {
            var now = performance.now();
            var dotRgbTriplet = getComputedStyle(root).getPropertyValue('--ai-dots-dot').trim() || '232, 118, 74';
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            if (touch) {
                touch.pruneRipples(ripples, now);
                if (maskLayer && glow) {
                    touch.updateGlow(glow, maskLayer, canvas, ripples, now);
                }
            }
            if (!touchPrimary) {
                while (trail.length && now - trail[0].t >= TRAIL_LIFE) trail.shift();
                var ds = Math.sqrt(Math.pow(mouse.x - mouse.px, 2) + Math.pow(mouse.y - mouse.py, 2));
                if (ds > 72) ds = 72;
                mouse.speed += (ds - mouse.speed) * 0.1;
                mouse.px = mouse.x;
                mouse.py = mouse.y;
            }
            for (var i = 0; i < dots.length; i++) {
                dots[i].update(now);
                dots[i].draw(now, dotRgbTriplet);
            }
            requestAnimationFrame(animate);
        }

        function setMouseFromClient(clientX, clientY) {
            var rect = canvas.getBoundingClientRect();
            mouse.x = clientX - rect.left;
            mouse.y = clientY - rect.top;

            // Sample the pointer path into the light trail (desktop only).
            if (!touchPrimary) {
                var nowTs = performance.now();
                var lastPt = trail.length ? trail[trail.length - 1] : null;
                if (!lastPt || Math.hypot(mouse.x - lastPt.x, mouse.y - lastPt.y) >= TRAIL_MIN_STEP) {
                    trail.push({
                        x: mouse.x,
                        y: mouse.y,
                        t: nowTs,
                        s: 0.5 + Math.random() * 1.0,   // random size → uneven spots
                        a: 0.6 + Math.random() * 0.5,   // random intensity
                        seed: Math.random() * 6.283      // random angular phase → organic edges
                    });
                    if (trail.length > TRAIL_MAX) trail.shift();
                }
            }

            if (!mouse.ready) {
                mouse.px = mouse.x;
                mouse.py = mouse.y;
                mouse.speed = 0;
                mouse.ready = true;
            }
        }

        function onMouseMove(e) {
            if ('pointerType' in e && e.pointerType === 'touch') return;
            setMouseFromClient(e.clientX, e.clientY);
        }

        function applyInteractionMode(isTouch) {
            touchPrimary = isTouch;
            root.classList.toggle('ai-dots-bg-stack--pointer-hover', !isTouch);
            trail.length = 0;
            mouse.ready = false;
            mouse.x = -1000;
            mouse.y = -1000;
            mouse.speed = 0;
            if (unbindRipples) {
                unbindRipples();
                unbindRipples = null;
            }
            if (mouseMoveHandler) {
                window.removeEventListener('mousemove', mouseMoveHandler);
                mouseMoveHandler = null;
            }
            if (isTouch && touch) {
                if (glow) glow.style.opacity = '0';
                unbindRipples = touch.bindTouchRipples(canvas, ripples, null, { hitElement: touchHitEl });
            } else {
                ripples.list.length = 0;
                // No follow-glow on desktop: the lit dot trail is the light now.
                if (glow) glow.style.opacity = '0';
                mouseMoveHandler = onMouseMove;
                window.addEventListener('mousemove', mouseMoveHandler, { passive: true });
                if (touch) {
                    unbindRipples = touch.bindRipples(canvas, ripples, null, {
                        hitElement: touchHitEl,
                        allowMouse: true,
                    });
                }
            }
        }

        if (typeof ResizeObserver !== 'undefined') {
            var ro = new ResizeObserver(function () { syncSize(); });
            ro.observe(canvas.parentElement || root);
        }
        window.addEventListener('resize', syncSize);
        if (window.visualViewport) {
            window.visualViewport.addEventListener('resize', function () {
                var vv = window.visualViewport;
                if (!vv) return;
                var w = Math.max(1, Math.floor(canvas.clientWidth));
                var h = Math.max(1, Math.floor(canvas.clientHeight));
                if (w !== layoutW || h !== layoutH) {
                    syncSize();
                }
            }, { passive: true });
        }

        applyInteractionMode(touchPrimary);
        if (touch) {
            touch.watchTouchMode(applyInteractionMode);
        } else {
            mouseMoveHandler = onMouseMove;
            window.addEventListener('mousemove', mouseMoveHandler, { passive: true });
            root.classList.add('ai-dots-bg-stack--pointer-hover');
        }

        syncSize();
        animate();
    }

    function bootAiDots() {
        if (!window.AiDotsTouch) {
            requestAnimationFrame(bootAiDots);
            return;
        }
        initAiDotsRoots();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', bootAiDots);
    } else {
        bootAiDots();
    }
})();
</script>
@endPushOnce

@else
<!-- ai-dots-background: interactive=false (sin capas ni script) -->
@endif
