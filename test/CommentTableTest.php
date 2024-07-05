<?php
use PHPUnit\Framework\TestCase;
global $wpdb;

class CommentTableTest extends TestCase {

    protected $wpdb;

    public function setUp(): void {
        parent::setUp();
        
        // Simulate WordPress $wpdb global object
        global $wpdb;
        $this->wpdb = $wpdb = new stdClass();
        $this->wpdb->comments = 'wp_comments'; // Simulate table name
        // var_dump($wpdb);
        // Alternatively, if you have a database connection available in your testing environment, you can mock $wpdb more realistically:
        // $this->wpdb = $GLOBALS['wpdb'];
    }

    public function testFetchComments() {

        $comments = $this->wpdb->prepare(
            "SELECT * FROM {$this->wpdb->comments} WHERE comment_approved = 1",
            OBJECT
        );

        $this->assertNotEmpty($comments);

        foreach ($comments as $comment) {

            $this->assertNotEmpty($comment->comment_author);
        }
    }
    
}
?>
