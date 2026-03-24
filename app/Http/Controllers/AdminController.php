<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materia;
use App\Models\Horario;
use App\Models\Grupo;
use App\Models\User;
use App\Models\Calificacion;
use App\Models\Inscripcion;

class AdminController extends Controller
{
    public function indexAdmin()
    {
        return view('admin.dashboardAdmin');
    }

    // ─── MATERIAS ───────────────────────────────────────
    public function materias()
    {
        $materias = Materia::paginate(10);
        return view('admin.materias')->with('materias', $materias);
    }

    public function saveMateria(Request $request)
    {
        $nuevaMateria = new Materia();
        $nuevaMateria->nombre = $request->nombre;
        $nuevaMateria->clave = $request->clave;
        $nuevaMateria->save();
        return redirect()->back()->with('success', 'Materia guardada correctamente.');
    }

    public function deleteMateria($id)
    {
        $materiaeliminar = Materia::find($id);
        if ($materiaeliminar != null) {
            $materiaeliminar->delete();
        } else {
            return redirect()->back()->withErrors(['error' => 'Materia no encontrada']);
        }
        return redirect()->back()->with('success', 'Materia eliminada correctamente.');
    }

    public function editMateria($id)
    {
        $materiaEditar = Materia::find($id);
        if ($materiaEditar != null) {
            return view('admin.modificarmateria')->with('materia', $materiaEditar);
        } else {
            return redirect()->back()->withErrors(['error' => 'Materia no encontrada']);
        }
    }

    public function updateMateria(Request $request, $id)
    {
        $materiaActualizar = Materia::find($id);
        if ($materiaActualizar != null) {
            $materiaActualizar->nombre = $request->nombre;
            $materiaActualizar->clave = $request->clave;
            $materiaActualizar->save();
        } else {
            return redirect()->back()->withErrors(['error' => 'Materia no encontrada']);
        }
        return redirect('/materias')->with('success', 'Materia actualizada correctamente.');
    }

    // ─── HORARIOS ───────────────────────────────────────
    public function horarios()
    {
        $horarios = Horario::paginate(10);
        $materias = Materia::all();
        $usuarios = User::all();
        return view('admin.horarios')->with('horarios', $horarios)
            ->with('materias', $materias)
            ->with('usuarios', $usuarios);
    }

    public function saveHorario(Request $request)
    {
        $nuevoHorario = new Horario();
        $nuevoHorario->materia_id  = $request->materia_id;
        $nuevoHorario->user_id     = $request->user_id;
        $nuevoHorario->dia         = $request->dia;
        $nuevoHorario->hora_inicio = $request->hora_inicio;
        $nuevoHorario->hora_fin    = $request->hora_fin;
        $nuevoHorario->save();
        return redirect()->back()->with('success', 'Horario guardado correctamente.');
    }

    public function deleteHorario($id)
    {
        $horarioEliminar = Horario::find($id);
        if ($horarioEliminar != null) {
            $horarioEliminar->delete();
        } else {
            return redirect()->back()->withErrors(['error' => 'Horario no encontrado']);
        }
        return redirect()->back()->with('success', 'Horario eliminado correctamente.');
    }

    public function editHorario($id)
    {
        $horarioEditar = Horario::find($id);
        $materias      = Materia::all();
        $usuarios      = User::all();
        if ($horarioEditar != null) {
            return view('admin.modificarHorario')->with('horario', $horarioEditar)
                ->with('materias', $materias)
                ->with('usuarios', $usuarios);
        } else {
            return redirect()->back()->withErrors(['error' => 'Horario no encontrado']);
        }
    }

    public function updateHorario(Request $request, $id)
    {
        $horarioActualizar = Horario::find($id);
        if ($horarioActualizar != null) {
            $horarioActualizar->materia_id  = $request->materia_id;
            $horarioActualizar->user_id     = $request->user_id;
            $horarioActualizar->dia         = $request->dia;
            $horarioActualizar->hora_inicio = $request->hora_inicio;
            $horarioActualizar->hora_fin    = $request->hora_fin;
            $horarioActualizar->save();
        } else {
            return redirect()->back()->withErrors(['error' => 'Horario no encontrado']);
        }
        return redirect('/horarios')->with('success', 'Horario actualizado correctamente.');
    }

    // ─── GRUPOS ─────────────────────────────────────────
    public function grupos()
    {
        $grupos   = Grupo::paginate(10);
        $horarios = Horario::all();
        return view('admin.grupos')->with('grupos', $grupos)
            ->with('horarios', $horarios);
    }

    public function saveGrupo(Request $request)
    {
        $nuevoGrupo = new Grupo();
        $nuevoGrupo->horario_id = $request->horario_id;
        $nuevoGrupo->nombre     = $request->nombre;
        $nuevoGrupo->save();
        return redirect()->back()->with('success', 'Grupo guardado correctamente.');
    }

    public function deleteGrupo($id)
    {
        $grupoEliminar = Grupo::find($id);
        if ($grupoEliminar != null) {
            $grupoEliminar->delete();
        } else {
            return redirect()->back()->withErrors(['error' => 'Grupo no encontrado']);
        }
        return redirect()->back()->with('success', 'Grupo eliminado correctamente.');
    }

    public function editGrupo($id)
    {
        $grupoEditar = Grupo::find($id);
        $horarios    = Horario::all();
        if ($grupoEditar != null) {
            return view('admin.modificarGrupo')->with('grupo', $grupoEditar)
                ->with('horarios', $horarios);
        } else {
            return redirect()->back()->withErrors(['error' => 'Grupo no encontrado']);
        }
    }

    public function updateGrupo(Request $request, $id)
    {
        $grupoActualizar = Grupo::find($id);
        if ($grupoActualizar != null) {
            $grupoActualizar->horario_id = $request->horario_id;
            $grupoActualizar->nombre     = $request->nombre;
            $grupoActualizar->save();
        } else {
            return redirect()->back()->withErrors(['error' => 'Grupo no encontrado']);
        }
        return redirect('/grupos')->with('success', 'Grupo actualizado correctamente.');
    }

    // ─── CALIFICACIONES ─────────────────────────────────────
    public function calificaciones()
    {
        $calificaciones = Calificacion::paginate(10);
        $grupos         = Grupo::all();
        $usuarios       = User::all();
        return view('admin.calificaciones')->with('calificaciones', $calificaciones)
            ->with('grupos', $grupos)
            ->with('usuarios', $usuarios);
    }

    public function saveCalificacion(Request $request)
    {
        $nuevaCalificacion = new Calificacion();
        $nuevaCalificacion->grupo_id      = $request->grupo_id;
        $nuevaCalificacion->user_id       = $request->user_id;
        $nuevaCalificacion->calificacion  = $request->calificacion;
        $nuevaCalificacion->save();
        return redirect()->back()->with('success', 'Calificación guardada correctamente.');
    }

    public function deleteCalificacion($id)
    {
        $calificacionEliminar = Calificacion::find($id);
        if ($calificacionEliminar != null) {
            $calificacionEliminar->delete();
        } else {
            return redirect()->back()->withErrors(['error' => 'Calificación no encontrada']);
        }
        return redirect()->back()->with('success', 'Calificación eliminada correctamente.');
    }

    public function editCalificacion($id)
    {
        $calificacionEditar = Calificacion::find($id);
        $grupos             = Grupo::all();
        $usuarios           = User::all();
        if ($calificacionEditar != null) {
            return view('admin.modificarcalificacion')->with('calificacion', $calificacionEditar)
                ->with('grupos', $grupos)
                ->with('usuarios', $usuarios);
        } else {
            return redirect()->back()->withErrors(['error' => 'Calificación no encontrada']);
        }
    }

    public function updateCalificacion(Request $request, $id)
    {
        $calificacionActualizar = Calificacion::find($id);
        if ($calificacionActualizar != null) {
            $calificacionActualizar->grupo_id     = $request->grupo_id;
            $calificacionActualizar->user_id      = $request->user_id;
            $calificacionActualizar->calificacion = $request->calificacion;
            $calificacionActualizar->save();
        } else {
            return redirect()->back()->withErrors(['error' => 'Calificación no encontrada']);
        }
        return redirect('/calificaciones')->with('success', 'Calificación actualizada correctamente.');
    }

    // ─── INSCRIPCIONES ──────────────────────────────────────
    public function inscripciones()
    {
        $inscripciones = Inscripcion::paginate(10);
        $usuarios      = User::all();
        $grupos        = Grupo::all();
        return view('admin.inscripciones')->with('inscripciones', $inscripciones)
            ->with('usuarios', $usuarios)
            ->with('grupos', $grupos);
    }

    public function saveInscripcion(Request $request)
    {
        $nuevaInscripcion = new Inscripcion();
        $nuevaInscripcion->user_id   = $request->user_id;
        $nuevaInscripcion->grupo_id  = $request->grupo_id;
        $nuevaInscripcion->save();
        return redirect()->back()->with('success', 'Inscripción guardada correctamente.');
    }

    public function deleteInscripcion($id)
    {
        $inscripcionEliminar = Inscripcion::find($id);
        if ($inscripcionEliminar != null) {
            $inscripcionEliminar->delete();
        } else {
            return redirect()->back()->withErrors(['error' => 'Inscripción no encontrada']);
        }
        return redirect()->back()->with('success', 'Inscripción eliminada correctamente.');
    }

    public function editInscripcion($id)
    {
        $inscripcionEditar = Inscripcion::find($id);
        $usuarios          = User::all();
        $grupos            = Grupo::all();
        if ($inscripcionEditar != null) {
            return view('admin.modificarinscripcion')->with('inscripcion', $inscripcionEditar)
                ->with('usuarios', $usuarios)
                ->with('grupos', $grupos);
        } else {
            return redirect()->back()->withErrors(['error' => 'Inscripción no encontrada']);
        }
    }

    public function updateInscripcion(Request $request, $id)
    {
        $inscripcionActualizar = Inscripcion::find($id);
        if ($inscripcionActualizar != null) {
            $inscripcionActualizar->user_id  = $request->user_id;
            $inscripcionActualizar->grupo_id = $request->grupo_id;
            $inscripcionActualizar->save();
        } else {
            return redirect()->back()->withErrors(['error' => 'Inscripción no encontrada']);
        }
        return redirect('/inscripciones')->with('success', 'Inscripción actualizada correctamente.');
    }
}
