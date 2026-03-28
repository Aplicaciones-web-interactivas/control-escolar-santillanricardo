<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarea;
use App\Models\Entrega;
use App\Models\Inscripcion;
use Illuminate\Support\Facades\Auth;

class AlumnoController extends Controller
{
    public function dashboard()
    {
        return view('alumno.dashboard');
    }

    // ─── TAREAS ─────────────────────────────────────────
    public function tareas()
    {
        $usuario = Auth::user();

        $inscripciones = Inscripcion::where('user_id', $usuario->id)->get();
        $grupo_ids     = $inscripciones->pluck('grupo_id');

        $todasLasTareas = Tarea::whereIn('grupo_id', $grupo_ids)->get();

        // IDs de tareas que ya entregó
        $tareasEntregadas_ids = Entrega::where('user_id', $usuario->id)->pluck('tarea_id');

        // Tareas pendientes (no entregadas)
        $tareasPendientes = $todasLasTareas->whereNotIn('id', $tareasEntregadas_ids);

        // Tareas ya entregadas
        $tareasEntregadas = Entrega::where('user_id', $usuario->id)->paginate(10);

        return view('alumno.tareas')->with('tareasPendientes', $tareasPendientes)
            ->with('tareasEntregadas', $tareasEntregadas);
    }

    // ─── ENTREGAS ────────────────────────────────────────
    public function entregarTarea(Request $request, $tarea_id)
    {
        $tarea = Tarea::find($tarea_id);

        // Verificar si ya pasó la fecha y hora límite
        $ahora = now('America/Mexico_City');
        $fechaHoraLimite = \Carbon\Carbon::parse($tarea->fecha_entrega . ' ' . $tarea->hora_limite, 'America/Mexico_City');

        if ($ahora->greaterThan($fechaHoraLimite)) {
            if (!$tarea->envio_tardio) {
                return redirect()->back()->withErrors(['error' => 'El plazo de entrega ha terminado y no se permite envío tardío.']);
            }
        }

        // Validar que sea PDF
        $request->validate([
            'archivo' => 'required|mimes:pdf|max:2048',
        ], [
            'archivo.required' => 'Debes subir un archivo.',
            'archivo.mimes'    => 'Solo se permiten archivos PDF.',
            'archivo.max'      => 'El archivo no debe pesar más de 2MB.',
        ]);

        // Guardar el archivo
        $ruta = $request->file('archivo')->store('entregas', 'public');

        $entrega           = new Entrega();
        $entrega->tarea_id = $tarea_id;
        $entrega->user_id  = Auth::user()->id;
        $entrega->archivo  = $ruta;
        $entrega->save();

        return redirect()->back()->with('success', 'Tarea entregada correctamente.');
    }
}
