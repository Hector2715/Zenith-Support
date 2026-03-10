<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SupportController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'asunto'  => 'required|string|max:100',
            'mensaje' => 'required|string|min:10',
        ]);

        // Preparamos los datos con un fallback para el nombre del taller
        $data = [
            'usuario' => auth()->user()->name,
            'taller'  => auth()->user()->nombre_taller ?? 'Taller sin nombre definido',
            'email'   => auth()->user()->email,
            'asunto'  => $request->asunto,
            'mensaje' => $request->mensaje
        ];

        try {
            Mail::send('emails.soporte', $data, function($message) use ($data) {
                $message->to('tu-soporte@zunith.com') // Reemplaza por tu correo real
                        ->replyTo($data['email'], $data['usuario']) // Permite responder directamente al usuario
                        ->subject('SOPORTE: ' . $data['asunto']);
            });

            return back()->with('status', 'Ticket enviado. Revisaremos tu caso en breve.');

        } catch (\Exception $e) {
            // Registramos el error en storage/logs/laravel.log para que puedas revisarlo
            Log::error("Error enviando correo de soporte: " . $e->getMessage());

            return back()->withErrors(['error' => 'No pudimos enviar el correo. Por favor, intenta por WhatsApp.']);
        }
    }
}