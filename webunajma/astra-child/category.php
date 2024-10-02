
<?php 
    get_header(); 
?>

<div class="category-page">
    <h1><?php single_cat_title(); ?></h1> <!-- Título de la categoría -->

    <div class="row-category">
        <?php
            $contador = 0; // Inicializamos el contador

            if (have_posts()) : 
                while (have_posts() && $contador < 6) : the_post(); // Limitar el bucle a 6 posts
                    $contador++; // Incrementamos el contador en cada iteración
                    ?>
                    <div class="post">
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <p><?php the_excerpt(); ?></p> <!-- Resumen del contenido -->
                    </div>
                <?php 
                endwhile; 
            endif;
        ?>
    </div>

    
    <div class="content-btn">
        <button clase="btn-category">SABER MÁS</button>
    </div>




</div>

<?php get_footer(); ?>