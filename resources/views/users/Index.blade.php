@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <h1>Gestion de usuarios</h1>
@stop

@section('content')
    
    <div class="card p-2">
        <div class="card-header">
            <h3 class="card-title
            ">Usuarios</h3>

            <div class="card-tools">
                <button id="openModal" class="btn btn-primary">Crear usuario</button>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <td>Foto</td>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                                <img src="{{ $user->picture_path }}" alt="{{ $user->name }}" width="40px">
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            
                            <td>
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-info">Editar</a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @component('components.modal-component')
            
        @endcomponent

    </div>

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')

    

    
@stop