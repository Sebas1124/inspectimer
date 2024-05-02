@extends('adminlte::page')

@section('title', 'Supervisor')

@section('content')

    <div class="card mt-2">
        <div class="card-header">
            <h3 class="card-title">Lista de empleados</h3>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped dataTable">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Horas</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)

                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <button class="btn btn-outline-primary">
                                    Aceptar horas
                                </button>
                            </td>
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

@endsection