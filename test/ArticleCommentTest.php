<?php
use PHPUnit\Framework\TestCase;
require_once 'C:\Program Files\Ampps\www\wordpress\wp-load.php';
class ArticleCommentTest extends TestCase
{
    public function testArticleCommentPage()
    {

        $post_id = 19; 
        global $post;
        $post = get_post($post_id);
        setup_postdata($post);
        ob_start();
        //comment_form();
        $comment_form = ob_get_clean();

        $this->assertStringContainsString($comment_form,'comment' );  

        $comments = get_comments(array(
            'post_id' => $post_id,
            'approve' => '1',  
        ));

        $this->assertnotEmpty($comments);
        wp_reset_postdata();
    }
}
?>