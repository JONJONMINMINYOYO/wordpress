<?php
//require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
// 获取当前评论页码
$wp_list_table = new WP_Comments_List_Table;
$wp_list_table->pagination( $which );
$paged = (get_query_var('cpage')) ? get_query_var('cpage') : 1;

// 获取评论总数
$total_comments = get_comments_number();

// 设置每页显示的评论数
$comments_per_page = 2;

// 计算总页数
$total_pages = ceil($total_comments / $comments_per_page);

// 输出分页导航条
if ($total_pages > 1) {
    $big = 999; // 用于兼容 `paginate_links()` 函数
    echo '<div class="comment-pagination">';
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format' => '?cpage=%#%',
        'current' => max(1, $paged),
        'total' => $total_pages,
        'prev_text' => '« 上一页',
        'next_text' => '下一页 »',
    ));
    echo '</div>';
}

// if ( function_exists( 'pagination' ) ) {
//     pagination( $total_pages );
// }

?>
