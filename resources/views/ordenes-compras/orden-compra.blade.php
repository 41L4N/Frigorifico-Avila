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
        #datosFacturacion, #direccionEnvio, #mercadoPago {
            max-height: 1000px;
            transition: .5s;
            margin-bottom: 12.5px;
        }
        #datosFacturacion:disabled, #direccionEnvio:disabled, #mercadoPago:disabled {
            max-height: 0px;
            overflow: hidden;
        }
    </style>
@endsection

{{-- Contenido --}}
@section('contenido')

    {{-- Formulario --}}
    @if (!$idOrdenCompra)
        <form method="POST" id="paymentForm">
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
            </fieldset>

            {{-- Lista de compras --}}
            {{-- Título --}}
            <div class="subtitulo-form">{{__('textos.titulos.lista_compras')}} (<span class="n-compras"></span>)</div>
            {{-- Alerta --}}
            <div class="alert alert-success text-center" id="alertaListaCompras"></div>
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

            {{-- Mercado pago --}}
            {{-- Check --}}
            <div class="fila-form flex-column">
                <label class="w-auto c-pointer"> <input type="radio" name="forma_pago" value="Efectivo" onchange="mercadoPago.disabled = !mercadoPago.disabled" checked required> {{__('textos.campos.efectivo')}} </label>
                <label class="w-auto c-pointer"> <input type="radio" name="forma_pago" value="Mercado Pago" onchange="mercadoPago.disabled = !mercadoPago.disabled" required> {{__('textos.campos.mercado_pago')}} </label>
            </div>
            {{-- Campos --}}
            <fieldset id="mercadoPago" disabled>
                <div class="fila-form">
                    <div>
                        <label for="email">E-mail</label>
                        <input id="email" name="email" class="form-control"/>
                    </div>
                    <div>
                        <label for="docType">Tipo de documento</label>
                        <select id="docType" name="docType" data-checkout="docType" class="form-control"></select>
                    </div>
                    <div>
                        <label for="docNumber">Número de documento</label>
                        <input id="docNumber" name="docNumber" data-checkout="docNumber" class="form-control"/>
                    </div>
                </div>
                <div class="fila-form">
                    <div>
                        <label for="cardholderName">Titular de la tarjeta</label>
                        <input id="cardholderName" data-checkout="cardholderName" class="form-control">
                    </div>
                    <div>
                        <label for="">Fecha de vencimiento</label>
                        <div class="d-flex">
                            <input placeholder="MM" id="cardExpirationMonth" data-checkout="cardExpirationMonth" class="form-control"
                            onselectstart="return false" onpaste="return false"
                            oncopy="return false" oncut="return false"
                            ondrag="return false" ondrop="return false" autocomplete=off>
                            <span class="date-separator">/</span>
                            <input placeholder="YY" id="cardExpirationYear" data-checkout="cardExpirationYear" class="form-control"
                            onselectstart="return false" onpaste="return false"
                            oncopy="return false" oncut="return false"
                            ondrag="return false" ondrop="return false" autocomplete=off>
                        </div>
                    </div>
                    <div>
                        <label for="cardNumber">Número de la tarjeta</label>
                        <input id="cardNumber" data-checkout="cardNumber" class="form-control"
                        onselectstart="return false" onpaste="return false"
                        oncopy="return false" oncut="return false"
                        ondrag="return false" ondrop="return false" autocomplete=off>
                    </div>
                    <div>
                        <label for="securityCode">Código de seguridad</label>
                        <input id="securityCode" data-checkout="securityCode" class="form-control"
                            onselectstart="return false" onpaste="return false"
                            oncopy="return false" oncut="return false"
                            ondrag="return false" ondrop="return false" autocomplete=off>
                    </div>
                </div>
                <div class="fila-form">
                    <div id="issuerInput">
                        <label for="issuer">Banco emisor</label>
                        <select id="issuer" name="issuer" data-checkout="issuer" class="form-control"></select>
                    </div>
                    <div>
                        <label for="installments">Cuotas</label>
                        <select id="installments" name="installments" class="form-control"></select>
                    </div>
                </div>
                <div>
                    <input type="hidden" name="transactionAmount" id="transactionAmount" value="100" />
                    <input type="hidden" name="paymentMethodId" id="paymentMethodId" />
                    <input type="hidden" name="description" id="description" />
                </div>
            </fieldset>

            {{-- Cupon --}}
            <div class="fila-form">
                <div>
                    <label>{{__('textos.campos.' . $n="cupon")}}</label>
                    <input name="{{$n}}" class="form-control" maxlength="25">
                </div>
            </div>

            {{-- Notas --}}
            <div class="fila-form">
                <div>
                    <label>{{__('textos.campos.' . $n='notas')}}</label>
                    <textarea name="{{$n}}" class="form-control" maxlength="500"></textarea>
                </div>
            </div>

            {{-- Botones --}}
            <div class="btns-form">
                <button class="btn btn-primary">{{__('textos.botones.confirmar')}}</button>
            </div>
        </form>
    {{-- Constancia --}}
    @else
        <div class="alert alert-success text-center">
            <h1>{{__('textos.titulos.gracias_compra')}}</h1>
            {!! __('textos.parrafos.orden_compra', ['idOrdenCompra' => $idOrdenCompra]) !!}
        </div>
    @endif
@endsection

{{-- JavaScript --}}
@section('js')
    <script>
        var mensajesErrores = new Object( @json( $errors->messages() ) ),
            valoresErrores  = new Object( @json( request()->old() ) );
    </script>
    <script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
    <script>
        window.Mercadopago.setPublishableKey("APP_USR-6e3c1e89-560a-40d4-bfe1-c987d43e9779");
        window.Mercadopago.getIdentificationTypes();
        document.getElementById('cardNumber').addEventListener('change', guessPaymentMethod);

function guessPaymentMethod(event) {
   let cardnumber = document.getElementById("cardNumber").value;
   if (cardnumber.length >= 6) {
       let bin = cardnumber.substring(0,6);
       window.Mercadopago.getPaymentMethod({
           "bin": bin
       }, setPaymentMethod);
   }
};

function setPaymentMethod(status, response) {
   if (status == 200) {
       let paymentMethod = response[0];
       document.getElementById('paymentMethodId').value = paymentMethod.id;
       getIssuers(paymentMethod.id);
   } else {
       alert(`payment method info error: ${response}`);
   }
}
function getIssuers(paymentMethodId) {
   window.Mercadopago.getIssuers(
       paymentMethodId,
       setIssuers
   );
}

function setIssuers(status, response) {
   if (status == 200) {
       let issuerSelect = document.getElementById('issuer');
       response.forEach( issuer => {
           let opt = document.createElement('option');
           opt.text = issuer.name;
           opt.value = issuer.id;
           issuerSelect.appendChild(opt);
       });

       getInstallments(
           document.getElementById('paymentMethodId').value,
           document.getElementById('transactionAmount').value,
           issuerSelect.value
       );
   } else {
       alert(`issuers method info error: ${response}`);
   }
}
function getInstallments(paymentMethodId, transactionAmount, issuerId){
   window.Mercadopago.getInstallments({
       "payment_method_id": paymentMethodId,
       "amount": parseFloat(transactionAmount),
       "issuer_id": parseInt(issuerId)
   }, setInstallments);
}

function setInstallments(status, response){
   if (status == 200) {
       document.getElementById('installments').options.length = 0;
       response[0].payer_costs.forEach( payerCost => {
           let opt = document.createElement('option');
           opt.text = payerCost.recommended_message;
           opt.value = payerCost.installments;
           document.getElementById('installments').appendChild(opt);
       });
   } else {
       alert(`installments method info error: ${response}`);
   }
}
doSubmit = false;
document.getElementById('paymentForm').addEventListener('submit', getCardToken);
function getCardToken(event){
   event.preventDefault();
   if(!doSubmit){
       let $form = document.getElementById('paymentForm');
       window.Mercadopago.createToken($form, setCardTokenAndPay);
       return false;
   }
};

function setCardTokenAndPay(status, response) {
   if (status == 200 || status == 201) {
       let form = document.getElementById('paymentForm');
       let card = document.createElement('input');
       card.setAttribute('name', 'token');
       card.setAttribute('type', 'hidden');
       card.setAttribute('value', response.id);
       form.appendChild(card);
       doSubmit=true;
       form.submit();
   } else {
       alert("Verify filled data!\n"+JSON.stringify(response, null, 4));
   }
};

    </script>
@endsection