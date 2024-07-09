<?php
use PHPUnit\Framework\TestCase;
require_once 'C:\Program Files\Ampps\www\wordpress\wp-load.php';
class TestWPCommentQuery extends TestCase
{
    public function testCommentTable() {

        $comments_table = new WP_Comments_List_Table();

        $args = array(

            'user_id' => '1',
        );


        $comments = $comments_table->get_comments($args);

        $this->assertEmpty($comments);

        var_dump($comments);

        foreach ($comments as $comment) {
        
            $this->assertNotEmpty($comment->comment_author);
        }
    }



}
?>
