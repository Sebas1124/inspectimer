@extends('adminlte::page')

@section('title', 'Supervisor')

@section('content')

    <div class="card mt-2">
        <div class="card-header">
            <h3 class="card-title">Lista de empleados</h3>
        </div>

        <div class="card-body">
            <table id="employees_table" class="table table-bordered table-striped dataTable">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Hora de inicio</th>
                        <th>Hora de Fin</th>
                        <th>Total horas</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($finalArray as $user)

                        <tr>
                            <td>{{ $user["name"] }}</td>
                            <td>{{ $user["hora_inicio"] }}</td>
                            <td>{{ $user["hora_fin"] }}</td>
                            <td>{{ $user["horas"] }}</td>
                            <td>{{ $user["fecha"] }}</td>
                            @if ( $user["hora_fin"] == null)
                                
                                <td>
                                    <button disabled class="btn btn-outline-primary">
                                        En curso
                                    </button>
                                    <button class="btn btn-outline-danger">
                                        Rechazar horas
                                    </button>
                                </td>
                            @else
                                <td>
                                    <button class="btn btn-outline-primary">
                                        Aceptar horas
                                    </button>
                                    <button class="btn btn-outline-danger">
                                        Rechazar horas
                                    </button>
                                </td>
                            @endif
                        </tr>
                        
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

@endsection

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endsection

@section('js')

<script>
    let table = new DataTable('#employees_table');
</script>

@endsection