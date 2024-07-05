<?php
use PHPUnit\Framework\TestCase;
require_once 'C:\Program Files\Ampps\www\wordpress\wp-load.php';
class SomePostClass extends TestCase
{
    public $testPostId;

    protected function setUp(): void
    {
        $this->testPostId = wp_insert_post([
            'post_title' => 'Sample Post',
            'post_content' => 'This is just some sample post content 0703.'
        ]);
    }
    protected function tearDown(): void
    {
        wp_delete_post($this->testPostId, true);
    }

    //... tests will go here.
    // protected function test123(): void
    // {
    //     $this->assertNotEmpty($testPostId);
    // }
}