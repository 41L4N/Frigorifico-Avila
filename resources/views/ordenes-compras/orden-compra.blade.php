{{-- Plantilla --}}
@extends('plantillas.plantilla')

{{-- Metadatos --}}
@php
    $tituloMD = __('textos.rutas.' . str_replace('-', '_', Route::currentRouteName()) );
@endphp

{{-- Estilos --}}
@section('estilos')
    <style>
        /* Dirección de envío */
        #datosFacturacion {
            max-height: 1000px;
            transition: .5s;
        }
        #datosFacturacion:disabled {
            max-height: 0px;
            overflow: hidden;
        }

        /* Envío a domicilio */
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
    <form method="POST">
        @csrf

        {{-- Datos de facturación --}}
        {{-- Título --}}
        <div class="subtitulo-form">{{__('textos.titulos.datos_facturacion')}}</div>

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

        {{-- Datos diferentes --}}
        {{-- Check --}}
        <div class="fila-form">
            <label class="w-auto c-pointer"> <input type="checkbox" onchange="datosFacturacion.disabled = !datosFacturacion.disabled"> {{__('textos.campos.datos_facturacion')}} </label>
        </div>
        {{-- Campos --}}
        <fieldset id="datosFacturacion" disabled>
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

        {{-- Dirección de envio --}}
        {{-- Check --}}
        <div class="fila-form">
            <label class="w-auto c-pointer"> <input type="checkbox" onchange="direccionEnvio.disabled = !direccionEnvio.disabled"> {{__('textos.campos.direccion_envio')}} </label>
        </div>
        {{-- Campos --}}
        <fieldset id="direccionEnvio" disabled>
            <div>
                {{-- Dirección --}}
                <div class="fila-form">
                    {{-- Calle --}}
                    <div>
                        <label>{{__('textos.campos.' . $n='calle')}}</label>
                        <input name="direccion_envio[{{$n}}]" class="form-control" maxlength="75" required>
                    </div>
                    {{-- Número de puerta --}}
                    <div>
                        <label>{{__('textos.campos.' . $n='codigo_puerta')}}</label>
                        <input name="direccion_envio[{{$n}}]" class="form-control" maxlength="75" required>
                    </div>
                    {{-- Código postal --}}
                    <div>
                        <label>{{__('textos.campos.' . $n='codigo_postal')}}</label>
                        <input name="direccion_envio[{{$n}}]" class="form-control" maxlength="75" required>
                    </div>
                </div>
                <div class="fila-form">
                    {{-- Estado --}}
                    <div>
                        <label>{{__('textos.campos.' . $n='estado')}}</label>
                        <select name="direccion_envio[{{$n}}]" class="form-control" required>
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
                        <input name="direccion_envio[{{$n}}]" class="form-control" maxlength="75" required>
                    </div>
                </div>
            </div>

            {{-- Uno adicional para el margencito XD --}}
            <div class="fila-form"></div>
        </fieldset>

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

        {{-- Notas --}}
        <div class="fila-form">
            <div>
                <label>{{__('textos.campos.notas')}}</label>
                <textarea name="notas" class="form-control" maxlength="500"></textarea>
            </div>
        </div>

        {{-- Botones --}}
        <div class="btns-form">
            <button class="btn btn-primary">{{__('textos.botones.confirmar')}}</button>
        </div>
    </form>
@endsection

{{-- JavaScript --}}
@section('js')
    <script>
        var mensajesErrores = new Object( @json( $errors->messages() ) ),
            valoresErrores  = new Object( @json( request()->old() ) );

            // Contenido desplegable
            function contenidoDesplegable(btn) {
                
            }
    </script>
@endsection