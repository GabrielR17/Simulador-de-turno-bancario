<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Turnos Bancarios</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: Arial, sans-serif;
            background: #eef2f7;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px;
        }

        header {
            background: #003087;
            color: white;
            width: 100%;
            max-width: 700px;
            padding: 20px 30px;
            border-radius: 10px 10px 0 0;
            text-align: center;
        }

        header h1 { font-size: 22px; letter-spacing: 1px; }
        header p  { font-size: 13px; opacity: 0.8; margin-top: 4px; }

        .contenedor {
            background: white;
            width: 100%;
            max-width: 700px;
            padding: 35px 40px;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        /* --- Formulario --- */
        .form-grupo { margin-bottom: 20px; }

        label {
            display: block;
            font-weight: bold;
            color: #003087;
            margin-bottom: 8px;
            font-size: 14px;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #d0d8e8;
            border-radius: 8px;
            font-size: 15px;
            transition: border .2s;
        }

        input[type="text"]:focus {
            border-color: #003087;
            outline: none;
        }

        .opciones-tramite {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .opcion {
            flex: 1;
            min-width: 140px;
            border: 2px solid #d0d8e8;
            border-radius: 8px;
            padding: 14px;
            cursor: pointer;
            text-align: center;
            transition: all .2s;
        }

        .opcion input { display: none; }

        .opcion:hover,
        .opcion.activa { border-color: #003087; background: #eef2f7; }

        .opcion .icono { font-size: 26px; display: block; margin-bottom: 6px; }
        .opcion .etiqueta { font-size: 13px; font-weight: bold; color: #003087; }

        .btn-turno {
            width: 100%;
            padding: 14px;
            background: #003087;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            letter-spacing: 1px;
            transition: background .2s;
            margin-top: 10px;
        }

        .btn-turno:hover { background: #00509e; }

        /* --- Confirmacion --- */
        .confirmacion {
            text-align: center;
            padding: 10px 0 20px;
        }

        .ticket {
            display: inline-block;
            background: #003087;
            color: white;
            border-radius: 16px;
            padding: 30px 50px;
            margin: 20px 0;
            box-shadow: 0 6px 20px rgba(0,48,135,0.3);
        }

        .ticket .label-turno { font-size: 13px; opacity: 0.8; letter-spacing: 2px; text-transform: uppercase; }
        .ticket .numero      { font-size: 64px; font-weight: bold; line-height: 1.1; }
        .ticket .tipo        { font-size: 14px; opacity: 0.85; margin-top: 6px; }

        .info-espera {
            background: #fff8e1;
            border-left: 4px solid #f59e0b;
            border-radius: 6px;
            padding: 14px 18px;
            margin: 16px 0;
            font-size: 15px;
            color: #555;
            text-align: left;
        }

        .info-espera strong { color: #003087; }

        .btn-volver {
            display: inline-block;
            margin-top: 14px;
            padding: 11px 30px;
            background: transparent;
            border: 2px solid #003087;
            color: #003087;
            border-radius: 8px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            transition: all .2s;
        }

        .btn-volver:hover { background: #003087; color: white; }

        /* --- Estado de filas --- */
        .filas-titulo {
            font-size: 13px;
            font-weight: bold;
            color: #888;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin: 28px 0 12px;
            border-top: 1px solid #eee;
            padding-top: 22px;
        }

        .filas-estado {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .fila-card {
            flex: 1;
            min-width: 140px;
            background: #f4f7fc;
            border-radius: 8px;
            padding: 14px;
            text-align: center;
            border-top: 4px solid #003087;
        }

        .fila-card .fila-nombre  { font-size: 12px; color: #888; text-transform: uppercase; letter-spacing: 1px; }
        .fila-card .fila-conteo  { font-size: 32px; font-weight: bold; color: #003087; line-height: 1.2; margin: 6px 0; }
        .fila-card .fila-label   { font-size: 11px; color: #aaa; }

        .btn-reset {
            display: block;
            margin: 20px auto 0;
            background: none;
            border: none;
            color: #bbb;
            font-size: 12px;
            cursor: pointer;
            text-decoration: underline;
        }

        .btn-reset:hover { color: #e74c3c; }
    </style>
</head>
<body>

<header>
    <h1>🏦 Banco — Sistema de Turnos</h1>
    <p>Tome su turno y espere a ser llamado</p>
</header>

<div class="contenedor">

    {{-- ===== CONFIRMACION ===== --}}
    @isset($turno)
    <div class="confirmacion">
        <p style="font-size:15px; color:#555;">Hola, <strong>{{ $nombre }}</strong>. Tu turno ha sido asignado:</p>

        <div class="ticket">
            <span class="label-turno">Tu número de turno</span>
            <div class="numero">{{ $turno }}</div>
            <div class="tipo">
                {{ $tramite === 'caja' ? '🏧 Caja' : ($tramite === 'servicio' ? '💬 Servicio al Cliente' : '💳 Créditos') }}
            </div>
        </div>

        <div class="info-espera">
            @if($personasAntes === 0)
                ✅ Eres el <strong>primero en la fila</strong>. ¡Pasa directamente!
            @elseif($personasAntes === 1)
                ⏳ Hay <strong>1 persona</strong> antes que tú en esta fila.
            @else
                ⏳ Hay <strong>{{ $personasAntes }} personas</strong> antes que tú en esta fila.
            @endif
        </div>

        <a href="{{ route('turno.index') }}" class="btn-volver">← Registrar otro turno</a>
    </div>

    {{-- ===== FORMULARIO ===== --}}
    @else
    <form action="{{ route('turno.registrar') }}" method="POST">
        @csrf

        <div class="form-grupo">
            <label for="nombre">Tu nombre completo</label>
            <input type="text" id="nombre" name="nombre"
                   placeholder="Ej: Carlos Rodríguez"
                   value="{{ old('nombre') }}" required>
            @error('nombre')
                <span style="color:red; font-size:13px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-grupo">
            <label>Tipo de trámite</label>
            <div class="opciones-tramite">

                <label class="opcion {{ old('tramite') === 'caja' ? 'activa' : '' }}">
                    <input type="radio" name="tramite" value="caja" required>
                    <span class="icono">🏧</span>
                    <span class="etiqueta">Caja</span>
                </label>

                <label class="opcion {{ old('tramite') === 'servicio' ? 'activa' : '' }}">
                    <input type="radio" name="tramite" value="servicio">
                    <span class="icono">💬</span>
                    <span class="etiqueta">Servicio al Cliente</span>
                </label>

                <label class="opcion {{ old('tramite') === 'creditos' ? 'activa' : '' }}">
                    <input type="radio" name="tramite" value="creditos">
                    <span class="icono">💳</span>
                    <span class="etiqueta">Créditos</span>
                </label>

            </div>
            @error('tramite')
                <span style="color:red; font-size:13px;">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn-turno">TOMAR TURNO</button>
    </form>
    @endisset

    {{-- ===== ESTADO DE FILAS ===== --}}
    <p class="filas-titulo">Estado actual de las filas</p>
    <div class="filas-estado">
        <div class="fila-card">
            <div class="fila-nombre">🏧 Caja</div>
            <div class="fila-conteo">{{ count($filas['caja'] ?? []) }}</div>
            <div class="fila-label">en espera</div>
        </div>
        <div class="fila-card">
            <div class="fila-nombre">💬 Servicio</div>
            <div class="fila-conteo">{{ count($filas['servicio'] ?? []) }}</div>
            <div class="fila-label">en espera</div>
        </div>
        <div class="fila-card">
            <div class="fila-nombre">💳 Créditos</div>
            <div class="fila-conteo">{{ count($filas['creditos'] ?? []) }}</div>
            <div class="fila-label">en espera</div>
        </div>
    </div>

    <form action="{{ route('turno.reset') }}" method="GET">
        <button class="btn-reset" type="submit">🗑 Reiniciar todas las filas</button>
    </form>

</div>

<script>
    // Resalta visualmente la opcion seleccionada
    document.querySelectorAll('.opcion input').forEach(radio => {
        radio.addEventListener('change', () => {
            document.querySelectorAll('.opcion').forEach(op => op.classList.remove('activa'));
            radio.parentElement.classList.add('activa');
        });
    });
</script>

</body>
</html>