<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        /* Configuración de Página */
        @page { margin: 0.5cm; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #1e293b; line-height: 1.4; margin: 0; padding: 0; }
        
        /* Colores y Branding */
        .text-navy { color: #1e3d6c; }
        .text-teal { color: #41bcb0; }
        .bg-navy { background-color: #1e3d6c; color: white; }
        
        /* Utilidades */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-black { font-weight: 900; }
        .uppercase { text-transform: uppercase; }
        .clearfix { clear: both; }
        
        /* Estilos de Tabla */
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background-color: #f8fafc; color: #64748b; font-size: 9px; padding: 8px; border: 1px solid #e2e8f0; }
        td { font-size: 10px; padding: 8px; border: 1px solid #e2e8f0; }

        /* Estilos de Ticket (Térmica) */
        .ticket-container { width: 100%; max-width: 80mm; margin: 0 auto; }
        .label-mini { font-size: 7px; font-weight: bold; color: #64748b; display: block; margin-top: 5px; }
        .value-mini { font-size: 10px; font-weight: bold; margin-bottom: 5px; }
        
        /* Footer Legal */
        .footer-pdf { text-align: center; margin-top: 30px; font-size: 8px; color: #94a3b8; border-top: 1px dashed #e2e8f0; padding-top: 10px; }
        .signature-box { margin-top: 40px; border-top: 1px solid #000; width: 180px; margin-left: auto; margin-right: auto; padding-top: 5px; font-size: 8px; font-weight: bold; }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>