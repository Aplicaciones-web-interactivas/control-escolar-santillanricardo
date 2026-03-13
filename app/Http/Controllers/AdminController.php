<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materia;
use App\Models\Horario;
use App\Models\Grupo;
use App\Models\User;

class AdminController extends Controller
{
    public function indexAdmin()
    {
        return view('admin.dashboardAdmin');
    }

    // ─── MATERIAS ───────────────────────────────────────
    public function materias()
    {
        $materias = Materia::all();
        return view('admin.materias')->with('materias', $materias);
    }

    public function saveMateria(Request $request)
    {
        $nuevaMateria = new Materia();
        $nuevaMateria->nombre = $request->nombre;
        $nuevaMateria->clave = $request->clave;
        $nuevaMateria->save();
        return redirect()->back();
    }

    public function deleteMateria($id)
    {
        $materiaeliminar = Materia::find($id);
        if ($materiaeliminar != null) {
            $materiaeliminar->delete();
        } else {
            return redirect()->back()->withErrors(['error' => 'Materia no encontrada']);
        }
        return redirect()->back();
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
        return redirect('/materias');
    }

    // ─── HORARIOS ───────────────────────────────────────
    public function horarios()
    {
        $horarios = Horario::all();
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
        return redirect()->back();
    }

    public function deleteHorario($id)
    {
        $horarioEliminar = Horario::find($id);
        if ($horarioEliminar != null) {
            $horarioEliminar->delete();
        } else {
            return redirect()->back()->withErrors(['error' => 'Horario no encontrado']);
        }
        return redirect()->back();
    }

    public function editHorario($id)
    {
        $horarioEditar = Horario::find($id);
        $materias      = Materia::all();
        $usuarios      = User::all();
        if ($horarioEditar != null) {
            return view('admin.modificarhorario')->with('horario', $horarioEditar)
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
        return redirect('/horarios');
    }

    // ─── GRUPOS ─────────────────────────────────────────
    public function grupos()
    {
        $grupos   = Grupo::all();
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
        return redirect()->back();
    }

    public function deleteGrupo($id)
    {
        $grupoEliminar = Grupo::find($id);
        if ($grupoEliminar != null) {
            $grupoEliminar->delete();
        } else {
            return redirect()->back()->withErrors(['error' => 'Grupo no encontrado']);
        }
        return redirect()->back();
    }

    public function editGrupo($id)
    {
        $grupoEditar = Grupo::find($id);
        $horarios    = Horario::all();
        if ($grupoEditar != null) {
            return view('admin.modificargrupo')->with('grupo', $grupoEditar)
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
        return redirect('/grupos');
    }
}