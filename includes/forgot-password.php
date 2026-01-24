@extends('partials.layouts.master_auth')

@section('title', 'Forgot Password | Analisys')

@section('content')

<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow">
                <div class="card-body">

                    <h5 class="text-center mb-4">Recuperar contraseña</h5>

                    @if (session('status'))
                        <div class="alert alert-success text-center">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ url('/send-password-reset') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Correo electrónico</label>
                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Enviar enlace
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
