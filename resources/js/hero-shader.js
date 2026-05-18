/**
 * hero-shader.js
 * WebGL diagonal-flow shader + AI dots background for the new dark hero card.
 * Imported via @vite in public.blade.php or via @push('scripts') in home.blade.php.
 */

/* ────────────────────────────────────────────────────────────────────
   1. WebGL shader — dark diagonal-flow (same as home.blade soft variant,
      retuned for the contained dark hero card)
   ──────────────────────────────────────────────────────────────────── */
(function initHeroShader() {
  const canvas = document.getElementById('hr-shader-canvas');
  if (!canvas) return;

  const gl = canvas.getContext('webgl', { premultipliedAlpha: false, antialias: true });
  if (!gl) return;

  const dpr = Math.min(window.devicePixelRatio || 1, 2);

  function resize() {
    const rect = canvas.getBoundingClientRect();
    const w = Math.max(1, Math.floor(rect.width * dpr));
    const h = Math.max(1, Math.floor(rect.height * dpr));
    if (canvas.width !== w || canvas.height !== h) {
      canvas.width = w;
      canvas.height = h;
    }
    gl.viewport(0, 0, w, h);
  }
  resize();
  window.addEventListener('resize', resize);
  if (window.ResizeObserver) new ResizeObserver(resize).observe(canvas);

  const vsSrc = `attribute vec2 a; void main(){ gl_Position = vec4(a, 0., 1.); }`;

  const fsSrc = `
    precision highp float;
    uniform vec2  u_res;
    uniform float u_time;
    uniform float u_intensity;
    uniform vec3  u_bg;
    uniform float u_fluidMix;

    float noise(vec2 p) {
      return fract(sin(dot(p, vec2(12.9898, 78.233))) * 43758.5453);
    }
    void main(){
      vec2 uv = gl_FragCoord.xy / u_res.xy;
      float ratio = u_res.x / u_res.y;
      vec2 p = uv;
      p.x *= ratio;

      float t = u_time * 0.18;

      vec2 shift = p;
      for (float i = 1.0; i < 3.0; i++) {
        shift.x += 0.35 / i * sin(i * 1.8 * p.y + t);
        shift.y += 0.30 / i * cos(i * 1.8 * p.x + t);
      }

      float diagonal = shift.x + shift.y * ratio;
      float target   = ratio * 1.0;
      float mask     = smoothstep(0.9, 0.0, abs(diagonal - target));

      float mixer  = smoothstep(0.2, 0.8, uv.x + sin(t * 0.5) * 0.2);
      vec3  cA     = vec3(0.604, 0.820, 0.824);
      vec3  cB     = vec3(0.388, 0.400, 0.945);
      vec3  fluid  = mix(cA, cB, mixer);

      float bandStrength = mask * u_intensity;
      vec3 color = mix(u_bg, fluid * u_fluidMix, bandStrength);

      float vign = smoothstep(1.1, 0.3, length(uv - vec2(0.35, 0.5)));
      color *= mix(0.85, 1.0, vign);

      float grain = (noise(uv + fract(u_time)) - 0.5) * 0.025;
      color += grain;

      gl_FragColor = vec4(color, 1.0);
    }
  `;

  function mkShader(type, src) {
    const s = gl.createShader(type);
    gl.shaderSource(s, src);
    gl.compileShader(s);
    if (!gl.getShaderParameter(s, gl.COMPILE_STATUS)) {
      console.warn('[hero-shader] compile error:', gl.getShaderInfoLog(s));
    }
    return s;
  }

  const prog = gl.createProgram();
  gl.attachShader(prog, mkShader(gl.VERTEX_SHADER, vsSrc));
  gl.attachShader(prog, mkShader(gl.FRAGMENT_SHADER, fsSrc));
  gl.linkProgram(prog);
  gl.useProgram(prog);

  const buf = gl.createBuffer();
  gl.bindBuffer(gl.ARRAY_BUFFER, buf);
  gl.bufferData(
    gl.ARRAY_BUFFER,
    new Float32Array([-1, -1, 1, -1, -1, 1, -1, 1, 1, -1, 1, 1]),
    gl.STATIC_DRAW
  );
  const aLoc = gl.getAttribLocation(prog, 'a');
  gl.enableVertexAttribArray(aLoc);
  gl.vertexAttribPointer(aLoc, 2, gl.FLOAT, false, 0, 0);

  const uRes        = gl.getUniformLocation(prog, 'u_res');
  const uTime       = gl.getUniformLocation(prog, 'u_time');
  const uIntensity  = gl.getUniformLocation(prog, 'u_intensity');
  const uBg         = gl.getUniformLocation(prog, 'u_bg');
  const uFluidMix   = gl.getUniformLocation(prog, 'u_fluidMix');

  function parseShaderBgRgb() {
    const raw = getComputedStyle(document.documentElement).getPropertyValue('--hr-shader-bg').trim();
    const parts = raw.split(/[\s,]+/).filter(Boolean).map(Number);
    if (parts.length >= 3 && parts.every((n) => Number.isFinite(n))) {
      return [parts[0] / 255, parts[1] / 255, parts[2] / 255];
    }
    return [0.025, 0.027, 0.035];
  }

  function parseFluidMix() {
    const v = parseFloat(
      getComputedStyle(document.documentElement).getPropertyValue('--hr-shader-fluid-mix').trim()
    );
    return Number.isFinite(v) ? v : 0.55;
  }

  const t0 = performance.now();
  let active = true;

  function frame() {
    if (!active) return;
    const t = ((performance.now() - t0) / 1000) * 0.5;
    const root = document.documentElement;
    const rawIntensity = parseFloat(getComputedStyle(root).getPropertyValue('--hr-shader-intensity').trim()) || 0.22;
    const [br, bg, bb] = parseShaderBgRgb();
    gl.uniform2f(uRes, canvas.width, canvas.height);
    gl.uniform1f(uTime, t);
    gl.uniform1f(uIntensity, rawIntensity);
    gl.uniform3f(uBg, br, bg, bb);
    gl.uniform1f(uFluidMix, parseFluidMix());
    gl.drawArrays(gl.TRIANGLES, 0, 6);
    requestAnimationFrame(frame);
  }
  frame();

  // Pause when off-screen to save GPU
  if (window.IntersectionObserver) {
    new IntersectionObserver(
      ([entry]) => { active = entry.isIntersecting; if (active) frame(); },
      { threshold: 0 }
    ).observe(canvas);
  }
})();


/* ────────────────────────────────────────────────────────────────────
   2. AI dots background — faithful port of ai-dots-background.blade.php
      Scoped to #hr-dots-panel (the right column behind the photo).
   ──────────────────────────────────────────────────────────────────── */
(function initHeroDots() {
  const root   = document.getElementById('hr-dots-panel');
  if (!root) return;
  const canvas = root.querySelector('.hr-dots-canvas');
  if (!canvas || !canvas.getContext) return;

  const ctx    = canvas.getContext('2d');
  let dots     = [];
  let spacing  = 22;

  const mouse = {
    x: -1000, y: -1000,
    px: -1000, py: -1000,
    speed: 0, radius: 120, ready: false,
  };
  const touch = window.AiDotsTouch;
  const ripples = touch ? touch.createRippleState() : { list: [] };
  let touchPrimary = touch ? touch.isTouchPrimary() : false;
  let unbindTouch = null;
  let mouseMoveHandler = null;

  const waveDefs = [
    {
      duration: 7500, alternateReverse: false, radius: 64, radiusPulse: 0.16, phase: 0.2,
      keys: [
        { x: -0.3, y: -0.1, rotate: -5,  scaleX: 0.95, scaleY: 0.72 },
        { x:  0,   y:  0.15, rotate:  3,  scaleX: 1.08, scaleY: 1.2  },
        { x:  0.3, y: -0.15, rotate: -2,  scaleX: 1.02, scaleY: 0.86 },
      ],
      segments: [
        [[-200,200],[100,50],[300,350],[600,200]],
        [[600,200],[900,50],[1100,350],[1400,200]],
      ],
    },
    {
      duration: 9500, alternateReverse: true, radius: 50, radiusPulse: 0.18, phase: 2.1,
      keys: [
        { x:  0.3, y:  0.15, rotate:  5, scaleX: 1.08, scaleY: 1.12 },
        { x:  0,   y: -0.1,  rotate: -2, scaleX: 0.92, scaleY: 0.84 },
        { x: -0.3, y:  0.1,  rotate:  3, scaleX: 1.12, scaleY: 1.28 },
      ],
      segments: [
        [[-200,200],[200,350],[400,50],[700,200]],
        [[700,200],[1000,350],[1200,50],[1400,200]],
      ],
    },
    {
      duration: 11000, alternateReverse: false, radius: 58, radiusPulse: 0.2, phase: 4.2,
      keys: [
        { x: -0.18, y:  0.18, rotate:  7, scaleX: 1.1,  scaleY: 0.78 },
        { x:  0.12, y: -0.06, rotate: -5, scaleX: 0.88, scaleY: 1.22 },
        { x:  0.24, y:  0.14, rotate:  4, scaleX: 1.04, scaleY: 0.96 },
      ],
      segments: [
        [[-200,180],[80,310],[280,90],[540,210]],
        [[540,210],[800,330],[980,80],[1400,180]],
      ],
    },
  ];

  function smoothstep(t) { return t < 0 ? 0 : t > 1 ? 1 : t * t * (3 - 2 * t); }
  function easeInOut(t)   { return 0.5 - Math.cos(t * Math.PI) * 0.5; }
  function lerp(a, b, t)  { return a + (b - a) * t; }
  function rotatePoint(x, y, deg) {
    const a = deg * Math.PI / 180, c = Math.cos(a), s = Math.sin(a);
    return { x: x * c - y * s, y: x * s + y * c };
  }
  function interpKeys(keys, p) {
    let st = keys[0], en = keys[1], l = p / 0.5;
    if (p > 0.5) { st = keys[1]; en = keys[2]; l = (p - 0.5) / 0.5; }
    l = easeInOut(l);
    return {
      x: lerp(st.x, en.x, l), y: lerp(st.y, en.y, l),
      rotate: lerp(st.rotate, en.rotate, l),
      scaleX: lerp(st.scaleX, en.scaleX, l),
      scaleY: lerp(st.scaleY, en.scaleY, l),
    };
  }
  function waveMotion(def, now) {
    const total = now / def.duration;
    const it    = Math.floor(total);
    let p       = total - it;
    if ((def.alternateReverse && it % 2 === 0) || (!def.alternateReverse && it % 2 === 1)) p = 1 - p;
    return interpKeys(def.keys, p);
  }
  function cubic(pts, t) {
    const m = 1 - t;
    return [
      m*m*m*pts[0][0] + 3*m*m*t*pts[1][0] + 3*m*t*t*pts[2][0] + t*t*t*pts[3][0],
      m*m*m*pts[0][1] + 3*m*m*t*pts[1][1] + 3*m*t*t*pts[2][1] + t*t*t*pts[3][1],
    ];
  }
  function distSeg(px, py, ax, ay, bx, by) {
    const vx = bx - ax, vy = by - ay, wx = px - ax, wy = py - ay;
    const len = vx * vx + vy * vy || 1;
    let t = (wx * vx + wy * vy) / len;
    t = Math.max(0, Math.min(1, t));
    return Math.hypot(px - (ax + vx * t), py - (ay + vy * t));
  }
  function distToPath(px, py, segs) {
    let closest = Infinity;
    for (let s = 0; s < segs.length; s++) {
      let last = cubic(segs[s], 0);
      for (let i = 1; i <= 22; i++) {
        const next = cubic(segs[s], i / 22);
        const d = distSeg(px, py, last[0], last[1], next[0], next[1]);
        if (d < closest) closest = d;
        last = next;
      }
    }
    return closest;
  }
  function toWaveVB(gx, gy, def, now, cw, ch) {
    let p  = rotatePoint(gx - cw * 0.5, gy - ch * 0.5, 10);
    let lx = p.x + cw, ly = p.y + ch * 0.5;
    const m = waveMotion(def, now);
    let x = lx - cw - m.x * cw, y = ly - ch * 0.5 - m.y * ch;
    p = rotatePoint(x, y, -m.rotate);
    x = p.x / m.scaleX + cw;
    y = p.y / m.scaleY + ch * 0.5;
    return { x: x / Math.max(cw * 2, 1) * 1000, y: y / Math.max(ch, 1) * 400 };
  }
  function waveBand(gx, gy, cw, ch, now) {
    let strongest = 0;
    for (let i = 0; i < waveDefs.length; i++) {
      const def = waveDefs[i];
      const p   = toWaveVB(gx, gy, def, now, cw, ch);
      const d   = distToPath(p.x, p.y, def.segments);
      const r   = def.radius * (1 + Math.sin(now * 0.00055 + def.phase) * def.radiusPulse);
      const band = 1 - smoothstep(d / r);
      if (band > strongest) strongest = band;
    }
    return strongest;
  }
  function visibility(gx, gy, cw, ch, now) {
    let v = waveBand(gx, gy, cw, ch, now);
    if (touchPrimary && touch) {
      v += touch.visibilityBoost(gx, gy, ripples, now, { maxRadius: 240 });
    } else if (mouse.ready) {
      const dx = mouse.x - gx, dy = mouse.y - gy;
      v += Math.exp(-(dx * dx + dy * dy) / (220 * 220)) * 0.7;
    }
    return Math.max(0, Math.min(1, v));
  }

  function Dot(x, y) { this.x = x; this.y = y; this.bx = x; this.by = y; this.vx = 0; this.vy = 0; }
  Dot.prototype.update = function (now) {
    if (touchPrimary && touch) {
      touch.applyRippleForces(this, ripples, now);
    } else {
      const dx = mouse.x - this.x, dy = mouse.y - this.y;
      const dist = Math.sqrt(dx * dx + dy * dy);
      if (dist < mouse.radius && mouse.speed > 0.5) {
        const force = (mouse.radius - dist) / mouse.radius;
        const ang   = Math.atan2(dy, dx);
        let pow     = mouse.speed * 0.005;
        if (pow > 1.2) pow = 1.2;
        this.vx -= Math.cos(ang) * force * pow;
        this.vy -= Math.sin(ang) * force * pow;
      }
    }
    this.x += this.vx; this.y += this.vy;
    this.vx *= 0.9;    this.vy *= 0.9;
    this.x  += (this.bx - this.x) * 0.007;
    this.y  += (this.by - this.y) * 0.007;
  };
  Dot.prototype.draw = function (now, rgb) {
    const v = visibility(this.bx, this.by, canvas.width, canvas.height, now);
    const r = 0.6 + (1.55 - 0.6) * v;
    const a = 0.18 + (1 - 0.18) * v;
    ctx.globalAlpha = a;
    ctx.fillStyle   = 'rgb(' + rgb + ')';
    ctx.beginPath();
    ctx.arc(this.x, this.y, r, 0, Math.PI * 2);
    ctx.fill();
    ctx.globalAlpha = 1;
  };

  function syncSize() {
    const w = Math.max(1, Math.floor(canvas.clientWidth));
    const h = Math.max(1, Math.floor(canvas.clientHeight));
    if (canvas.width !== w || canvas.height !== h) {
      canvas.width  = w;
      canvas.height = h;
    }
    const ds = parseInt(root.dataset.spacing, 10);
    if (ds >= 8 && ds <= 60) spacing = ds;
    dots = [];
    for (let x = 0; x <= canvas.width; x += spacing) {
      for (let y = 0; y <= canvas.height; y += spacing) {
        dots.push(new Dot(x, y));
      }
    }
  }

  function animate() {
    const now = performance.now();
    const rgb = getComputedStyle(root).getPropertyValue('--hr-dots-dot').trim() || '165, 180, 252';
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    if (touchPrimary && touch) {
      touch.pruneRipples(ripples, now);
    } else {
      let ds = Math.hypot(mouse.x - mouse.px, mouse.y - mouse.py);
      if (ds > 72) ds = 72;
      mouse.speed += (ds - mouse.speed) * 0.1;
      mouse.px = mouse.x;
      mouse.py = mouse.y;
    }
    for (let i = 0; i < dots.length; i++) {
      dots[i].update(now);
      dots[i].draw(now, rgb);
    }
    requestAnimationFrame(animate);
  }

  function onMouseMove(e) {
    if ('pointerType' in e && e.pointerType === 'touch') return;
    const rect = canvas.getBoundingClientRect();
    mouse.x = e.clientX - rect.left;
    mouse.y = e.clientY - rect.top;
    if (!mouse.ready) {
      mouse.px = mouse.x; mouse.py = mouse.y; mouse.speed = 0; mouse.ready = true;
    }
  }

  function applyInteractionMode(isTouch) {
    touchPrimary = isTouch;
    mouse.ready = false;
    mouse.x = -1000;
    mouse.y = -1000;
    mouse.speed = 0;
    if (unbindTouch) {
      unbindTouch();
      unbindTouch = null;
    }
    if (mouseMoveHandler) {
      window.removeEventListener('mousemove', mouseMoveHandler);
      mouseMoveHandler = null;
    }
    if (isTouch && touch) {
      unbindTouch = touch.bindTouchRipples(canvas, ripples);
    } else {
      ripples.list.length = 0;
      mouseMoveHandler = onMouseMove;
      window.addEventListener('mousemove', mouseMoveHandler, { passive: true });
    }
  }

  applyInteractionMode(touchPrimary);
  if (touch) {
    touch.watchTouchMode(applyInteractionMode);
  } else {
    mouseMoveHandler = onMouseMove;
    window.addEventListener('mousemove', mouseMoveHandler, { passive: true });
  }

  window.addEventListener('resize', syncSize);
  if (window.ResizeObserver) {
    new ResizeObserver(syncSize).observe(canvas.parentElement || root);
  }
  syncSize();
  animate();
})();
