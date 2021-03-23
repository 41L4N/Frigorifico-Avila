{{-- Contenido --}}
@if (in_array("id",$campos))
    <input type="hidden" name="id">
@endif

{{-- Nombre y Apellido --}}
@if (in_array("subtitulos",$campos))
    <h4 class="subtitulo-campos-usuario">{{__('textos.formularios.subtitulos.datos_personales')}}</h4>
@endif

{{-- Nombres --}}
<div class="fila-form">
    <div>
        <label>{{__('textos.formularios.etiquetas.nombre')}}</label>
        <input type="text" name="nombre" class="form-control" maxlength="50" required>
    </div>
    <div>
        <label>{{__('textos.formularios.etiquetas.apellido')}}</label>
        <input type="text" name="apellido" class="form-control" maxlength="50" required>
    </div>
    
</div>

{{-- Email y teléfono --}}
<div class="fila-form">
    <div>
        <label>{{__('textos.formularios.etiquetas.email')}}</label>
        <input type="email" name="email" class="form-control" maxlength="50" required>
    </div>
    @if (in_array("telf",$campos))
        <div>
            <label>{{__('textos.formularios.etiquetas.telf')}}</label>
            <div class="fila-form">
                <input name="telf[codigo_pais]" class="form-control w-25" placeholder="58" minlength="2" maxlength="4" onkeypress="soloNumeros(event)" required>
                <input name="telf[telf]" class="form-control" placeholder="1234567890" minlength="7" maxlength="12" onkeypress="soloNumeros(event)" required>
            </div>
        </div>
    @endif
</div>

{{-- Claves --}}
@if (in_array("claves",$campos))
    @if (in_array("subtitulos",$campos))
        <h4 class="subtitulo-campos-usuario">{{__('textos.formularios.subtitulos.seguridad')}}</h4>
    @endif
    @if (in_array("cambiar_claves",$campos))
        <label class="cursor-pointer"> <input type="checkbox" name="claves" onchange='claves.disabled = !claves.disabled'>
            {{__('textos.formularios.etiquetas.cambiar_clave')}}
        </label>
    @endif
    <fieldset id="claves" @if (in_array("cambiar_claves",$campos)) disabled @endif>
        <div class="fila-form">
            <div>
                <label>{{__('textos.formularios.etiquetas.clave')}}</label>
                <input type="password" name="clave" class="form-control" minlength="8" maxlength="15" required>
            </div>
            <div>
                <label>{{__('textos.formularios.etiquetas.confirmar_clave')}}</label>
                <input type="password" name="clave2" class="form-control" minlength="8" maxlength="15" required>
            </div>
        </div>
    </fieldset>
@endif