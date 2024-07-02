<?php
use PHPUnit\Framework\TestCase;
require_once 'C:\Program Files\Ampps\www\wordpress\wp-load.php'; 
//require_once 'C:\Program Files\Ampps\www\wordpress\vendor\johnpbloch\wordpress-core\wp-includes\class-wp-comment-query.php';
class CommentContentTest extends TestCase
{
    public function testFetchCommentContent()
    {
        $args = array(
            'comment_author' => 'root', 
            'comment_ID' => '50', 
            // 'comment_author_tel' => '09022222211', 
        );
        $comments_query = new WP_Comment_Query();
       
        $comments = $comments_query->query($args);
     
        $this->assertNotEmpty($comments);
        $comment = $comments[0];
        $this->assertNotEmpty($comment->comment_content);
        var_dump($comments[0]);
        echo "Comment Content: " . $comment->comment_content . "\n";

        if ($comment->comment_parent != 0) {

            $parent_comment = get_comment($comment->comment_parent);
           
            $this->assertInstanceOf('WP_Comment', $parent_comment);

            echo "Parent Comment Content: " . $parent_comment->comment_content . "\n";
            echo "Child Comment Content: " . $comment->comment_content . "\n";
        }
    }
}
?>
