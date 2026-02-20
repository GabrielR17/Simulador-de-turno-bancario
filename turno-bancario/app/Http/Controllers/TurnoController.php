<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TurnoController extends Controller
{
    public function index()
    {
        $filas = session('turnos', [
            'caja'     => [],
            'servicio' => [],
            'creditos' => [],
        ]);

        return view('turno', compact('filas'));
    }

    public function registrar(Request $request)
    {
        $request->validate([
            'nombre'  => 'required|string|max:100',
            'tramite' => 'required|in:caja,servicio,creditos',
        ]);

        $nombre  = $request->input('nombre');
        $tramite = $request->input('tramite');

        $prefijos = [
            'caja'     => 'C',
            'servicio' => 'S',
            'creditos' => 'R',
        ];

        $filas = session('turnos', [
            'caja'     => [],
            'servicio' => [],
            'creditos' => [],
        ]);

        $personasAntes = count($filas[$tramite]);
        $numero        = $personasAntes + 1;
        $turno         = $prefijos[$tramite] . '-' . str_pad($numero, 3, '0', STR_PAD_LEFT);

        $filas[$tramite][] = [
            'nombre' => $nombre,
            'turno'  => $turno,
        ];

        session(['turnos' => $filas]);

        return view('turno', compact('filas', 'nombre', 'turno', 'tramite', 'personasAntes'));
    }

    public function reset()
    {
        session()->forget('turnos');
        return redirect('/turno');
    }
    public function atender(Request $request)
{
    $tramite = $request->input('tramite');
    $filas   = session('turnos', ['caja' => [], 'servicio' => [], 'creditos' => []]);

    if (!empty($filas[$tramite])) {
        array_shift($filas[$tramite]);
        session(['turnos' => $filas]);
    }

    return redirect('/turno');
}
}
