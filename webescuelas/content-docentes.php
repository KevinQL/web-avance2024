<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

<?php if ( astra_page_layout() == 'left-sidebar' ) : ?>

    <?php get_sidebar(); ?>

<?php endif ?>

    <div id="primary" <?php astra_primary_class(); ?>>

        <div class="post-content">
            <?php the_content(); ?>
        </div>
        
    </div><!-- #primary -->

<?php if ( astra_page_layout() == 'right-sidebar' ) : ?>

    <?php get_sidebar(); ?>

<?php endif ?>

<?php get_footer(); ?>