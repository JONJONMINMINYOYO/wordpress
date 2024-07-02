<?php
use PHPUnit\Framework\TestCase;

class GetCommentSexTest extends TestCase {

    public function testGetCommentSexWithMaleComment() {

        // $comment_id = self::factory()->comment->create();

        $comment = new stdClass();
        $comment->comment_ID = 3; 
        $comment->comment_sex = 1; 

        $comment_id = 50;

        $comment_sex = ( 1 == $comment->comment_sex ) ? '男性' : ( ( 0 == $comment->comment_sex ) ? '女性' : 'なし' );
        $this->assertNotEmpty($comment_sex);
        $this->assertEquals('男性', $comment_sex);
        $this->assertEquals('女性', $comment_sex);
        $this->assertEquals('なし', $comment_sex);
    }

    public function testGetCommentSexWithFemaleComment() {
        $comment = new stdClass();
        // $comment->comment_ID = 3;
        //$comment->comment_sex = 0; 

 

        $comment_sex = $comment->comment_ID = 42;

        $this->assertEquals('0', $comment_sex);
    }

    public function testGetCommentSexWithNoComment() {
        $comment_sex = 1; 
        $this->assertEquals('1', $comment_sex);
    }

}
?>
