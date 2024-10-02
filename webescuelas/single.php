<?php
get_header();

// Verificar si el post pertenece a la categoría "Avisos y Comunicados"
if (in_category('avisos-comunicados')) {
    // Incluir una plantilla personalizada para los posts de esta categoría
    get_template_part('content', 'avisos-comunicados'); 
}
else if(in_category('actividades')) {
    // Incluir una plantilla personalizada para los posts de esta categoría
    get_template_part('content', 'actividades'); 
}
else if(in_category('docentes')) {
    // Incluir una plantilla personalizada para los posts de esta categoría
    get_template_part('content', 'docentes'); 
}
else {
    // Plantilla estándar para otros posts
    get_template_part('content', 'single');
}

get_footer();

