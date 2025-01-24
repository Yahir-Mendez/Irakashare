<?php
function my_theme_enqueue_styles() {
    $parent_style = 'parent-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );


/*	-----------------------------------------------------------------------------------------------
	BLOCK PATTERNS
	Register theme specific block patterns.
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'child_theme_register_block_patterns' ) ) :
    function child_theme_register_block_patterns() {

        if ( ! ( function_exists( 'register_block_pattern_category' ) && function_exists( 'register_block_pattern' ) ) ) return;

        // The block pattern categories included in child_theme.
        $child_theme_block_pattern_categories = apply_filters( 'child_theme_block_pattern_categories', array(
            'child_theme' => array(
                'label'			=> esc_html__( 'Patrones propios', 'child_theme' ),
            ),
        ) );
        

        // Register block pattern categories.
        foreach ( $child_theme_block_pattern_categories as $slug => $settings ) {
            register_block_pattern_category( $slug, $settings );
        }
       
        // The block patterns included in child_theme.
        $child_theme_block_patterns = apply_filters( 'child_theme_block_patterns', array(
            
            'child_theme/Opiniones' => array(
                'title'         => esc_html__( 'Opiniones', 'child_theme' ),
                'categories'    => array( 'child_theme' ),
                'content'       => child_theme_get_block_pattern_markup( 'comentarios' ),
            ),
			'child_theme/Colaboradores' => array(
                'title'         => esc_html__( 'Colaboradores', 'child_theme' ),
                'categories'    => array( 'child_theme' ),
                'content'       => child_theme_get_block_pattern_markup( 'colaboradores' ),
            ),
			'child_theme/CV' => array(
                'title'         => esc_html__( 'Curriculum', 'child_theme' ),
                'categories'    => array( 'child_theme' ),
                'content'       => child_theme_get_block_pattern_markup( 'cv' ),
            ),
			'child_theme/datos' => array(
                'title'         => esc_html__( 'Datos', 'child_theme' ),
                'categories'    => array( 'child_theme' ),
                'content'       => child_theme_get_block_pattern_markup( 'datos' ),
            ),
			'child_theme/faq' => array(
                'title'         => esc_html__( 'FAQ', 'child_theme' ),
                'categories'    => array( 'child_theme' ),
                'content'       => child_theme_get_block_pattern_markup( 'faq' ),
            ),
			'child_theme/horario' => array(
                'title'         => esc_html__( 'horario', 'child_theme' ),
                'categories'    => array( 'child_theme' ),
                'content'       => child_theme_get_block_pattern_markup( 'horario' ),
            ),
			'child_theme/faq' => array(
                'title'         => esc_html__( 'Menú', 'child_theme' ),
                'categories'    => array( 'child_theme' ),
                'content'       => child_theme_get_block_pattern_markup( 'menu' ),
            ),
        ) );

        // Register block patterns.
        foreach ( $child_theme_block_patterns as $slug => $settings ) {
            register_block_pattern( $slug, $settings );
        }

    }
    add_action( 'init', 'child_theme_register_block_patterns' );
endif;


/*	-----------------------------------------------------------------------------------------------
	GET BLOCK PATTERN MARKUP
	Returns the markup of the block pattern at the specified theme path.
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'child_theme_get_block_pattern_markup' ) ) :
    function child_theme_get_block_pattern_markup( $pattern_name ) {

        $path = 'inc/block-patterns/' . $pattern_name . '.php';

        if ( ! locate_template( $path ) ) return;

        ob_start();
        include( locate_template( $path ) );
        return ob_get_clean();

    }
endif;


function article_dashboard_widget() {
	$pathPDF = get_option('siteurl').'/wp-content/plugins/wp-optimizado/wp-optimizado.pdf';
    ?>
<p>Theme Hijo 2022 es un tema original para montar tu web en muy pocos clics. Su gran ventaja es que incluye patrones personalizados para las secciones más habituales de cualquier web (clientes, colaboradores, horario, etc.). Gracias a los patrones, el diseño se hace mucho más intuitivo y ahorrarás mucho más tiempo.</p>
<p> Es un tema perfecto para blogs, webs de emprendedores y pymes, agencias y pequeñas tiendas, ya que es compatible con WooCommerce. Su diseño limpio y moderno adapta perfectamente tu contenido a cualquier dispositivo.</p>
        <a target="_blank" href="<?php echo $pathPDF?>">Ver documentación</a>
    <?php 

}

function add_articule_info_dashboard_widget() {
        wp_add_dashboard_widget('custom_dashboard_widget_id', 'Theme Hijo 2022', 'article_dashboard_widget');
}
add_action('wp_dashboard_setup', 'add_articule_info_dashboard_widget');
?>
