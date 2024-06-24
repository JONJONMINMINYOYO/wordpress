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
?>
    <form method="get">
     <table>
                <tr class="form-field">
                    <th colspan="6" scope="row"><label for="postshow-post_name"><?php _e( 'Post検索エリア' ); ?></label></th>
                </tr>
                  <tr>
                    <td colspan="2">
                    <p class="post_names_select">
                        <label class="post_names_select" for="post_names_select">post_name</label>
                        <select name="post_names_select" id="post_names_select">
                            <option value="">選んでください</option> <!-- 空白のオプションを追加する -->
                            <?php foreach ($post_names as $option) : ?>
                                <option value="<?php echo esc_attr($option); ?>"><?php echo esc_html($option); ?></option>   
                            <?php endforeach; ?>
                        </select>
                        <input type="submit" value="送信する" onclick="keep_postname();">
                    </p>
                    <div id="result"></div>
                            <script>    
                                 function clearall() {
                                    var commentsShowRow = document.getElementsByClassName('comments-show');
                                          for (var i = 0; i < commentsShowRows.length; i++) {
                                            var cells = commentsShowRows[i].getElementsByClassName('comment-cell');
                                            for (var j = 0; j < cells.length; j++) {
                                                cells[j].innerHTML = ''; 
                                            }
                                        }
                                 }  
                                document.addEventListener('DOMContentLoaded', function () {                  
                                    selectElement.addEventListener('change', function () {
                                        document.getElementById('postemail-search').value = '';
                                        document.getElementById('keyword-search').value = '';
                                        urlParams.set('post_names_select', selectedValue);
                                    });
                                });

                                function onClickRedirect() {
                                    window.location.href = '<?php echo home_url(); ?>';
                                }

                                const selectElement = document.getElementById('post_names_select');
                                const resultContainer = document.getElementById('result');
                                selectElement.addEventListener('change', function() {
                                    const selectedValue = selectElement.value;
                                    resultContainer.innerHTML = '';
                                        if (selectedValue) {
                                            resultContainer.innerHTML = `ユーザーが選択したPost名は：${selectedValue}`;
                                        }
                                });
                                function clearSearchKeyword() {
                                    document.getElementById('keyword-search').value = '';
                                }
                                function clearSearchEmail() {
                                    document.getElementById('postemail-search').value = '';
                                }
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
                        <button type="button" class="initial-button" onclick="clearall()">クリアする</button>
                        <button type="button" class="homepage-button" onclick="onClickRedirect()">ホームページ</button>
                    </tr>
            </table>
          <?php  
            $post_name_select = isset($_GET['post_names_select']) ? sanitize_text_field($_GET['post_names_select']) : '';
            $search_email = isset($_GET['search_email']) ? sanitize_text_field($_GET['search_email']) : '';
            $search_keyword = isset($_GET['search_keyword']) ? sanitize_text_field($_GET['search_keyword']) : '';
            $current_page = isset($_GET['page']) ? absint($_GET['page']) : 1;
               var_dump($current_page);                     
        if ("" != ($post_name_select)) {
            $sql_post_name = $wpdb->prepare("
                SELECT c.*
                FROM {$wpdb->prefix}comments AS c
                INNER JOIN {$wpdb->prefix}posts AS p ON c.comment_post_ID = p.ID
                WHERE p.post_name = %s
            ", $_GET['post_names_select']);
            $serach_total_comments = $wpdb->get_var($sql_post_name);
        }
        if ("" != ($search_email)) {
            $sql = "SELECT * FROM {$wpdb->prefix}comments ";
            $sql .= " where comment_author_email LIKE '%" . esc_sql($search_email) . "%'";
            $sql_email = $sql;
            $serach_total_comments = $wpdb->get_var($sql_email);
        }

         if ("" != ($search_keyword)) {
             $sql = "SELECT * FROM {$wpdb->prefix}comments ";
                $escaped_keyword = esc_sql($search_keyword);
                $sql .= " where (";
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
                $sql_keyword = $sql;
                //$serach_total_comments = $wpdb->get_var($sql_keyword);
            }
            $limit = 10;
            // $page = isset($_GET['page']) && $_GET['page'] > 0 ? $_GET['page'] : 1; 
            // var_dump( $page );
            $total_pages = ceil($serach_total_comments / $limit);
           

            $offset = ($total_pages - 1) * $limit; 
            $sql_all = $sql ;
            
            $sql.= " LIMIT $limit OFFSET $offset";
         
            $comments = $wpdb->get_results($sql);
           
            $total_comments = $wpdb->get_var($sql_all);
            
           // $total_comments = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}comments WHERE 1 = 1");
   
            ?>                             
                <head>
                    <meta charset="UTF-8">
                    <title>Postに関わるコメント表示</title>
                </head>
          <body>
            <h2>POSTに関わるコメント表示</h2>
            <style>
                         form {
                            width: 95%; 
                            margin:auto;  
                            padding: 20px; 
                            border: 8px solid #bbb; 
                            box-shadow: 0 0 10px rgba(2, 2, 2, 0.1); 
                        }
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
                        .postshow_allitems {
                            background-color: #f2f2f2;
                            padding: 10px;
                            margin-bottom: 10px;
                            border: 2px solid #aaa;
                            display: flex;
                            align-items: center;
                        }
                        .comment-count {
                            margin-right: 20px;
                        }
                        .postshow_allitems strong {
                            font-weight: bold;
                            color: #666;
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
                <table>
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
                            <?php 
                            foreach ($comments as $index => $comment): ?>
                                <tr class="comments-show">
                                    <td class="comment-cell"><?php echo (($page - 1) * $limit + $index + 1); ?></td>
                                    <td class="comment-cell"><?php echo $comment->comment_ID; ?></td>
                                    <td class="comment-cell"><?php echo $comment->comment_post_ID; ?></td>
                                    <td class="comment-cell"><?php echo $comment->comment_author; ?></td>
                                    <td class="comment-cell"><?php echo $comment->comment_author_email; ?></td>
                                    <td class="comment-cell"><?php echo $comment->comment_author_url; ?></td>
                                    <td class="comment-cell"><?php echo $comment->comment_author_IP; ?></td>
                                    <td class="comment-cell"><?php echo $comment->comment_content; ?></td>
                                    <td class="comment-cell"><?php echo $comment->comment_approved; ?></td>
                                    <td class="comment-cell"><?php echo $comment->comment_type; ?></td>
                                    <td class="comment-cell"><?php echo $comment->comment_parent; ?></td>
                                    <td class="comment-cell"><?php echo $comment->user_id; ?></td>
                                    <td class="comment-cell"><?php echo $comment->comment_author_tel; ?></td>
                                    <td class="comment-cell"><?php echo ($comment->comment_sex == 1 ? "男性" : "女性"); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                </table>
                    <div class="pagination">
                            <div class="postshow_allitems">
                                <span class="comment-count">コメントの総数:</span>
                                <strong><?php echo $total_comments; ?></strong>
                            </div>
                        <div class="pagination-pages-links">
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <a href="?page=<?php echo $i; ?>
                                    <?php echo !empty($search_email) ? '&search_email=' . urlencode($search_email) : ''; ?>
                                    <?php echo !empty($search_keyword) ? '&search_keyword=' . urlencode($search_keyword) : ''; ?>">
                                    <?php echo $i; ?>
                                </a>
                            <?php endfor; ?>
                        </div>
                       
                    </div>
                 </body>
             </form>
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



