<?php
/**
 * Server-side rendering of the `core/comment-content` block.
 *
 * @package WordPress
 */

/**
 * Renders the `core/comment-content` block on the server.
 *
 * @param array    $attributes Block attributes.
 * @param string   $content    Block default content.
 * @param WP_Block $block      Block instance.
 * @return string Return the post comment's content.
 */
function render_block_core_comment_content( $attributes, $content, $block ) {
	if ( ! isset( $block->context['commentId'] ) ) {
		return '';
	}

	$comment            = get_comment( $block->context['commentId'] );
	$commenter          = wp_get_current_commenter();
	$show_pending_links = isset( $commenter['comment_author'] ) && $commenter['comment_author'];
	if ( empty( $comment ) ) {
		return '';
	}

	$args         = array();
	$comment_text = get_comment_text( $comment, $args );
	if ( !$comment_text ) {
		return '';
	}

	//20240605 render_block_core_comment_content電話番号と性別が表示　新規　koui start
	$comment_tel = get_comment_author_tel( $comment );
	
	$comment_sex = get_comment_sex( $comment );
	
	//20240605 render_block_core_comment_content電話番号と性別が表示　新規　koui end

	/** This filter is documented in wp-includes/comment-template.php */
	$comment_text = apply_filters( 'comment_text', $comment_text, $comment, $args );

	//20240605 apply_filtersに電話番号と性別　追加　koui start
	$comment_tel = apply_filters( 'comment_tel', $comment_tel, $comment, $args );
	$comment_sex = apply_filters( 'comment_sex', $comment_sex, $comment, $args );
	//20240605 apply_filtersに電話番号と性別　追加　koui end

	$moderation_note = '';
	//20240603 commentページで新規コメントに表示される　既存修正　koui start

	// if ('0' === $comment->comment_approved ) {
	// 	$commenter = wp_get_current_commenter();

	// 	if ( $commenter['comment_author_email'] ) {
	// 		echo "sssscomment_author_email";
	// 		$moderation_note = __( 'Your comment is awaiting moderation.' );
	// 	} else {
		
	// 		$moderation_note = __( 'Your comment is awaiting moderation. This is a preview; your comment will be visible after it has been approved.' );
	// 	}
	// 	$moderation_note = '<p><em class="comment-awaiting-moderation">' . $moderation_note . '</em></p>';
	// 	if ( ! $show_pending_links ) {
	// 		$comment_text = wp_kses( $comment_text, array() );
	// 	}
	// }
	
	//20240603 commentページで新規コメントに表示される　既存修正　koui end
	$classes = array();
	if ( isset( $attributes['textAlign'] ) ) {
		$classes[] = 'has-text-align-' . $attributes['textAlign'];
	}
	if ( isset( $attributes['style']['elements']['link']['color']['text'] ) ) {
		$classes[] = 'has-link-color';
	}

	$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => implode( ' ', $classes ) ) );
	
	return sprintf(
		'<div %s>%s %s</div>',
		$wrapper_attributes,
		$moderation_note,
		"コメント：$comment_text"."電話番号：$comment_tel"." <br>性別：$comment_sex",
	);
}

/**
 * Registers the `core/comment-content` block on the server.
 */
function register_block_core_comment_content() {
	register_block_type_from_metadata(
		__DIR__ . '/comment-content',
		array(
			'render_callback' => 'render_block_core_comment_content',
		)
	);
}
add_action( 'init', 'register_block_core_comment_content' );
