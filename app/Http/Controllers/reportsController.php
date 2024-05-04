<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Horas_admin;
use Illuminate\Http\Request;

class reportsController extends Controller
{
    public function index(){

        $users = Horas_admin::leftJoin('users', 'users.id', 'horas_admin.adminUserId')
            ->leftJoin('horas_empleados', 'horas_empleados.id', 'horas_admin.horas_empleados_id')
            ->leftJoin('status_hours', 'status_hours.id', 'horas_admin.status')
            ->leftJoin('users as empleados', 'empleados.id', 'horas_empleados.userId')
            ->select(
                'users.name as nombre_admin', 
                'users.email as email_admin', 
                'status_hours.name_status',
                'horas_empleados.fecha',
                'horas_empleados.hora_inicio',
                'horas_empleados.hora_fin',
                'horas_empleados.horas',
                'horas_admin.comentario',
                'empleados.name as nombre_empleado',
                'empleados.email as email_empleado'
            )
            ->get();

        return view('admin.reports.index', compact('users'));
    }
}
