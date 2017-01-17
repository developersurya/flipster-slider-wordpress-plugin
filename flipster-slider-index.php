<?php
/**
 * @package flipster slider plugin by Surya Manandhar
 * @version 1.1
 */
/*
Plugin Name: flipster slider plugin by developerSurya
Plugin URI: http://hellosurya.com.np/
Description: This is just a plugin for showing flipster slider by shortcode e.g [flipster totalslide='2'].Add your slider image in feature image of the custom post named flipsters.Add caption on the title section.
Author: Surya Manandhar
Version: 1.1
Author URI: http://hellosurya.com.np/
*/

//load js for plugin
function flipster_admin_scripts() {
    //wp_enqueue_script( 'jquery' );
    //wp_enqueue_script( 'jquery', plugin_dir_url( __FILE__ ) . '/js/custom.js', array( 'jquery' ), '1.0.0', true );
    wp_enqueue_script( 'flipster', plugin_dir_url( __FILE__ ) . 'js/flipster.js', array( 'jquery' ), '', true );
    wp_register_style( 'flipster',plugin_dir_url( __FILE__ ) . 'css/flipster.css');
    wp_enqueue_style( 'flipster' );
    wp_enqueue_script( 'flipster' );
}
add_action( 'init', 'flipster_admin_scripts' ); 

//looad css for plugin
function load_flipster_wp_admin_style() {
       
}
add_action( 'admin_enqueue_scripts', 'load_t_wp_admin_style' );
function flipster_custom_init() {
 
    $args = array(
        'label'  => 'flipster slider',
         'description'        => __( 'Description.', 'slider images and more' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'slider' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'thumbnail' )
    );

    register_post_type( 'flipsters', $args );
}
add_action( 'init', 'flipster_custom_init' );

function flipster_func( $atts ){
      $foobar_atts = shortcode_atts( array(
        'totalslide' => '5',
        'attribution' => 'Author',
    ), $atts );
       $num= $foobar_atts['totalslide'];
        $string = '';
         $string = '<div class="recent-works"><h1>Recent<span>Works('.$num.'++)</span></h1></div>';
        $string .= ' <div id="carouselnew">
        <ul class="flip-items">';
        //var_dump($num);
       $args= array(
        //'post_type' => 'tcsn_portfolio'
        'post_type' => 'flipsters'
        );
        $the_query = new WP_Query( $args );
        if ( $the_query->have_posts() ) {
        while ( $the_query->have_posts()){
            $the_query->the_post(); 
            $post_thumbnail_id = get_post_thumbnail_id($post->ID);
            $attachment_title = get_the_title($post_thumbnail_id);
            $image_alt = get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true);
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full');
            $image_path = $image['0'];
            $image_link = get_post_meta( $post->ID, 'rw_link_url', true);
        $string .= '<li><img src="'.$image_path.'" alt="'.$image_alt.'" title="'.$attachment_title.'" width="355" height="200" >
                <a href="'.$image_path.'" data-rel="prettyPhoto[gallery]" title="'.$attachment_title.'" class="icon-zoom" rel="prettyPhoto[gallery]" style="opacity: 1;"><i class="fa fa-search"></i></a>
                <a href="'.$image_link.'" class="icon-link" target="_blank" style="opacity: 1;">
                    <i class="fa fa-link"></i>
                </a>
            </li>';
          $count++;
               }
                $string.='</ul></div>';
                wp_reset_postdata();
            }
            return $string;
    ?>
    <?php  
     
}
add_shortcode( 'flipster', 'flipster_func' );





       
   