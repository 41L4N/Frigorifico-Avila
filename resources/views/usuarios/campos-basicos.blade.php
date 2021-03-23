{{-- Id --}}
@if (in_array("id",$campos))
    <input type="hidden" name="id">
@endif

{{-- Nombre y Apellido --}}
<div class="fila-form">
    <div>
        <label>Nombre</label>
        <input type="text" name="nombre" class="form-control" minlength="3" maxlength="15" required>
    </div>
    <div>
        <label>Apellido</label>
        <input type="text" name="apellido" class="form-control" minlength="3" maxlength="15" required>
    </div>
</div>

{{-- Correo y teléfono --}}
<div class="fila-form">
    <div>
        <label>Correo</label>
        <input type="text" name="email" class="form-control" minlength="15" maxlength="50" required>
    </div>
    <div>
        <div class="fila-form m-0">
            <div class="w-25">
                Código
                <input type="text" name="telf[codigo_pais]" class="form-control" maxlength="4" onkeypress="soloNumeros(event)" required>
            </div>
            <div>
                Teléfono
                <input type="text" class="form-control" name="telf[telf]" onkeypress="soloNumeros(event)"required>
            </div>
        </div>
    </div>
</div>

{{-- Cambiar clave --}}
@if (in_array("cambiar-claves",$campos))
    <label class="cursor-pointer">
        <input type="checkbox" name="claves" onchange='document.querySelector("#claves").disabled = !document.querySelector("#claves").disabled'>
        Cambiar clave
    </label>
@endif

{{-- Claves --}}
@if (in_array("claves",$campos))
    <fieldset id="claves" @if (in_array("cambiar-claves",$campos)) disabled @endif>
        <div class="fila-form">
            <div>
                <label>Clave</label>
                <input type="password" name="password" class="form-control" minlength="8" maxlength="15" required>
            </div>
            <div>
                <label>Confirmar clave</label>
                <input type="password" name="password2" class="form-control" minlength="8" maxlength="15" required>
            </div>
        </div>
    </fieldset>
@endif