@extends('adminlte::page')

@section('title', 'Panel de control')

@section('content_header')
    <h1>Panel de control</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $pendientes }}</h3>
                    <p>Pedidos Pendientes</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
                <a href="{{ route('pedidos.pendientes') }}" class="small-box-footer">
                    Ver pedidos <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $reservados }}</h3>
                    <p>Pedidos Reservados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <a href="{{ route('pedidos.reservados') }}" class="small-box-footer">
                    Ver pedidos <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $pagados }}</h3>
                    <p>Pedidos Pagados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-euro-sign"></i>
                </div>
                <a href="#" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $completados }}</h3>
                    <p>Pedidos Completados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check"></i>
                </div>
                <a href="#" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $cancelados }}</h3>
                    <p>Pedidos Cancelados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-times"></i>
                </div>
                <a href="#" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
@endsection