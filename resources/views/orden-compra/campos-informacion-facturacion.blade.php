{{-- Nombre y apellido --}}
<div class="fila-form">
    <div>
        <label>{{__('textos.campos.' . $n='nombre')}}</label>
        <input name="{{ ($cPadre) ? $cPadre . "[$n]" : $n }}" class="form-control" maxlength="50" required>
    </div>
    <div>
        <label>{{__('textos.campos.' . $n='apellido')}}</label>
        <input name="{{ ($cPadre) ? $cPadre . "[$n]" : $n }}" class="form-control" maxlength="50" required>
    </div>
</div>

{{-- Nombre de la empresa --}}
<div class="fila-form">
    <div>
        <label>{{__('textos.campos.' . $n='nombre_empresa')}}</label>
        <input name="{{ ($cPadre) ? $cPadre . "[$n]" : $n }}" class="form-control" maxlength="75" required>
    </div>
</div>

{{-- Dirección --}}
<div class="fila-form">
    {{-- Calle --}}
    <div>
        <label>{{__('textos.campos.' . $n='calle')}}</label>
        <input name="{{ ($cPadre) ? $cPadre . "[direccion][$n]" : "direccion[$n]" }}" class="form-control" maxlength="75" required>
    </div>
    {{-- Número de puerta --}}
    <div>
        <label>{{__('textos.campos.' . $n='n_puerta')}}</label>
        <input name="{{ ($cPadre) ? $cPadre . "[direccion][$n]" : "direccion[$n]" }}" class="form-control" maxlength="75" required>
    </div>
    {{-- Código postal --}}
    <div>
        <label>{{__('textos.campos.' . $n='codigo_postal')}}</label>
        <input name="{{ ($cPadre) ? $cPadre . "[direccion][$n]" : "direccion[$n]" }}" class="form-control" maxlength="75" required>
    </div>
</div>
<div class="fila-form">
    {{-- Estado --}}
    <div>
        <label>{{__('textos.campos.' . $n='estado')}}</label>
        <select name="{{ ($cPadre) ? $cPadre . "[direccion][$n]" : "direccion[$n]" }}" class="form-control" required>
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
        <input name="{{ ($cPadre) ? $cPadre . "[direccion][$n]" : "direccion[$n]" }}" class="form-control" maxlength="75" required>
    </div>
    {{-- Pais --}}
    <div>
        <label>{{__('textos.campos.' . $n='pais')}}</label>
        <input name="{{ ($cPadre) ? $cPadre . "[direccion][$n]" : "direccion[$n]" }}" class="form-control" maxlength="75" value="Argentina" readonly required>
    </div>
</div>

{{-- Email y teléfono --}}
<div class="fila-form">
    <div>
        <label>{{__('textos.campos.' . $n='email')}}</label>
        <input name="{{ ($cPadre) ? $cPadre . "[$n]" : "$n" }}" class="form-control" maxlength="75" required>
    </div>
    <div>
        <label>{{__('textos.campos.' . $n='telf')}}</label>
        <div class="d-flex">
            <input name="{{ ($cPadre) ? $cPadre . "[$n]" : $n }}[codigo]" class="form-control w-25" placeholder="58" minlength="2" maxlength="4" onkeypress="soloNumeros(event)" required>
            <input name="{{ ($cPadre) ? $cPadre . "[$n]" : $n }}[numero]" class="form-control" placeholder="1234567890" minlength="7" maxlength="12" onkeypress="soloNumeros(event)" required>
        </div>
    </div>
</div>