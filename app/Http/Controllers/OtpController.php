<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OtpCode; // ¡Importante! Sin esto fallará el verify
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    /**
     * Muestra la vista para ingresar el código.
     * Esto soluciona el error "Call to undefined method ... show()"
     */
    public function show()
    {
        return view('livewire.pages.auth.verify-email');
    }

    /**
     * Verifica el código ingresado por el usuario.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6'
        ]);

        $otp = OtpCode::where('user_id', Auth::id())
                      ->where('code', $request->code)
                      ->where('expires_at', '>', now())
                      ->first();

        if ($otp) {
            $user = Auth::user();
            
            // Marcamos al usuario como verificado en la base de datos
            $user->forceFill([
                'email_verified_at' => now(),
            ])->save();

            $otp->delete(); // Borramos el código para que no se use dos veces

            return redirect()->route('dashboard');
        }

        return back()->withErrors(['code' => 'El código es incorrecto o ha expirado.']);
    }
}