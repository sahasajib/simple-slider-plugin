<?php
/*
*Plugin Name: Slider
*Description: This is a slider plugin 
*Version:1.0
*/

function sajib_register_cpt(){
    $labels = [
        'name' => 'Sajib Slider'
        ];
    $args = [
        'labels' => $labels,
        'public' => true,
        'show_uri' => true,
        'supports' => ['title', 'editor', 'thumbnail', 'page-attributes']
    ];

    register_post_type('sajib-slider', $args);
}
add_action('init', 'sajib_register_cpt');

function sajib_slider_shortcode(){
    $args = [
        'post_type' => 'sajib-slider',
        'posts_per_page' => -1
    ];

    $query = new WP_Query($args);

    $html = '
            <script>
                jQuery(document).ready(function($){
                    $(".sajib-slider").slick({
                        autoplay: true,
                        autoplaySpeed: 2000
                    });
                });
            </script>
            <div class="sajib-slider">';

    while($query->have_posts()) : $query->the_post();

    $html .= '<div class="sajib-slider-single-slide-item" style="background-image:url('.get_the_post_thumbnail_url(get_the_ID(),'large').')">;
                <div class="sajib-slider-content">
                    <h3> '.get_the_title().'</h3>
                    '.wpautop(get_the_content()).'
                </div>
    </div>';

    endwhile; wp_reset_query();

    $html .= '</div>';

    return $html;
}
add_shortcode( 'sajib_slider', 'sajib_slider_shortcode');

function sajib_plugin_assets(){
    $plugin_dir_uri = plugin_dir_url( __FILE__ );

    wp_enqueue_style( 'slick', $plugin_dir_uri . 'assets/css/slick.min.css');
    wp_enqueue_script( 'slick', $plugin_dir_uri . 'assets/js/slick.min.js' , ['jquery'], '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'sajib_plugin_assets');