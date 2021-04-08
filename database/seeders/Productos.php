<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Http\Request;
use App\Models\FiltroProducto;
use App\Models\Producto;

class Productos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        $productos = [
            [
                'titulo'            => "Asado",
                'unidad_medida'     => "Kg",
                'filtro'            => FiltroProducto::where('titulo', 'Vacunos')->value('id'),
                'pedido_min_detal'  => 2,
                'precio_detal'      => 510,
                'oferta'            => 5,
                'pedido_min_mayor'  => 10,
                'precio_mayor'      => 410,
                'descripcion'       => "Es el corte mas popular la parrilla argentina. El contenido que este corte posee de grasa le da un sabor unico."
            ],
            [
                'titulo'            => "Bife ancho",
                'unidad_medida'     => "Kg",
                'filtro'            => FiltroProducto::where('titulo', 'Vacunos')->value('id'),
                'pedido_min_detal'  => 1,
                'precio_detal'      => 440,
                'oferta'            => 5,
                'pedido_min_mayor'  => null,
                'precio_mayor'      => null,
                'descripcion'       => "Para preparar a la parrilla o plancha."
            ],
            [
                'titulo'            => "Bife de chorizo",
                'unidad_medida'     => "Kg",
                'filtro'            => FiltroProducto::where('titulo', 'Vacunos')->value('id'),
                'pedido_min_detal'  => 2,
                'precio_detal'      => 560,
                'oferta'            => 5,
                'pedido_min_mayor'  => null,
                'precio_mayor'      => null,
                'descripcion'       => "Corte único de la carne argentina, es uno de los cortes mas usados  para la parrilla. Proviene de la parte central del bife angosto, con menos grasa y aprovechamiento integral"
            ],
            [
                'titulo'            => "Bola de lomo",
                'unidad_medida'     => "Kg",
                'filtro'            => FiltroProducto::where('titulo', 'Vacunos')->value('id'),
                'pedido_min_detal'  => 2,
                'precio_detal'      => 530,
                'oferta'            => 5,
                'pedido_min_mayor'  => null,
                'precio_mayor'      => null,
                'descripcion'       => "Se caracteriza por ser un corte económico y suave, se uso principal es para hacer milanesas."
            ],
            [
                'titulo'            => "Suprema de pollo",
                'unidad_medida'     => "Kg",
                'filtro'            => FiltroProducto::where('titulo', 'Aves')->value('id'),
                'pedido_min_detal'  => 1,
                'precio_detal'      => 350,
                'oferta'            => 5,
                'pedido_min_mayor'  => null,
                'precio_mayor'      => null,
                'descripcion'       => "Se caracteriza por su bajo contenido graso y por ser utilizado por una gran variedad de platos."
            ],
        ];
        foreach ($productos as $dP) {
            // Producto
            $p = new Producto;
            // Datos
            foreach (array_keys($dP) as $clave) {
                $p->$clave = $dP[$clave];
            }
            // Guardar
            $p->save();
            // Imagen
            guardarImg($p->getTable(), base64_encode( file_get_contents( storage_path("/app/ejemplos/$p->titulo.jpg") ) ) ,$p->id);
        }
    }
}
