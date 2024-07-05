<?php
use PHPUnit\Framework\TestCase;  
require_once 'C:\Program Files\Ampps\www\wordpress\wp-load.php';

class TestCommentsInsertAndCheck  extends TestCase {

  // A method that runs before each test
  public function setUp(): void {
    parent::setUp();
    // Additional setup code here, if needed
}

// A method that runs after each test
public function tearDown(): void {
    // Clean up after the test
    parent::tearDown();
}

// Test inserting a comment
public function test_insert_comment() {
    // Insert a comment into the database
    $comment_id = wp_insert_comment([
        'comment_post_ID' => 36,
        'comment_author' => 'test0705',
        'comment_author_email' => 'test0705@example.com',
        'comment_author_url' => 'test0705@example.com',
        'comment_content' => 'This is a test comment12321332',
        'comment_type' => '',
        'comment_parent' => 0,
        'user_id' => 1,
        'comment_sex' => 1,
        'comment_author_tel' => '01234567891',
    ]);

    // Check if the comment was inserted
    $this->assertIsInt($comment_id);
    $this->assertGreaterThan(0, $comment_id);

    // Retrieve the comment from the database
    $comment = get_comment($comment_id);

    // Assert the comment fields
    $this->assertEquals('test0705', $comment->comment_author);
    $this->assertEquals('test0705@example.com', $comment->comment_author_email);
    $this->assertEquals('test0705@example.com', $comment->comment_author_url);
    $this->assertEquals('This is a test comment12321332', $comment->comment_content);
    $this->assertEquals('1', $comment->comment_sex);
    $this->assertEquals('01234567891', $comment->comment_author_tel);
}

// Test retrieving comments
// public function test_get_comments() {
//     // Insert a few comments
//     $comment_id1 = wp_insert_comment([
//         'comment_post_ID' => 1,
//         'comment_author' => 'Alice',
//         'comment_author_email' => 'alice@example.com',
//         'comment_content' => 'This is Alice\'s comment',
//     ]);

//     $comment_id2 = wp_insert_comment([
//         'comment_post_ID' => 1,
//         'comment_author' => 'Bob',
//         'comment_author_email' => 'bob@example.com',
//         'comment_content' => 'This is Bob\'s comment',
//     ]);

//     // Retrieve comments for the post
//     $comments = get_comments([
//         'post_id' => 1,
//     ]);

//     // Assert we have the correct number of comments
//    // $this->assertCount(4, $comments);

//     // Assert the content of each comment
//     $this->assertEquals('Alice', $comments[0]->comment_author);
//     $this->assertEquals('This is Alice\'s comment', $comments[0]->comment_content);
//     $this->assertEquals('Bob', $comments[1]->comment_author);
//     $this->assertEquals('This is Bob\'s comment', $comments[1]->comment_content);
// }

// Test updating a comment
public function test_update_comment() {
    // Insert a comment
    $comment_id = wp_insert_comment([
        'comment_post_ID' => 36,
        'comment_author' => 'Charlie',
        'comment_author_email' => 'charlie@example.com',
        'comment_content' => 'Original comment',
    ]);

    // Update the comment
    wp_update_comment([
        'comment_ID' => $comment_id,
        'comment_content' => 'Updated comment',
    ]);

    // Retrieve the updated comment
    $comment = get_comment($comment_id);

    // Assert the comment was updated
    $this->assertEquals('Updated comment', $comment->comment_content);
}

// Test deleting a comment
public function test_delete_comment() {
    // Insert a comment
    $comment_id = wp_insert_comment([
        'comment_post_ID' => 36,
        'comment_author' => 'Charlie',
        'comment_author_email' => 'charlie@example.com',
        'comment_content' => 'Original comment',
    ]);

    // Delete the comment
    wp_delete_comment($comment_id, true);

    // Assert the comment was deleted
    $comment = get_comment($comment_id);

    $this->assertNull($comment);
}
}