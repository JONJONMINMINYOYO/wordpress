<?php
use PHPUnit\Framework\TestCase;

require_once 'C:\Program Files\Ampps\www\wordpress\wp-load.php';
class GetCommentSexTest1 extends TestCase
{
    public function testWPQueryWithDefaultArgs()
    {

        $query = new WP_Query();

        $this->assertInstanceOf(WP_Query::class, $query);
     
        $this->assertEmpty($query->posts);
    }

    public function testWPQueryWithCustomArgs()
    {
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => 3,
            'orderby' => 'date',
            'order' => 'DESC',
            'post_author' => '1',
            'post_title' => '11-11',
        );

        $query = new WP_Query($args);

        $this->assertInstanceOf(WP_Query::class, $query);

        $this->assertNotEmpty( $query->posts);
        $this->assertEquals('post', $query->query_vars['post_type']);
        $this->assertEquals('DESC', $query->query_vars['order']);
        $this->assertEquals('date', $query->query_vars['orderby']);
        $this->assertEquals('11-11', $query->query_vars['post_title']);
        $this->assertEquals('3', $query->query_vars['posts_per_page']);
    }


}
?>
