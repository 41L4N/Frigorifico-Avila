{{-- Id --}}
@if (in_array("id",$campos))
    <input type="hidden" name="id">
@endif

{{-- Datos personales --}}
{{-- Subtitulo --}}
@if (in_array("subtitulos",$campos))
    <h4 class="subtitulo-campos-usuario">{{__('textos.formularios.subtitulos.datos_personales')}}</h4>
@endif
{{-- Nombre y apellido --}}
<div class="fila-form">
    <div>
        <label>{{__('textos.formularios.etiquetas.'.$n='nombre')}}</label>
        <input type="text" name="nombre" class="form-control @error($n) is-invalid @enderror" maxlength="50" required>
    </div>
    <div>
        <label>{{__('textos.formularios.etiquetas.'.$n='apellido')}}</label>
        <input type="text" name="apellido" class="form-control @error($n) is-invalid @enderror" maxlength="50" required>
    </div>
</div>
{{-- Email y teléfono --}}
<div class="fila-form">
    <div>
        <label>{{__('textos.formularios.etiquetas.'.$n='email')}}</label>
        <input type="email" name="email" class="form-control @error($n) is-invalid @enderror" maxlength="75" required>
    </div>
    @if (in_array("telf",$campos))
        <div>
            <label>{{__('textos.formularios.etiquetas.'.$n='telf')}}</label>
            <div class="d-flex">
                <input name="telf[codigo]" class="form-control w-25" placeholder="58" minlength="2" maxlength="4" onkeypress="soloNumeros(event)" required>
                <input name="telf[numero]" class="form-control @error($n) is-invalid @enderror" placeholder="1234567890" minlength="7" maxlength="12" onkeypress="soloNumeros(event)" required>
            </div>
        </div>
    @endif
</div>

{{-- Seguridad --}}
{{-- Subtitulo --}}
@if (in_array("subtitulos",$campos))
    <h4 class="subtitulo-campos-usuario">{{__('textos.formularios.subtitulos.seguridad')}}</h4>
@endif
{{-- Contraseñas --}}
@if (in_array("contraseñas",$campos))
    @if (in_array("cambiar_contraseñas",$campos))
        <label class="cursor-pointer"> <input type="checkbox" name="contraseñas" onchange='contraseñas.disabled = !contraseñas.disabled'>
            {{__('textos.formularios.etiquetas.cambiar_contraseña')}}
        </label>
    @endif
    <fieldset id="contraseñas" @if (in_array("cambiar-contraseñas",$campos)) disabled @endif>
        <div class="fila-form">
            <div>
                <label>{{__('textos.formularios.etiquetas.'.$n='contraseña')}}</label>
                <input type="password" name="password" class="form-control @error($n) is-invalid @enderror" minlength="8" maxlength="15" required>
            </div>
            <div>
                <label>{{__('textos.formularios.etiquetas.'.$n='confirmar-contraseña')}}</label>
                <input type="password" name="confirmacion_password" class="form-control @error($n) is-invalid @enderror" minlength="8" maxlength="15" required>
            </div>
        </div>
    </fieldset>
@endif