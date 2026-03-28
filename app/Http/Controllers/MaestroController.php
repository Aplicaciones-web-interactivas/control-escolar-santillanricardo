<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarea;
use App\Models\Grupo;
use App\Models\Entrega;
use Illuminate\Support\Facades\Auth;

class MaestroController extends Controller
{
    public function dashboard()
    {
        return view('maestro.dashboard');
    }

    // ─── TAREAS ─────────────────────────────────────────
    public function tareas()
    {
        $ahora = now('America/Mexico_City');

        $tareasActivas = Tarea::where(function ($query) use ($ahora) {
            $query->whereDate('fecha_entrega', '>', $ahora->toDateString())
                ->orWhere(function ($q) use ($ahora) {
                    $q->whereDate('fecha_entrega', $ahora->toDateString())
                        ->whereTime('hora_limite', '>=', $ahora->toTimeString());
                });
        })->paginate(10);

        $tareasFinalizadas = Tarea::where(function ($query) use ($ahora) {
            $query->whereDate('fecha_entrega', '<', $ahora->toDateString())
                ->orWhere(function ($q) use ($ahora) {
                    $q->whereDate('fecha_entrega', $ahora->toDateString())
                        ->whereTime('hora_limite', '<', $ahora->toTimeString());
                });
        })->paginate(10);

        $grupos = Grupo::all();

        return view('maestro.tareas')->with('tareasActivas', $tareasActivas)
            ->with('tareasFinalizadas', $tareasFinalizadas)
            ->with('grupos', $grupos);
    }

    public function saveTarea(Request $request)
    {
        $nuevaTarea = new Tarea();
        $nuevaTarea->grupo_id      = $request->grupo_id;
        $nuevaTarea->user_id       = Auth::user()->id;
        $nuevaTarea->titulo        = $request->titulo;
        $nuevaTarea->descripcion   = $request->descripcion;
        $nuevaTarea->fecha_entrega = $request->fecha_entrega;
        $nuevaTarea->hora_limite   = $request->hora_limite;
        $nuevaTarea->envio_tardio  = $request->has('envio_tardio') ? true : false;
        $nuevaTarea->save();
        return redirect()->back()->with('success', 'Tarea guardada correctamente.');
    }


    public function deleteTarea($id)
    {
        $tareaEliminar = Tarea::find($id);
        if ($tareaEliminar != null) {
            $tareaEliminar->delete();
        } else {
            return redirect()->back()->withErrors(['error' => 'Tarea no encontrada']);
        }
        return redirect()->back()->with('success', 'Tarea eliminada correctamente.');
    }

    public function editTarea($id)
    {
        $tareaEditar = Tarea::find($id);
        $grupos      = Grupo::all();
        if ($tareaEditar != null) {
            return view('maestro.modificartarea')->with('tarea', $tareaEditar)
                ->with('grupos', $grupos);
        } else {
            return redirect()->back()->withErrors(['error' => 'Tarea no encontrada']);
        }
    }

    public function updateTarea(Request $request, $id)
    {
        $tareaActualizar = Tarea::find($id);
        if ($tareaActualizar != null) {
            $tareaActualizar->grupo_id      = $request->grupo_id;
            $tareaActualizar->titulo        = $request->titulo;
            $tareaActualizar->descripcion   = $request->descripcion;
            $tareaActualizar->fecha_entrega = $request->fecha_entrega;
            $tareaActualizar->hora_limite   = $request->hora_limite;
            $tareaActualizar->envio_tardio  = $request->has('envio_tardio') ? true : false;
            $tareaActualizar->save();
        } else {
            return redirect()->back()->withErrors(['error' => 'Tarea no encontrada']);
        }
        return redirect('/maestro/tareas')->with('success', 'Tarea actualizada correctamente.');
    }
    // ─── ENTREGAS ────────────────────────────────────────
    public function verEntregas($tarea_id)
    {
        $tarea    = Tarea::find($tarea_id);
        $entregas = Entrega::where('tarea_id', $tarea_id)->paginate(10);
        return view('maestro.entregas')->with('tarea', $tarea)
            ->with('entregas', $entregas);
    }
}
