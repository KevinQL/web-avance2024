<?php
/**
 * Enqueue script for parent theme stylesheet 
 */

 function childtheme_parent_styles(){
    //enqueue style
    wp_enqueue_style('parent', get_template_directory_uri().'/style.css');    
}

add_action('wp_enqueue_scripts', 'childtheme_parent_styles');

//--------------------- FIN TEMA HIJO UNAJMA----------------------------
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

// Detectar los shortcodes en el contenido. 
/*
* Esta funcion carga los scripts de estilos y js para todos, y al mimso tiempo filtra los scripts de estilos y js para que se cargen solo cuando existan hortcodes dentro del post.
*/
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


//------------- FIN CONFIGURACIÓN DE ARCHIVOS JS Y CSS------------------
//----------------------------------------------------------------------
//----------------------------------------------------------------------
//----------------------------------------------------------------------



/**
 * [ADD FILTER]
 * 
 * Función para modificar el excerpt de los posts de una categoría específica
 * para la sección de COMUNICADOS UNAJMA en la página principal
 */
function custom_excerpt_for_category_actividades($excerpt) {
    global $post;

    // Verifica si el post pertenece a la categoría 'noticia_unajma'
    if (has_category('actividades', $post)) {
        // Personaliza el excerpt aquí
        $custom_excerpt = get_field('descripcion_actividades');
        // Limita el excerpt a 30 palabras (por ejemplo)
        $custom_excerpt = wp_trim_words($custom_excerpt, 30, '...');

        return $custom_excerpt;
    }

    // Si el post no pertenece a la categoría, retorna el excerpt original
    return $excerpt;
}

// Añade el filtro para modificar el excerpt
add_filter('the_excerpt', 'custom_excerpt_for_category_actividades');

/**
 * [ADD FILTER]
 * 
 * Función para modificar el excerpt de los posts de una categoría específica
 * para la sección de COMUNICADOS UNAJMA en la página principal
 */
function custom_excerpt_for_category_docentes($excerpt) {
    global $post;

    // Verifica si el post pertenece a la categoría 'noticia_unajma'
    if (has_category('docentes', $post)) {
        // Personaliza el excerpt aquí
        $custom_excerpt = get_field('resumen_docentes');
        // Limita el excerpt a 30 palabras (por ejemplo)
        $custom_excerpt = wp_trim_words($custom_excerpt, 30, '...');

        $custom_excerpt = "<span class='name-docente'>".get_field('nombre_docentes')."</span>".$custom_excerpt;


        return $custom_excerpt;
    }

    // Si el post no pertenece a la categoría, retorna el excerpt original
    return $excerpt;
}

// Añade el filtro para modificar el excerpt
add_filter('the_excerpt', 'custom_excerpt_for_category_docentes');

