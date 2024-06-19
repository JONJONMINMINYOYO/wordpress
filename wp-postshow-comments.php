<?php

// require_once __DIR__ . 'wp-includes/general-template.php';
// get_header(); 
require_once('wp-load.php');

// Get post ID from query string or any other means
$post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;

// Example: Retrieve comments for a specific post
$comments = get_comments(array(
    'post_id' => $post_id,
    'status' => 'approve', // Include only approved comments
));

// Display comments
if (!empty($comments)) {
    foreach ($comments as $comment) {
        echo '<p>' . esc_html($comment->comment_content) . '</p>';
    }
} else {
    echo '<p>No comments found.</p>';
}
// 处理表单提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 获取表单提交的时间（这里假设是更新时间）
    $updated_datetime = $_POST['current_datetime'];

    // 在页面顶部显示当前的时间和日期
    echo "<h2>当前时间和日期</h2>";
    echo "<p>更新后的时间：$updated_datetime</p>";
}
get_footer();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>显示时间日期</title>
</head>
<body>
    <h2>当前时间和日期</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="current_datetime">当前时间和日期：</label><br>
        <input type="text" id="current_datetime" name="current_datetime" value="<?php echo date('Y-m-d H:i:s'); ?>" readonly><br><br>
        <input type="submit" value="更新时间">
    </form>
</body>
</html>

