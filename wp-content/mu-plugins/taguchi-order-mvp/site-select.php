<?php
/**
 * Purchase-order site selector behavior.
 *
 * Administrators can select from every published site. Other users only see
 * sites assigned to them through the existing `user` post meta relation.
 */

defined( 'ABSPATH' ) || exit;

function taguchi_order_register_dynamic_site_select(): void {
    if ( ! function_exists( 'wpcf7_add_form_tag' ) || ! class_exists( 'WPCF7_FormTag' ) ) {
        return;
    }

    wpcf7_add_form_tag(
        'dynamic_select',
        'taguchi_order_dynamic_site_select_handler',
        array( 'name-attr' => true )
    );
}
add_action( 'wpcf7_init', 'taguchi_order_register_dynamic_site_select', 20 );

function taguchi_order_dynamic_site_select_handler( $tag ): string {
    $tag = new WPCF7_FormTag( $tag );
    $name = (string) $tag->name;

    if ( '' === $name ) {
        return '';
    }

    $args = array(
        'post_type'      => 'site_post',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'title',
        'order'          => 'ASC',
    );

    if ( ! current_user_can( 'manage_options' ) ) {
        $user = wp_get_current_user();
        $args['meta_query'] = array(
            array(
                'key'     => 'user',
                'value'   => (int) $user->ID,
                'compare' => '=',
            ),
        );
    }

    $posts = get_posts( $args );

    $html  = '<select name="' . esc_attr( $name ) . '" id="' . esc_attr( $name ) . '" class="wpcf7-form-control wpcf7-select" required>';
    $html .= '<option value="" disabled selected>選択して下さい</option>';

    foreach ( $posts as $post ) {
        $title = get_the_title( $post->ID );
        $html .= '<option value="' . esc_attr( (string) $post->ID ) . '">' . esc_html( $title ) . '</option>';
    }

    $html .= '</select>';

    return $html;
}
