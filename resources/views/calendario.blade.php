@extends('adminlte::page')

@section('title', 'Calendario de Pedidos')

@section('content_header')
    <h1>Calendario</h1>
@endsection

@section('content')
    <div id="calendar"></div>
@endsection

@section('js')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                businessHours: true,
                events: '/api/pedidos', // Ya configurado
            });

            calendar.render();
        });
    </script>
@endsection