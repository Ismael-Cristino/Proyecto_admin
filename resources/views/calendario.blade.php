@extends('adminlte::page')

@section('title', 'Calendario de Pedidos')

@section('content_header')
    <h1>Calendario de Pedidos</h1>
@endsection

@section('content')
<div class="row">
    <!-- Panel izquierdo estilo AdminLTE -->
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Estados</h5>
            </div>
            <div class="card-body">
                <div class="external-event bg-primary text-white px-2 py-1 mb-2 rounded">Reservado</div>
                <div class="external-event bg-info text-white px-2 py-1 mb-2 rounded">Pagado</div>
                <div class="external-event bg-success text-white px-2 py-1 mb-2 rounded">Completado</div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title">Acciones</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('pedidos.create') }}" class="btn btn-primary btn-block">
                    Crear Pedido
                </a>
            </div>
        </div>
    </div>

    <!-- Calendario principal -->
    <div class="col-md-9">
        <div class="card card-primary">
            <div class="card-body p-0">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet" />
    <style>
        #calendar {
            padding: 20px;
        }
    </style>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                height: 'auto',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                events: {
                    url: '/api/eventos-calendario',
                    failure: function () {
                        alert('Error al cargar los eventos.');
                    }
                },
                loading: function (isLoading) {
                    if (isLoading) {
                        console.log('Cargando eventos...');
                    }
                },
                dateClick: function(info) {
                    calendar.changeView('timeGridDay', info.dateStr);
                },
                eventDidMount: function(info) {
                    if (info.event.title) {
                        new bootstrap.Tooltip(info.el, {
                            title: info.event.title,
                            placement: 'top',
                            trigger: 'hover',
                            container: 'body'
                        });
                    }
                }
            });

            calendar.render();
        });
    </script>
@endsection
