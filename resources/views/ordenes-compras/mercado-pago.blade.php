{{-- Plantilla --}}
@extends('plantillas.plantilla')

{{-- JavaScript --}}
@section('js')
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script>
        // const mp = new MercadoPago('TEST-cc09e262-e7ab-43e0-9f61-042550b8e19e', {
        const mp = new MercadoPago('APP_USR-6e3c1e89-560a-40d4-bfe1-c987d43e9779', {
            locale: 'es-AR'
        });
        // Inicializa el checkout
        const checkout = mp.checkout({
            preference: {
                id: @json( $idPreference )
            },
            autoOpen: true
        });
    </script>
@endsection