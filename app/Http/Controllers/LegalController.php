<?php

namespace App\Http\Controllers;

class LegalController extends Controller
{
    public function terminos() {
        return view('legal.show', ['section' => 'terminos', 'title' => 'Términos y Condiciones']);
    }

    public function privacidad() {
        return view('legal.show', ['section' => 'privacidad', 'title' => 'Política de Privacidad']);
    }

    public function soporte() {
        return view('legal.show', ['section' => 'soporte', 'title' => 'Centro de Soporte']);
    }
}