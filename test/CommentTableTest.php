<?php
use PHPUnit\Framework\TestCase;
use WP_Comment;
use wpdb;
global $wpdb;
class CommentTableTest extends TestCase {
   
    public function testQueryCommentTable() {
        $wpdb = $this->getDbInstance();
        $author_name = 'John Doe';

        $comments = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM {$wpdb->comments} WHERE comment_author = %s",
                $author_name
            ),
            OBJECT
        );

        $this->assertNotEmpty($comments);

        var_dump($comments);

        foreach ($comments as $comment) {
            $this->assertEquals($author_name, $comment->comment_author);
        }
        function getDbInstance()   {
                global $wpdb;
                return $wpdb;
            }
    }

}
