<?php
//require_once( dirname( __FILE__ ) . '/wordpress/wp-load.php' );
// 获取当前页面的 URL，用于返回按钮
// //require_once __DIR__ . '/admin.php';
// require_once( dirname( dirname( __FILE__ ) ) . '/wp-load.php' );
// require_once( dirname( dirname( __FILE__ ) ) . '/wp-load.php' );
// 在这里使用 WordPress 函数
    // $comments = get_comments( array(
    //     'post_id' => get_the_ID(), // 获取当前文章的评论
    // ) );

// foreach ($_SERVER as $key => $value) {
//     echo $key . ' = ' . $value . '<br>';
// }
//$current_url = esc_url( $_SERVER['REQUEST_URI'] );

// 获取当前 post 的评论信息
// $post_id = get_comments(); // 获取当前页面或文章的 ID
// $comments = get_comments( array(
//     'post_id' => $post_id,
//     'status' => 'approve', // 仅显示已批准的评论
// ) );

// if ( !post_password_required() ) {
//     return ;
// }

// $align_class_name    = empty( $attributes['textAlign'] ) ? '' : "has-text-align-{$attributes['textAlign']}";
// $show_post_title     = ! empty( $attributes['showPostTitle'] ) && $attributes['showPostTitle'];
// $show_comments_count = ! empty( $attributes['showCommentsCount'] ) && $attributes['showCommentsCount'];
// //$wrapper_attributes  = get_block_wrapper_attributes( array( 'class' => $align_class_name ) );
// //$comments_count      = get_comments_number("");
// /* translators: %s: Post title. */
// $post_title = sprintf( __( '&#8220;%s&#8221;' ), get_the_title() );
// $tag_name   = 'h1';
// if ( isset( $attributes['level'] ) ) {
//     $tag_name = 'h' . $attributes['level'];
// }

// if ( '0' === $comments_count ) {
//     return;
// }

// if ( $show_comments_count ) {
//     if ( $show_post_title ) {
//         if ( '1' === $comments_count ) {
//             /* translators: %s: Post title. */
//             $comments_title = sprintf( __( 'One response to %s' ), $post_title );
//         } else {
//             $comments_title = sprintf(
//                 /* translators: 1: Number of comments, 2: Post title. */
//                 _n(
//                     '%1$s response to %2$s',
//                     '%1$s responses to %2$s',
//                     $comments_count
//                 ),
//                 number_format_i18n( $comments_count ),
//                 $post_title
//             );
//         }
//     } elseif ( '1' === $comments_count ) {
//         $comments_title = __( 'One response' );
//     } else {
//         $comments_title = sprintf(
//             /* translators: %s: Number of comments. */
//             _n( '%s response', '%s responses', $comments_count ),
//             number_format_i18n( $comments_count )
//         );
//     }
// } elseif ( $show_post_title ) {
//     if ( '1' === $comments_count ) {
//         /* translators: %s: Post title. */
//         $comments_title = sprintf( __( 'Response to %s' ), $post_title );
//     } else {
//         /* translators: %s: Post title. */
//         $comments_title = sprintf( __( 'Responses to %s' ), $post_title );
//     }
// } elseif ( '1' === $comments_count ) {
//     $comments_title = __( 'Response' );
// } else {
//     $comments_title = __( 'Responses' );
// }

?>

<!DOCTYPE html>
<html lang="en">
<!-- <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>きょうの健康</title>
    <style>
        table {
            width: 80%;
            margin: 210px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 5px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .back-button {
            position: absolute;
            top: 5px;
            right: 5px;
            padding: 5px;
            background-color: #65574E;
            color: #ffffff;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2>きょうの健康</h2>
    <button class="back-button" onclick="goBack()">戻る</button>
    <table>
        <tr>
            <th>項目</th>
            <th>数値</th>
        </tr>
        <tr>
            <td>今の期日</td>
            <td><?php //echo date('Y-m-d H:i:s'); ?></td>
        </tr>
        <tr>
            <td>期日</td>
            <td><?php //echo date('Y-m-d'); ?></td>
        </tr>
        <tr>
            <td>時間</td>
            <td><?php //echo date('H:i:s'); ?></td>
        </tr>
    </table> -->
    <!-- <button class="back-button" onclick="goBack()">戻る</button>
    <script>
        function goBack() {
            window.history.back();
        }
    </script> -->
   
</body>
</html>
