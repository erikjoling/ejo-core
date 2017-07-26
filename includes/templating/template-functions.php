<?php 

/**
 * Allows putting header.php inside a subdirectory
 *
 * Forked from wp-includes\general-template.php
 */
function ejo_get_header() {

    /* WordPress Core action hook */
    do_action( 'get_header' );

    /* Set `template-parts` as default folder */
    $template_parts_dir = trailingslashit(apply_filters( 'ejo_template_parts_dir', 'template-parts' ));

    /* Set template hierarchy for header */
    $templates = array();
    $templates[] = $template_parts_dir . 'header/header.php';
    $templates[] = $template_parts_dir . 'header.php';
    $templates[] = 'header.php';

    locate_template( $templates, true );
}

/**
 * Allows putting footer.php inside a subdirectory
 *
 * Forked from wp-includes\general-template.php
 */
function ejo_get_footer() {

    /* WordPress Core action hook */
    do_action( 'get_footer' );

    /* Set `template-parts` as default folder */
    $template_parts_dir = trailingslashit(apply_filters( 'ejo_template_parts_dir', 'template-parts' ));

    /* Set template hierarchy for footer */
    $templates = array();
    $templates[] = $template_parts_dir . 'footer/footer.php';
    $templates[] = $template_parts_dir . 'footer.php';
    $templates[] = 'footer.php';

    locate_template( $templates, true );
}

/**
 * Allow custom template directory 
 * Replaces WordPress Core version
 */
function ejo_get_template_part( $slug, $require_once = true ) {

    // Just like WordPress Core...
    do_action( "get_template_part_{$slug}", $slug, '' );

    // Set `template-parts` as default template-parts folder
    $template_parts_dir = trailingslashit(apply_filters( 'ejo_template_parts_dir', 'template-parts' ));
    
    // Generate template
    $templates = array(); 
    $templates[] = $template_parts_dir . $slug . '.php';

    locate_template($templates, true, $require_once );
}

/**
 * Calculate which content template to get
 * Has a fallback hierarchy, whicht ejo_get_template_part has not
 *
 * Inspired by Justin Tadlock
 */
function ejo_get_content_template( $post_type = '', $template_type = '', $require_once = true) {
    
    // Set up an empty array and get the post type.
    $templates = array();

    // Set `template-parts` as default template-parts folder
    $template_parts_dir = trailingslashit(apply_filters( 'ejo_template_parts_dir', 'template-parts' ));

    // Process given input
    if (!$post_type) {
        
        $post_type = get_post_type();

        // Reset template type because it wouldn't make any sense without a manual post_type
        $template_type = ''; 

        // Add archive template_type to posts in archives
        if ( is_archive() || is_home() ) {

            $template_type = 'plural';
            $require_once = false;
        }
    }

    // Process template based off the post type and template type.
    if ($template_type) {

        $templates[] = $template_parts_dir. "content/{$post_type}/{$post_type}-{$template_type}.php";
        $templates[] = $template_parts_dir. "content/{$post_type}-{$template_type}.php";
    }

    // Template based off the post type.
    $templates[] = $template_parts_dir. "content/{$post_type}/{$post_type}.php";
    $templates[] = $template_parts_dir. "content/{$post_type}.php";

    // Fallback 'content.php' template.
    $templates[] = $template_parts_dir. 'content/content.php';

    // Apply filters to the templates array.
    $templates = apply_filters( 'ejo_content_template_hierarchy', $templates );

    // Locate the template.
    locate_template($templates, true, $require_once );
}

