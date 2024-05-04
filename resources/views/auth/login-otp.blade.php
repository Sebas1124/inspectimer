@extends('layouts.App')

@section('css')

<style>
    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 10px;
    }

    .image {
        order: 2; /* Cambia el orden de visualización en pantallas grandes */
    }

    @media (max-width: 768px) {
        .grid-container {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 10px;
        }

        .image {
            order: 1; /* Cambia el orden de visualización en pantallas pequeñas */
        }
    }
</style>

@endsection


@section('content')

@php
    if ( Auth::check() ) {
        exit (header('Location: /'));
    }
@endphp


<div class="container d-flex justify-content-center align-items-center align-content-center" style="height: 100vh;">
    <div class="card p-4" id="loginCard" style="width: 600px;">

        <div class="card-body">
            <h5 id="loginCardTitle" style="font-size: 30px; font-weight: bold" class="card-title text-center">Login</h5>
        </div>

        <div class="grid-container">
            <div class="image">
                <img src="{{ asset('imgs/loginPic.png') }}" class="img-fluid" alt="Login">
            </div>
    
            <form action="{{ route('login.verify') }}" method="POST">
                @csrf
                <div class="form-group mb-2">
                    <label id="emailText" for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
        
                <div class="form-group mb-2">
                    <label id="passwordCardLogin" for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                </div>
        
                <button type="submit" id="pressLoginButton" class="btn btn-outline-primary btn-block mt-3">Login</button>
            </form>
        </div>
    
    </div>
</div>



@endsection

@section('js')

    <script>
        const pressLoginButton = document.getElementById('pressLoginButton');

        pressLoginButton.addEventListener('click', () => {
            openLoader();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            if (email === '' || password === '') {
                closeLoader();
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Por favor, rellena todos los campos',
                });

                return false;
            }
        });

    </script>

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
            })
        </script>
        
    @endif
@endsection
