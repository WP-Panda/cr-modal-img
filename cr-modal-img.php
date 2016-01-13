<?php
/*
Plugin Name: Cr Modal Img
Plugin URI: https://github.com/WP-Panda/cr-modal-img
Description: Плагин для вставки изображений с модальным окном, подписью и кнопкой отправить в Pinterest.
Version: 1.0.0
Author: WP Panda
Author URI: http://wp-panda.com
License: GPL2
*/

/**
 * Кнопка картинка в визуальный редактор
 * @param $atts
 * @return string
 */
function cr_img_short( $atts ) {
    global $post;
    $a = shortcode_atts( array(
        'href' => '',
        'alt' => '',
        'text'=>'',
    ), $atts );

    $upload_dir = wp_upload_dir();

    $out =  '<div class="wp-caption aligncenter">';
    $out .=  '<a data-pin-do="buttonPin" href="https://ru.pinterest.com/pin/create/button/?url=' . get_the_permalink($post->ID) . '&media=' .  $upload_dir['baseurl'] .'/' . $a['href']. '&description=' . get_the_title($post->ID) . '" data-pin-color="red"></a>';
    $out .=  '<a href="' .  $upload_dir['baseurl'] .'/' . $a['href']. '" title="' . $a['alt'] . '" data-ob="lightbox">';
    $out .=  '<img src="' .  $upload_dir['baseurl'] .'/' . $a['href']. '" alt ="' . $a['alt'] . '">' ;
    $out .=  '</a>' ;
    if(!empty( $a['text'])){
        $out .=  '<p class="wp-caption-text">' . $a['text'] . '</p>';
    }
    $out .=  '</div>';
    return $out;

}
add_shortcode( 'cr_img', 'cr_img_short' );


add_action( 'init', 'wptuts_buttons' );
function wptuts_buttons() {
    add_filter( "mce_external_plugins", "wptuts_add_buttons" );
    add_filter( 'mce_buttons', 'wptuts_register_buttons' );
}
function wptuts_add_buttons( $plugin_array ) {
    $plugin_array['wptuts'] = plugins_url( '/assets/js/shortcode.js' , __FILE__ ) ;
    return $plugin_array;
}
function wptuts_register_buttons( $buttons ) {
    array_push( $buttons, 'dropcap');
    return $buttons;
}

/**
 * Кнопка картинка в текстовый редактор
 */
function cr_fast_add_quicktags() {
    if (wp_script_is('quicktags')){
        ?>
        <script type="text/javascript">
            QTags.addButton( 'wp_panda', 'cr_img', '[cr_img href="" alt="" text=""]');
        </script>
        <?php
    }
}
add_action( 'admin_print_footer_scripts', 'cr_fast_add_quicktags' );

/**
 * Подключение скриптов
 */
 function cr_modal_img_frontend_assets() {
     wp_enqueue_script('orangebox-js', plugins_url( '/assets/js/orangebox.min.js' , __FILE__ ), array('jquery'),'3.0.0',true);
     wp_enqueue_script('pin-js', plugins_url( '/assets/js/pinit.js' , __FILE__ ), array('jquery'),'3.0.0',true);
     wp_enqueue_style('orangebox-css', plugins_url( '/assets/css/orangebox.css' , __FILE__ ) );
     wp_enqueue_style('pin-css', plugins_url( '/assets/css/style.css' , __FILE__ ) );
 }

add_action('wp_enqueue_scripts','cr_modal_img_frontend_assets');
