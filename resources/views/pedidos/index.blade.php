@extends('adminlte::page')

@section('title', 'Pedidos Pendientes')

@section('content_header')
    <h1>Index</h1>
@endsection

@section('content')
    <table id="tablaPedidos" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Descripción</th>
                <th>Servicio</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedidos as $pedido)
                <tr>
                    <td>{{ $pedido->id_pedido }}</td>
                    <td>{{ $pedido->cliente->nombre ?? 'Sin cliente' }}</td>
                    <td>{{ $pedido->descripcion }}</td>
                    <td>{{ $pedido->servicio }}</td>
                    <td>{{ $pedido->fecha->fecha ?? 'Sin fecha' }}</td>
                    <td>{{ $pedido->estado }}</td>
                    <td>
                        <a href="{{ route('pedidos.edit', $pedido->id_pedido) }}" class="btn btn-sm btn-primary">Editar</a>
                        <a href="{{ route('pedidos.show', $pedido->id_pedido) }}" class="btn btn-sm btn-info">Ver</a>
                        <form action="{{ route('pedidos.destroy', $pedido->id_pedido) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('¿Seguro que deseas eliminar este pedido?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('js')
    {{-- Carga JS de DataTables y bootstrap 4 si no lo has hecho --}}
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

    {{-- Estilos CSS si faltan --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css" />

    <script>
        $(document).ready(function () {
            $('#tablaPedidos').DataTable({
                order: [[0, 'desc']],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
                }
            });
        });
    </script>
@endsection