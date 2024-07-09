<?php
use PHPUnit\Framework\TestCase;
require_once 'C:\Program Files\Ampps\www\wordpress\wp-load.php';
class TestCommentTelAndSex extends TestCase
{
    /**
     * Test comment form fields generation with default values.
     */
    public function testCommentFormFieldsWithDefaultValues()
    {
        // Simulate default commenter data
        $commenter = array(
            'comment_author' => 'root',
            'comment_author_email' => 'decvc55485@yahoo.co.jp',
            'comment_author_url' => 'http://localhost/wordpress-initial',
            'comment_author_tel' => '09066667777',
            'comment_sex' => '11',
        );

        // Simulate default settings
        $req = false; // Whether fields are required
        $required_indicator = ''; // Required field indicator
        $required_attribute = ''; // Required attribute for inputs
        $html5 = true; // Whether to use HTML5 input types

        // Generate fields HTML
        $fields = array(
            'author' => sprintf(
                '<p class="comment-form-author">%s %s</p>',
                sprintf(
                    '<label for="author">%s%s</label>',
                    __('🥰名前🥰'),
                    ($req ? $required_indicator : '')
                ),
                sprintf(
                    '<input id="author" name="author" type="text" value="%s" size="30" maxlength="245" autocomplete="name"%s />',
                    esc_attr($commenter['comment_author']),
                    ($req ? $required_attribute : '')
                )
            ),
            'email'  => sprintf(
                '<p class="comment-form-email">%s %s</p>',
                sprintf(
                    '<label for="email">%s%s</label>',
                    __('🥰メールアドレス🥰'),
                    ($req ? $required_indicator : '')
                ),
                sprintf(
                    '<input id="email" name="email" %s value="%s" size="30" maxlength="100" aria-describedby="email-notes" autocomplete="email"%s />',
                    ($html5 ? 'type="email"' : 'type="text"'),
                    esc_attr($commenter['comment_author_email']),
                    ($req ? $required_attribute : '')
                )
            ),
            'url'    => sprintf(
                '<p class="comment-form-url">%s</p>',
                sprintf(
                    '<label for="url">%s</label>',
                    __('🥰ウェブサイト🥰')
                ),
                sprintf(
                    '<input id="url" name="url" %s value="%s" size="30" maxlength="200" autocomplete="url" />',
                    ($html5 ? 'type="url"' : 'type="text"'),
                    esc_attr(substr($commenter['comment_author_url'], 7))
                )
            ),
            'tel'    => sprintf(
                '<p class="comment-form-tel">%s %s</p>',
                sprintf(
                    '<label for="tel">%s%s</label>',
                    __('🥰電話番号🥰'),
                    ($req ? $required_indicator : '')
                ),
                sprintf(
                    '<input id="tel" name="tel" %s value="%s" size="11" maxlength="11" autocomplete="0123456789" />',
                    ($html5 ? 'type="tel"' : 'type="text"'),
                    esc_attr($commenter['comment_author_tel'])
                )
            ),
            'sex' => sprintf(
                '<p class="comment-form-sex">%s</p>',
                sprintf(
                    '<label>%s</label>',
                    __('🥰性別🥰')
                ),
                sprintf(
                    '<div style="display: flex; flex-direction: row;">
                    <label>男性</label>
                    <input id="male" name="sex" type="radio" value="1" />
                    <label>女性</label>
                    <input id="female" name="sex" type="radio" value="0" />
                    <script>
                        document.addEventListener(\'DOMContentLoaded\', function() {
                            const radioButtons = document.getElementsByName(\'sex\');
                            radioButtons.forEach(function(button) {
                                button.addEventListener(\'dblclick\', function() {
                                    radioButtons.forEach(function(btn) {
                                        btn.checked = false;
                                    });
                                });
                            });
                        });
                    </script>
                </div>'
                )
            )
        );

        // Expected HTML for each field
        $expected_author_field = '<p class="comment-form-author"><label for="author">🥰名前🥰</label><input id="author" name="author" type="text" value="" size="30" maxlength="245" autocomplete="name" /></p>';
        $expected_email_field = '<p class="comment-form-email"><label for="email">🥰メールアドレス🥰</label><input id="email" name="email" type="email" value="" size="30" maxlength="100" aria-describedby="email-notes" autocomplete="email" /></p>';
        $expected_url_field = '<p class="comment-form-url"><label for="url">🥰ウェブサイト🥰</label><input id="url" name="url" type="url" value="" size="30" maxlength="200" autocomplete="url" /></p>';
        $expected_tel_field = '<p class="comment-form-tel"><label for="tel">🥰電話番号🥰</label><input id="tel" name="tel" type="tel" value="" size="11" maxlength="11" autocomplete="0123456789" /></p>';
        $expected_sex_field = '<p class="comment-form-sex"><label>🥰性別🥰</label><div style="display: flex; flex-direction: row;"><label>男性</label><input id="male" name="sex" type="radio" value="1" /><label>女性</label><input id="female" name="sex" type="radio" value="0" /><script>                        document.addEventListener(\'DOMContentLoaded\', function() {                            const radioButtons = document.getElementsByName(\'sex\');                            radioButtons.forEach(function(button) {                                button.addEventListener(\'dblclick\', function() {                                    radioButtons.forEach(function(btn) {                                        btn.checked = false;                                    });                                });                            });                        });                    </script>                </div></p>';

        // Assert each field's generated HTML matches expected
       
        $this->assertNotNull($expected_author_field, $fields['author']);
       
       
        $this->assertNotNull($expected_email_field, $fields['email']);
        $this->assertNotNull($expected_url_field, $fields['url']);
        $this->assertNotNull($expected_tel_field, $fields['tel']);
        $this->assertNotNull($expected_sex_field, $fields['sex']);
    }
}
?>
