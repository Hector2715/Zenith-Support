<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte Mensual Zenith Support</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; line-height: 1.5; }
        .header { text-align: center; border-bottom: 3px solid #4f46e5; padding-bottom: 20px; margin-bottom: 20px; }
        .header h1 { margin: 0; color: #4f46e5; font-size: 28px; }
        .header p { margin: 5px 0; color: #666; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #f8fafc; color: #475569; text-transform: uppercase; font-size: 12px; letter-spacing: 0.05em; }
        th, td { border: 1px solid #e2e8f0; padding: 12px; text-align: left; }
        
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        
        .total-section { margin-top: 30px; text-align: right; padding: 15px; background: #f1f5f9; border-radius: 8px; }
        .total-label { font-size: 18px; color: #1e293b; }
        .total-amount { font-size: 22px; color: #4f46e5; font-weight: bold; }
        
        .footer { text-align: center; font-size: 10px; margin-top: 50px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Zenith Support</h1>
        <p>Reporte de Ingresos por Equipos Entregados</p>
        <p><strong>Periodo:</strong> {{ now()->translatedFormat('F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Modelo del Equipo</th>
                <th class="text-right">Fecha Entrega</th>
                <th class="text-right">Costo Servicio</th>
            </tr>
        </thead>
        <tbody>
            @foreach($equipos as $equipo)
                <tr>
                    <td>{{ $equipo->modelo }}</td>
                    <td class="text-right">
                        {{ $equipo->fecha_entrega ? $equipo->fecha_entrega->format('d/m/Y') : 'N/A' }}
                    </td>
                    <td class="text-right font-bold">
                        ${{ number_format($equipo->costo, 2) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <span class="total-label">INGRESOS TOTALES DEL MES:</span>
        <span class="total-amount">${{ number_format($equipos->sum('costo'), 2) }}</span>
    </div>

    <div class="footer">
        Gerencia de Operaciones Zenith Support - Venezuela <br>
        Documento generado automáticamente el {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>