@extends('adminlte::page')

@section('title', 'Dashboard')


@section('content')
    
<div class="card mt-2">
    <div class="card-header">
        <h3 class="card-title">Lista de empleados</h3>
    </div>

    <div class="card-body">
        <table id="reports_Table" class="table table-bordered table-striped dataTable">
            <thead>
                <tr>
                    <th>Empleado</th>
                    <th>Email Empleado</th>
                    <th>Total horas</th>
                    <th>Fecha</th>
                    <th>Administrador</th>
                    <th>Email Administrador</th>
                    <th>Estado de horas</th>
                    <th>Comentario</th>
                    <th>fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)

                    <tr>
                        <td>{{ $user["nombre_empleado"] }}</td>
                        <td>{{ $user["email_empleado"] }}</td>
                        <td>{{ $user["horas"] }}</td>
                        <td>{{ $user["fecha"] }}</td>
                        <td>{{ $user["nombre_admin"] }}</td>
                        <td>{{ $user["email_admin"] }}</td>
                        <td>{{ $user["name_status"] }}</td>
                        <td>{{ $user["comentario"] }}</td>
                        <td>{{ $user["fecha"] }}</td>

                    </tr>
                    
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')

    <script>
        $(document).ready(function() {
            $('#reports_Table').DataTable();
        });
    </script>

@stop