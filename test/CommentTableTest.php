<?php
use PHPUnit\Framework\TestCase;
global $wpdb;

class CommentTableTest extends TestCase {

    protected $wpdb;

    public function setUp(): void {
        parent::setUp();
        global $wpdb;
        $this->wpdb = $wpdb;
    }

    public function testFetchComments() {
        // 查询已批准的评论
        $comments = $this->wpdb->get_results(
            "SELECT * FROM {$this->wpdb->comments} WHERE comment_approved = 1",
            OBJECT
        );

        // 断言获取的评论不为空
        $this->assertNotEmpty($comments);

        // 输出评论数据，可以根据实际情况自定义输出格式或断言
        var_dump($comments);

        // 进一步断言评论数据的特定属性或条件
        foreach ($comments as $comment) {
            // 示例：断言评论作者不为空
            $this->assertNotEmpty($comment->comment_author);
        }
    }

    // 可以根据需要添加更多的测试方法和断言

}
?>
