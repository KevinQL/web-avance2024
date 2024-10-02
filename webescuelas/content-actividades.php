<?php
if (!defined('ABSPATH')) {
    exit; // Evitar acceso directo al archivo
}

?>

<div class="content-wrapper-activity">

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
                $tiempo_lectura = get_field('fecha_actividades');
                
                if ($tiempo_lectura) {
                    echo ' Evento ' . $tiempo_lectura;
                } else {
                    echo 'fecha de evento no disponible.';
                }
            ?>
        </p>
    </div>

    <div class="content-activity">
        
        <div class="main-content-activity">
            <div class="section-activity">
                <div class="details-activity">
                    <h3>DETALLES DEL EVENTO</h3>
                    <div class="separator-2"></div>
                    <div>
                        <ul>
                            <li>
                                <label for="">FECHA:</label> 
                                <span><?php echo get_field('fecha_actividades'); ?></span>
                            </li>
                            <li>
                                <label for="">HORA:</label> 
                                <span><?php echo get_field('hora_inicio_actividades') . ' - ' . get_field('hora_fin_actividades'); ?></span>
                            </li>
                            <li>
                                <label for="">LUGAR:</label> 
                                <span><?php echo get_field('lugar_actividades'); ?></span>
                            </li>
                            <li>
                                <label for="">INVERSIÓN:</label> 
                                <span><?php echo get_field('inversion_actividades'); ?></span>
                            </li>
                            <li>
                                <label for="">DIRIGIDO A:</label> 
                                <span><?php echo get_field('dirigido_actividades'); ?></span>
                            </li>
                        </ul>
                    </div>

                </div>
                <div class="img-activity">
                    <div class="post-thumbnail">
                        <?php 
                            // Imprimir la imagen destacada del post
                            if (has_post_thumbnail()) {
                                the_post_thumbnail('custom-size', ['class' => 'custom-featured-image']);
                            } else {
                                echo '<p class="msj-error">No hay imagen destacada disponible.</p>';
                            }
                        ?>
                        <!-- <div class="separator"></div> -->
                        </div>
                        <div class="separator-2"></div>
                </div>

            </div>

            <div class="container-activity">
                <div class="btn-activity">
                    <a  href="<?php echo get_field('link_inscripcion_actividades') ? get_field('link_inscripcion_actividades'):'#'; ?>"
                        target="_blank">
                        <?php
                            echo get_field('link_inscripcion_actividades') ? 'INSCRIBIRME':'Inscripción No disponible.';
                        ?>
                    </a>
                    <a  href="<?php echo get_field('contacto_actividades') ? 'https://api.whatsapp.com/send?phone=51'.get_field('contacto_actividades'):'#'; ?>"
                        target="_blank">
                        <?php
                            echo get_field('contacto_actividades') ? 'CONTACTAR':'Contacto No disponible.';
                        ?>
                    </a>
                </div>
            </div>

            <div class="container-activity">
                <div class="description-activity">
                    <h3>DESCRIPCIÓN</h3>
                    <div class="separator-2"></div>
                    <div class="description-activity_content">

                        <?php
                            echo get_field('descripcion_actividades') ? get_field('descripcion_actividades'):'Descripción No disponible.';
                        ?>
                    </div>

                    <h3>ORGANIZADO POR</h3>
                    <!-- <div class="separator-2"></div> -->
                    <p>
                        <?php
                            echo get_field('organizador_actividades') ? get_field('organizador_actividades'):'No disponible.';
                        ?>
                    </p>
                </div>
            </div>

            <div class="container-activity">
                <div class="btn-enlaces btn-activity">

                    <a  href="<?php echo get_field('descargar_actividades') ? get_field('descargar_actividades'):'#'; ?>"
                        target="_blank">
                        <?php
                            echo get_field('descargar_actividades') ? 'DESCARGAR':'Descarga No disponible.';
                        ?>
                    </a>
                    <a  href="<?php echo get_field('enlace_evento_actividades') ? get_field('enlace_evento_actividades'):'#'; ?>"
                        target="_blank">
                        <?php
                            echo get_field('enlace_evento_actividades') ? 'ENLACE EVENTO':'Enlace No disponible.';
                        ?>
                    </a>

                </div>
            </div>

        </div>

        <!-- Aside -->
        <div class="sidebar-activity">
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
                        <p class="">Próximos eventos 2024</p>
                        <h3 class="">
                            <mark class="mark-white">Próximos</mark>
                            <mark class="mark-blue">Eventos</mark>
                        </h3>
                        <div class="uagb-separator"></div>
                    </div>
                </aside>


                <ul>
                    <?php
                    // Query para obtener los últimos 3 posts de la categoría 'avisos-comunicados'
                    $recent_posts = new WP_Query(array(
                        'posts_per_page' => 3,
                        'category_name' => 'actividades',
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

</div>