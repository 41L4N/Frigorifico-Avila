<?php

return [

    // Rutas
    'rutas' => [
        // Inicio
        'inicio'                => "Inicio",
        'productos'             => "Productos",
        'mayoristas'            => "Mayoristas",
        'combos'                => "Combos",
        'ofertas'               => "Ofertas",
        // Sesion
        'ingreso'               => "Ingreso",
        'registro'              => "Registro",
        'recuperar_contraseña'  => "Recuperar contraseña",
        // Usuario
        'perfil'                => "Perfil",
        'salir'                 => "Salir",
        // Orden de compra
        'orden_compra'          => "Orden de compra",
        // Administrador
        'administrador'         => [
            'panel'             => "Panel de administrador",
            'carrusel'          => "Carrusel",
            'roles'             => "Roles",
            'usuarios'          => "Usuarios",
            'filtros_productos' => "Filtros de productos",
            'productos'         => "Productos",
            'cupones'           => "Cupones",
            'combos'            => "Combos",
            'ordenes_compras'   => "Ordenes de compras",
            'productos'         => "Productos",
        ],
        'usuario'               => [
            'orden_compra' => "Orden de compra"
        ]
    ],

    // Alertas
    'alertas' => [

        // Sesion
        // Registro
        // Ingreso
        'ingreso'                   => "Bienvenido",
        // Recuperación
        'recuperacion_contraseña'   => "Se ha enviado un código a su correo, por favor revise su buzon para continuar con el proceso.",
        // Renovación

        // Rutas
        // Roles
        'success'                   => "Operación exitosa",
        // Lista de compras
        'compras_minoristas'        => "Te invitamos a aprovechar nuestros precios mayoristas si tu compra alcanza un mínimo de 20Kg",
        'compras_mayoristas'        => "¡Felicidades! Estas disfrutando de nuestros precios mayoristas",
        // Orden de compra
        'orden_compra'              => "Su orden de compra se ha generado exitosamente, en breve recibira respuesta.",
        'cupon_vencido'             => "El cupón que esta usando ya expiró"
    ],

    // Titulos
    'titulos'   =>  [

        // Inicio
        'mas_visitados'             => "Mas visitados",
        'mas_nuevos'                => "Mas nuevos",

        // Sesion
        'registro'                  => "Registro",
        'ingreso'                   => "Ingreso",
        'recuperar_contraseña'      => "Recuperar contraseña",
        'recuperacion_contraseña'   => "Recuperación de contraseña",
        'renovacion_contraseña'     => "Renovación de contraseña",

        // Correos
        'bienvenida_app_name'       => "¡Bienvenido a " . config('app.name'),
        'nueva_orden_compra'        => "Nueva orden de compra",
        'usuario'                   => "Usuario",
        'lista_compras'             => "Lista de compras",

        // Lista de compras
        'lista_compras'             => "Lista de compras",

        // Buscador
        'buscador'                  => "Buscador",

        // Confirmación
        'confirmacion'              => "Confirmación",

        // Usuarios
        'datos_personales'          => "Datos personales",
        'seguridad'                 => "Seguridad",

        // Productos
        'compra_minorista'          => "Compra minorista",
        'compra_mayorista'              => "Compra mayorista",

        // Orden de compra
        'datos_facturacion'         => "Datos de facturación",
        'gracias_compra'            => "Gracias por su compra"
    ],

    // Parrafos
    'parrafos' => [

        // Menú superior
        'envio_gratis'                  => "¡Envío gratis si tu compra supera los $ 5.000 (CABA) y $8.000 (Provincia)!",
        'disfruta_precios_mayoristaistas'   => "Disfruta de nuestros precios mayoristas si tu compra supera los 20Kg",
        'sin_resultados'                => "Sin resultados",
        'confirmacion'                  => "¿Seguro que desea realizar esta acción?",
        'necesita_ingreso'              => "Necesitas <a href='". route('sesion', 'ingreso') ."'>iniciar sesion</a> ó <a href='". route('sesion', 'registro') ."'>registrarte</a> para continuar",

        // Correos
        'bienvenida'                    => "",
        'invitacion'                    => "",

        // Derechos de autor
        'derechos_autor'                => "2021 &copy " . config('app.name') . ". Todos los derechos reservados",

        // Desarrollador
        'desarrollador'                 => "Desarrollado por <a href='https://openskie.com/' target='_blank'>OpenSkies</a>",

        // Orden de compra
        'orden_compra'                  => "
                                            Su compra ya ha sido procesada exitosamente, en breve se comunicaran con usted.
                                            <br>
                                            Puede ver su <a href=" . route('usuario.orden-compra-pdf', ":idOrdenCompra") . ">orden de compra en PDF</a> ó puede <a href=" . route('productos') . ">ver más productos</a>.
                                        "
    ],

    // Campos
    'campos' => [

        // Lista de compras
        'precio_unitario'           => "Precio Unitario",
        'subtotal'                  => "Subtotal",
        // Usuario
        'nombre'                    => "Nombre",
        'apellido'                  => "Apellido",
        'email'                     => "Email",
        'telf'                      => "Teléfono",
        'twitter'                   => "Twitter",
        'rol'                       => "Rol",
        'cambiar_contraseña'        => "Cambiar contraseña",
        'contraseña'                => "Contraseña",
        'confirmacion_contraseña'   => "Confirmar contraseña",
        // Usuarios
        'nombre_apellido'           => "Nombre y apellido",
        // Roles
        'titulo'                    => "Titulo",
        'permisos'                  => "Permisos",
        // Filtros
        'opciones'                  => "Opciones",
        // Productos
        'producto'                  => "Producto",
        'filtro'                    => "Filtro",
        'unidad_medida'             => "Unidad de medida",
        'pedido_min_minorista'                => "Pedido mínimo",
        'pedido_min_minorista'                => "Pedido mínimo minorista",
        'precio_minorista'          => "Precio minorista",
        'pedido_min_oferta'         => "Pedido mínimo de oferta",
        'oferta'                    => "Oferta (%)",
        'pedido_min_mayorista'          => "Pedido mínimo mayorista",
        'precio_mayorista'              => "Precio mayorista",
        'descripcion'               => "Descripción",
        'actualizar_img'            => "Actualizar Imagen",
        // Combos
        'precio'                    => "Precio",
        'productos'                 => "Productos",
        'cantidad'                  => "Cantidad",
        // Cupones
        'codigo'                    => "Código",
        'fecha_vencimiento'         => "Fecha de vencimiento",
        // Orden de compra
        'datos_facturacion'         => "Datos de facturación",
        'direccion_envio'           => "Entrega por envío a domicilio",
        'calle'                     => "Calle",
        'codigo_puerta'             => "Número, Piso, Unidad",
        'codigo_postal'             => "Código postal",
        'estado'                    => "Región / Provincia",
        'ciudad'                    => "Ciudad",
        'notas'                     => "Notas",
        'cupon'                     => "Cupón",
        'total'                     => "Total",
        // Ordenes de compras
        'fecha'                     => "Fecha",
        'mercado_pago'              => "Mercado Pago"
    ],

    // Placesholder
    'placeholders' => [
        'select' => "Elegir"
    ],

    // Botones
    'botones' => [
        'aceptar_invitacion'    => "Aceptar invitación",
        'agregar'               => "Agregar",
        'roles'                 => "Roles",
        'eliminar'              => "Eliminar",
        'cancelar'              => "Cancelar",
        'enviar'                => "Enviar",
        'comprar'               => "Comprar",
        'confirmar'             => "Confirmar",
    ],
];