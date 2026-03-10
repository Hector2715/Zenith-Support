@extends('layouts.email')

@section('content')
    <div>
        <span class="label">Remitente del Taller:</span>
        <span class="value">{{ $taller }} ({{ $usuario }})</span>

        <span class="label">Correo de Contacto:</span>
        <span class="value">{{ $email }}</span>

        <span class="label">Asunto del Ticket:</span>
        <span class="value" style="color: #1e3d6c; font-weight: bold;">{{ $asunto }}</span>

        <span class="label">Descripción detallada:</span>
        <div class="message-box">
            {{ $mensaje }}
        </div>
    </div>
@endsection