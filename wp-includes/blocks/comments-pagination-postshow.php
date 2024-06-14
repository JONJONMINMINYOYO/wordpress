<?php
/**
 * @package WordPress
 */
/**
 * @param array    $attributes Block attributes.
 * @param string   $content    Block default content.
 * @param WP_Block $block      Block instance.
 *
 * @return string Returns the next comments link for the query pagination.
 */
function render_block_core_comments_pagination_postshow( $attributes, $content, $block ) {
	//20240610 ページ名称改修　start
	//$default_label    = __( 'Older Comments' );  
	$default_label    = __( 'postshow' );
	//20240610 ページ名称改修  end
	$label            = isset( $attributes['label'] ) && ! empty( $attributes['label'] ) ? $attributes['label'] : $default_label;
	$pagination_arrow = get_comments_pagination_arrow( $block, 'postshow' );
	if ( $pagination_arrow ) {
		$label = $pagination_arrow . $label;
	}

	$filter_link_attributes = static function () {
		return get_block_wrapper_attributes();
	};
	add_filter( 'postshow_comments_link_attributes', $filter_link_attributes );

	$postshow_comments_link = get_postshow_comments_link( $label );

	remove_filter( 'postshow_comments_link_attributes', $filter_link_attributes );

	if ( ! isset( $postshow_comments_link ) ) {
		return '';
	}

	return $postshow_comments_link;
}

/**
 * Registers the `core/comments-pagination-previous` block on the server.
 */
function register_block_core_comments_pagination_postshow() {
	register_block_type_from_metadata(
		__DIR__ . '/comments-pagination-previous',
		array(
			'render_callback' => 'render_block_core_comments_pagination_postshow',
		)
	);
}
add_action( 'init', 'register_block_core_comments_pagination_postshow' );
