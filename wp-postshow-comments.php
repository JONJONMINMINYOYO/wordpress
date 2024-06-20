<?php
    require_once( dirname( __FILE__ ) . '/wp-load.php' );
    require_once( ABSPATH . 'wp-admin/includes/admin.php' );
    require_once  'wp-admin/includes/class-wp-comments-list-table.php';
    /**
    * @param array    $attributes Block attributes.
    * @param string   $content    Block default content.
    * @param WP_Block $block      Block instance.
    * @global WP_Query $wp_query WordPress Query object.
    */
    global $wp_query;
    global $wpdb;

    $postshow_list = new WP_Comments_List_Table();  
    //20240620  文章のpost_nameの取得  koui  start   
    $query = new WP_Query();
    $postshow_table = new WP_List_Table(); 

    $query_params = array(
        'post_type'      => 'post',
        'posts_per_page' => get_option('posts_per_page'), 
        'paged'          => (get_query_var('paged')) ? get_query_var('paged') : 1,
    );
    $query->query($query_params);
    $posts = $query->posts;
    $post_names = array_column($posts, 'post_title');
    //20240620  文章のpost_nameの取得  koui  end
?>
            <style>
                form {
                    width: 95%; 
                    margin:auto;  
                    padding: 20px; 
                    border: 8px solid #bbb; 
                    box-shadow: 0 0 10px rgba(2, 2, 2, 0.1); 
                }
            </style>
    <form method="get">
     <table>
            <tr class="form-field">
                <th colspan="6" scope="row"><label for="postshow-post_name"><?php _e( 'Post検索エリア' ); ?></label></th>
            </tr>
              <tr>
                <td colspan="2">
                <p class="postname-serach">
                    <label class="postname-serach" for="postname-serach">post_name</label>
                    <select name="postname-serach" id="postname-serach">
                        <option value="">選んでください</option> <!-- 空白のオプションを追加する -->
                        <?php foreach ($post_names as $option) : ?>
                            <option value="<?php echo esc_attr($option); ?>"><?php echo esc_html($option); ?></option>
                        <?php endforeach; ?>
                    </select>
                </p>
                <div id="result"></div>
                <script>
                    const selectElement = document.getElementById('postname-serach');
                    const resultContainer = document.getElementById('result');
                    selectElement.addEventListener('change', function() {
                        const selectedValue = selectElement.value;
                        resultContainer.innerHTML = '';
                            if (selectedValue) {
                                resultContainer.innerHTML = `ユーザーが選択したPost名は：${selectedValue}`;
                            }
                    });
                </script>
                </td>  
                <td colspan="2">
                    <p class="postemail-box">
                        <label for="postemail-search">メール検索：</label>
                        <input type="text" name="search_email" id="postemail-search" value="<?php echo isset($_GET['search_email']) ? htmlspecialchars($_GET['search_email']) : ''; ?>">
                        <input type="submit" value="検索" onclick="clearSearchKeyword();">
                    </p>
                </td>  
                <td colspan="3">
                    <p class="keyword-search">
                        <label for="keyword-search">キーワード検索：</label>
                        <input type="text" name="search_keyword" id="keyword-search" value="<?php echo isset($_GET['search_keyword']) ? htmlspecialchars($_GET['search_keyword']) : ''; ?>">
                        <input type="submit" value="検索" onclick="clearSearchEmail();">
                </p>
                </td>
             </tr>
            <tr>
              <div class="form-actions">
                <button type="button" class="initial-button" onclick="resetForm()">クリアする</button>
                <a href="<?php echo home_url(); ?>" class="button">ホームに移動する</a>
                   <div class="pagination-up">
                    <?php
                              global $wp_query;
                              global  $attributes;
                              global  $content;
                              global  $block;
                              
                              $current = (int) get_query_var( 'cpage' ); //現在のPOSTに対応するコメントページの数
                              $post_id = get_the_ID();
                              $per_page = (int) get_option( 'comments_per_page' ); //毎ペースでコメント数
                              $total_items = get_comments_number($post_id);
                      
                              $total_pages = intval(ceil( $total_items / $per_page ));
                            
                              $prev_link2 = render_block_core_comments_pagination_previous( $attributes, $content,$block);

                              $next_link2 = get_next_comments_link( "", $total_pages );
                              
                              if ( $total_pages > 1 ) {
                              }
                              $output = '<span class="displaying-num">' . sprintf(
                                  _n( '%s item', '%s items', $total_items ),
                                  number_format_i18n( $total_items )
                              ) . '</span></br>';
                              
                              $removable_query_args = wp_removable_query_args();
                              
                              $current_url = set_url_scheme( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
                              //
                              $current_url = remove_query_arg( $removable_query_args, $current_url );
                              
                              $page_links = array();
                              
                              $total_pages_before = '<span class="postshow-paging-input">';
                              $total_pages_after  = '</span></span>';
                              
                              $disable_first = false;
                              $disable_last  = false;
                              $disable_prev  = false;
                              $disable_next  = false;
                              
                              if ( 1 == $current ) {
                                  $disable_first = true;
                                  $disable_prev  = true;
                              }
                              if ( $total_pages == $current ) {
                                  $disable_last = true;
                                  $disable_next = true;
                              }
                              
                              if ( $disable_first ) {
                                  $page_links[] = '<span class="postshow button disabled" aria-hidden="true">&laquo;</span>';
                              } else {
                                  $page_links[] = sprintf(
                                      "<a class='first-page button' href='%s'>" .
                                          "<span class='screen-reader-text'>%s</span>" .
                                          "<span aria-hidden='true' style='font-size: 30px;font-style:italic;color:#65574E' >&laquo;</span>" .
                                      '</a>',
                                      esc_url( remove_query_arg( 'paged', $current_url ) ),
                                      /* translators: Hidden accessibility text. */
                                      __( 'First page' ),
                                      //'&laquo;'
                                  );               
                              }
                              
                              if ( $disable_prev ) {
                                  $page_links[] = '<span class="postshow button disabled" aria-hidden="true">&lsaquo;</span>';
                              } else {
                                  //$current_url = $prev_link;
                                  $page_links[] = sprintf(
                                      "<a class='prev-page button' href='%s'>" .
                                          "<span class='screen-reader-text'>%s</span>" .
                                          "<span aria-hidden='true' style='font-size: 30px;font-style:italic;color:#65574E' >&lsaquo;</span>" .
                                      '</a>',
                                      esc_url( add_query_arg( 'paged', max( 1, $current - 1 ), $current_url ) ),
                                      /* translators: Hidden accessibility text. */
                                      __( 'Previous page' ),
                                      //'&lsaquo;'
                                  );
                              }
                           
                              if ($current) {
                                  $html_current_page  = $current;
                                  $total_pages_before = sprintf(
                                      '<span class="screen-reader-text">%s</span>' .
                                      '<span id="table-paging" class="paging-input">' .
                                      '<span class="tablenav-paging-text">',
                                      /* translators: Hidden accessibility text. */
                                      __( '現在のページ番号' )
                                  );
                              } else {
                                  $html_current_page = sprintf(
                                      '<label for="post-current-page-selector" class="screen-reader-text">%s</label>' .
                                      "<input class='current-page' id='post-current-page-selector' type='text'
                                          name='paged' value='%s' size='%d' aria-describedby='table-paging' />" .
                                      "<span class='tablenav-paging-text'>",
                                      /* translators: Hidden accessibility text. */
                                      __( '現在のページ番号' ),
                                      $current,
                                      strlen( $total_pages )
                                  );
                              }
                              
                              $html_total_pages = sprintf( "<span class='post-total-pages'>%s</span>", number_format_i18n( $total_pages ) );
                              
                              $page_links[] = $total_pages_before . sprintf(
                                  /* translators: 1: Current page, 2: Total pages. */
                                  _x( '%1$s of %2$s', 'paging' ),
                                  $html_current_page,
                                  $html_total_pages
                              ) . $total_pages_after;
                              
                              if ( $disable_next ) {
                                  $page_links[] = '<span class="postshow button disabled" aria-hidden="true">&rsaquo;</span>';
                              } 
                              else {
              
                                  $page_links[] = sprintf(
                                      "<a class='next-page button' href='%s'>" .
                                          "<span class='screen-reader-text'>%s</span>" .
                                          "<span aria-hidden='true' style='font-size: 30px;font-style:italic;color:#65574E' >&rsaquo;</span>" .
                                      '</a>',
                                      esc_url( add_query_arg( 'paged', min( $total_pages, $current + 1 ), $current_url ) ),
                                      //esc_url($next_link2),
                                      /* translators: Hidden accessibility text. */
                                      __( 'Next page' ),
                                      //'&rsaquo;'
                                  );
                              }
                          
                              if ( $disable_last ) {
                                  $page_links[] = '<span class="postshow button disabled" aria-hidden="true">&raquo;</span>';
                              } else {
                                  $page_links[] = sprintf(
                                      "<a class='last-page button' href='%s'>" .
                                          "<span class='screen-reader-text'>%s</span>" .
                                          "<span aria-hidden='true'style='font-size: 30px;font-style:italic;color:#65574E' >&raquo;</span>" .
                                      '</a>',
                                      esc_url( add_query_arg( 'paged', $total_pages, $current_url ) ),
                                      /* translators: Hidden accessibility text. */
                                      __( 'Last page' ),
                                      //'&raquo;'
                                  );
                              }
                              $pagination_links_class = 'pagination-links';
                              
                              if ( ! empty( $infinite_scroll ) ) {
                                  $pagination_links_class .= ' hide-if-js';
                              }
                              
                              $output .= "\n<span class='$pagination_links_class'>" . implode( "\n", $page_links ) . '</span>';
                              
                              if ( $total_pages ) {
                                  $page_class = $total_pages < 2 ? ' one-page' : '';
                              } else {
                                  $page_class = ' no-pages';
                              }
                              $_pagination = "<div class='tablenav-pages{$page_class}'>$output</div>";
                              echo apply_filters( 'comment_form_postpage_area', $_pagination, $args )."</br>";
                         ?>
                     </div>
                    </tr>
                </table>
        </form>
    <?php
             var_dump($option);
            $limit = 10; 
            $page = isset($_GET['page']) && $_GET['page'] > 0 ? $_GET['page'] : 1; 
            $offset = ($page - 1) * $limit; 

            $search_email = isset($_GET['search_email']) ? sanitize_text_field($_GET['search_email']) : '';
            $search_keyword = isset($_GET['search_keyword']) ? sanitize_text_field($_GET['search_keyword']) : '';

            $sql = "SELECT * FROM {$wpdb->prefix}comments WHERE 1 = 1";

        if (!empty($search_email)) {
            $sql .= " AND comment_author_email LIKE '%" . esc_sql($search_email) . "%'";
        }

         if (!empty($search_keyword)) {
                $escaped_keyword = esc_sql($search_keyword);
                $sql .= " AND (";
                $sql .= " comment_ID LIKE '%$escaped_keyword%' OR";
                $sql .= " comment_post_ID LIKE '%$escaped_keyword%' OR";
                $sql .= " comment_author LIKE '%$escaped_keyword%' OR";
                $sql .= " comment_author_email LIKE '%$escaped_keyword%' OR";
                $sql .= " comment_author_url LIKE '%$escaped_keyword%' OR";
                $sql .= " comment_author_IP LIKE '%$escaped_keyword%' OR";
                $sql .= " comment_content LIKE '%$escaped_keyword%' OR";
                $sql .= " comment_approved LIKE '%$escaped_keyword%' OR";
                $sql .= " comment_type LIKE '%$escaped_keyword%' OR";
                $sql .= " comment_parent LIKE '%$escaped_keyword%' OR";
                $sql .= " user_id LIKE '%$escaped_keyword%' OR";
                $sql .= " comment_author_tel LIKE '%$escaped_keyword%' OR";
                $sql .= " comment_sex LIKE '%$escaped_keyword%'";
                $sql .= ")";
            }

   
            $sql .= " LIMIT $limit OFFSET $offset";

            $comments = $wpdb->get_results($sql);

            $total_comments = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}comments WHERE 1 = 1");

            $total_pages = ceil($total_comments / $limit);
            ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Postに関わるコメント表示</title>
            <style>
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                }
                table, th, td {
                    border: 1px solid #ccc;
                    padding: 8px;
                    text-align: left;
                }
                th {
                    background-color: #f2f2f2;
                }
                .pagination {
                    margin-top: 10px;
                }
                .pagination a {
                    display: inline-block;
                    padding: 5px 10px;
                    text-decoration: none;
                    color: black;
                    border: 1px solid #ccc;
                    margin-right: 5px;
                }
                .pagination a:hover {
                    background-color: #65574E;
                    color: white;
                }
            </style>
        </head>
        <body>
            <h2>POSTに関わるコメント表示</h2>
            <table>
            <script>
                function clearSearchKeyword() {
                    document.getElementById('keyword-search').value = '';
                }
                function clearSearchEmail() {
                    document.getElementById('postemail-search').value = '';
                }
            </script>
            <thead>
                <tr>
                <th>番号</th>
                    <th>ID</th>
                    <th>post_ID</th>
                    <th>作者</th>
                    <th>メール</th>
                    <th>URL</th>
                    <th>IP</th>
                    <!-- <th>comment_date</th>
                    <th>comment_date_gmt</th> -->
                    <th>コンテンツ</th>
                    <!-- <th>comment_karma</th> -->
                    <th>承認状態</th>
                    <!-- <th>comment_agent</th> -->
                    <th>タイプ</th>
                    <th>親コメント</th>
                    <th>ユーザーID</th>
                    <th>電話番号</th>
                    <th>性別</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($comments as $index => $comment): ?>
                    <tr>
                        <td><?php echo (($page - 1) * $limit + $index + 1); ?></td>
                        <td><?php echo $comment->comment_ID; ?></td>
                        <td><?php echo $comment->comment_post_ID; ?></td>
                        <td><?php echo $comment->comment_author; ?></td>
                        <td><?php echo $comment->comment_author_email; ?></td>
                        <td><?php echo $comment->comment_author_url; ?></td>
                        <td><?php echo $comment->comment_author_IP; ?></td>
                        <td><?php echo $comment->comment_content; ?></td>
                        <td><?php echo $comment->comment_approved; ?></td>
                        <td><?php echo $comment->comment_type; ?></td>
                        <td><?php echo $comment->comment_parent; ?></td>
                        <td><?php echo $comment->user_id; ?></td>
                        <td><?php echo $comment->comment_author_tel; ?></td>
                        <td><?php echo ($comment->comment_sex == 1 ? "男性" : "女性"); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?php echo $i; ?>
                    <?php echo !empty($search_email) ? '&search_email=' . urlencode($search_email) : ''; ?>
                    <?php echo !empty($search_keyword) ? '&search_keyword=' . urlencode($search_keyword) : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>

    </body>
    </html>

        </html>
        <?php 
$post_ids = array();
foreach ( $posts as $p ) {
  // 投稿IDの配列を作成
  $post_ids[] = $p->ID; 
}
// 現在の記事IDが何番目か取得
$current = array_search($post->ID, $post_ids);
$currentID = $post_ids[$current]; // 現在の記事ID
$prevID = $post_ids[$current - 1]; // 前の記事ID
$nextID = $post_ids[$current + 1]; // 次の記事ID
?>      
<?php wp_reset_postdata(); ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Postに関わるコメント表示xxxxxx</title>
</head>
<body>
<?php body_class(); ?>
<?php get_header(); ?>
<nav class="navigation post-navigation" aria-label="投稿">
  <h2 class="screen-reader-text">投稿ナビゲーション</h2>
  <div class="nav-links">
    <div class="nav-previous">
      <a href="前の記事のリンク" rel="prev">前の記事タイトル</a>
      <a href="<?php echo esc_url(home_url('/')); ?>">本ページ</a>
      <a href="<?php echo esc_url(postshow_url('/')); ?>">postshow_url</a>
    </div>
    <div class="nav-next">
      <a href="次の記事のリンク" rel="next">次の記事タイトル</a>
    </div>
  </div>
</nav>



