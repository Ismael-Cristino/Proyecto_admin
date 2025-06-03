@extends('adminlte::page')

@section('title', 'Cambiar contraseña')

@section('content_header')
    <h1>Cambiar Contraseña</h1>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('usuarios.password') }}">
        @csrf
        <div class="form-group">
            <label for="current_password">Contraseña actual</label>
            <input type="password" name="current_password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password">Nueva contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmar nueva contraseña</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Cambiar contraseña</button>
    </form>
@endsection
