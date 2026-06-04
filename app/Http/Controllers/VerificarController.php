<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;

class VerificarController extends Controller
{
    public function index()
    {
        return view('verificar');
    }

    public function buscar(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $registration = Registration::with('user', 'ticket.event')
            ->where('code', strtoupper(trim($request->code)))
            ->first();

        return view('verificar', compact('registration'));
    }
}
