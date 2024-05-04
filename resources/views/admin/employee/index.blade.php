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
                                    <button data-registroId="{{ $user["id"] }}" class="btn btn-outline-danger cancelHoras">
                                        Rechazar horas
                                    </button>
                                </td>
                            @else
                                <td>
                                    <button data-registroId="{{ $user["id"] }}" class="btn btn-outline-primary acceptButton">
                                        Aceptar horas
                                    </button>
                                    <button data-registroId="{{ $user["id"] }}" class="btn btn-outline-danger cancelHoras">
                                        Rechazar horas
                                    </button>
                                </td>
                            @endif
                        </tr>
                        
                    @endforeach
                </tbody>
            </table>
        </div>

        @component('components.accept-hours-component')
            
        @endcomponent

        @component('components.cancel-hours-component')
            
        @endcomponent

    </div>

@endsection

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endsection

@section('js')

<script>
    let table = new DataTable('#employees_table');

    const acceptButton = document.querySelectorAll('.acceptButton');
    const modal = new bootstrap.Modal(document.getElementById('exampleModal'));

    const cancelHoras = document.querySelectorAll('.cancelHoras');
    const modalCancel = new bootstrap.Modal(document.getElementById('exampleModalCancel'));

    acceptButton.forEach(button => {
        button.addEventListener('click', () => {
            let registroId = button.getAttribute('data-registroId');
            const registroID = document.getElementById('registroID').value = registroId;
            modal.show();
        });
    });

    cancelHoras.forEach(btn => {
        btn.addEventListener('click', () => {
            let registroId = btn.getAttribute('data-registroId');
            const registroID = document.getElementById('registroID').value = registroId;
            modalCancel.show();
        });
    });

</script>

@endsection