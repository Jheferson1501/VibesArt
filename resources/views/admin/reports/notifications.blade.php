<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vibes Art – Notificaciones</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0a0a0f; --surface: #12121a; --border: #1e1e2e;
            --accent1: #c084fc; --accent2: #f472b6;
            --text: #e2e2f0; --muted: #6b6b8a;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; padding: 2rem 1rem; }
        body::before {
            content: ''; position: fixed; inset: 0;
            background:
                radial-gradient(ellipse 60% 50% at 20% 20%, rgba(192,132,252,0.08) 0%, transparent 60%),
                radial-gradient(ellipse 50% 60% at 80% 80%, rgba(244,114,182,0.06) 0%, transparent 60%);
            pointer-events: none; z-index: 0;
        }
        .container { position: relative; z-index: 1; max-width: 800px; margin: 0 auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .brand {
            font-family: 'Playfair Display', serif; font-size: 1.5rem;
            background: linear-gradient(135deg, var(--accent1), var(--accent2));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .nav-links { display: flex; gap: 1rem; }
        .nav-links a { color: var(--muted); text-decoration: none; font-size: 0.85rem; transition: color 0.2s; }
        .nav-links a:hover { color: var(--accent1); }
        .page-title { font-family: 'Playfair Display', serif; font-size: 1.8rem; margin-bottom: 0.4rem; }
        .page-sub { color: var(--muted); font-size: 0.88rem; margin-bottom: 2rem; }

        /* Alert */
        .alert {
            padding: 0.9rem 1.2rem; border-radius: 12px; margin-bottom: 1.5rem;
            font-size: 0.88rem; display: flex; align-items: center; gap: 0.6rem;
        }
        .alert-success { background: rgba(39,174,96,0.12); border: 1px solid rgba(39,174,96,0.3); color: #2ecc71; }
        .alert-error   { background: rgba(255,68,68,0.12);  border: 1px solid rgba(255,68,68,0.3);  color: #ff4444; }

        /* Formulario */
        .card { background: var(--surface); border: 1px solid var(--border); border-radius: 20px; padding: 1.8rem; margin-bottom: 1.5rem; }
        .card-title { font-family: 'Playfair Display', serif; font-size: 1.2rem; margin-bottom: 1.2rem; }
        .form-group { margin-bottom: 1.2rem; }
        .form-label { display: block; font-size: 0.8rem; color: var(--muted); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.5rem; }
        .form-input, .form-select {
            width: 100%; padding: 0.8rem 1rem;
            background: rgba(255,255,255,0.03); border: 1px solid var(--border);
            border-radius: 10px; color: var(--text);
            font-family: 'DM Sans', sans-serif; font-size: 0.9rem;
            transition: border-color 0.2s; outline: none;
        }
        .form-input:focus, .form-select:focus { border-color: var(--accent1); }
        .form-select option { background: #1a1a2e; }
        .form-error { font-size: 0.78rem; color: #ff4444; margin-top: 0.3rem; }
        .btn-primary {
            padding: 0.8rem 1.8rem;
            background: linear-gradient(135deg, var(--accent1), var(--accent2));
            border: none; border-radius: 10px; color: #fff;
            font-family: 'DM Sans', sans-serif; font-size: 0.9rem; font-weight: 500;
            cursor: pointer; transition: opacity 0.2s;
        }
        .btn-primary:hover { opacity: 0.88; }

        /* Lista */
        .tipo-section { margin-bottom: 2rem; }
        .tipo-title {
            font-size: 0.75rem; color: var(--muted);
            text-transform: uppercase; letter-spacing: 0.1em;
            margin-bottom: 0.8rem; padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--border);
        }
        .notif-item {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 14px; padding: 1rem 1.2rem;
            display: flex; align-items: flex-start; gap: 1rem;
            margin-bottom: 0.7rem; transition: border-color 0.2s;
        }
        .notif-item.inactive { opacity: 0.45; }
        .notif-item:hover { border-color: rgba(192,132,252,0.3); }
        .notif-dot {
            width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; margin-top: 5px;
        }
        .notif-dot.active   { background: #2ecc71; box-shadow: 0 0 8px #2ecc71; }
        .notif-dot.inactive { background: var(--muted); }
        .notif-text { flex: 1; font-size: 0.9rem; line-height: 1.5; }
        .notif-actions { display: flex; gap: 0.5rem; flex-shrink: 0; }
        .btn-icon {
            width: 32px; height: 32px; border-radius: 8px; border: 1px solid var(--border);
            background: transparent; color: var(--muted); cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.9rem; transition: border-color 0.2s, color 0.2s;
        }
        .btn-icon:hover { border-color: var(--accent1); color: var(--accent1); }
        .btn-icon.danger:hover { border-color: #ff4444; color: #ff4444; }

        /* Tipo badges */
        .tipo-badge {
            font-size: 0.72rem; padding: 0.2rem 0.6rem; border-radius: 100px;
            font-weight: 500; white-space: nowrap;
        }
        .tipo-general     { background: rgba(192,132,252,0.15); color: #c084fc; border: 1px solid rgba(192,132,252,0.3); }
        .tipo-racha       { background: rgba(255,165,0,0.15);   color: #FFA500; border: 1px solid rgba(255,165,0,0.3); }
        .tipo-recordatorio{ background: rgba(52,152,219,0.15);  color: #3498DB; border: 1px solid rgba(52,152,219,0.3); }

        .empty-tipo { color: var(--muted); font-size: 0.85rem; padding: 0.5rem 0; }
    </style>
</head>
<body>
<div class="container">

    <div class="header">
        <div class="brand">🎨 Vibes Art</div>
        <div class="nav-links">
            <a href="{{ route('admin.reports.index') }}">Reportes</a>
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        </div>
    </div>

    <div class="page-title">💜 Notificaciones</div>
    <div class="page-sub">Gestiona los mensajes motivacionales que reciben los usuarios.</div>

    @if(session('success'))
    <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-error">❌ {{ session('error') }}</div>
    @endif

    <!-- Formulario nueva notificación -->
    <div class="card">
        <div class="card-title">➕ Nueva Notificación</div>
        <form method="POST" action="{{ route('admin.notifications.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Mensaje</label>
                <input type="text" name="mensaje" class="form-input"
                    placeholder="Ej: ¿Cómo te sientes hoy? 🎨"
                    value="{{ old('mensaje') }}" maxlength="255">
                @error('mensaje')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Tipo</label>
                <select name="tipo" class="form-select">
                    <option value="general"      {{ old('tipo') === 'general'      ? 'selected' : '' }}>🌟 General</option>
                    <option value="racha"        {{ old('tipo') === 'racha'        ? 'selected' : '' }}>🔥 Racha</option>
                    <option value="recordatorio" {{ old('tipo') === 'recordatorio' ? 'selected' : '' }}>🌙 Recordatorio</option>
                </select>
                @error('tipo')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn-primary">Guardar notificación</button>
        </form>
    </div>

    <!-- Lista agrupada por tipo -->
    @php
        $tipos = ['general' => '🌟 General', 'racha' => '🔥 Racha', 'recordatorio' => '🌙 Recordatorio'];
    @endphp

    @foreach($tipos as $tipo => $label)
    @php $grupo = $notifications->where('tipo', $tipo); @endphp
    <div class="tipo-section">
        <div class="tipo-title">{{ $label }} ({{ $grupo->count() }})</div>

        @forelse($grupo as $notif)
        <div class="notif-item {{ $notif->activo ? '' : 'inactive' }}">
            <div class="notif-dot {{ $notif->activo ? 'active' : 'inactive' }}"></div>
            <div style="flex:1;">
                <div class="notif-text">{{ $notif->mensaje }}</div>
                <div style="margin-top:0.4rem;">
                    <span class="tipo-badge tipo-{{ $notif->tipo }}">{{ $label }}</span>
                </div>
            </div>
            <div class="notif-actions">
                <!-- Toggle activo/inactivo -->
                <form method="POST" action="{{ route('admin.notifications.toggle', $notif->id) }}">
                    @csrf
                    <button type="submit" class="btn-icon" title="{{ $notif->activo ? 'Desactivar' : 'Activar' }}">
                        {{ $notif->activo ? '⏸' : '▶️' }}
                    </button>
                </form>
                <!-- Eliminar -->
                <form method="POST" action="{{ route('admin.notifications.destroy', $notif->id) }}"
                    onsubmit="return confirm('¿Eliminar esta notificación?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-icon danger" title="Eliminar">🗑</button>
                </form>
            </div>
        </div>
        @empty
        <div class="empty-tipo">Sin notificaciones de este tipo.</div>
        @endforelse
    </div>
    @endforeach

</div>
</body>
</html>