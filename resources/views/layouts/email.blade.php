<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        /* Estilos fijos para que el correo se vea igual en cualquier bandeja */
        body { font-family: 'Segoe UI', Helvetica, Arial, sans-serif; background-color: #f4f7f6; color: #333; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.03); border: 1px solid #e2e8f0; }
        .header { background-color: #1e3d6c; padding: 25px; text-align: center; border-bottom: 4px solid #41bcb0; }
        .header h1 { color: #ffffff; margin: 0; text-transform: uppercase; font-size: 16px; letter-spacing: 3px; font-weight: 900; }
        .header span { color: #41bcb0; }
        .content { padding: 30px; }
        .footer { background: #f8fafc; padding: 15px; text-align: center; font-size: 9px; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; }
        
        /* Clases de utilidad para el contenido */
        .label { font-size: 10px; font-weight: 900; color: #1e3d6c; text-transform: uppercase; display: block; margin-bottom: 2px; }
        .value { font-size: 14px; color: #64748b; margin-bottom: 15px; display: block; }
        .message-box { background: #f1f5f9; padding: 20px; border-radius: 8px; font-size: 13px; line-height: 1.6; color: #334155; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Zenith<span>Support</span> • Help Desk</h1>
        </div>
        
        <div class="content">
            @yield('content')
        </div>

        <div class="footer">
            Sistema de Gestión de Taller • Generado por Zenith Panel v2.0
        </div>
    </div>
</body>
</html>