/**
 * ══════════════════════════════════════════════════════════════
 *  Apartment Designer - صمم شقتك بنفسك
 *  Interactive Floor Plan Drawing Tool for Real Estate
 * ══════════════════════════════════════════════════════════════
 */
const ApartmentDesigner = (() => {
    'use strict';

    // ════════════════════════════════════════════
    //  CONSTANTS
    // ════════════════════════════════════════════

    const PX_PER_M = 40;               // 1 meter = 40 pixels (at zoom 1×)
    const GRID      = PX_PER_M / 2;    // 20 px = 0.5 m (minor grid)
    const MIN_ZOOM  = 0.25;
    const MAX_ZOOM  = 3;
    const ZOOM_STEP = 0.1;

    // Room type catalogue
    const ROOM_TYPES = {
        bedroom:  { ar: 'غرفة نوم',  en: 'Bedroom',     color: '#BBDEFB', border: '#1565C0', icon: '🛏️', minArea: 12 },
        bathroom: { ar: 'حمام',      en: 'Bathroom',    color: '#C8E6C9', border: '#2E7D32', icon: '🚿', minArea: 4  },
        living:   { ar: 'صالة',      en: 'Living Room', color: '#FFE0B2', border: '#E65100', icon: '🛋️', minArea: 20 },
        kitchen:  { ar: 'مطبخ',      en: 'Kitchen',     color: '#F8BBD0', border: '#AD1457', icon: '🍳', minArea: 8  },
        balcony:  { ar: 'بلكونة',    en: 'Balcony',     color: '#E1BEE7', border: '#6A1B9A', icon: '🌿', minArea: 3  },
        hallway:  { ar: 'مدخل/ممر',  en: 'Hallway',     color: '#CFD8DC', border: '#37474F', icon: '🚪', minArea: 4  },
        dining:   { ar: 'سفرة',      en: 'Dining',      color: '#DCEDC8', border: '#558B2F', icon: '🍽️', minArea: 10 },
        storage:  { ar: 'مخزن',      en: 'Storage',     color: '#D7CCC8', border: '#4E342E', icon: '📦', minArea: 2  },
    };

    // ════════════════════════════════════════════
    //  STATE
    // ════════════════════════════════════════════

    let isAr = true;
    const t = (ar, en) => isAr ? ar : en;

    let S = {
        canvas: null, ctx: null,
        zoom: 1, panX: 0, panY: 0,
        isPanning: false, panStart: { x: 0, y: 0 },

        tool: 'select',            // select | room | delete
        roomType: 'bedroom',       // current room type brush
        drawing: false,
        drawStart: null,
        drawCur: null,

        floors: [{ id: 0, name: '', rooms: [] }],
        floor: 0,                  // current floor index

        sel: null,                 // selected room ref
        drag: null,                // 'move' | handle direction
        dragOff: { x: 0, y: 0 },

        northAngle: 0,

        history: [], histIdx: -1, maxHist: 50,
        suggestions: [],
    };

    const $ = id => document.getElementById(id);
    const uid = () => 'r' + Date.now().toString(36) + Math.random().toString(36).slice(2, 6);
    const snap = v => Math.round(v / GRID) * GRID;
    const m2px = m => m * PX_PER_M;
    const px2m = p => p / PX_PER_M;
    const s2w = (sx, sy) => ({ x: (sx - S.panX) / S.zoom, y: (sy - S.panY) / S.zoom });
    const w2s = (wx, wy) => ({ x: wx * S.zoom + S.panX, y: wy * S.zoom + S.panY });
    const floorData = () => S.floors[S.floor];

    // ════════════════════════════════════════════
    //  INITIALIZATION
    // ════════════════════════════════════════════

    function init(opts = {}) {
        isAr = opts.isArabic !== false;
        S.floors[0].name = t('الدور 1', 'Floor 1');

        S.canvas = $('designerCanvas');
        S.ctx = S.canvas.getContext('2d');
        resize();
        window.addEventListener('resize', resize);

        S.panX = S.canvas.width / 2 - 240;
        S.panY = S.canvas.height / 2 - 200;

        bindCanvas();
        bindUI();
        pushHistory();
        render();
    }

    function resize() {
        const p = S.canvas.parentElement;
        S.canvas.width = p.clientWidth;
        S.canvas.height = p.clientHeight;
        render();
    }

    // ════════════════════════════════════════════
    //  CANVAS EVENTS
    // ════════════════════════════════════════════

    function bindCanvas() {
        const c = S.canvas;
        c.addEventListener('mousedown', onDown);
        c.addEventListener('mousemove', onMove);
        c.addEventListener('mouseup', onUp);
        c.addEventListener('wheel', onWheel, { passive: false });
        c.addEventListener('contextmenu', e => e.preventDefault());
        c.addEventListener('touchstart', onTouchStart, { passive: false });
        c.addEventListener('touchmove', onTouchMove, { passive: false });
        c.addEventListener('touchend', onTouchEnd);
        document.addEventListener('keydown', onKey);
    }

    function mpos(e) {
        const r = S.canvas.getBoundingClientRect();
        return { x: e.clientX - r.left, y: e.clientY - r.top };
    }

    // ── Mouse down ──
    function onDown(e) {
        const p = mpos(e);
        // Pan with middle-click or alt+click
        if (e.button === 1 || (e.button === 0 && e.altKey)) {
            S.isPanning = true;
            S.panStart = { x: p.x - S.panX, y: p.y - S.panY };
            S.canvas.style.cursor = 'grabbing';
            return;
        }
        if (e.button !== 0) return;
        const w = s2w(p.x, p.y);
        const sn = { x: snap(w.x), y: snap(w.y) };

        if (S.tool === 'select')  selectDown(w, sn);
        if (S.tool === 'room')    roomDrawStart(sn);
        if (S.tool === 'delete')  deleteTool(w);
    }

    // ── Mouse move ──
    function onMove(e) {
        const p = mpos(e);
        if (S.isPanning) {
            S.panX = p.x - S.panStart.x;
            S.panY = p.y - S.panStart.y;
            render(); return;
        }
        const w = s2w(p.x, p.y);
        const sn = { x: snap(w.x), y: snap(w.y) };

        if (S.tool === 'select') selectMove(w, sn);
        if (S.tool === 'room' && S.drawing) { S.drawCur = sn; render(); }
        setCursor(w);
    }

    // ── Mouse up ──
    function onUp(e) {
        if (S.isPanning) { S.isPanning = false; S.canvas.style.cursor = ''; return; }
        const p = mpos(e);
        const w = s2w(p.x, p.y);
        const sn = { x: snap(w.x), y: snap(w.y) };

        if (S.tool === 'select') selectUp();
        if (S.tool === 'room' && S.drawing) roomDrawEnd(sn);
    }

    // ── Wheel (zoom) ──
    function onWheel(e) {
        e.preventDefault();
        const p = mpos(e);
        const w = s2w(p.x, p.y);
        const d = e.deltaY > 0 ? -ZOOM_STEP : ZOOM_STEP;
        const nz = Math.max(MIN_ZOOM, Math.min(MAX_ZOOM, S.zoom + d));
        S.panX = p.x - w.x * nz;
        S.panY = p.y - w.y * nz;
        S.zoom = nz;
        if ($('zoomLevel')) $('zoomLevel').textContent = Math.round(S.zoom * 100) + '%';
        render();
    }

    // ── Keyboard ──
    function onKey(e) {
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'SELECT' || e.target.tagName === 'TEXTAREA') return;
        if (e.ctrlKey && e.key === 'z') { e.preventDefault(); undo(); }
        if (e.ctrlKey && e.key === 'y') { e.preventDefault(); redo(); }
        if (e.key === 'Delete' || e.key === 'Backspace') {
            if (S.sel) { deleteRoom(S.sel.id); S.sel = null; pushHistory(); updateProps(); suggest(); render(); }
        }
        if (e.key === 'Escape') { S.sel = null; S.drawing = false; updateProps(); render(); }
    }

    // ── Touch ──
    let lastTD = 0;
    function onTouchStart(e) {
        e.preventDefault();
        if (e.touches.length === 2) {
            lastTD = Math.hypot(e.touches[0].clientX - e.touches[1].clientX, e.touches[0].clientY - e.touches[1].clientY);
            return;
        }
        const t = e.touches[0];
        onDown({ clientX: t.clientX, clientY: t.clientY, button: 0, altKey: false });
    }
    function onTouchMove(e) {
        e.preventDefault();
        if (e.touches.length === 2) {
            const d = Math.hypot(e.touches[0].clientX - e.touches[1].clientX, e.touches[0].clientY - e.touches[1].clientY);
            S.zoom = Math.max(MIN_ZOOM, Math.min(MAX_ZOOM, S.zoom + (d - lastTD) * 0.004));
            lastTD = d;
            render(); return;
        }
        const t = e.touches[0];
        onMove({ clientX: t.clientX, clientY: t.clientY });
    }
    function onTouchEnd() { onUp({ clientX: 0, clientY: 0 }); }

    // ════════════════════════════════════════════
    //  TOOL HANDLERS
    // ════════════════════════════════════════════

    // ── SELECT ──
    function selectDown(w, sn) {
        // Check resize handles first
        if (S.sel) {
            const h = hitHandle(w, S.sel);
            if (h) { S.drag = h; return; }
        }
        const room = roomAt(w.x, w.y);
        if (room) {
            S.sel = room;
            S.drag = 'move';
            S.dragOff = { x: w.x - room.x, y: w.y - room.y };
        } else {
            S.sel = null; S.drag = null;
        }
        updateProps(); render();
    }

    function selectMove(w, sn) {
        if (!S.drag || !S.sel) return;
        const r = S.sel;
        if (S.drag === 'move') {
            r.x = snap(w.x - S.dragOff.x);
            r.y = snap(w.y - S.dragOff.y);
        } else {
            resizeByHandle(r, S.drag, sn);
        }
        r.area = px2m(r.w) * px2m(r.h);
        updateProps(); render();
    }

    function selectUp() {
        if (S.drag) { pushHistory(); suggest(); }
        S.drag = null;
    }

    // ── ROOM DRAW ──
    function roomDrawStart(sn) {
        S.drawing = true;
        S.drawStart = { ...sn };
        S.drawCur = { ...sn };
    }

    function roomDrawEnd(sn) {
        S.drawing = false;
        const x = Math.min(S.drawStart.x, sn.x);
        const y = Math.min(S.drawStart.y, sn.y);
        const w = Math.abs(sn.x - S.drawStart.x);
        const h = Math.abs(sn.y - S.drawStart.y);
        if (w < PX_PER_M || h < PX_PER_M) { render(); return; } // too small
        const room = makeRoom(S.roomType, x, y, w, h);
        floorData().rooms.push(room);
        S.sel = room;
        pushHistory(); updateProps(); suggest(); render();
    }

    // ── DELETE TOOL ──
    function deleteTool(w) {
        const room = roomAt(w.x, w.y);
        if (room) {
            deleteRoom(room.id);
            S.sel = null;
            pushHistory(); updateProps(); suggest(); render();
        }
    }

    // ════════════════════════════════════════════
    //  ROOM CRUD
    // ════════════════════════════════════════════

    function makeRoom(type, x, y, w, h) {
        const info = ROOM_TYPES[type];
        const cnt = floorData().rooms.filter(r => r.type === type).length + 1;
        return {
            id: uid(), type,
            x, y, w, h,
            area: px2m(w) * px2m(h),
            label: info[isAr ? 'ar' : 'en'] + ' ' + cnt,
        };
    }

    function deleteRoom(id) {
        const fd = floorData();
        fd.rooms = fd.rooms.filter(r => r.id !== id);
    }

    function roomAt(wx, wy) {
        const rooms = floorData().rooms;
        for (let i = rooms.length - 1; i >= 0; i--) {
            const r = rooms[i];
            if (wx >= r.x && wx <= r.x + r.w && wy >= r.y && wy <= r.y + r.h) return r;
        }
        return null;
    }

    // ── Resize handles ──
    function handlePoints(r) {
        return {
            nw: { x: r.x,              y: r.y },
            n:  { x: r.x + r.w / 2,    y: r.y },
            ne: { x: r.x + r.w,        y: r.y },
            e:  { x: r.x + r.w,        y: r.y + r.h / 2 },
            se: { x: r.x + r.w,        y: r.y + r.h },
            s:  { x: r.x + r.w / 2,    y: r.y + r.h },
            sw: { x: r.x,              y: r.y + r.h },
            w:  { x: r.x,              y: r.y + r.h / 2 },
        };
    }

    function hitHandle(w, room) {
        const sz = 8 / S.zoom;
        for (const [name, pt] of Object.entries(handlePoints(room))) {
            if (Math.abs(w.x - pt.x) < sz && Math.abs(w.y - pt.y) < sz) return name;
        }
        return null;
    }

    function resizeByHandle(r, h, sn) {
        const min = PX_PER_M;
        const ex = r.x + r.w, ey = r.y + r.h;
        if (h.includes('e')) r.w = Math.max(min, sn.x - r.x);
        if (h.includes('s')) r.h = Math.max(min, sn.y - r.y);
        if (h.includes('w')) { const nw = ex - sn.x; if (nw >= min) { r.w = nw; r.x = sn.x; } }
        if (h.includes('n')) { const nh = ey - sn.y; if (nh >= min) { r.h = nh; r.y = sn.y; } }
        // single axis
        if (h === 'n') { const nh = ey - sn.y; if (nh >= min) { r.h = nh; r.y = sn.y; } }
        if (h === 's') r.h = Math.max(min, sn.y - r.y);
        if (h === 'e') r.w = Math.max(min, sn.x - r.x);
        if (h === 'w') { const nw = ex - sn.x; if (nw >= min) { r.w = nw; r.x = sn.x; } }
    }

    function setCursor(w) {
        if (S.tool === 'room')   { S.canvas.style.cursor = 'crosshair'; return; }
        if (S.tool === 'delete') { S.canvas.style.cursor = 'pointer'; return; }
        if (S.sel) {
            const h = hitHandle(w, S.sel);
            if (h) {
                const map = { nw:'nw-resize',ne:'ne-resize',sw:'sw-resize',se:'se-resize',n:'n-resize',s:'s-resize',e:'e-resize',w:'w-resize' };
                S.canvas.style.cursor = map[h]; return;
            }
        }
        S.canvas.style.cursor = roomAt(w.x, w.y) ? 'move' : 'default';
    }

    // ════════════════════════════════════════════
    //  RENDERING
    // ════════════════════════════════════════════

    function render() {
        if (!S.ctx) return;
        const ctx = S.ctx, W = S.canvas.width, H = S.canvas.height;
        ctx.fillStyle = '#0f172a';
        ctx.fillRect(0, 0, W, H);

        ctx.save();
        ctx.translate(S.panX, S.panY);
        ctx.scale(S.zoom, S.zoom);

        drawGrid(ctx);
        floorData().rooms.forEach(r => drawRoom(ctx, r));
        if (S.sel) drawSelection(ctx, S.sel);
        if (S.drawing && S.drawStart && S.drawCur) drawPreview(ctx);

        ctx.restore();

        drawCompass(ctx);
        drawInfo(ctx);
    }

    // ── Grid ──
    function drawGrid(ctx) {
        const b = visBounds();
        const sx = Math.floor(b.l / GRID) * GRID;
        const sy = Math.floor(b.t / GRID) * GRID;
        const ex = Math.ceil(b.r / GRID) * GRID;
        const ey = Math.ceil(b.b / GRID) * GRID;

        // Minor grid
        ctx.strokeStyle = 'rgba(51,65,85,0.25)';
        ctx.lineWidth = 0.5 / S.zoom;
        ctx.beginPath();
        for (let x = sx; x <= ex; x += GRID) { if (x % (GRID * 2) === 0) continue; ctx.moveTo(x, sy); ctx.lineTo(x, ey); }
        for (let y = sy; y <= ey; y += GRID) { if (y % (GRID * 2) === 0) continue; ctx.moveTo(sx, y); ctx.lineTo(ex, y); }
        ctx.stroke();

        // Major grid (1 m)
        ctx.strokeStyle = 'rgba(71,85,105,0.45)';
        ctx.lineWidth = 1 / S.zoom;
        ctx.beginPath();
        for (let x = sx; x <= ex; x += GRID * 2) { ctx.moveTo(x, sy); ctx.lineTo(x, ey); }
        for (let y = sy; y <= ey; y += GRID * 2) { ctx.moveTo(sx, y); ctx.lineTo(ex, y); }
        ctx.stroke();

        // Origin dot
        ctx.fillStyle = 'rgba(99,102,241,0.5)';
        ctx.beginPath(); ctx.arc(0, 0, 4 / S.zoom, 0, Math.PI * 2); ctx.fill();
    }

    function visBounds() {
        return {
            l: -S.panX / S.zoom,
            t: -S.panY / S.zoom,
            r: (S.canvas.width - S.panX) / S.zoom,
            b: (S.canvas.height - S.panY) / S.zoom,
        };
    }

    // ── Room ──
    function drawRoom(ctx, r) {
        const T = ROOM_TYPES[r.type] || ROOM_TYPES.bedroom;

        // Fill
        ctx.fillStyle = T.color + 'CC';
        ctx.beginPath();
        roundRect(ctx, r.x, r.y, r.w, r.h, 3 / S.zoom);
        ctx.fill();

        // Border
        ctx.strokeStyle = T.border;
        ctx.lineWidth = 2 / S.zoom;
        ctx.beginPath();
        roundRect(ctx, r.x, r.y, r.w, r.h, 3 / S.zoom);
        ctx.stroke();

        // Labels
        const fs = Math.max(10, 13 / S.zoom);
        const cx = r.x + r.w / 2, cy = r.y + r.h / 2;

        // Icon
        ctx.font = `${fs * 1.6}px 'Segoe UI Emoji','Segoe UI'`;
        ctx.textAlign = 'center'; ctx.textBaseline = 'middle';
        ctx.fillStyle = T.border;
        ctx.fillText(T.icon, cx, cy - fs * 0.8);

        // Name
        ctx.font = `bold ${fs}px 'Segoe UI',Tahoma,sans-serif`;
        ctx.fillStyle = '#1e293b';
        ctx.fillText(r.label, cx, cy + fs * 0.6);

        // Area
        ctx.font = `${fs * 0.8}px 'Segoe UI'`;
        ctx.fillStyle = '#475569';
        ctx.fillText(r.area.toFixed(1) + ' m²', cx, cy + fs * 1.7);

        // Edge dimensions
        if (S.zoom >= 0.45) {
            const df = Math.max(8, 10 / S.zoom);
            ctx.font = `${df}px 'Segoe UI'`;
            ctx.fillStyle = '#94a3b8';
            ctx.textAlign = 'center';
            ctx.fillText(px2m(r.w).toFixed(1) + 'm', cx, r.y - 5 / S.zoom);
            ctx.save();
            ctx.translate(r.x + r.w + 12 / S.zoom, cy);
            ctx.rotate(Math.PI / 2);
            ctx.fillText(px2m(r.h).toFixed(1) + 'm', 0, 0);
            ctx.restore();
        }
    }

    function roundRect(ctx, x, y, w, h, rad) {
        ctx.moveTo(x + rad, y);
        ctx.lineTo(x + w - rad, y);
        ctx.quadraticCurveTo(x + w, y, x + w, y + rad);
        ctx.lineTo(x + w, y + h - rad);
        ctx.quadraticCurveTo(x + w, y + h, x + w - rad, y + h);
        ctx.lineTo(x + rad, y + h);
        ctx.quadraticCurveTo(x, y + h, x, y + h - rad);
        ctx.lineTo(x, y + rad);
        ctx.quadraticCurveTo(x, y, x + rad, y);
    }

    // ── Selection ──
    function drawSelection(ctx, r) {
        ctx.strokeStyle = '#60a5fa';
        ctx.lineWidth = 2 / S.zoom;
        ctx.setLineDash([6 / S.zoom, 4 / S.zoom]);
        ctx.strokeRect(r.x - 2 / S.zoom, r.y - 2 / S.zoom, r.w + 4 / S.zoom, r.h + 4 / S.zoom);
        ctx.setLineDash([]);

        const sz = 5 / S.zoom;
        ctx.fillStyle = '#3b82f6'; ctx.strokeStyle = '#fff'; ctx.lineWidth = 1.5 / S.zoom;
        Object.values(handlePoints(r)).forEach(p => {
            ctx.fillRect(p.x - sz, p.y - sz, sz * 2, sz * 2);
            ctx.strokeRect(p.x - sz, p.y - sz, sz * 2, sz * 2);
        });
    }

    // ── Draw preview ──
    function drawPreview(ctx) {
        const x = Math.min(S.drawStart.x, S.drawCur.x);
        const y = Math.min(S.drawStart.y, S.drawCur.y);
        const w = Math.abs(S.drawCur.x - S.drawStart.x);
        const h = Math.abs(S.drawCur.y - S.drawStart.y);
        const T = ROOM_TYPES[S.roomType];

        ctx.fillStyle = T.color + '55';
        ctx.fillRect(x, y, w, h);
        ctx.strokeStyle = T.border;
        ctx.lineWidth = 2 / S.zoom;
        ctx.setLineDash([8 / S.zoom, 4 / S.zoom]);
        ctx.strokeRect(x, y, w, h);
        ctx.setLineDash([]);

        if (w > 0 && h > 0) {
            const fs = Math.max(11, 13 / S.zoom);
            ctx.font = `bold ${fs}px 'Segoe UI'`;
            ctx.fillStyle = '#e2e8f0';
            ctx.textAlign = 'center'; ctx.textBaseline = 'middle';
            ctx.fillText(
                px2m(w).toFixed(1) + 'm × ' + px2m(h).toFixed(1) + 'm',
                x + w / 2, y + h / 2 - fs * 0.6
            );
            ctx.fillText(
                (px2m(w) * px2m(h)).toFixed(1) + ' m²',
                x + w / 2, y + h / 2 + fs * 0.6
            );
        }
    }

    // ── Compass ──
    function drawCompass(ctx) {
        const cx = S.canvas.width - 55, cy = 75, r = 30;
        ctx.save(); ctx.translate(cx, cy);
        ctx.rotate(S.northAngle * Math.PI / 180);

        ctx.fillStyle = 'rgba(15,23,42,0.88)';
        ctx.beginPath(); ctx.arc(0, 0, r + 4, 0, Math.PI * 2); ctx.fill();
        ctx.strokeStyle = '#334155'; ctx.lineWidth = 1.5; ctx.stroke();

        // North
        ctx.fillStyle = '#ef4444';
        ctx.beginPath(); ctx.moveTo(0, -r + 4); ctx.lineTo(-7, 4); ctx.lineTo(0, -1); ctx.closePath(); ctx.fill();
        // South
        ctx.fillStyle = '#64748b';
        ctx.beginPath(); ctx.moveTo(0, r - 4); ctx.lineTo(7, -4); ctx.lineTo(0, 1); ctx.closePath(); ctx.fill();

        ctx.font = 'bold 11px sans-serif'; ctx.textAlign = 'center'; ctx.textBaseline = 'middle';
        ctx.fillStyle = '#ef4444'; ctx.fillText('N', 0, -r - 9);
        ctx.fillStyle = '#64748b'; ctx.fillText('S', 0, r + 9);

        ctx.restore();
    }

    // ── Info overlay ──
    function drawInfo(ctx) {
        const rooms = floorData().rooms;
        if (rooms.length === 0) return;
        const total = rooms.reduce((s, r) => s + r.area, 0);
        const txt = t('المساحة الكلية: ', 'Total Area: ') + total.toFixed(1) + ' m²';
        ctx.font = '13px "Segoe UI",Tahoma,sans-serif';
        ctx.fillStyle = '#94a3b8';
        ctx.textAlign = isAr ? 'right' : 'left';
        ctx.fillText(txt, isAr ? S.canvas.width - 15 : 15, S.canvas.height - 15);
    }

    // ════════════════════════════════════════════
    //  UNDO / REDO
    // ════════════════════════════════════════════

    function pushHistory() {
        S.histIdx++;
        S.history = S.history.slice(0, S.histIdx);
        S.history.push(JSON.stringify(S.floors));
        if (S.history.length > S.maxHist) { S.history.shift(); S.histIdx--; }
    }

    function undo() {
        if (S.histIdx <= 0) return;
        S.histIdx--;
        S.floors = JSON.parse(S.history[S.histIdx]);
        S.sel = null; updateProps(); updateFloorTabs(); suggest(); render();
    }

    function redo() {
        if (S.histIdx >= S.history.length - 1) return;
        S.histIdx++;
        S.floors = JSON.parse(S.history[S.histIdx]);
        S.sel = null; updateProps(); updateFloorTabs(); suggest(); render();
    }

    // ════════════════════════════════════════════
    //  SUGGESTIONS ENGINE
    // ════════════════════════════════════════════

    function suggest() {
        const rooms = floorData().rooms;
        const sg = [];
        if (rooms.length === 0) { S.suggestions = []; renderSuggestions(); return; }

        // 1. Min-size check
        rooms.forEach(r => {
            const T = ROOM_TYPES[r.type];
            if (T && r.area < T.minArea) {
                sg.push({ type: 'warning', icon: '⚠️',
                    text: t(
                        `${r.label} صغيرة (${r.area.toFixed(1)}م²) — الحد الأدنى ${T.minArea}م²`,
                        `${r.label} too small (${r.area.toFixed(1)}m²) — min ${T.minArea}m²`
                    )
                });
            }
        });

        // 2. Aspect ratio check
        rooms.forEach(r => {
            const ratio = Math.max(r.w, r.h) / Math.min(r.w, r.h);
            if (ratio > 3.5) {
                sg.push({ type: 'tip', icon: '📏',
                    text: t(
                        `${r.label} ضيقة جداً — يفضل تعديل النسب`,
                        `${r.label} is too narrow — adjust proportions`
                    )
                });
            }
        });

        // 3. Kitchen on exterior
        const kitchens = rooms.filter(r => r.type === 'kitchen');
        const allBounds = roomsBounds(rooms);
        kitchens.forEach(k => {
            if (!isOnEdge(k, allBounds)) {
                sg.push({ type: 'tip', icon: '💨',
                    text: t('المطبخ لازم يكون على حائط خارجي للتهوية', 'Kitchen needs exterior wall for ventilation')
                });
            }
        });

        // 4. Need bathroom
        const beds = rooms.filter(r => r.type === 'bedroom');
        const baths = rooms.filter(r => r.type === 'bathroom');
        if (beds.length > 0 && baths.length === 0) {
            sg.push({ type: 'warning', icon: '🚿',
                text: t('لازم يكون فيه حمام واحد على الأقل!', 'At least one bathroom needed!')
            });
        }

        // 5. Living room suggestion
        const living = rooms.filter(r => r.type === 'living');
        if (living.length > 0) {
            sg.push({ type: 'info', icon: '☀️',
                text: t(
                    'الصالة يفضل تكون في الاتجاه البحري (الشمال) للتهوية',
                    'Living room best facing North (بحري) for ventilation'
                )
            });
        }

        // 6. Living too large
        const totalA = rooms.reduce((s, r) => s + r.area, 0);
        const livingA = living.reduce((s, r) => s + r.area, 0);
        if (totalA > 0 && livingA / totalA > 0.40) {
            sg.push({ type: 'tip', icon: '📐',
                text: t('الصالة كبيرة جداً — ممكن تقسمها صالة + سفرة', 'Living room too large — split into living + dining')
            });
        }

        // 7. Bathroom near bedroom
        beds.forEach(bed => {
            const near = baths.some(b => {
                return Math.hypot((bed.x + bed.w / 2) - (b.x + b.w / 2), (bed.y + bed.h / 2) - (b.y + b.h / 2)) < m2px(8);
            });
            if (!near && baths.length > 0) {
                sg.push({ type: 'tip', icon: '🛏️',
                    text: t(`${bed.label} بعيدة عن الحمام`, `${bed.label} far from bathroom`)
                });
            }
        });

        // 8. Overlap detection
        for (let i = 0; i < rooms.length; i++) {
            for (let j = i + 1; j < rooms.length; j++) {
                const a = rooms[i], b = rooms[j];
                if (!(a.x + a.w <= b.x || b.x + b.w <= a.x || a.y + a.h <= b.y || b.y + b.h <= a.y)) {
                    sg.push({ type: 'error', icon: '❌',
                        text: t(`${a.label} و ${b.label} متداخلين!`, `${a.label} and ${b.label} overlap!`)
                    });
                }
            }
        }

        // 9. Praise
        if (sg.length === 0 && rooms.length >= 3) {
            sg.push({ type: 'success', icon: '✅', text: t('تصميم ممتاز! التوزيع متوازن 👏', 'Excellent design! Well-balanced layout 👏') });
        }

        S.suggestions = sg;
        renderSuggestions();
    }

    function roomsBounds(rooms) {
        if (!rooms.length) return { x1: 0, y1: 0, x2: 0, y2: 0 };
        return {
            x1: Math.min(...rooms.map(r => r.x)),
            y1: Math.min(...rooms.map(r => r.y)),
            x2: Math.max(...rooms.map(r => r.x + r.w)),
            y2: Math.max(...rooms.map(r => r.y + r.h)),
        };
    }

    function isOnEdge(r, b) {
        const m = GRID;
        return r.x <= b.x1 + m || r.y <= b.y1 + m || r.x + r.w >= b.x2 - m || r.y + r.h >= b.y2 - m;
    }

    function renderSuggestions() {
        const el = $('suggestionsContent');
        if (!el) return;
        if (!S.suggestions.length) {
            el.innerHTML = `<p class="ad-sug-empty">${t('ابدأ ارسم وهنعطيك اقتراحات ذكية! 💡', 'Start drawing for smart suggestions! 💡')}</p>`;
            return;
        }
        el.innerHTML = S.suggestions.map(s =>
            `<div class="ad-sug ad-sug-${s.type}"><span class="ad-sug-icon">${s.icon}</span><span>${s.text}</span></div>`
        ).join('');
    }

    // ════════════════════════════════════════════
    //  AUTO DESIGN
    // ════════════════════════════════════════════

    function autoDesign(params) {
        const { totalArea, bedrooms, bathrooms, orientation } = params;
        const fd = floorData();
        fd.rooms = [];

        // Apartment dimensions (slightly rectangular)
        const ratio = 1.35;
        const hM = Math.sqrt(totalArea / ratio);
        const wM = totalArea / hM;
        const wPx = m2px(wM), hPx = m2px(hM);

        const ox = 80, oy = 80; // origin offset

        // ── Hallway strip on top ──
        const hallH = m2px(Math.max(1.5, Math.min(2, hM * 0.12)));
        fd.rooms.push(makeRoom('hallway', ox, oy, snap(wPx), snap(hallH)));

        const usableH = hPx - hallH;

        // ── Left column: bedrooms ──
        const bedColW = snap(wPx * 0.38);
        const bedH = snap(usableH / Math.max(1, bedrooms));
        for (let i = 0; i < bedrooms; i++) {
            fd.rooms.push(makeRoom('bedroom', ox, oy + snap(hallH) + i * bedH, bedColW, bedH));
        }

        // ── Right column: kitchen + bathrooms ──
        const rightColW = snap(wPx * 0.24);
        const rightX = ox + snap(wPx) - rightColW;

        // Kitchen
        const kitchenH = snap(usableH * 0.35);
        fd.rooms.push(makeRoom('kitchen', rightX, oy + snap(hallH), rightColW, kitchenH));

        // Bathrooms
        const bathTotalH = usableH - px2m(kitchenH) * PX_PER_M;
        const bathH = snap(bathTotalH / Math.max(1, bathrooms));
        for (let i = 0; i < bathrooms; i++) {
            fd.rooms.push(makeRoom('bathroom', rightX, oy + snap(hallH) + kitchenH + i * bathH, rightColW, bathH));
        }

        // ── Center: living room ──
        const livingW = snap(wPx) - bedColW - rightColW;
        const livingH = snap(usableH);
        fd.rooms.push(makeRoom('living', ox + bedColW, oy + snap(hallH), livingW, livingH));

        // ── Balcony (if large enough) ──
        if (totalArea >= 80) {
            const balW = livingW;
            const balH = snap(m2px(2));
            fd.rooms.push(makeRoom('balcony', ox + bedColW, oy + snap(hallH) + livingH, balW, balH));
        }

        // Orientation
        if (orientation) {
            const angles = { N: 0, NE: 45, E: 90, SE: 135, S: 180, SW: 225, W: 270, NW: 315 };
            S.northAngle = angles[orientation] || 0;
            const slider = $('compassSlider');
            if (slider) slider.value = S.northAngle;
        }

        S.sel = null;
        pushHistory(); updateProps(); updateFloorTabs(); suggest(); centerView(); render();
    }

    function centerView() {
        const rooms = floorData().rooms;
        if (!rooms.length) return;
        const b = roomsBounds(rooms);
        const cx = (b.x1 + b.x2) / 2, cy = (b.y1 + b.y2) / 2;
        const dw = b.x2 - b.x1, dh = b.y2 - b.y1;
        const pad = 80;
        const sx = (S.canvas.width - pad * 2) / (dw || 1);
        const sy = (S.canvas.height - pad * 2) / (dh || 1);
        S.zoom = Math.min(sx, sy, 2);
        S.panX = S.canvas.width / 2 - cx * S.zoom;
        S.panY = S.canvas.height / 2 - cy * S.zoom;
        if ($('zoomLevel')) $('zoomLevel').textContent = Math.round(S.zoom * 100) + '%';
    }

    // ════════════════════════════════════════════
    //  MULTI-FLOOR
    // ════════════════════════════════════════════

    function addFloor() {
        const i = S.floors.length;
        S.floors.push({ id: i, name: t('الدور ' + (i + 1), 'Floor ' + (i + 1)), rooms: [] });
        S.floor = i; S.sel = null;
        pushHistory(); updateFloorTabs(); updateProps(); render();
    }

    function dupFloor() {
        const i = S.floors.length;
        const cur = floorData();
        S.floors.push({
            id: i, name: t('الدور ' + (i + 1), 'Floor ' + (i + 1)),
            rooms: JSON.parse(JSON.stringify(cur.rooms)).map(r => ({ ...r, id: uid() })),
        });
        S.floor = i; S.sel = null;
        pushHistory(); updateFloorTabs(); updateProps(); render();
    }

    function switchFloor(idx) {
        S.floor = idx; S.sel = null;
        updateFloorTabs(); updateProps(); suggest(); render();
    }

    function updateFloorTabs() {
        const el = $('floorTabs');
        if (!el) return;
        el.innerHTML = S.floors.map((f, i) =>
            `<button class="ad-ftab${i === S.floor ? ' active' : ''}" onclick="ApartmentDesigner.switchFloor(${i})">${f.name}</button>`
        ).join('') +
        `<button class="ad-ftab ad-ftab-add" onclick="ApartmentDesigner.addFloor()" title="${t('إضافة دور', 'Add Floor')}">+</button>` +
        `<button class="ad-ftab ad-ftab-dup" onclick="ApartmentDesigner.dupFloor()" title="${t('نسخ الدور', 'Duplicate')}">⧉</button>`;
    }

    // ════════════════════════════════════════════
    //  UI BINDING
    // ════════════════════════════════════════════

    function bindUI() {
        // Tool buttons
        document.querySelectorAll('[data-tool]').forEach(b =>
            b.addEventListener('click', () => setTool(b.dataset.tool))
        );

        // Room type palette
        document.querySelectorAll('[data-rtype]').forEach(b =>
            b.addEventListener('click', () => {
                S.roomType = b.dataset.rtype;
                document.querySelectorAll('[data-rtype]').forEach(x => x.classList.remove('active'));
                b.classList.add('active');
                setTool('room');
            })
        );

        // Zoom
        $('zoomIn')?.addEventListener('click', () => {
            S.zoom = Math.min(MAX_ZOOM, S.zoom + ZOOM_STEP * 2);
            $('zoomLevel').textContent = Math.round(S.zoom * 100) + '%'; render();
        });
        $('zoomOut')?.addEventListener('click', () => {
            S.zoom = Math.max(MIN_ZOOM, S.zoom - ZOOM_STEP * 2);
            $('zoomLevel').textContent = Math.round(S.zoom * 100) + '%'; render();
        });
        $('zoomFit')?.addEventListener('click', () => { centerView(); render(); });

        // Undo/Redo
        $('undoBtn')?.addEventListener('click', undo);
        $('redoBtn')?.addEventListener('click', redo);

        // Clear
        $('clearBtn')?.addEventListener('click', () => {
            if (!confirm(t('متأكد تمسح كل التصميم؟', 'Clear entire design?'))) return;
            floorData().rooms = []; S.sel = null;
            pushHistory(); updateProps(); suggest(); render();
        });

        // Auto-design modal
        $('autoDesignBtn')?.addEventListener('click', () => $('autoModal').classList.toggle('ad-hidden'));
        $('autoModalClose')?.addEventListener('click', () => $('autoModal').classList.add('ad-hidden'));
        $('generateBtn')?.addEventListener('click', () => {
            autoDesign({
                totalArea:   parseFloat($('adArea').value) || 120,
                bedrooms:    parseInt($('adBeds').value) || 2,
                bathrooms:   parseInt($('adBaths').value) || 1,
                orientation: $('adOrient').value || 'N',
            });
            $('autoModal').classList.add('ad-hidden');
        });

        // Compass slider
        $('compassSlider')?.addEventListener('input', e => {
            S.northAngle = parseInt(e.target.value);
            render(); suggest();
        });

        // Export
        $('exportBtn')?.addEventListener('click', exportJSON);

        updateFloorTabs();
    }

    function setTool(tool) {
        S.tool = tool; S.drawing = false;
        document.querySelectorAll('[data-tool]').forEach(b => b.classList.toggle('active', b.dataset.tool === tool));
        render();
    }

    // ── Properties panel ──
    function updateProps() {
        const el = $('propsPanel');
        if (!el) return;
        const r = S.sel;
        if (!r) {
            el.innerHTML = `<div class="ad-prop-empty"><i class="fas fa-mouse-pointer"></i><p>${t('اختر غرفة لتعديلها', 'Select a room to edit')}</p></div>`;
            return;
        }
        const opts = Object.entries(ROOM_TYPES).map(([k, v]) =>
            `<option value="${k}"${k === r.type ? ' selected' : ''}>${v[isAr ? 'ar' : 'en']}</option>`
        ).join('');

        el.innerHTML = `
            <div class="ad-pg"><label>${t('النوع', 'Type')}</label>
                <select class="ad-inp" onchange="ApartmentDesigner.setProp('type',this.value)">${opts}</select></div>
            <div class="ad-pg"><label>${t('الاسم', 'Label')}</label>
                <input class="ad-inp" value="${r.label}" onchange="ApartmentDesigner.setProp('label',this.value)"></div>
            <div class="ad-pr">
                <div class="ad-pg"><label>${t('العرض (م)', 'Width (m)')}</label>
                    <input type="number" class="ad-inp" value="${px2m(r.w).toFixed(1)}" step="0.5" min="1"
                           onchange="ApartmentDesigner.setProp('wM',parseFloat(this.value))"></div>
                <div class="ad-pg"><label>${t('الطول (م)', 'Height (m)')}</label>
                    <input type="number" class="ad-inp" value="${px2m(r.h).toFixed(1)}" step="0.5" min="1"
                           onchange="ApartmentDesigner.setProp('hM',parseFloat(this.value))"></div>
            </div>
            <div class="ad-pg"><label>${t('المساحة', 'Area')}</label>
                <div class="ad-area-badge">${r.area.toFixed(1)} m²</div></div>
            <button class="ad-btn ad-btn-del" onclick="ApartmentDesigner.delSel()">
                <i class="fas fa-trash-alt"></i> ${t('حذف', 'Delete')}</button>`;
    }

    function setProp(prop, val) {
        if (!S.sel) return;
        const r = S.sel;
        switch (prop) {
            case 'type':
                r.type = val;
                r.label = ROOM_TYPES[val][isAr ? 'ar' : 'en'];
                break;
            case 'label': r.label = val; break;
            case 'wM': r.w = snap(m2px(val)); r.area = px2m(r.w) * px2m(r.h); break;
            case 'hM': r.h = snap(m2px(val)); r.area = px2m(r.w) * px2m(r.h); break;
        }
        pushHistory(); updateProps(); suggest(); render();
    }

    function delSel() {
        if (!S.sel) return;
        deleteRoom(S.sel.id); S.sel = null;
        pushHistory(); updateProps(); suggest(); render();
    }

    // ── Export ──
    function exportJSON() {
        const data = {
            floors: S.floors.map(f => ({
                name: f.name,
                rooms: f.rooms.map(r => ({
                    type: r.type, label: r.label,
                    width: +px2m(r.w).toFixed(1), height: +px2m(r.h).toFixed(1),
                    area: +r.area.toFixed(1),
                    position: { x: +px2m(r.x).toFixed(1), y: +px2m(r.y).toFixed(1) },
                })),
            })),
            orientation: { north: S.northAngle },
            totalArea: +floorData().rooms.reduce((s, r) => s + r.area, 0).toFixed(1),
        };
        const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
        const a = document.createElement('a');
        a.href = URL.createObjectURL(blob);
        a.download = 'apartment-design.json';
        a.click();
        URL.revokeObjectURL(a.href);
    }

    // ════════════════════════════════════════════
    //  PUBLIC API
    // ════════════════════════════════════════════

    return {
        init, setTool, switchFloor, addFloor, dupFloor,
        setProp, delSel, autoDesign, undo, redo,
    };
})();
