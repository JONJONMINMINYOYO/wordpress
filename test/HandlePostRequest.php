<?php
require_once(dirname(__FILE__) . '/wp-load.php');
require_once(ABSPATH . 'wp-admin/includes/admin.php');
require_once('wp-admin/includes/class-wp-comments-list-table.php');

function handlePostRequest() {
    // Check if initial URL matches and redirect if necessary
    $postshow_initial_url = set_url_scheme('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    if ($postshow_initial_url == 'http://localhost/wordpress/wp-postshow-comments.php') {
        $target_url = "http://localhost/wordpress/wp-postshow-comments.php?post_id_select=&search_email=&search_keyword=&paged=1";
        wp_redirect($target_url);
        exit;
    }

    global $wpdb;

    // Set up variables for filtering and querying
    $post_id_select = isset($_GET['post_id_select']) ? sanitize_text_field($_GET['post_id_select']) : '';
    $search_email = isset($_GET['search_email']) ? sanitize_text_field($_GET['search_email']) : '';
    $search_keyword = isset($_GET['search_keyword']) ? sanitize_text_field($_GET['search_keyword']) : '';

    // Build SQL query based on filters
    $sql = "SELECT * FROM {$wpdb->prefix}comments WHERE 1 = 1 ";
    $sql_count = "SELECT COUNT(*) FROM {$wpdb->prefix}comments WHERE 1 = 1 ";

    if (!empty($post_id_select)) {
        $sql .= " AND comment_post_ID = " . esc_sql($post_id_select);
        $sql_count .= " AND comment_post_ID LIKE '%" . esc_sql($post_id_select) . "%'";
    }

    if (!empty($search_email)) {
        $sql .= " AND comment_author_email LIKE '%" . esc_sql($search_email) . "%'";
        $sql_count .= " AND comment_author_email LIKE '%" . esc_sql($search_email) . "%'";
    }

    if (!empty($search_keyword)) {
        $escaped_keyword = esc_sql($search_keyword);
        $sql_by_keyword = " AND ( comment_ID LIKE '%$escaped_keyword%' OR 
                              comment_post_ID LIKE '%$escaped_keyword%' OR 
                              comment_author LIKE '%$escaped_keyword%' OR
                              comment_author_email LIKE '%$escaped_keyword%' OR
                              comment_author_url LIKE '%$escaped_keyword%' OR
                              comment_author_IP LIKE '%$escaped_keyword%' OR
                              comment_content LIKE '%$escaped_keyword%' OR
                              comment_approved LIKE '%$escaped_keyword%' OR
                              comment_type LIKE '%$escaped_keyword%' OR
                              comment_parent LIKE '%$escaped_keyword%' OR
                              user_id LIKE '%$escaped_keyword%' OR
                              comment_author_tel LIKE '%$escaped_keyword%' OR
                              comment_sex LIKE '%$escaped_keyword%') ";
        $sql .= $sql_by_keyword;
        $sql_count .= $sql_by_keyword;
    }

    // Set pagination parameters
    $limit = 3;
    $page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
    $offset = ($page - 1) * $limit;

    $sql .= " LIMIT $limit OFFSET $offset";

    // Retrieve comments and total comment count
    $comments = $wpdb->get_results($sql);
    $total_comments = $wpdb->get_var($sql_count);
    $total_pages = ceil($total_comments / $limit);

    // Return or output comments table HTML (this part is typically output in your original code)

    return array($comments, $total_pages);
}

// Call the function to handle the POST request
list($comments, $total_pages) = handlePostRequest();
?>

<!-- HTML part of your code -->
<head>
    <meta charset="UTF-8">
    <title>Postに関わるコメント表示</title>
    <style>
        /* Your CSS styles here */
    </style>
</head>
<body>
    <!-- Your HTML content here -->
</body>
