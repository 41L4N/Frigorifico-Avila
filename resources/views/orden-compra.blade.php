{{-- Plantilla --}}
@extends('plantillas.plantilla')

{{-- Metadatos --}}
@php
    $tituloMD = __('textos.rutas.' . str_replace('-', '_', $nRuta = Route::currentRouteName()) );
@endphp

{{-- Estilos --}}
@section('estilos')
    <style>
        /* Dirección de envío */
        #direccionEnvio {
            max-height: 1000px;
            transition: .5s;
        }
        #direccionEnvio:disabled {
            max-height: 0px;
            overflow: hidden;
        }
    </style>
@endsection

{{-- Contenido --}}
@section('contenido')

    {{-- Validación de usuario --}}
    @auth
        <form method="POST">
            @csrf

            {{-- Información de facturación --}}
            {{-- Título --}}
            <div class="subtitulo-form">{{__('textos.titulos.informacion_facturacion')}}</div>

            {{-- Campos --}}
            <div class="fila-form">
                <div>
                    <label>{{__('textos.campos.' . $n='nombre')}}</label>
                    <input class="form-control" maxlength="50" value="{{Auth::user()->nombre}}" readonly disabled>
                </div>
                <div>
                    <label>{{__('textos.campos.' . $n='apellido')}}</label>
                    <input class="form-control" maxlength="50" value="{{Auth::user()->apellido}}" readonly disabled>
                </div>
            </div>

            {{-- Email y teléfono --}}
            <div class="fila-form">
                <div>
                    <label>{{__('textos.campos.' . $n='email')}}</label>
                    <input class="form-control" maxlength="75" value="{{Auth::user()->email}}" readonly disabled>
                </div>
                {{-- <div>
                    <label>{{__('textos.campos.' . $n='telf')}}</label>
                    <div class="d-flex">
                        <input class="form-control w-25" placeholder="58" minlength="2" maxlength="4" onkeypress="soloNumeros(event)" required>
                        <input class="form-control" placeholder="1234567890" minlength="7" maxlength="12" onkeypress="soloNumeros(event)" required>
                    </div>
                </div> --}}
            </div>

            {{-- Información de envio --}}
            {{-- Título --}}
            <div class="subtitulo-form">{{__('textos.titulos.informacion_envio')}}</div>
            {{-- Check --}}
            <div class="fila-form">
                <div>
                    <label><input type="checkbox" onchange="direccionEnvio.disabled = !direccionEnvio.disabled">{{__('textos.campos.datos_diferentes')}}</label>
                </div>
            </div>

            {{-- Campos --}}
            <fieldset id="direccionEnvio" disabled>
                <div class="fila-form">
                    <div>
                        <label>{{__('textos.campos.' . $n='nombre')}}</label>
                        <input name="datos_facturacion[{{$n}}]" class="form-control" maxlength="50" required>
                    </div>
                    <div>
                        <label>{{__('textos.campos.' . $n='apellido')}}</label>
                        <input name="datos_facturacion[{{$n}}]" class="form-control" maxlength="50" required>
                    </div>
                </div>

                {{-- Email y teléfono --}}
                <div class="fila-form">
                    <div>
                        <label>{{__('textos.campos.' . $n='email')}}</label>
                        <input name="datos_facturacion[{{$n}}]" class="form-control" maxlength="75" required>
                    </div>
                    {{-- <div>
                        <label>{{__('textos.campos.' . $n='telf')}}</label>
                        <div class="d-flex">
                            <input name="datos_facturacion[{{$n}}][codigo]" class="form-control w-25" placeholder="58" minlength="2" maxlength="4" onkeypress="soloNumeros(event)" required>
                            <input name="datos_facturacion[{{$n}}][numero]" class="form-control" placeholder="1234567890" minlength="7" maxlength="12" onkeypress="soloNumeros(event)" required>
                        </div>
                    </div> --}}
                </div>

                {{-- Uno adicional para el margencito XD --}}
                <div class="fila-form"></div>
            </fieldset>

            {{-- Nombre de la empresa --}}
            <div class="fila-form">
                <div>
                    <label>{{__('textos.campos.' . $n='nombre_empresa')}}</label>
                    <input name="{{$n}}" class="form-control" maxlength="75">
                </div>
            </div>

            {{-- Dirección --}}
            <div class="fila-form">
                {{-- Calle --}}
                <div>
                    <label>{{__('textos.campos.' . $n='calle')}}</label>
                    <input name="direccion[{{$n}}]" class="form-control" maxlength="75" required>
                </div>
                {{-- Número de puerta --}}
                <div>
                    <label>{{__('textos.campos.' . $n='n_puerta')}}</label>
                    <input name="direccion[{{$n}}]" class="form-control" maxlength="75" required>
                </div>
                {{-- Código postal --}}
                <div>
                    <label>{{__('textos.campos.' . $n='codigo_postal')}}</label>
                    <input name="direccion[{{$n}}]" class="form-control" maxlength="75" required>
                </div>
            </div>
            <div class="fila-form">
                {{-- Estado --}}
                <div>
                    <label>{{__('textos.campos.' . $n='estado')}}</label>
                    <select name="direccion[{{$n}}]" class="form-control" required>
                        <option value="" selected disabled>{{__('textos.placeholders.select')}}</option>
                        @foreach ([
                            'Ciudad Autónoma de Buenos Aires',
                            'Buenos Aires',
                            'Catamarca',
                            'Chaco',
                            'Chubut',
                            'Córdoba',
                            'Corrientes',
                            'Entre Ríos',
                            'Formosa',
                            'Jujuy',
                            'La Pampa',
                            'La Rioja',
                            'Mendoza',
                            'Misiones',
                            'Neuquén',
                            'Río Negro',
                            'Salta',
                            'San Juan',
                            'San Luis',
                            'Santa Cruz',
                            'Santa Fe',
                            'Santiago del Estero',
                            'Tierra del Fuego',
                            'Tucumán'
                        ] as $e)
                            <option value="{{$e}}">{{$e}}</option>
                        @endforeach
                    </select>
                </div>
                {{-- Ciudad --}}
                <div>
                    <label>{{__('textos.campos.' . $n='ciudad')}}</label>
                    <input name="direccion[{{$n}}]" class="form-control" maxlength="75" required>
                </div>
                {{-- Pais --}}
                <div>
                    <label>{{__('textos.campos.' . $n='pais')}}</label>
                    <input name="direccion[{{$n}}]" class="form-control" maxlength="75" value="Argentina" readonly required>
                </div>
            </div>

            {{-- Notas --}}
            <div class="fila-form">
                <div>
                    <label>{{__('textos.campos.notas_pedido')}}</label>
                    <textarea name="notas" class="form-control" maxlength="500"></textarea>
                </div>
            </div>

            {{-- Lista de compras --}}
            {{-- Título --}}
            <div class="subtitulo-form">{{__('textos.titulos.lista_compras')}} (<span class="n-compras"></span>)</div>
            {{-- Compras --}}
            <div id="contListaCompras"></div>
            {{-- Total --}}
            <div class="text-center">
                {{__('textos.campos.total')}}
                <br>
                <b class="precio-total"></b>
            </div>

            {{-- Forma de pago --}}
            {{-- Título --}}
            <div class="subtitulo-form">{{__('textos.titulos.forma_pago')}}</div>

            {{-- Cupon --}}
            <div class="fila-form">
                <div>
                    <label>{{__('textos.campos.cupon')}}</label>
                    <input type="text" name="cupon" class="form-control" maxlength="25">
                </div>
            </div>

            {{-- Botones --}}
            <div class="btns-form">
                <button class="btn btn-primary">{{__('textos.botones.confirmar')}}</button>
            </div>
        </form>

    {{-- Si no hay usuario --}}
    @else
        <div class="text-center w-100">
            {!! __('textos.contenido.necesita_ingreso') !!}
        </div>
    @endauth
@endsection

{{-- JavaScript --}}
@section('js')
    <script>
        var mensajesErrores = new Object( @json( $errors->messages() ) ),
            valoresErrores  = new Object( @json( request()->old() ) );
    </script>
@endsection