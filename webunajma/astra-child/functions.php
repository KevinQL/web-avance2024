<?php
/**
 * Enqueue script for parent theme stylesheet 
 */

 function childtheme_parent_styles(){
    //enqueue style
    wp_enqueue_style('parent', get_template_directory_uri().'/style.css');    
}

add_action('wp_enqueue_scripts', 'childtheme_parent_styles');

// FIN TEMA HIJO UNAJMA
//----------------------------------------------------------------------
//----------------------------------------------------------------------
//----------------------------------------------------------------------




/**
 ************************************************************************** 
 ************************************************************************** 
 * CONFIGURACIÓN DE ARCHIVOS JS Y CSS
 ************************************************************************** 
 ************************************************************************** 
 * 
 */


/**
 * Funciones para encolar estilos y scripts generales y en páginas o post especificas
 * get_template_directory_uri() : devuelve la uri del tema padre
 * get_stylesheet_directory_uri() : uri del tema hijo
 * 
 */
function registrar_scripts_y_estilos_especificos(){
    wp_register_style('mi_estilo_main', get_stylesheet_directory_uri() . '/css/style_main.css');
    wp_register_script('mi_script_main', get_stylesheet_directory_uri() . '/js/script_main.js', array('jquery'), null, true);

    wp_register_style('mi_estilo', get_stylesheet_directory_uri() . '/css/style_page.css');
    wp_register_script('mi_script', get_stylesheet_directory_uri() . '/js/script_page.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'registrar_scripts_y_estilos_especificos');

// Detectar los shortcodes en el contenido
function detectar_shortcodes_en_contenido( $posts ) {
    if ( empty($posts) ) {
        return $posts;
    }

    //scripts y estilos en toda las paginas y posts 
    wp_enqueue_style('mi_estilo_main');
    wp_enqueue_script('mi_script_main');

    // Lista de shortcodes a verificar
    $shortcodes_a_verificar = array( 'shortcode1', 'shortcode2'); // Añade más shortcodes según sea necesario

    // Variable para verificar si alguno de los shortcodes está presente
    $shortcode_presente = false;

    // Verificar si alguno de los shortcodes está presente en cualquiera de los posts
    foreach ( $posts as $post ) {
        foreach ( $shortcodes_a_verificar as $shortcode ) {
            if ( has_shortcode( $post->post_content, $shortcode ) ) {
                $shortcode_presente = true;
                break 2; // Salir de ambos bucles si se encuentra un shortcode
            }
        }
    }

    // Encolar los scripts y estilos si algún shortcode está presente
    if ( $shortcode_presente ) {
        wp_enqueue_style( 'mi_estilo' );
        wp_enqueue_script( 'mi_script' );
    }

    return $posts;
}
add_action( 'the_posts', 'detectar_shortcodes_en_contenido' );




/**
 ************************************************************************** 
 ************************************************************************** 
 * PÁGINA PRINCIPAL 
 ************************************************************************** 
 ************************************************************************** 
 * 
 */

//------------> 
add_shortcode('nav_pagina_unajma_mobile','html_navegacion_principal_mobile');
add_shortcode('nav_pagina_unajma','html_navegacion_principal_desktop');

add_shortcode('print-carrusel-img-arr', 'print_carrusel_img_enlaces_arr');

add_action('uagb_single_post_after_meta_timeline', 'atr_modificar_texto',10,2);
add_action('wp_footer', 'obtener_ultima_img_post_v2');

add_shortcode('btn_color', 'bn_cambiar_color_pagina');



function fn_nombre_organizador(){

        ob_start();

        ?>  
            <p>
                <?= the_field('organizado_por'); ?>
            </p>
        <?php

        // Capturar el contenido generado
        $contenido = ob_get_clean();
    
        // Devolver el contenido generado
        return $contenido;
}
add_shortcode('nombre-organizador', 'fn_nombre_organizador');


function print_title_action(){

    //obtiene la img de la portada del post
    $url_img_portada = get_the_post_thumbnail_url();
    $img_srcset = "$url_img_portada, $url_img_portada 780w,$url_img_portada 360w";            
    
    ?>
        <script>
            // cambia titulo del post
            let title_html = document.querySelector(".title-post-event .uagb-heading-text");
            title_html.innerHTML = "<?= the_title(); ?>";

            // cambia imagen del post
            let img_html = document.querySelector("figure img");
            img_html.srcset = '<?= $img_srcset ?>';
            img_html.src = '<?= $url_img_portada ?>';

            // verificar recurso descarga! y coloca link de ACF, e imprime texto de recurso disponible o no!
            let link_recurso = '<?= the_field("link_recurso"); ?>'; 
            let text_resource = "No hay archivos disponibles!!";  //
            if( link_recurso.length >= 5 ){
                document.querySelector(".icon-folder-event a").href = link_recurso;
                text_resource = "Archivos disponibles!!";
            }
            document.querySelector(".icon-folder-event p.uagb-ifb-desc").innerHTML = text_resource;

        </script>
        
    <?php
}


/**
 * [SHORTCODE]
 * 
 * Retorna los detalles del evento de cada post
 * Se utiliza en cada uno de los POST de la categoria de  "Agenda y eventos"
 * 
 */
function shortcode_print_title_agenda_actividades(){

    ob_start();
    ?>
        <div>
            <!-- <h3>DETALLES DEL EVENTO</h3> -->
            <div class="card-detalles-evento">
                <div class="card-detalle">
                    <span class="card-detalle_titulo">fecha: </span> 
                    <span class="card-detalle_value"><?php the_field('fecha_evento'); ?></span>
                </div>
                <div class="card-detalle">
                    <span class="card-detalle_titulo">Hora: </span> 
                    <span class="card-detalle_value"><?php the_field('lugar_evento'); ?></span>
                </div>
                <div class="card-detalle">
                    <span class="card-detalle_titulo">Lugar: </span> 
                    <span class="card-detalle_value"><?php the_field('hora_evento'); ?></span>
                </div>
                <div class="card-detalle">
                    <span class="card-detalle_titulo">Inversión: </span> 
                    <span class="card-detalle_value"><?php the_field('inversion_evento'); ?></span>
                </div>
                <div class="card-detalle">
                    <span class="card-detalle_titulo">Dirigido a: </span> 
                    <span class="card-detalle_value"><?php the_field('dirigido_a_evento'); ?></span>
                </div>
                
                <div>
                    <input type="hidden" id="txt_link_evento" name="link_evento" value="<?php the_field('link_evento'); ?>">
                    <input type="hidden" id="txt_contacto_evento" name="contacto_evento" value="<?php the_field('contacto_evento'); ?>">
                </div>
            </div>
        </div>


    <?php
    // Capturar el contenido generado
    $contenido = ob_get_clean();

    // Agregando linnk
    add_action('wp_footer', 'print_title_action');

    // Devolver el contenido generado
    return $contenido;
}
add_shortcode('print_text_agenda', 'shortcode_print_title_agenda_actividades');



/**
 * [SHORTCODE]
 * 
 * Imprime los post de agenda y actividades conforme el diseño pasado en el canva
 * Se utiliza en la pagina principal de "agenda y actividades"
 * 
 */
function shortcode_agenda_actividades($atts) {
    // Atributos por defecto
    $atts = shortcode_atts(
        array(
            'posts_per_page' => 3, // Número de posts por página
            'paged' => 1 // Página actual
        ), 
        $atts,
        'agenda_actividades'
    );

    // Obtener el número de la página actual
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    // Query de los posts
    $query_args = array(
        'post_type' => 'post', // Tipo de post
        'posts_per_page' => intval($atts['posts_per_page']),
        'paged' => $paged,
        'category_name' => 'agenda-actividades' // Nombre de la categoría Agenda y Actividades
    );
    $query = new WP_Query($query_args);

    // Iniciar el output buffer
    ob_start();

    if ($query->have_posts()) {

        echo '<div class="posts-timeline">';

        while ($query->have_posts()) {
            $query->the_post();
            /**
             * get_the_excerpt()
             */
            //obtiene la img del ultimo post de evento y agenda
            $url_img_portada = get_the_post_thumbnail_url();

            ?>
            <div class="post-container">
                <div class="post-column post-fecha">
                    <div class="div-fecha-evento div-fecha-evento__proximos_eventos">
                        <span>Fecha Evento:</span>
                        <?php the_field('fecha_evento'); ?>
                    </div>
                </div>
                <div class="post-column post-content">
                    <h2> 
                        <a href="<?= get_permalink(); ?> "><?= get_the_title(); ?></a> <br>
                        <span><?php the_field('lugar_evento'); ?></span>
                    </h2>
                    <p>
                        <?= obtener_extracto_personalizado(250); ?> 
                    </p>
                </div>
                <div class="post-column post-imagen">
                    <img src="<?= $url_img_portada; ?>" alt="">
                    
                </div>
            </div>
            <?php
        }

        echo '</div>';

        
        // Paginación
        $big = 999999999; // Un número grande para el reemplazo en paginate_links
        $pagination = paginate_links(array(
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'current' => max(1, $paged),
            'total' => $query->max_num_pages,
            'prev_text' => __('&laquo; Anterior'),
            'next_text' => __('Siguiente &raquo;'),
            'end_size' => 1,
            'mid_size' => 1,
        ));

        if ($pagination) {
            echo '<div class="pagination">' . $pagination . '</div>';
        }
    } else {
        echo '<p>No hay posts disponibles.</p>';
    }

    // Resetear el query
    wp_reset_postdata();

    // Devolver el contenido generado
    return ob_get_clean();
}
// Registrar el shortcode
add_shortcode('agenda_actividades', 'shortcode_agenda_actividades');



/**
 * [FUNCTION]
 * 
 * Obtiene un extracto de longitud específica.
 *
 * @param int $length Longitud del extracto en caracteres.
 * @return string El extracto truncado.
 */
function obtener_extracto_personalizado($length = 350) {
    global $post;
    
    // Obtener el contenido del post
    $excerpt = get_the_content();
    
    // Quitar etiquetas HTML
    $excerpt = strip_tags($excerpt);
    
    // Truncar el contenido a la longitud especificada
    if (strlen($excerpt) > $length) {
        $excerpt = substr($excerpt, 0, $length) . '...';
    }

    return $excerpt;
}



/**
 * [ADD_SHORTCODE]
 * 
 * Ya NO SE USA. ELIMINAR!!
 * función para imprimir el carrusel de imagenes de enlaces de interes 
 */

 function print_carrusel_img_enlaces(){
    // Iniciar el búfer de salida
    ob_start();

    ?>
    <div class="container-scroll">
        <button class="control" id="prev">◄</button>
        <div class="scroll-box">
            <div class="images">
                <a href="">
                    <img src="http://localhost/test-wordpress/wp-content/uploads/2024/04/modulo-servir_0.png" alt="Imagen 1">
                </a>
                <a href="">
                    <img src="http://localhost/test-wordpress/wp-content/uploads/2024/04/concytec_5.png" alt="Imagen 2">
                </a>
                <a href="">
                    <img src="http://localhost/test-wordpress/wp-content/uploads/2024/04/sd_1.png" alt="Imagen 3">
                </a>
                <a href="">
                    <img src="http://localhost/test-wordpress/wp-content/uploads/2024/04/pronabec.png" alt="Imagen 4">
                </a>
                <a href="">
                    <img src="http://localhost/test-wordpress/wp-content/uploads/2024/04/logo-criscos-1_0.png" alt="Imagen 5">
                </a>
                <a href="">
                    <img src="http://localhost/test-wordpress/wp-content/uploads/2024/04/sineace.png" alt="Imagen 6">
                </a>
                <a href="">
                    <img src="http://localhost/test-wordpress/wp-content/uploads/2024/04/sunedu_1.png" alt="Imagen 7">
                </a>
                <a href="">
                    <img src="http://localhost/test-wordpress/wp-content/uploads/2024/04/rpu_0.png" alt="Imagen 8">
                </a>
                <!-- Agrega más imágenes aquí -->
            </div>
        </div>
        <button class="control" id="next">►</button>
    </div>

    <?php

    // Agregar scripts JavaScript para el carrusel (si es necesario)
    // Aquí puedes agregar tus scripts JavaScript necesarios para el carrusel


    // Capturar el contenido generado
    $contenido = ob_get_clean();

    // Devolver el contenido generado
    return $contenido;

}
// add_shortcode('print-carrusel-img', 'print_carrusel_img_enlaces');




/**
 * [ADD_SHORTCODE]
 *
 * función para imprimir el carrusel de imagenes de enlaces de interes 
 */

 function print_carrusel_img_enlaces_arr( $atts ){
    // Iniciar el búfer de salida
    ob_start();

    $atts = shortcode_atts( 
        array(
            'images' => 'http://localhost/test-wordpress/wp-content/uploads/2024/04/biblioteca_0.png, http://localhost/test-wordpress/wp-content/uploads/2024/04/intranet.png, http://localhost/test-wordpress/wp-content/uploads/2024/04/repositorio.png, http://localhost/test-wordpress/wp-content/uploads/2024/04/resoluciones_1.png, http://localhost/test-wordpress/wp-content/uploads/2024/04/sgambiental_0.png, http://localhost/test-wordpress/wp-content/uploads/2024/04/defensoria_0.png, http://localhost/test-wordpress/wp-content/uploads/2024/04/bolsa_0.png, http://localhost/test-wordpress/wp-content/uploads/2024/04/tramite_0.png',
            
            'linksa' => 'www.google.com, www.google.com, www.google.com, www.google.com, www.google.com, www.google.com, www.google.com, www.google.com'
        ),
        $atts,
        'print-carrusel-img_arr'
    );
    
    $images_txt = $atts['images']; 
    $linka_txt = $atts['linksa'];
    
    // Eliminar todos los espacios en blanco, y quita los tags que se pueden generar 
    $images_txt = preg_replace('/\s+/','', strip_tags($images_txt));
    $linka_txt = preg_replace('/\s+/','', strip_tags($linka_txt));

    $images_arr = explode(',', $images_txt);
    $linksa_arr = explode(',', $linka_txt);
    
    ?>
    <div class="container-scroll">
        <button class="control" id="prev">◄</button>
        <div class="scroll-box">
            <div class="images">
                <?php
                foreach ($images_arr as $i => $image) {
                    # code...
                ?>
                    <a href="<?= $linksa_arr[$i] ?>">
                        <img src="<?= $image ?>" alt="Imagen 1">
                    </a>
                <?php
                }
                ?>
            </div>
        </div>
        <button class="control" id="next">►</button>
    </div>

    <?php

    // El script del scroll se escribe en el archivo de main de js, dentro de los archivos del tema hijo

    // Capturar el contenido generado
    $contenido = ob_get_clean();

    // Devolver el contenido generado
    return $contenido;

}
// add_shortcode('print-carrusel-img-arr', 'print_carrusel_img_enlaces_arr');



/**
 * [ADD_SHORTCODE]
 * 
 * Función boton ára cambiar color
 * Boton de prueba para la función de cambiar color a la página 
 * 
 */ 
function bn_cambiar_color_pagina(){
    ?>
        <button class="button-color" onclick="ejecuta()">CAMBIAR COLORES</button>
    <?php
    return null;
}
// add_shortcode('btn_color', 'bn_cambiar_color_pagina');



/**
 * [ADD_ACTION]
 * 
 * Función para Modificar la sección de agenda y actividades.
 * 
 */
function atr_modificar_texto($post_id, $post){
    // Iniciar el búfer de salida
    ob_start();

    // Estructura html para imprimir la fecha del evento dentro de los cards de cada post de evento
    ?>
        <div class="div-fecha-evento">
            <span>Fecha Evento:</span>
            <?php the_field('fecha_evento', get_the_ID()); ?>
        </div>
    <?php

    // Capturar el contenido generado
    $contenido = ob_get_clean();

    // Devolver el contenido generado. Fijar que aca no se pone return, sino echo. 
    echo $contenido;
}
// add_action('uagb_single_post_after_meta_timeline', 'atr_modificar_texto',10,2);
add_action('uagb_single_post_before_title_grid', 'atr_modificar_texto',10,2);


/**
 * [ADD_ACTION]
 * 
 * Obtener y reemplazar la ultima imagen del post de EVENTOS Y AGENDAS
 * 
 * Para que funcione este shortcode, se establece una clase al contenedor de la imagen. De manera que a partir de ahí se puede capturar a la imagen y realizar el reemplazo correspondiente
 * 
 */
function obtener_ultima_img_post_v2(){

    // Establece los atributos predeterminados
    $atts = array(
        'categoria' => 'agenda-actividades', // El slug de la categoría
    );
    // Argumentos para la consulta del post
    $args = array(
        'category_name' => $atts['categoria'], // El slug de la categoría
        'posts_per_page' => 1, // Obtener solo un post
        'orderby' => 'date', // Ordenar por fecha de publicación
        'order' => 'DESC', // En orden descendente (del más reciente al más antiguo)
    );

    // Realiza la consulta
    $posts = get_posts( $args );

    // Inicializa la variable para almacenar el resultado
    $output = '';

    // Verifica si se encontraron posts
    if ( $posts ) {
        // Recorre los posts encontrados
        foreach ( $posts as $post ) {
            setup_postdata( $post );
            
            //obtiene la img del ultimo post de evento y agenda
            $url_img_portada = get_the_post_thumbnail_url( $post->ID );

            $img_srcset = "$url_img_portada, $url_img_portada 780w,$url_img_portada 360w";            
            
            ?>
            <script>
                // dont work here. Averiguar por qué!!!??
                // window.onload = function() {
                // }
                console.log("neuvo action imagen 2")
                let divimg = document.querySelector('.img-actividad');
                console.log(divimg)
                if(divimg){
                    divimg.querySelector("img").srcset = '<?= $img_srcset ?>';
                    divimg.querySelector("img").src = '<?= $url_img_portada ?>';
                }
                
            </script>
            <?php
        }

        // Restablece los datos del post global
        wp_reset_postdata();
    } else {
        // Si no se encontraron posts
        ?>
            <p>No se encontraron posts en esta categoría.</p>
        <?php
    }
}
// add_action('wp_footer', 'obtener_ultima_img_post_v2');


/**
 * [ADD_SHORTCODE]
 * 
 * ESTA FUNCIÓN NO SE UTILIZA. SOLO ES REFERENCIAL YA QUE EL CÓDIGO ES FUNCIONAL!
 * 
 * Función para obtener el primer post de una categoria en cuestion
 * 
 */
function obtener_primer_post_categoria_shortcode( $atts ) {
    // Establece los atributos predeterminados del shortcode
    $atts = shortcode_atts( array(
        'categoria' => '', // El slug de la categoría
    ), $atts );

    // Argumentos para la consulta del post
    $args = array(
        'category_name' => $atts['categoria'], // El slug de la categoría
        'posts_per_page' => 1, // Obtener solo un post
        'orderby' => 'date', // Ordenar por fecha de publicación
        'order' => 'DESC', // En orden descendente (del más reciente al más antiguo)
    );

    // Realiza la consulta
    $posts = get_posts( $args );

    // Inicializa la variable para almacenar el resultado
    $output = '';

    // Verifica si se encontraron posts
    if ( $posts ) {
        // Recorre los posts encontrados
        foreach ( $posts as $post ) {
            setup_postdata( $post );

            // Obtén el título del post
            $titulo = get_the_title($post->ID);
            
            // Obtén el contenido del post
            // $contenido = strip_tags( get_the_content('', false, $post->ID) );

            // Obtén el contenido del post sin clases en las etiquetas
            $contenido = preg_replace('/<(\w+)\s[^>]*class="[^"]*"[^>]*>/', '<$1>', get_the_content( '', false, $post->ID ) );
            $imagen_portada = get_the_post_thumbnail( $post->ID );

            // Puedes agregar más datos del post según tus necesidades

            // Construye la salida
            ?>
            <div class='bloque-txt'>
                <h1><?= esc_html( $titulo ) ?></h1>
                <p>
                    <h5>
                        <?= the_field( "lugar_evento", get_the_ID()); ?>
                    </h5>
                    <?= $contenido  ?>
                    <?= $imagen_portada  ?>
                </p>
            </div>
            
            <?php
        }

        // Restablece los datos del post global
        wp_reset_postdata();
    } else {
        // Si no se encontraron posts
        $output = '<p>No se encontraron posts en esta categoría.</p>';
    }

    // Retorna la salida
    return $output;
}
// add_shortcode( 'primer_post_categoria', 'obtener_primer_post_categoria_shortcode' );
// Uso con shotcode ==> [primer_post_categoria categoria="noticias"]




/**
 ************************************************************************** 
 ************************************************************************** 
 * Navegación Principal de la pagina wbe
 ************************************************************************** 
 ************************************************************************** 
 * 
 */
function html_nav(){
    ?>
    <!-- MENÚ para Desktop Unajma!!! -->
    <div class="container">
        <div class="navbar">
            <div class="dropdown">
                <!-- <a href="#" class="link-nav link-nav-drop">
                    La Universidad +
                    <i class="fa fa-caret-down"></i>
                </a> -->
                <span class="link-nav link-nav-drop">
                    La Universidad +
                    <i class="fa fa-caret-down"></i>
                </span>
                <div class="dropdown-content">
                    <div class="header">
                        <h3>La Universidad</h3>
                    </div>   
                    <div class="row">
                        <div class="column">
                            <h5>La Universidad</h5>
                            <a href="#">Misión y Visión</a>
                            <a href="#">Reseña Histórica</a>
                            <a href="#">Autoridades</a>
                            <a href="#">Rendición de Cuentas</a>
                            <a href="#">Comité Electoral</a>
                            <a href="#">Organigrama Estructural</a>
                            <a href="#">Sistema de Gestión de Calidad</a>
                            <a href="#">Directorio</a>
                        </div>
                    </div>
                </div>
            </div> 

            <a href="#news" class="link-nav">Admisión</a>

            <div class="dropdown">
                <!-- <a href="#" class="link-nav link-nav-drop">
                    Pregrado +
                    <i class="fa fa-caret-down"></i>
                </a> -->
                <span class="link-nav link-nav-drop">
                    Pregrado +
                    <i class="fa fa-caret-down"></i>
                </span>
                <div class="dropdown-content">
                    <div class="header">
                        <h3>Pregrado</h3>
                    </div>   
                    <div class="row">
                        <div class="column">
                            <h5>Vicerrectorado Académico</h5>
                            <a href="#">Acerca de Nosotros</a>
                            <a href="#">Dirección de Admisión</a>
                            <a href="#">Dirección de Registros Académicos</a>
                            <a href="#">Movilidad Académica</a>
                            <a href="#">Calendario Académico</a>
                        </div>
                        <div class="column">
                            <h5>Facultad de Ingeniería</h5>
                            <a href="#">E.P. de Ingeniería de Sistemas</a>
                            <a href="#">E.P. de Ingeniería Agroindustrial</a>
                            <a href="#">E.P. de Ingeniería Ambiental</a>
                        </div>
                        <div class="column">
                            <h5>Facultad Ciencias Empresariales</h5>
                            <a href="#">E.P. de Administración de Empresas</a>
                            <a href="#">E.P. de Contabilidad</a>
                            <a href="#">E.P. de Educación Primaria Intercultural</a>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="dropdown">
                <!-- <a href="#" class="link-nav link-nav-drop">
                    Postgrado +
                    <i class="fa fa-caret-down"></i>
                </a> -->
                <span href="#" class="link-nav link-nav-drop">
                    Postgrado +
                    <i class="fa fa-caret-down"></i>
                </span>
                <div class="dropdown-content">
                    <div class="header">
                        <h3>Postgrado</h3>
                    </div>   
                    <div class="row">
                        <div class="column">
                            <h5>Postgrado</h5>
                            <a href="#">Maestría en Gestión Pública</a>
                            <a href="#">Maestría en Pedagogía y Educación Intercultural</a>
                            <a href="#">Maestría en Tecnologías de Información y Comunicación</a>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="dropdown">
                <!-- <a href="#" class="link-nav link-nav-drop">
                    Investigación +
                    <i class="fa fa-caret-down"></i>
                </a> -->
                <span href="#" class="link-nav link-nav-drop">
                    Investigación +
                    <i class="fa fa-caret-down"></i>
                </span>
                <div class="dropdown-content">
                    <div class="header">
                        <h3>Investigación</h3>
                    </div>   
                    <div class="row">
                        <div class="column">
                            <h5>Vicerrectorado de Investigación</h5>
                            <a href="#">Acerca de Nosotros</a>
                            <a href="#">Líneas de Investigación</a>
                            <a href="#">Docentes Investigadores</a>
                            <a href="#">Reglamentos</a>
                        </div>
                        <div class="column">
                            <h5>Publicaciones</h5>
                            <a href="#">Repositorio Institucional</a>
                            <a href="#">Biblioteca Virtual</a>
                            <a href="#">Revistas</a>
                        </div>
                        <div class="column">
                            <h5>Producción Científica</h5>
                            <a href="#">Proyectos de Investigación</a>
                            <a href="#">Convocatorias de Proyectos</a>
                        </div>
                    </div>
                </div>
            </div> 
    
            <div class="dropdown">
                <!-- <a href="#" class="link-nav link-nav-drop">
                    Servicios +
                    <i class="fa fa-caret-down"></i>
                </a> -->
                <span href="#" class="link-nav link-nav-drop">
                    Servicios +
                    <i class="fa fa-caret-down"></i>
                </span>
                <div class="dropdown-content">
                    <div class="header">
                        <h3>Servicios</h3>
                    </div>   
                    <div class="row">
                        <div class="column">
                            <h5>Servicios</h5>
                            <a href="#">CEPRE</a>
                            <a href="#">Instituto de Informática</a>
                            <a href="#">Centro de Idiomas</a>
                        </div>
                    </div>
                </div>
            </div> 

        </div>
    </div>
    <?php
}

//  NAVEGACIÓN MOBILE
function html_navegacion_principal_mobile(){

    html_nav();
    ?>
    <script>
        //Permite Desglosar las opciones del submenu, sin redireccionarlo a otra página. 
        let btndrops = document.querySelectorAll("span.link-nav");
        if(btndrops){
            if(window.innerWidth < 920){
                // console.log("ancho del pg: ", window.innerWidth);
                btndrops.forEach(btndrop => {
                    btndrop.addEventListener("click", function () {
                        // console.log("test console click")
                        let dc = btndrop.nextElementSibling;
                        dc.classList.toggle("vermas");
                    })
                });
            }
        }
    </script>
    <?php
}
//add_shortcode('nav_pagina_unajma_mobile','html_navegacion_principal_mobile');


// NAVEGACIÓN DESKTOP
function html_navegacion_principal_desktop(){
    html_nav();
}
//add_shortcode('nav_pagina_unajma','html_navegacion_principal_desktop');