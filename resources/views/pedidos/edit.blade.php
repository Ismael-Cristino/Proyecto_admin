@extends('adminlte::page')

@section('title', 'Editar Pedido')

@section('content_header')
    <h1>Editar Pedido</h1>
@endsection

@section('content')
    <form action="{{ route('pedidos.update', $pedido->id_pedido) }}" method="POST">
        @csrf
        <input type="hidden" name="redirect_back" value="{{ $redirect_back }}">
        @method('PUT')

        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <input type="text" name="descripcion" class="form-control"
                value="{{ old('descripcion', $pedido->descripcion) }}" required>
        </div>

        <div class="form-group">
            <label for="servicio">Servicio</label>
            <select name="servicio" class="form-control" required>
                <option value="trasladoDom" {{ $pedido->servicio == 'trasladoDom' ? 'selected' : '' }}>Traslado de domicilio
                </option>
                <option value="trasladoOfi" {{ $pedido->servicio == 'trasladoOfi' ? 'selected' : '' }}>Traslado de oficina
                </option>
                <option value="retiro" {{ $pedido->servicio == 'retiro' ? 'selected' : '' }}>Retiro de objetos en desuso
                </option>
                <option value="vaciado" {{ $pedido->servicio == 'vaciado' ? 'selected' : '' }}>Vaciados de trasteros</option>
                <option value="otros" {{ $pedido->servicio == 'otros' ? 'selected' : '' }}>Otros</option>
            </select>
        </div>

        <div class="form-group">
            <label for="estado">Estado</label>
            <select name="estado" class="form-control" required>
                <option value="pendiente" {{ $pedido->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="reservado" {{ $pedido->estado == 'reservado' ? 'selected' : '' }}>Reservado</option>
                <option value="pagado" {{ $pedido->estado == 'pagado' ? 'selected' : '' }}>Pagado</option>
                <option value="completado" {{ $pedido->estado == 'completado' ? 'selected' : '' }}>Completado</option>
                <option value="cancelado" {{ $pedido->estado == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
            </select>
        </div>

        <div class="form-group">
            <label for="nombre_cliente">Cliente</label>
            <input type="hidden" name="id_cliente" value="{{ $pedido->id_cliente }}">
            <input type="text" name="nombre_cliente" class="form-control"
                value="{{ old('nombre_cliente', $pedido->cliente->nombre) }}" required>
        </div>

        <div class="form-group">
            <label for="fecha_inicio">Fecha y hora de inicio</label>
            <input type="datetime-local" name="fecha_inicio" class="form-control"
                value="{{ old('fecha_inicio', \Carbon\Carbon::parse($pedido->fecha->fecha_inicio)->format('Y-m-d\TH:i')) }}"
                required>
        </div>

        <div class="form-group">
            <label for="fecha_fin">Fecha y hora de fin</label>
            <input type="datetime-local" name="fecha_fin" class="form-control"
                value="{{ old('fecha_fin', \Carbon\Carbon::parse($pedido->fecha->fecha_fin)->format('Y-m-d\TH:i')) }}"
                required>
        </div>

        <hr>
        <h4>Factura</h4>
        <small>IVA del 21%</small>
        <div class="row mb-2">
            <div class="col">
                <input type="number" step="0.01" name="precio_bruto" id="precio_bruto" placeholder="Precio bruto (€)"
                    class="form-control" value="{{ old('precio_bruto', $pedido->factura->precio_bruto) }}">
            </div>

            <input type="hidden" name="iva" id="iva" value="21">

            <div class="col">
                <input type="number" step="0.01" name="precio_final" id="precio_final" placeholder="Precio final (€)"
                    class="form-control" value="{{ old('precio_final', $pedido->factura->precio_final) }}" readonly>
            </div>
        </div>

        @push('js')
            <script>
                document.getElementById('precio_bruto').addEventListener('input', function () {
                    const bruto = parseFloat(this.value);
                    const iva = 21;
                    if (!isNaN(bruto)) {
                        const final = bruto + (bruto * iva / 100);
                        document.getElementById('precio_final').value = final.toFixed(2);
                    } else {
                        document.getElementById('precio_final').value = '';
                    }
                });
            </script>
        @endpush


        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancelar</a>

    </form>
@endsection