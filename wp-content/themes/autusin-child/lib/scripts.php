<?php

function autusin_scripts()
{
    if(!is_admin()) {
        wp_enqueue_style('autusin-responsive', get_template_directory_uri() . '/css/app-responsive.css', array(), null);
    }
}
?>