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
                <button data-type="create" class="btn btn-primary openModal" data-modal-title="Crear un usuario" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Crear usuario
                </button>
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
                                <button data-type="edit" class="btn btn-info openModal" data-modal-title="Editar usuario" data-userId="{{ $user->id }}" data-modal-content="Contenido del modal de edición" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    Editar
                                </button>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger buttonDestroy" type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @component('components.modal-edit-component')
            
        @endcomponent

    </div>

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')

@if (session('success'))

<script>
    Swal.fire(
        'Exito!',
        '{{ session('success') }}',
        'success'
    )
</script>
    
@endif

<script>

    const buttonDestroy = document.querySelectorAll('.buttonDestroy');

    buttonDestroy.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const form = e.target.parentElement;
            Swal.fire({
                title: '¿Estas seguro?',
                text: "No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        });
    });


</script>

    

    
@stop