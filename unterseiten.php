<?php
/**
 * Plugin Name:     Unterseiten
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     Shortcode [unterseiten]
 * Author:          Bego Mario Garde <pixolin@pixolin.de>
 * Author URI:      YOUR SITE HERE
 * Text Domain:     unterseiten
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Unterseiten
 */

add_shortcode( 'unterseiten', 'unterseiten_shortcode' );
function unterseiten_shortcode( $atts ) {
	$a = shortcode_atts(
		array(
			'anzahl' => 10,
		),
		$atts
	);

	$out = '';
	global $post;
	$args     = array(
		'post_type'      => 'page',
		'posts_per_page' => esc_attr( $a['anzahl'] ),
		'post_parent'    => $post->ID,
		'order'          => 'DESC',
		'orderby'        => 'date',
	);
	$children = new WP_Query( $args );

	if ( $children->have_posts() ) {
		while ( $children->have_posts() ) {
			$children->the_post();

			$out .= '<div id="child-' . get_the_ID() . '" class="child-page">';
			$out .= '<h2><a href="' . get_the_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a></h2>';
			if ( has_post_thumbnail() ) {
				$out .= get_the_post_thumbnail(
					$post->ID,
					'thumbnail',
					array(
						'class' => 'alignleft',
						'style' => 'width:150px; height:auto;',
					)
				);
			}
			$out .= '<p>' . get_the_excerpt() . '</p>';
			$out .= '</div><div style="clear:both"></div>';

		}
	}
	wp_reset_postdata();

	return $out;
}
