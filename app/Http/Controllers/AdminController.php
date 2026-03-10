<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materia;

class AdminController extends Controller
{
    public function indexAdmin()
    {
        return view('admin.dashboardAdmin');
    }

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
            $materiaActualizar->clave = $request->clave; // ← corregido: era ->codigo
            $materiaActualizar->save();
        } else {
            return redirect()->back()->withErrors(['error' => 'Materia no encontrada']);
        }
        return redirect('/materias');
    }
}
