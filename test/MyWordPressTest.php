<?php
use PHPUnit\Framework\TestCase;

class MyWordPressTest extends TestCase
{
    // 测试 WordPress 用户登录功能
    public function testUserLogin()
    {
        $_POST['user'] = 'root';
        $_POST['pwd'] = 'asd123';

        require_once 'C:\Program Files\Ampps\www\wordpress\wp-load.php';

        $user = wp_signon();

        $this->assertInstanceOf('WP_User', $user);
        $this->assertnotTrue(is_user_logged_in());
    }

    public function testPostCreation()
    {
        require_once 'C:\Program Files\Ampps\www\wordpress\wp-load.php';

        $post_id = wp_insert_post(array(
            'post_title' => 'Test Post For Phpunit',
            'post_content' => 'This is a test post content For Phpunit.',
            'post_status' => 'publish For Phpunit',
            'post_author' => 1,  
        ));

        $this->assertGreaterThan(0, $post_id);
    }

}
?>