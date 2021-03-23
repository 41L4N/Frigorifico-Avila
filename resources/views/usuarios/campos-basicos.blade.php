{{-- Contenido --}}
@if (in_array("id",$campos))
    <input type="hidden" name="id">
@endif

{{-- Nombre y Apellido --}}
@if (in_array("subtitulos",$campos))
    <h4 class="subtitulo-campos-usuario">Información personal</h4>
@endif

{{-- Nombres --}}
<div class="fila-form">
    <div>
        <label>Nombre</label>
        <input type="text" name="nombre" class="form-control" maxlength="50" required>
    </div>
    <div>
        <label>Apellido</label>
        <input type="text" name="apellido" class="form-control" maxlength="50" required>
    </div>
    
</div>

{{-- Cédula y correo --}}
<div class="fila-form">
    <div>
        <label>Correo</label>
        <input type="email" name="email" class="form-control" maxlength="50" oninput="validarCampoUnico(this)" required>
    </div>
    @if (in_array("telf",$campos))
        <div>
            <label>Teléfono</label>
            <div class="fila-form">
                <input name="telf[codigo_pais]" class="form-control w-25" placeholder="58" minlength="2" maxlength="4" onkeypress="soloNumeros(event)" required>
                <input name="telf[telf]" class="form-control" placeholder="1234567890" minlength="7" maxlength="12" onkeypress="soloNumeros(event)" required>
            </div>
        </div>
    @endif
</div>

{{-- Teléfonos --}}
@if (in_array("telfs",$campos))
    @if (in_array("subtitulos",$campos))
        <h4 class="subtitulo-campos-usuario">Teléfonos</h4>
    @endif
    <div class="fila-form">
        @foreach (["Móvil","Fijo","Whatsapp"] as $tipoTelf)
            <div class="fila-form">
                <div>
                    <i class="fa{{["s fa-mobile-alt","s fa-phone","b fa-whatsapp"][$loop->index]}}"></i>
                    {{$tipoTelf}}
                    <div class="d-flex">
                        <input name="telfs[{{$tipoTelf}}][codigo_pais]" class="form-control w-25" placeholder="58" minlength="2" maxlength="4" onkeypress="soloNumeros(event)">
                        <input name="telfs[{{$tipoTelf}}][telf]" class="form-control" placeholder="1234567890" minlength="7" maxlength="12" onkeypress="soloNumeros(event)">
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

{{-- Claves --}}
@if (in_array("claves",$campos))
    @if (in_array("subtitulos",$campos))
        <h4 class="subtitulo-campos-usuario">Seguridad</h4>
    @endif
    @if (in_array("cambiar_claves",$campos))
        <label class="cursor-pointer"> <input type="checkbox" name="claves" onchange='document.querySelector("#claves").disabled = !document.querySelector("#claves").disabled'> Cambiar clave </label>
    @endif
    <fieldset id="claves" @if (in_array("cambiar_claves",$campos)) disabled @endif>
        <div class="fila-form">
            <div>
                <label>Clave</label>
                <input type="password" name="clave" class="form-control" minlength="8" maxlength="15" required>
            </div>
            <div>
                <label>Repetir clave</label>
                <input type="password" name="clave2" class="form-control" minlength="8" maxlength="15" required>
            </div>
        </div>
    </fieldset>
@endif