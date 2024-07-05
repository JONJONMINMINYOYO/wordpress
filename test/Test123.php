<?php
use PHPUnit\Framework\TestCase;  
require_once 'C:\Program Files\Ampps\www\wordpress\wp-load.php';
//require_once 'C:\Program Files\Ampps\www\wordpress\vendor\johnpbloch\wordpress-core\wp-includes\taxonomy.php';
class Test123  extends TestCase {

  protected $comments_list_table;

  protected function setUp(): void {
      parent::setUp();

      // Set up the WordPress environment for testing
      global $wpdb;
      $wpdb->suppress_errors();

      // Load the class we want to test
      require_once ABSPATH . 'wp-admin/includes/class-wp-comments-list-table.php';
      $this->comments_list_table = new WP_Comments_List_Table();
  }

  public function test_table_columns() {
      $columns = $this->comments_list_table->get_columns();
      var_dump($columns);
      $this->assertArrayHasKey('author', $columns);
      $this->assertArrayHasKey('comment', $columns);
      $this->assertArrayHasKey('response', $columns);
      $this->assertArrayHasKey('date', $columns);
      //$this->assertArrayHasKey('comment_sex', $columns);
  }

  public function test_table_sortable_columns() {
      $sortable_columns = $this->comments_list_table->get_sortable_columns();
      
      //$this->assertArrayHasKey('comment', $sortable_columns);
      $this->assertArrayHasKey('author', $sortable_columns);
      $this->assertArrayHasKey('date', $sortable_columns);
      //$this->assertArrayHasKey('comment_sex', $sortable_columns);
  }
}
