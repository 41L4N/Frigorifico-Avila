<?php

return [

    // Rutas
    'rutas' => [
        // Inicio
        'inicio'                => "Inicio",
        'productos'             => "Productos",
        'combos'                => "Combos",
        'ofertas'               => "Ofertas",
        // Sesion
        'ingreso'               => "Ingreso",
        'registro'              => "Registro",
        'recuperar_contraseña'  => "Recuperar contraseña",
        // Usuario
        'usuario'               => "Usuario",
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
        // Orden de compra
        'orden_compra'              => "Su orden de compra se ha generado exitosamente, en breve recibira respuesta."
    ],

    // Contenido
    'contenido' => [

        // Menú superior
        'anuncio_menu_s'            => "¡Envío gratis si tu compra supera los $ 5.000!",
        'sin_resultados'            => "Sin resultados",
        'confirmacion'              => "¿Seguro que desea realizar esta acción?",
        'necesita_ingreso'          => "Necesitas <a href='". route('sesion', 'ingreso') ."'>iniciar sesion</a> ó <a href='". route('sesion', 'registro') ."'>registrarte</a> para continuar",

        // Derechos de autor
        'derechos_autor'            => "2021 &copy " . config('app.name') . ". Todos los derechos reservados",

        // Desarrollador
        'desarrollador'             => "Desarrollado por <a href='https://openskie.com/'>OpenSkies</a>",
    ],

    // Correos
    'correos' => [

        // Asuntos
        'asuntos' => [
            'nueva_orden_compra' => "Nueva orden de compra"
        ],

        // Parrafos
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

        // Lista de compras
        'lista_compras'              => "Lista de compras",

        // Buscador
        'buscador'                  => "Buscador",

        // Confirmación
        'confirmacion'              => "Confirmación",

        // Usuarios
        'datos_personales'          => "Datos personales",
        'seguridad'                 => "Seguridad",

        // Productos
        'compra_detal'              => "Compra al detal",
        'compra_mayor'              => "Compra al mayor",

        // Orden de compra
        'informacion_facturacion'   => "Información de facturación",
        'informacion_envio'         => "Información de envío",
        'forma_pago'                => "Forma de pago",
    ],

    // Campos
    'campos' => [

        // Lista de compras
        'precio_unitario'       => "Precio Unitario",
        'subtotal'              => "Subtotal",

        // Usuario
        'nombre'                => "Nombre",
        'apellido'              => "Apellido",
        'email'                 => "Email",
        'telf'                  => "Teléfono",
        'rol'                   => "Rol",
        'cambiar_contraseña'    => "Cambiar contraseña",
        'contraseña'            => "Contraseña",
        'confirmar_contraseña'  => "Confirmar contraseña",

        // Usuarios
        'nombre_apellido'       => "Nombre y apellido",

        // Roles
        'titulo'                => "Titulo",
        'permisos'              => "Permisos",

        // Filtros
        'opciones'              => "Opciones",

        // Productos
        'producto'              => "Producto",
        'filtro'                => "Filtro",
        'unidad_medida'         => "Unidad de medida",
        'pedido_min'            => "Pedido mínimo",
        'pedido_min_detal'      => "Pedido mínimo al detal",
        'precio_detal'          => "Precio al detal",
        'oferta'                => "Oferta (%)",
        'pedido_min_mayor'      => "Pedido mínimo al mayor",
        'precio_mayor'          => "Precio al mayor",
        'descripcion'           => "Descripción",
        'actualizar_img'        => "Actualizar Imagen",

        // Combos
        'precio'                => "Precio",
        'productos'             => "Productos",

        // Cupones
        'codigo'                => "Código",
        'fecha_vencimiento'     => "Fecha de vencimiento",

        // Orden de compra
        'cantidad'              => "Cantidad",
        'datos_diferentes'      => "¿Enviar con datos diferentes?",
        'direccion_diferentes'  => "¿Enviar a una dirección diferente?",
        'nombre_empresa'        => "Nombre de empresa",
        'calle'                 => "Calle",
        'n_puerta'              => "Número, Piso, Unidad",
        'codigo_postal'         => "Código postal",
        'estado'                => "Región / Provincia",
        'ciudad'                => "Ciudad",
        'pais'                  => "País",
        'notas_pedido'          => "Notas de pedido",
        'cupon'                 => "Cupón",
        'total'                 => "Total"
    ],

    // Placesholder
    'placeholders' => [
        'select' => "Elegir"
    ],

    // Botones
    'botones' => [
        'agregar'   => "Agregar",
        'roles'     => "Roles",
        'eliminar'  => "Eliminar",
        'cancelar'  => "Cancelar",
        'enviar'    => "Enviar",
        'comprar'   => "Comprar",
        'confirmar' => "Confirmar",
    ],
];