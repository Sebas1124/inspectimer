@extends('adminlte::page')

@section('title', 'Dashboard')


@section('content')
    
    <div class="card p-2 mt-2">
        <div class="card-header">
            <h3 class="card-title">
                Bienvenido {{ Auth::user()->name }}
            </h3>
        </div>
        <div class="card-body">
            <p>Este es tu panel de control, aquí podrás visualizar las horas de cada uno de los empleados.</p>
        </div>

        <div class="card">

            <div class="card-body d-flex justify-content-center align-items-center flex-wrap">
                @foreach ($employees as $employe)
                    @php
                        $horas = 0;
                    @endphp
                    <div class="card m-2" style="max-width: 300px; min-height: 300px; max-height: 400px; overflow-y: hidden">
                        <div class="card-body d-flex flex-column align-items-center">
                            <div class="mb-4">
                                <img src="{{ $employe->picture_path }}" width="100px" alt="{{ $employe->name }}" class="img-fluid">
                            </div>
                            <div class="text-center">
                                <strong style="font-size: 20px">{{ $employe->name }}</strong>
                                <br>
                                <p>Empleado de la empresa</p>
                                <strong>Horas trabajadas {{ $horas }}</strong>
                                <p>Horas trabajadas en la semana {{ $horas }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

    </div>

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
@stop