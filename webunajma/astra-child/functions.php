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
    // <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    wp_enqueue_style('my_icons_awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css');

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

// add_shortcode('btn_color', 'bn_cambiar_color_pagina');
// Se usa en la vista de la página principal de la págian, a traves de un elemento shortcode: [btn_color]




/**
********************************************************************************************
********************************************************************************************
************************** codigo para Convocatoria Prácticas *******************************
********************************************************************************************
********************************************************************************************
*
*/
function print_aditionals_convocatoria_practicas(){

    $estado_convocatoria = get_field("estado_convocatoria_practicas");
    $text_estado = $estado_convocatoria ? "<span style='color:#198754; font-size:x-large; display: block'>(vigente)</span>":"";
    ?>
        <script>
            // cambia titulo del post
            let title_html = document.querySelector("h3.uagb-heading-text");
            title_html.innerHTML = "<?= the_title(); ?> <?= $text_estado; ?>";

        </script>
    <?php
}

function shortcode_print_contenido_convocatoria_practicas(){
    ob_start();
    ?>
        <div class="content-notice post-content">

            <?= the_field('detalle_convocatoria_practicas'); ?>

        </div>
    <?php
    // Capturar el contenido generado
    $contenido = ob_get_clean();

    // Coloca el titulo de la página con js
    add_action('wp_footer', 'print_aditionals_convocatoria_practicas');

    // Devolver el contenido generado
    return $contenido;
}
add_shortcode('detalle_convocatoria_practicas', 'shortcode_print_contenido_convocatoria_practicas');



/**
********************************************************************************************
********************************************************************************************
************************** codigo para Convocatoria 276 Y CAS *******************************
********************************************************************************************
********************************************************************************************
*
*/
function print_aditionals_convocatoria_276_cas(){

    $estado_convocatoria = get_field("estado_convocatoria_276_cas");
    $text_estado = $estado_convocatoria ? "<span style='color:#198754; font-size:x-large; display: block'>(vigente)</span>":"";
    ?>
        <script>
            // cambia titulo del post
            let title_html = document.querySelector("h3.uagb-heading-text");
            title_html.innerHTML = "<?= the_title(); ?> <?= $text_estado; ?>";

        </script>
    <?php
}

function shortcode_print_contenido_convocatoria_276_cas(){
    ob_start();
    ?>
        <div class="content-notice post-content">

            <?= the_field('detalle_convocatoria_276_cas'); ?>

        </div>
    <?php
    // Capturar el contenido generado
    $contenido = ob_get_clean();

    // Coloca el titulo de la página con js
    add_action('wp_footer', 'print_aditionals_convocatoria_276_cas');

    // Devolver el contenido generado
    return $contenido;
}
add_shortcode('detalle_convocatoria_276_cas', 'shortcode_print_contenido_convocatoria_276_cas');



/**
********************************************************************************************
********************************************************************************************
************************** codigo para Convocatoria docentes *******************************
********************************************************************************************
********************************************************************************************
*
*/
function print_aditionals_convocatoria_docente(){

    $estado_convocatoria = get_field("estado_convocatoria_docente");
    $text_estado = $estado_convocatoria ? "<span style='color:#198754; font-size:x-large; display: block'>(vigente)</span>":"";
    ?>
        <script>
            // cambia titulo del post
            let title_html = document.querySelector("h3.uagb-heading-text");
            title_html.innerHTML = "<?= the_title(); ?> <?= $text_estado; ?>";

        </script>
    <?php
}

function shortcode_print_contenido_convocatoria_docente(){
    ob_start();
    ?>
        <div class="content-notice post-content">

            <?= the_field('detalle_convocatoria_docente'); ?>

        </div>
    <?php
    // Capturar el contenido generado
    $contenido = ob_get_clean();

    // Coloca el titulo de la página con js
    add_action('wp_footer', 'print_aditionals_convocatoria_docente');

    // Devolver el contenido generado
    return $contenido;
}
add_shortcode('detalle_convocatoria_docente', 'shortcode_print_contenido_convocatoria_docente');


/**
********************************************************************************************
********************************************************************************************
***************************** para la pagina ORGANIGRAMA  **********************************
********************************************************************************************
********************************************************************************************
*
*/

function shortcode_embed_pdf($atts) {
    // Establece los atributos predeterminados del shortcode
    $atts = shortcode_atts(
        array(
            'url' => '', // La URL del PDF
            'width' => '100%', // Ancho del PDF embebido
            'height' => '900px', // Alto del PDF embebido
        ), 
        $atts, 
        'embed_pdf'
    );

    // Comprueba si la URL se ha proporcionado
    if (empty($atts['url'])) {
        return '<p>Por favor, proporciona la URL del PDF.</p>';
    }

    // Devuelve el código HTML para embeber el PDF
    return '<div style="overflow: auto;">
                <embed src="' . esc_url($atts['url']) . '" width="' . esc_attr($atts['width']) . '" height="' . esc_attr($atts['height']) . '" type="application/pdf">
            </div>';
}

// Registra el shortcode [embed_pdf]
add_shortcode('embed_pdf', 'shortcode_embed_pdf');

/**
********************************************************************************************
********************************************************************************************
***************************** plantilla para COMUNICADOS  **********************************
********************************************************************************************
********************************************************************************************
*
*/

function shortcode_print_redactor_comunicado(){
    ob_start();
    ?>
        <div class="data-notice">
            <p><?= the_field('redactor_comunicado'); ?> | Redactor Personal De Unajma</p>
            <p><?= the_field('fecha_comunicado'); ?> - <?= the_field('tiempo_lectura_comunicado'); ?> de lectura.</p>
            <div class="separator-notice"></div>
        </div>
    <?php
    // Capturar el contenido generado
    $contenido = ob_get_clean();

    // Devolver el contenido generado
    return $contenido;
}
add_shortcode('redactor_comunicado', 'shortcode_print_redactor_comunicado');

function print_aditionals_comunicados(){
    //obtiene la img de la portada del post
    $url_img_portada = get_the_post_thumbnail_url();
    $img_srcset = "$url_img_portada, $url_img_portada 780w,$url_img_portada 360w";            
    
    ?>
        <script>
            // cambia titulo del post
            let title_html = document.querySelector("h3.uagb-heading-text");
            title_html.innerHTML = "<?= the_title(); ?>";

            // cambia ultimo texto
            let parrafo_html = document.querySelector("p.parrafo-entrada strong");
            parrafo_html.innerHTML = "<em><?= the_field('ultimo_texto_comunicado'); ?></em>";

            // cambia imagen del post
            let img_html = document.querySelector("figure.wp-block-uagb-image__figure img");
            img_html.srcset = '<?= $img_srcset ?>';
            img_html.src = '<?= $url_img_portada ?>';
        </script>
    <?php
}

function shortcode_print_contenido_comunicado(){
    ob_start();
    ?>
        <div class="content-notice post-content">

            <?= the_field('contenido_comunicado'); ?>

        </div>
    <?php
    // Capturar el contenido generado
    $contenido = ob_get_clean();

    // Coloca el titulo de la página con js
    add_action('wp_footer', 'print_aditionals_comunicados');

    // Devolver el contenido generado
    return $contenido;
}
add_shortcode('contenido_comunicado', 'shortcode_print_contenido_comunicado');

function shortcode_print_botones_comunicado(){
    ob_start();

    $btns = get_field('grupo_botones');
    ?>
        <div class="content-btn-comunicados">
            <?php
            foreach ($btns as $key => $value) {
                if(!empty($value)){
                    ?>
                    <a href="<?= $value; ?>" class="btn-comunicados">
                        <span> <?= str_replace("_"," ",$key); ?> <i class="fa-solid fa-link"></i></span>
                        <p>Click Aquí para abrir</p>
                    </a>
                    <?php
                }
            }
            ?>
        </div>  
    <?php

    $content = ob_get_clean();

    return $content;

}
add_shortcode('botones_comunicado', 'shortcode_print_botones_comunicado');


/**
 * [ADD FILTER]
 * 
 * Función para modificar el excerpt de los posts de una categoría específica
 * para la sección de COMUNICADOS UNAJMA en la página principal
 */
function custom_excerpt_for_category_comunicado($excerpt) {
    global $post;

    // Verifica si el post pertenece a la categoría 'noticia_unajma'
    if (has_category('avisos-comunicados', $post)) {
        // Personaliza el excerpt aquí
        $custom_excerpt = get_field('contenido_comunicado');
        // Limita el excerpt a 30 palabras (por ejemplo)
        $custom_excerpt = wp_trim_words($custom_excerpt, 30, '...');

        return $custom_excerpt;
    }

    // Si el post no pertenece a la categoría, retorna el excerpt original
    return $excerpt;
}

// Añade el filtro para modificar el excerpt
add_filter('the_excerpt', 'custom_excerpt_for_category_comunicado');



/**
 * [ADD FILTER]
 * 
 * Función para modificar el excerpt de los posts de una categoría específica
 * para la sección de NOTICIAS UNAJMA en la página principal
 */
function custom_excerpt_for_category_evento($excerpt) {
    global $post;

    // Verifica si el post pertenece a la categoría 'noticia_unajma'
    if (has_category('agenda-actividades', $post)) {
        // Personaliza el excerpt aquí
        $custom_excerpt = get_field('contenido_evento');
        // Limita el excerpt a 30 palabras (por ejemplo)
        $custom_excerpt = wp_trim_words($custom_excerpt, 30, '...');

        return $custom_excerpt;
    }

    // Si el post no pertenece a la categoría, retorna el excerpt original
    return $excerpt;
}

// Añade el filtro para modificar el excerpt
add_filter('the_excerpt', 'custom_excerpt_for_category_evento');



/**
 * [ADD FILTER]
 * 
 * Función para modificar el excerpt de los posts de una categoría específica
 * para la sección de NOTICIAS UNAJMA en la página principal
 */
function custom_excerpt_for_category_noticia_unajma($excerpt) {
    global $post;

    // Verifica si el post pertenece a la categoría 'noticia_unajma'
    if (has_category('noticias-unajma', $post)) {
        // Personaliza el excerpt aquí
        // Por ejemplo, podrías agregar un prefijo al excerpt
        $custom_excerpt = get_field('contenido_noticia_unajma');

        // Opcionalmente, también podrías limitar la longitud del excerpt
        // Limita el excerpt a 30 palabras (por ejemplo)
        $custom_excerpt = wp_trim_words($custom_excerpt, 30, '...');

        return $custom_excerpt;
    }

    // Si el post no pertenece a la categoría, retorna el excerpt original
    return $excerpt;
}

// Añade el filtro para modificar el excerpt
add_filter('the_excerpt', 'custom_excerpt_for_category_noticia_unajma');



/**
 * [ADD FILTER]
 * 
 * Establece la fecha actua en el campo personalizado para las NOTICIAS
 * 
 */
function set_default_date($value, $post_id, $field) {
    // Verifica si el campo está vacío
    if( !$value ) {
        // Establece la fecha actual
        $value = date('Y-m-d');
    }
    return $value; // se retorna el valor modificado.
}

// Reemplazar 'fecha_noticia' o con el nombre del campo adecuado. La acción se realiza para cada campo
add_filter('acf/load_value/name=fecha_noticia_unajma', 'set_default_date', 10, 3);
add_filter('acf/load_value/name=fecha_comunicado', 'set_default_date', 10, 3);




//----------------------------------------------- INICIO
//----------------------------------------------- INICIO
//----------------------------------------------- INICIO
//----------------------------------------------- INICIO

/**
 * 
 * 
 * Funciones para la sección de NOTICIAS UNAJMAAA V2
 * 
 */
function shortcode_print_data_noticia_unajma(){

    ob_start();
    ?>
        <div class="data-notice">
            <p><?= the_field('redactor_noticia_unajma'); ?> | Redactor Personal De Unajma</p>
            <p><?= the_field('fecha_noticia_unajma'); ?> - <?= the_field('tiempo_lecture_noticia'); ?> de lectura.</p>
            <div class="separator-notice"></div>
        </div>
    <?php
    // Capturar el contenido generado
    $contenido = ob_get_clean();

    // Devolver el contenido generado
    return $contenido;
}
add_shortcode('data_noticia_unajma', 'shortcode_print_data_noticia_unajma');

function print_details_noticias_unajma(){
    
    //obtiene la img de la portada del post
    $url_img_portada = get_the_post_thumbnail_url();
    $img_srcset = "$url_img_portada, $url_img_portada 780w,$url_img_portada 360w";            
    
    ?>
        <script>
            // cambia titulo del post
            let title_html = document.querySelector("h3.uagb-heading-text strong");
            title_html.innerHTML = "<?= the_title(); ?>";

            // cambia ultimo texto
            let parrafo_html = document.querySelector("p.parrafo-entrada strong");
            parrafo_html.innerHTML = "<em><?= the_field('ultimo_texto_noticia'); ?></em>";

            // cambia imagen del post
            let img_html = document.querySelector("div.uagb-ifb-image-content img");
            img_html.srcset = '<?= $img_srcset ?>';
            img_html.src = '<?= $url_img_portada ?>';

        </script>
        
    <?php
}

function shortcode_print_details_noticia_unajma(){

    ob_start();
    ?>
        <div class="content-notice post-content">
            <?php the_field('contenido_noticia_unajma'); ?>
        </div>


    <?php
    // Capturar el contenido generado
    $contenido = ob_get_clean();

    // Agregando linnk Y otros. Revizar función
    add_action('wp_footer', 'print_details_noticias_unajma');

    // Devolver el contenido generado
    return $contenido;
}
add_shortcode('detalles_noticia_unajma', 'shortcode_print_details_noticia_unajma');

//----------------------------------------------- FIN
//----------------------------------------------- FIN
//----------------------------------------------- FIN
//----------------------------------------------- FIN



/**
 * [ADD SHORCODE]
 * 
 * Imprime el valor de un campo personalizado en la sección de AGENDAS Y EVENTOS. 
 * * buscar la manera de argega en una unica función.
 * 
 */
function fn_nombre_organizador(){
        // se inicia el buffer
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



/**
 * [ADD SHORTCODE]
 * 
 * Implementa el contenido para la plantilla de AGENDAS Y EVENTOS.
 * Este shortcode se puede usar para mostrar el contenido personalizado del campo 'contenido_evento'.
 * Utiliza la función the_field de ACF para obtener el valor del campo personalizado.
 * 
 * Ejemplo de uso del shortcode: [contenido_evento]
 *
 * @return string El contenido HTML generado por el shortcode.
 */
function shortcode_print_content_evento(){
    // Inicia el almacenamiento en el buffer de salida
    ob_start();
    ?>
        <div class="content-notice post-content">
            <?php 
                // Obtener el contenido del campo personalizado 'contenido_evento'
                $conten_event = get_field('contenido_evento');
                // Verificar si el contenido contiene un iframe
                if(strpos($conten_event,"<iframe") != false){
                    // Imprime el valor del campo personalizado 'contenido_evento'
                    echo $conten_event;
                }else{
                    // Imprime el valor del campo personalizado 'contenido_evento'
                    the_field('contenido_evento'); 
                }
            ?>
        </div>
    <?php
    // Captura el contenido generado y limpia el buffer de salida
    $contenido = ob_get_clean();

    // Devuelve el contenido generado para que sea mostrado en el lugar donde se usó el shortcode
    return $contenido;
}
// shortcode [contenido_evento] que ejecuta la función 'shortcode_print_content_evento'
add_shortcode('contenido_evento', 'shortcode_print_content_evento');



/**
 * [ADD SHORCODE]
 * 
 * Realzia varias tareas para las entradas de AGENDA Y ACTIVIDADES. 
 * las tareas se listan como comentarios encima de cada linea.
 * 
 */
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
 * [ACTION]
 * 
 * Retorna una sección en forma de tabla con la información requerida para AGENDA Y ACTIVIDADES
 * Se utiliza en cada uno de los POST de la categoria de  "Agenda y eventos"
 * !! ESTA ACTIÓN SE EJECUTA DENTRO DE UNA SHORCODE PARA EVITAR QUE SE EJECUTA EN TODAS LAS PÁGINAS POSIBLES!!
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
                    <span class="card-detalle_value"><?php the_field('fecha_evento'); ?> - <?php the_field('fecha_fin_evento'); ?></span>
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

    // Agregando linnk Y otros. Revizar función
    add_action('wp_footer', 'print_title_action');

    // Devolver el contenido generado
    return $contenido;
}
add_shortcode('print_text_agenda', 'shortcode_print_title_agenda_actividades');



/**
 * [SHORTCODE]
 * 
 * Shortcode para mostrar posts de la categoría "agenda-actividades" con paginación.
 * Se utiliza en la pagina principal de "agenda y actividades"
 *
 * @param array $atts Atributos del shortcode.
 * @return string Contenido HTML generado por el shortcode.
 */
function shortcode_agenda_actividades($atts) {
    // Establece los atributos por defecto del shortcode
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
    // Argumentos para la consulta de posts
    $query_args = array(
        'post_type' => 'post', // Tipo de post
        'posts_per_page' => intval($atts['posts_per_page']),
        'paged' => $paged,
        'category_name' => 'agenda-actividades' // Nombre de la categoría Agenda y Actividades
    );
    $query = new WP_Query($query_args);

    // Iniciar el buffer de salida
    ob_start();

    if ($query->have_posts()) {
        // Inicia el contenedor de los posts
        echo '<div class="posts-timeline">';

        while ($query->have_posts()) {
            $query->the_post();
            // Obtiene la URL de la imagen destacada del post actual
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
                        <?= obtener_extracto_de_campo_personalizado("contenido_evento", 150); ?> 
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
            echo '<div class="pagination-agenda">' . $pagination . '</div>';
        }
    } else {
        // Mensaje si no hay posts disponibles
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
 * Obtener un extracto personalizado del contenido del post
 *
 * Esta función obtiene el contenido del post actual, elimina las etiquetas HTML,
 * trunca el contenido a una longitud especificada y devuelve el extracto resultante.
 *
 * @param int $length La longitud máxima del extracto a devolver (por defecto 350 caracteres).
 * @return string El extracto truncado y sin etiquetas HTML del contenido del post.
 */
function obtener_extracto_personalizado($length = 350) {
    // Hace referencia al objeto global $post
    global $post;
    
    // Obtiene el contenido completo del post actual
    $excerpt = get_the_content();
    
    // Elimina las etiquetas HTML del contenido obtenido
    $excerpt = strip_tags($excerpt);
    
    // Trunca el contenido si su longitud excede el valor especificado
    if (strlen($excerpt) > $length) {
        // Corta el contenido a la longitud especificada y añade '...'
        $excerpt = substr($excerpt, 0, $length) . '...';
    }

    // Devuelve el extracto procesado
    return $excerpt;
}



/**
 * [FUNCTION]
 * 
 * Obtener un extracto de un campo personalizado
 *
 * Esta función obtiene el contenido de un campo personalizado de un post,
 * elimina las etiquetas HTML, trunca el contenido a una longitud especificada
 * y devuelve el extracto resultante.
 *
 * @param string $campo_name El nombre del campo personalizado a obtener.
 * @param int $length La longitud máxima del extracto a devolver (por defecto 350 caracteres).
 * @return string El extracto truncado y sin etiquetas HTML del campo personalizado.
 */
function obtener_extracto_de_campo_personalizado($campo_name, $length = 350) {
    // Hace referencia al objeto global $post
    global $post;
    
    // Obtiene el contenido del campo personalizado especificado
    $excerpt = get_field($campo_name);
    
    // Elimina las etiquetas HTML del contenido obtenido
    $excerpt = strip_tags($excerpt);
    
    // Trunca el contenido si su longitud excede el valor especificado
    if (strlen($excerpt) > $length) {
        // Corta el contenido a la longitud especificada y añade '...'
        $excerpt = substr($excerpt, 0, $length) . '...';
    }

    // Devuelve el extracto procesado
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

    $fecha_evento = get_field('fecha_evento');
    // comprobamos que la fecha de evento exista y no esté vacio
    if(isset($fecha_evento) && !empty($fecha_evento)){
        // Estructura html para imprimir la fecha del evento dentro de los cards de cada post de evento
        ?>
            <div class="div-fecha-evento">
                <span>Fecha Evento:</span>
                <?= $fecha_evento;  ?>
            </div>
        <?php
    }

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
function get_base_domain() {
    // Obtiene el esquema (http o https)
    $scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    
    // Obtiene el host
    $host = $_SERVER['HTTP_HOST'];
    
    // Construye el dominio base
    $base_domain = $scheme . "://" . $host;
    
    return $base_domain;
}

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
                    La universidad
                    <i class="fas fa-arrow-circle-down"></i>
                </span>
                <div class="dropdown-content">
                    <div class="header">
                        <h3>La universidad</h3>
                    </div>   
                    <div class="row">
                        <div class="column">
                            <h5>La universidad</h5> 
                            <a href="<?= get_base_domain();?>/mision-y-vision/"><i class="fas fa-external-link-alt"></i> Misión y visión </a>
                            <a href="<?= get_base_domain();?>/resena-historica/"><i class="fas fa-external-link-alt"></i> Reseña histórica </a>
                            <a href="<?= get_base_domain();?>/comite-electoral-universitario/"><i class="fas fa-external-link-alt"></i> Comité Electoral </a>
                            <!-- <a href="<?= get_base_domain();?>/asamblea-universitaria/"><i class="fas fa-external-link-alt"></i> Asamblea Universitaria </a> -->
                            <a href="<?= get_base_domain();?>/directorio/"><i class="fas fa-external-link-alt"></i> Directorio </a>
                            <!-- <a href="#"><i class="fas fa-external-link-alt"></i> Vicerrectorado Académico </a>
                            <a href="#"><i class="fas fa-external-link-alt"></i> Vicerrectorado de Investigación </a> -->
                            <a href="<?= get_base_domain();?>/rendicion-de-cuentas/"><i class="fas fa-external-link-alt"></i> Rendición de cuentas </a>
                            <a href="<?= get_base_domain();?>/organigrama/"><i class="fas fa-external-link-alt"></i> Organigrama </a>
                        </div>
                        <div class="column">
                            <h5>Órganos de gobierno</h5>
                            <!-- <a href="<?= get_base_domain();?>/rectorado/"><i class="fas fa-external-link-alt"></i> Rectorado </a> -->
                            <a href="<?= get_base_domain();?>/asamblea-universitaria/"><i class="fas fa-external-link-alt"></i> Asamblea Universitaria </a>
                            <a href="<?= get_base_domain();?>/consejo-universitario/"><i class="fas fa-external-link-alt"></i> Consejo Universitario </a>
                        </div>
                    </div>
                </div>
            </div> 

            <a href="http://admision.unajma.edu.pe/" class="link-nav">Admisión</a>

            <div class="dropdown">
                <!-- <a href="#" class="link-nav link-nav-drop">
                    Pregrado +
                    <i class="fa fa-caret-down"></i>
                </a> -->
                <span class="link-nav link-nav-drop">
                    Pregrado
                    <i class="fas fa-arrow-circle-down"></i>
                </span>
                <div class="dropdown-content">
                    <div class="header">
                        <h3>Pregrado</h3>
                    </div>   
                    <div class="row">
                        <div class="column">
                            <h5>Pregrado</h5>
                            <a href="<?= get_base_domain();?>/facultades/#fingenieria"><i class="fas fa-external-link-alt"></i> Facultad de ingeniería</a>
                            <a href="<?= get_base_domain();?>/facultades/"><i class="fas fa-external-link-alt"></i> Facultad de ciencias empresariales</a>
                        </div>
                        <!-- <div class="column">
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
                        </div> -->
                    </div>
                </div>
            </div> 
            <div class="dropdown">
                <span href="#" class="link-nav link-nav-drop">
                    Posgrado
                    <i class="fas fa-arrow-circle-down"></i>
                </span>
                <div class="dropdown-content">
                    <div class="header">
                        <h3>Posgrado</h3>
                    </div>   
                    <div class="row">
                        <div class="column">
                            <h5>Posgrado</h5>
                            <a href="<?= get_base_domain();?>/escuela-de-posgrado/"><i class="fas fa-external-link-alt"></i> Maestrías</a>
                            <!-- <a href="#"><i class="fas fa-external-link-alt"></i> Doctorados</a> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="dropdown">
                <span href="#" class="link-nav link-nav-drop">
                    Investigación
                    <i class="fas fa-arrow-circle-down"></i>
                </span>
                <div class="dropdown-content">
                    <div class="header">
                        <h3>Investigación</h3>
                    </div>   
                    <div class="row">
                        <div class="column">
                            <h5>Investigación</h5>
                            <a href="<?= get_base_domain();?>/acerca-de-nosotros/"><i class="fas fa-external-link-alt"></i> Acerca de nosotros</a>
                            <a href="<?= get_base_domain();?>/docentes-investigadores-investigacion/"><i class="fas fa-external-link-alt"></i> Docentes investigadores</a>
                            <a href="<?= get_base_domain();?>/reglamentos-investigacion/"><i class="fas fa-external-link-alt"></i> Reglamentos</a>
                        </div>
                        <div class="column">
                            <h5>Publicaciones</h5>
                            <a href="https://repositorio.unajma.edu.pe/" target="_blank"><i class="fas fa-external-link-alt"></i> Repositorio institucional</a>
                            <a href="http://bibliotecavirtual.unajma.edu.pe/" target="_blank"><i class="fas fa-external-link-alt"></i> Biblioteca virtual</a>
                            <a href="<?= get_base_domain();?>/revistas-en-educacion/"><i class="fas fa-external-link-alt"></i> Revistas</a>
                        </div>
                        <div class="column">
                            <h5>Producción Científica</h5>
                            <a href="<?= get_base_domain();?>/proyectos-de-investigacion/"><i class="fas fa-external-link-alt"></i> Proyectos de investigación</a>
                            <a href="<?= get_base_domain();?>/convocatoria-proyectos-de-investigacion/"><i class="fas fa-external-link-alt"></i> Convocatorias de proyectos</a>
                        </div>
                    </div>
                </div>
            </div> 
    
            <div class="dropdown">
                <span href="#" class="link-nav link-nav-drop">
                    Servicios
                    <i class="fas fa-arrow-circle-down"></i>
                </span>
                <div class="dropdown-content">
                    <div class="header">
                        <h3>Servicios</h3>
                    </div>   
                    <div class="row">
                        <div class="column">
                            <h5>Servicios</h5>
                            <a href="<?= get_base_domain();?>/direccion-de-produccion-de-bienes-y-servicios/"><i class="fas fa-external-link-alt"></i> Instituto de informática</a>
                            <a href="<?= get_base_domain();?>/direccion-de-produccion-de-bienes-y-servicios/"><i class="fas fa-external-link-alt"></i> Centro de idiomas</a>
                            <a href="<?= get_base_domain();?>/direccion-de-produccion-de-bienes-y-servicios/"><i class="fas fa-external-link-alt"></i> Cepre</a>
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