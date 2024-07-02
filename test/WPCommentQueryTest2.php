<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\DbUnit\Database\DefaultConnection;
use PHPUnit\DbUnit\DataSet\CsvDataSet;
require_once 'C:\Program Files\Ampps\www\wordpress\wp-load.php';
class WPCommentQueryTest2 extends TestCase {
    protected function getConnection() {
        global $wpdb;

        $pdo = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
            DB_USER,
            DB_PASSWORD
        );
        return new DefaultConnection($pdo, 'wp_'); 
        //return true; 
    }


    protected function getDataSet() {
        return true; 
    }

    // 测试查询评论数据
    public function testFetchComments() {
        global $wpdb;

        $comments = $wpdb->get_results(
            "SELECT * FROM {$wpdb->comments}"
        );

        $this->assertNotEmpty($comments);

        var_dump($comments);

        foreach ($comments as $comment) {
           
            $this->assertNotEmpty($comment->comment_author);
        }
    }


}
