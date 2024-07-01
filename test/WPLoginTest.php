<?php
use PHPUnit\Framework\TestCase;

class WPLoginTest extends TestCase
{
    public function testValidLogin()
    {
        // 模拟有效的用户名和密码
        $_POST['log'] = 'valid_username';
        $_POST['pwd'] = 'valid_password';

        // 包含 wp-load.php 文件来初始化 WordPress 环境
        require_once 'C:\Program Files\Ampps\www\wordpress\wp-load.php';

        // 登录
        $user = wp_signon();

        // 验证是否能成功登录
        $this->assertInstanceOf('WP_User', $user);
    }

    // public function testInvalidLogin()
    // {
    //     // 模拟无效的用户名和密码
    //     $_POST['log'] = 'invalid_username';
    //     $_POST['pwd'] = 'invalid_password';

    //     // 包含 wp-load.php 文件来初始化 WordPress 环境
    //     require_once 'C:\Program Files\Ampps\www\wordpress\wp-load.php';

    //     // 登录
    //     $user = wp_signon();

    //     // 验证登录是否失败
    //     $this->assertInstanceOf('WP_Error', $user);
    //     $this->assertContains('Invalid username or password.', $user->get_error_message());
    // }

    public function testLogout()
    {
        // 包含 wp-load.php 文件来初始化 WordPress 环境
        require_once 'C:\Program Files\Ampps\www\wordpress\wp-load.php';

        // 模拟已登录的用户
        wp_set_current_user(1);

        // 登出
        wp_logout();

        // 验证是否能成功登出
        $this->assertFalse(is_user_logged_in());
    }
    
}
