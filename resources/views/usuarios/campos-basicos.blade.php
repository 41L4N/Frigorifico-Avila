{{-- Id --}}
@if (in_array("id",$campos))
    <input name="id" class="d-none">
@endif

{{-- Datos personales --}}
{{-- Subtitulo --}}
@if (in_array("subtitulos",$campos))
    <div class="subtitulo-form">{{__('textos.titulos.datos_personales')}}</div>
@endif
{{-- Nombre y apellido --}}
<div class="fila-form">
    <div>
        <label>{{__('textos.campos.' . $n='nombre')}}</label>
        <input type="text" name="{{$n}}" class="form-control" maxlength="50" required>
    </div>
    <div>
        <label>{{__('textos.campos.' . $n='apellido')}}</label>
        <input type="text" name="{{$n}}" class="form-control" maxlength="50" required>
    </div>
</div>
{{-- Email y teléfono --}}
<div class="fila-form">
    <div>
        <label>{{__('textos.campos.' . $n='email')}}</label>
        <input type="email" name="{{$n}}" class="form-control" maxlength="75" required>
    </div>
    @if (in_array("telf",$campos))
        <div>
            <label>{{__('textos.campos.' . $n='telf')}}</label>
            <div class="d-flex">
                <input name="{{$n}}[codigo]" class="form-control w-25" placeholder="58" minlength="2" maxlength="4" onkeypress="soloNumeros(event)" required>
                <input name="{{$n}}[numero]" class="form-control" placeholder="1234567890" minlength="7" maxlength="12" onkeypress="soloNumeros(event)" required>
            </div>
        </div>
    @endif
</div>

{{-- Redes sociales --}}


{{-- Seguridad --}}
{{-- Subtitulo --}}
@if (in_array("subtitulos",$campos))
    <div class="subtitulo-form">{{__('textos.titulos.seguridad')}}</div>
@endif
{{-- Contraseñas --}}
@if (in_array("contraseñas",$campos))
    @if (in_array("cambiar_contraseñas",$campos))
        <label class="cursor-pointer"> <input type="checkbox" name="contraseñas" onchange='contraseñas.disabled = !contraseñas.disabled'>
            {{__('textos.campos.cambiar_contraseña')}}
        </label>
    @endif
    <fieldset id="contraseñas" @if (in_array('cambiar_contraseñas', $campos)) disabled @endif>
        <div class="fila-form">
            <div>
                <label>{{__('textos.campos.contraseña')}}</label>
                <input type="password" name="password" class="form-control" minlength="8" maxlength="15" required>
            </div>
            <div>
                <label>{{__('textos.campos.confirmacion_contraseña')}}</label>
                <input type="password" name="confirmacion_password" class="form-control" minlength="8" maxlength="15" required>
            </div>
        </div>
    </fieldset>
@endif