<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendOTPNotification extends Notification
{
    use Queueable;

    // 1. Definimos la propiedad pública
    public $otp;

    /**
     * 2. Recibimos el código en el constructor
     */
    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Tu código de seguridad - Zenith Support')
            ->greeting('¡Hola!') // Un saludo amigable
            ->line('Has solicitado cambiar tu contraseña en **Zenith Support**.')
            ->line('Tu código de verificación de 6 dígitos es:')
            // Usamos un formato destacado para el código
            ->line('**' . $this->otp . '**') 
            ->line('Este código expirará en 10 minutos por razones de seguridad.')
            ->line('Si no solicitaste este cambio, no es necesario realizar ninguna acción.')
            ->salutation('Gracias por confiar en nosotros.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'otp' => $this->otp,
        ];
    }
}