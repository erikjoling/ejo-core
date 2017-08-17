<?php 

// Icon
add_shortcode( 'icon', 'ejo_get_icon' );

/* EJO Icon shortcode */
function ejo_get_icon( $atts ) 
{
    // Break if no attributes array
    if (!is_array($atts)) {
        return '';
    }

    // Preprocess the attributes to make the icon shortcode simpler
    foreach ($atts as $key => $value) {
        if (is_int($key)) {
            if ($value == 'circle') {
                $atts['circle'] = 'circle';
            }
            else {
                $atts['icon'] = $value;   
            }
            unset($atts[$key]);
        }
    }

    // Defaults
    $atts = shortcode_atts( array(
        'icon' => false,
        'circle' => ''
    ), $atts );

    // Break if no icon
    if (!$atts['icon']) {
        return '';
    }

    $icon_prefix = apply_filters( 'ejo_icon_prefix', 'fa-' );
    
    // Return the icon html
    return sprintf('<span class="%s %s" aria-hidden="true"></span>', $icon_prefix.$atts['icon'], $atts['circle']);
}