<?php 

/**
 * Manage the template directory
 */
function ejo_get_template_dir() {
    return trailingslashit( apply_filters( 'ejo_template_dir', 'templates' ) );
}

/**
 * Manage the template parts directory
 */
function ejo_get_template_part_dir() {
    return trailingslashit( apply_filters( 'ejo_template_part_dir', ejo_get_template_dir() . 'parts' ) );
}