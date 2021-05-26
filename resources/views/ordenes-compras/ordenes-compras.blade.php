{{-- Plantilla --}}
@extends('plantillas.plantilla')

{{-- Metadatos --}}
@php
    $tituloMD = __('textos.rutas.' . str_replace('-', '_', Route::currentRouteName()) );
@endphp

{{-- Contenido --}}
@section('contenido')
    @if (($registros = $ordenesCompras)->count())

        {{-- Submenu --}}
        <div class="submenu-registros">
            <div>{{$tituloMD}}</div>
        </div>

        {{-- Tabla de resultados --}}
        <table class="tb-registros">

            {{-- Campos --}}
            <tr>
                <th>#</th>
                <th>{{__('textos.campos.codigo')}}</th>
                <th>{{__('textos.campos.fecha')}}</th>
                <th>{{__('textos.campos.total')}}</th>
                <th><i class="fas fa-cogs"></i></th>
            </tr>

            {{-- Registros --}}
            @foreach ($registros as $reg)
                <tr>
                    <th>{{$loop->iteration}}</th>
                    <td>{{$reg->codigo}}</td>
                    <td>{{formatos('f', $reg->created_at)}}</td>
                    <td>{{formatos('n', $reg->total, true)}}</td>
                    <td><a class="fas fa-file-pdf" href="{{route('usuario.orden-compra-pdf', $reg->id)}}" target="_blank"></a></td>
                </tr>
            @endforeach
        </table>

    {{-- Sin resultados --}}
    @else
        @include('plantillas.sin-resultados')
    @endif
@endsection