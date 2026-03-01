<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlanController extends Controller
{
    public function index(): View
    {
        $plans = Plan::all();

        return view('plans.index', [
            'plans' => $plans
        ]);
    }

    public function checkout(Plan $plan)
    {
        try {
            // Validación extra: Si el usuario ya está suscrito, redirigir al dashboard
            if (auth()->user()->subscribed('default')) {
                return redirect()->route('dashboard')->with('info', 'Ya tienes una suscripción activa.');
            }

            return auth()->user()
                ->newSubscription('default', $plan->stripe_id)
                ->checkout([
                    // CAMBIO: Al tener éxito, lo enviamos al Dashboard
                    'success_url' => route('dashboard') . '?success=true',
                    'cancel_url' => route('plans.index') . '?canceled=true',
                ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Hubo un problema al conectar con Stripe: ' . $e->getMessage());
        }
    }
}