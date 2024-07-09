<?php
use PHPUnit\Framework\TestCase;
require_once 'C:\Program Files\Ampps\www\wordpress\wp-load.php'; 
//require_once 'C:\Program Files\Ampps\www\wordpress\vendor\johnpbloch\wordpress-core\wp-includes\class-wp-comment-query.php';
class TestCommentContent extends TestCase
{
    public function testFetchCommentContent()
    {
        $args = array(
            'comment_author' => 'root', 
            'comment_ID' => '51', 
            'comment_author_tel' => '133', 
            'as' => '12', 
        );

        $comments_query = new WP_Comment_Query();
        $comments = $comments_query->query($args);

        // 检查是否获取到评论
        $this->assertNotEmpty($comments, 'No comments found');
        
        // 检查是否为数组并且是否有内容
        $this->assertIsArray($comments, 'Comments is not an array');
        $this->assertGreaterThan(0, count($comments), 'Comments array is empty');

        // 检查第一个评论内容
        $comment = $comments[0];
        $this->assertNotEmpty($comment->comment_content, 'Comment content is empty');
        $this->assertIsString($comment->comment_content, 'Comment content is not a string');

    
        echo "Comment Content: " . $comment->comment_content . "\n";

        // 检查父评论
        if ($comment->comment_parent != 0) {
            $parent_comment = get_comment($comment->comment_parent);

            // 检查父评论是否为 WP_Comment 实例
            $this->assertInstanceOf('WP_Comment', $parent_comment, 'Parent comment is not an instance of WP_Comment');

            // 打印父评论内容（仅用于调试，实际测试时应移除）
            echo "Parent Comment Content: " . $parent_comment->comment_content . "\n";
            echo "Child Comment Content: " . $comment->comment_content . "\n";
        }
    }
}
?>
