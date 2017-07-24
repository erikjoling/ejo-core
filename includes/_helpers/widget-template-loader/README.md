# Add this library to every widget?

# How to use it in your theme
Integrate the template loader by using the following line in the widget-method of you Widget Class

    //* Check if Widget Template Loader exists and try to load template
    if ( class_exists( 'EJO_Widget_Template_Loader' ) && EJO_Widget_Template_Loader::load_template( $args, $instance, $this ) )
        return;

## Overwegingen
- Overwoog een plugin template toe te voegen, maar omdat de template class extern wordt ingeladen moet de plugin-url handmatig meegegeven worden aan een method. En dat vind ik het niet waard.