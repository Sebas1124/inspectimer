<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Horas_admin;
use App\Models\horas_empleados;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupervisorController extends Controller
{
    public function index(){

        $usersPendingStatus = horas_empleados::leftJoin('horas_admin as aprobadas', 'aprobadas.horas_empleados_id', 'horas_empleados.id')
            ->leftJoin('users', 'users.id', 'horas_empleados.userId')
            ->where([ 'aprobadas.status' => NULL ])
            ->WhereNotNull('horas_empleados.hora_fin')
            ->select('users.name', 'users.email', 'horas_empleados.*', 'aprobadas.status')
            ->get();

        $usersCurrent = horas_empleados::leftJoin('horas_admin as aprobadas', 'aprobadas.horas_empleados_id', 'horas_empleados.id')
            ->leftJoin('users', 'users.id', 'horas_empleados.userId')
            ->whereNull('horas_empleados.hora_fin')
            ->WhereNotNull('horas_empleados.hora_inicio')
            ->select('users.name', 'users.email', 'horas_empleados.*', 'aprobadas.status')
            ->get();

        $finalArray = array_merge($usersPendingStatus->toArray(), $usersCurrent->toArray());


        return view('admin.employee.index', compact('finalArray'));
    }

    public function store( Request $request ){

        $fecha = Carbon::parse($request->fecha)->format('Y-m-d');

        $verify = horas_empleados::where('userId', $request->userId)
            ->where('fecha', $fecha)
            ->first();

        if ( $request->tipo === 'Inicio de jornada' ) {
            if( $verify && $verify->hora_fin === NULL ){
                throw new \Exception("Ya se ha registrado un $request->tipo para este empleado en esta fecha, $fecha");
            }
        }

        if ( $request->tipo === 'Fin de jornada' ) {
            if( $verify && $verify->hora_fin ){
                throw new \Exception("No se ha registrado un Inicio de jornada para este empleado en esta fecha, $fecha");
            }
        }
            
        if( $request->tipo === 'Fin de jornada' ){

            $exists = horas_empleados::where('userId', $request->userId)
                ->where('fecha', $fecha)
                ->where('tipo', 'Inicio de jornada')
                ->first();

            if( $exists->hora_fin ){
                throw new \Exception("Ya se ha registrado un Fin de jornada para este empleado en esta fecha, $fecha");
            }

            $horaFin = $request->hora;

            $horaInicio = Carbon::parse($exists->hora_inicio);
            $horaFin = Carbon::parse($horaFin);
            
            $horas = $horaInicio->diffInMinutes($horaFin);
            
            $horas = gmdate('H:i:s', $horas * 60);

            $exists->hora_fin = $horaFin;
            $exists->horas = $horas;
            $exists->tipo = 'fin de jornada';
            $exists->save();

            return json_encode(['message' => 'Horas registradas correctamente']);
                
        }else{
            $horaInicio = $request->hora;
            $horaFin = null;
            $horas = NULL;
        }

        horas_empleados::create([
            'userId'      => $request->userId,
            'hora_inicio' => $horaInicio,
            'hora_fin'    => $horaFin,
            'horas'       => $horas,
            'fecha'       => $fecha,
            'tipo'        => $request->tipo
        ]);

        return json_encode(['message' => 'Horas registradas correctamente']);
    }

    public function aceptarHoras( Request $request ){

        $horas      = horas_empleados::find($request->registroId);
        $comentario = $request->comentario;
        $userAdmin  = Auth::user()->id;

        Horas_admin::create([
            'horas_empleados_id' => $horas->id,
            'adminUserId'        => $userAdmin,
            'comentario'         => $comentario,
            'status'             => 1
        ]);


        return response()->json(['message' => 'Horas aceptadas correctamente']);
    }
}
