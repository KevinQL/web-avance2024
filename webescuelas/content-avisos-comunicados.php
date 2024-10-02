<?php
if (!defined('ABSPATH')) {
    exit; // Evitar acceso directo al archivo
}

?>


<div class="content-wrapper">
    <!-- Sección del contenido principal -->
    <div class="main-content">
        <div class="k-activity-header">
            <h3><?php the_title(); ?></h3>
            <div class="separator"></div>
            <p>Avisos y Comunicados de la Escuela Profesional. Encuentra aquí información importante y novedades para nuestra comunidad.</p>
        </div>

        <div class="post-presentation">
            <span>
                <!-- ACA VA EL ICONO DE LA PÁGINA O ALGUNA IMAGEN TIPO ICONO -->
                <img src="<?php echo get_site_icon_url(); ?>" alt="Ícono del sitio" class="icono">
            </span>
            <p class="redactor">
                <mark class="mark-unajma">UNAJMA</mark>
                |
                <mark class="mark-escuela">EPIS</mark>
            </p>
            <p class="info">
                <?php
                    // Obtener el valor del campo personalizado "tiempo_lectura_comunicado"
                    $tiempo_lectura = get_field('tiempo_lectura_comunicado');
                    
                    if ($tiempo_lectura) {
                        echo $tiempo_lectura . ' de lectura.';
                    } else {
                        echo 'Tiempo de lectura no disponible.';
                    }
                ?>
            </p>
        </div>

        <div class="post-content">
            <?php the_content(); ?>
        </div>
        <div class="post-thumbnail">
            <?php 
                // Imprimir la imagen destacada del post
                if (has_post_thumbnail()) {
                    the_post_thumbnail('custom-size', ['class' => 'custom-featured-image']);
                } else {
                    echo '<p class="msj-error">No hay imagen destacada disponible.</p>';
                }
            ?>
    </div>
    </div>

    <!-- Aside -->
    <div class="sidebar">
        <!-- Buscador -->
        <div class="search-form">
            <?php //get_search_form(); ?>
            <div class="search-form">
                <form role="search" method="get" class="search-form" action="https://localhost.webescuelas/">
                    <label for="search-field">
                        <span class="screen-reader-text">Search for:</span>
                        <input type="search" id="search-field" class="search-field" placeholder="Buscar..." value="" name="s" tabindex="-1">
                    </label>
                    <input type="submit" class="search-submit" value="Buscar">
                </form>
            </div>
        </div>

        <!-- Últimos 3 comunicados -->
        <div class="recent-posts">
            
            <aside class="">
                <div class="box-title umt-15">
                    <p class="">Entradas recientes 2024</p>
                    <h3 class="">
                        <mark class="mark-white">Entradas</mark>
                        <mark class="mark-blue">Recientes</mark>
                    </h3>
                    <div class="uagb-separator"></div>
                </div>
            </aside>


            <ul>
                <?php
                // Query para obtener los últimos 3 posts de la categoría 'avisos-comunicados'
                $recent_posts = new WP_Query(array(
                    'posts_per_page' => 3,
                    'category_name' => 'avisos-comunicados',
                    'orderby' => 'date',
                    'order' => 'DESC'
                ));
                
                if ($recent_posts->have_posts()) :
                    while ($recent_posts->have_posts()) : $recent_posts->the_post();
                        ?>
                        <li>
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            <span class="post-date"><?php echo get_the_date(); ?></span>
                        </li>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </ul>
        </div>

        <aside class="">
            <div class="box-title umt-15">
                <p class="">Categorias existentes 2024</p>
                <h3 class="">
                    <mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-ast-global-color-7-color">Categorias </mark>
                    <mark style="background-color:rgba(0, 0, 0, 0);color:#334e96" class="has-inline-color">Existentes</mark>
                </h3>
                <div class="uagb-separator"></div>
            </div>
        </aside>

        <!-- Mensaje al final del aside -->
        <div class="aside-categories">
            <ul>
                <li><i class="fa-solid fa-angles-right"></i> <a href="">Avisos y Comunicados</a></li>
                <li><i class="fa-solid fa-angles-right"></i> <a href="">Actividades</a></li>
                <li><i class="fa-solid fa-angles-right"></i> <a href="">Docentes</a></li>
                <li><i class="fa-solid fa-angles-right"></i> <a href="">Página principal de la UNAJMA</a></li>
            </ul>
        </div>
    </div>
</div>
