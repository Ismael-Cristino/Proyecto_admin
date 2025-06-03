@extends('adminlte::page')

@section('title', 'Crear Pedido')

@section('content_header')
    <h1>Crear nuevo pedido</h1>
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif
    <small>Los nuevos pedidos se envian a <a href="{{ route('pedidos.reservados') }}">Reservados</a></small>
    <form action="{{ route('pedidos.store') }}" method="POST">
        @csrf

        <input type="text" name="nombre" placeholder="Nombre y apellidos" class="form-control mb-2"
            value="{{ old('nombre') }}">

        <div class="row mb-2">
            <div class="col">
                <input type="number" name="numero" placeholder="Número de teléfono" class="form-control"
                    value="{{ old('numero') }}">
            </div>
            <div class="col">
                <input type="email" name="email" placeholder="Correo electrónico" class="form-control"
                    value="{{ old('email') }}">
            </div>
        </div>

        <div class="form-group">
            <label for="fecha_inicio">Fecha y hora de inicio</label>
            <input type="datetime-local" name="fecha_inicio" class="form-control mb-2" value="{{ old('fecha_inicio') }}">
        </div>

        <div class="form-group">
            <label for="fecha_fin">Fecha y hora de fin</label>
            <input type="datetime-local" name="fecha_fin" class="form-control mb-2" value="{{ old('fecha_fin') }}">
        </div>

        <select name="servicio" class="form-control mb-2">
            <option value="">-- Selecciona un servicio --</option>
            <option value="trasladoDom" {{ old('servicio') == 'trasladoDom' ? 'selected' : '' }}>Traslado de domicilio
            </option>
            <option value="trasladoOfi" {{ old('servicio') == 'trasladoOfi' ? 'selected' : '' }}>Traslado de oficina</option>
            <option value="retiro" {{ old('servicio') == 'retiro' ? 'selected' : '' }}>Retiro de objetos en desuso</option>
            <option value="vaciado" {{ old('servicio') == 'vaciado' ? 'selected' : '' }}>Vaciados de trasteros</option>
            <option value="otros" {{ old('servicio') == 'otros' ? 'selected' : '' }}>Otros</option>
        </select>

        <small class="form-text text-muted mb-1">Incluye ciudad, población, código postal, número, etc.</small>
        <div class="row mb-2">
            <div class="col">
                <input type="text" name="direccionOri" placeholder="Dirección Origen" class="form-control"
                    value="{{ old('direccionOri') }}">
            </div>
            <div class="col-auto align-self-center">
                <span>&rarr;</span>
            </div>
            <div class="col">
                <input type="text" name="direccionDes" placeholder="Dirección Destino" class="form-control"
                    value="{{ old('direccionDes') }}">
            </div>
        </div>

        <textarea name="descripcion" rows="5" placeholder="Describe los muebles, cantidad, etc."
            class="form-control mb-3">{{ old('descripcion') }}</textarea>

        <hr>
        <h4>Factura</h4>
        <small>IVA del 21%</small>
        <div class="row mb-2">
            <div class="col">
                <input type="number" step="0.01" name="precio_bruto" id="precio_bruto" placeholder="Precio bruto (€)"
                    class="form-control" value="{{ old('precio_bruto') }}">
            </div>

            <input type="hidden" name="iva" id="iva" value="21"> <!-- oculto pero enviado -->

            <div class="col">
                <input type="number" step="0.01" name="precio_final" id="precio_final" placeholder="Precio final (€)"
                    class="form-control" value="{{ old('precio_final') }}" readonly>
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

        <br>
        <button type="submit" class="btn btn-success">Enviar formulario</button>
        <a href="{{ route('pedidos.pendientes') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection