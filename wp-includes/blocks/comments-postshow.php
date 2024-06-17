<?php
//
define('WP_USE_THEMES', false);
require_once('wp-load.php');

// 
$post_id = 1;

// 
$comments = get_comments(array(
    'post_id' => $post_id,
    'status' => 'approve', // 
    'orderby' => 'comment_ID', // 
    'order' => 'ASC', // 
));

// 
if ($comments) {
    echo '<table>';
    echo '<tr><th>xx</th><th>xx</th><th>xx</th></tr>';

    foreach ($comments as $comment) {
        echo '<tr>';
        echo '<td>' . esc_html($comment->comment_author) . '</td>';
        echo '<td>' . wpautop($comment->comment_content) . '</td>';
        echo '<td>' . $comment->comment_date . '</td>';
        echo '</tr>';
    }

    echo '</table>';
} else {
    echo '<p>xxx</p>';
}
?>
