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
                            //    const currentContainer = document.getElementById('post-current-page-selector');
                            //     currentContainer.addEventListener('input', function() {
                            //         const currentValue = currentContainer.value;
                            //         console.log(currentValue);
                            //     });

                            document.addEventListener('DOMContentLoaded', function () {                  
                                    selectElement.addEventListener('change', function () {
                                        document.getElementById('postemail-search').value = '';
                                        document.getElementById('keyword-search').value = '';
                                        urlParams.set('post_names_select', selectedValue);
                                    });
                                    
                                    document.addEventListener('keypress', function(event) {
                                        if (event.key === 'Enter') {
                                            var target = event.target;

                                            if (target.classList.contains('current-page')) {
                                               var currentPageValue = currentPageInput.value.trim();
                                            if (currentPageValue !== '') {
                                                var url = 'http://localhost/wordpress/wp-postshow-comments.php?page=' + currentPageValue;
                                                console.log(url);
                                                window.location.href = url;
                                            }
                                            }
                                        }
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
                                            resultContainer.innerHTML = `ユーザーが選択したPost名は :${selectedValue}`;
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
                        <button id="clear-table-btn" type="button" class="initial-button" >クリアする</button>
                        <button type="button" class="homepage-button" onclick="onClickRedirect()">ホームページ</button>
                    </tr>
            </table>
          <?php  
            $limit = 3; 
            $page = isset($_GET['page']) && $_GET['page'] > 0 ? $_GET['page'] : 1; 
            $offset = ($page - 1) * $limit; 

            $post_name_select = isset($_GET['post_names_select']) ? sanitize_text_field($_GET['post_names_select']) : '';
            $search_email = isset($_GET['search_email']) ? sanitize_text_field($_GET['search_email']) : '';
            $search_keyword = isset($_GET['search_keyword']) ? sanitize_text_field($_GET['search_keyword']) : '';
            $sql = "SELECT * FROM {$wpdb->prefix}comments WHERE 1 = 1";

        if ("" !=($post_name_select) && isset($post_name_select)) {
            $sql = $wpdb->prepare(
                "SELECT * FROM {$wpdb->comments} AS c
                LEFT JOIN {$wpdb->posts} AS p ON c.comment_post_ID = p.ID
                WHERE p.post_name = %s and p.post_type = %s
                ORDER BY c.comment_date DESC",
                $post_name_select,
                "post");
        }
        if ("" !=($search_email) && isset($search_email)) {
            $sql .= " AND comment_author_email LIKE '%" . esc_sql($search_email) . "%'";
        }

         if ("" !=($search_keyword) && isset($search_keyword)) {
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
            $sql_count =  $sql;
            var_dump( $sql_count);
            $sql .= " LIMIT $limit OFFSET $offset";

           // $comments_count = $wpdb->get_results($sql);
            $comments = $wpdb->get_results($sql);
            $total_comments = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}comments ");
           //$total_comments = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}comments ");
        
          // $total_comments = $wpdb->get_var( $sql_count);
        //    var_dump( $total_comments)."<br>";
            // var_dump( $comments_count);
            // var_dump( $total_comments);
            $total_pages = ceil($total_comments / $limit);
            
            ?>
                <head>
                    <meta charset="UTF-8">
                    <title>Postに関わるコメント表示</title>
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
                </head>
          <body>
            <h2>POSTに関わるコメント表示</h2>
                <table id="comments-table">
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
                            <div class="postshow_allitems">
                                <span class="comment-count">コメントの総数:</span>
                                <strong><?php echo $total_comments; ?></strong>
                            </div>
                        <div class="pagination-links">
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <a href="?page=<?php echo $i; ?>
                                    <?php echo !empty($search_email) ? '&search_email=' . urlencode($search_email) : ''; ?>
                                    <?php echo !empty($search_keyword) ? '&search_keyword=' . urlencode($search_keyword) : ''; ?>">
                                    <?php echo $i; ?>
                                </a>
                            <?php endfor; ?>
                        </div>
                        <?php
                        
                         //20240620  文章のpost_nameの取得  koui  end
                         
                         global $wp_query;
                         global  $attributes;
                         global  $content;
                         global  $block;
                         
                         $current = (int) get_query_var( 'cpage' ); //現在のPOSTに対応するコメントページの数
                         $post_id = get_the_ID();
                         $per_page = (int) get_option( 'comments_per_page' ); //毎ペースでコメント数
                         $total_items = get_comments_number($post_id);
                 
                       
                         $prev_link2 = render_block_core_comments_pagination_previous( $attributes, $content,$block);

                         $next_link2 = get_next_comments_link( "", $total_pages );

                         $removable_query_args = wp_removable_query_args();
                         
                         $current_url = set_url_scheme( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
                     
                         $current_url = remove_query_arg( $removable_query_args, $current_url );
                    
                         // 使用 basename() 函数获取路径中的文件名部分（不包括查询字符串）
                         $filename = basename($_SERVER['REQUEST_URI']);
                         // 使用 substr() 函数获取省略最后一位的部分
                        $trimmed_uri = substr($filename, 0, -1);
                         // 使用 substr() 函数获取文件名的最后一位字符
                         $last_character = intval(substr($filename, -1));
                       
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
                                     "<span aria-hidden='false' style='font-size: 30px;font-style:italic;color:#65574E' >&laquo;</span>" .
                                 '</a>',
                                 //esc_url( remove_query_arg( 'paged', $trimmed_uri."1" ) ),
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
                                     "<span aria-hidden='false' style='font-size: 30px;font-style:italic;color:#65574E' >&lsaquo;</span>" .
                                 '</a>',
                                 esc_url( add_query_arg( 'paged', max( 1, $current - 1 ), $current_url ) ),
                                 //esc_url( remove_query_arg( 'paged', $trimmed_uri.($last_character-1)) ),
                                 /* translators: Hidden accessibility text. */
                                 __( 'Previous page' ),
                                 //'&lsaquo;'
                             );
                         }
                      
                        //  if ($last_character) {
                        //      $html_current_page  = $last_character;
                        //      $total_pages_before = sprintf(
                        //          '<span class="screen-reader-text">%s</span>' .
                        //          '<span id="table-paging" class="paging-input">' .
                        //          '<span class="tablenav-paging-text">',
                        //          /* translators: Hidden accessibility text. */
                        //          __( '現在のページ番号' )
                        //      );
                        //  } else {
                        //      $html_current_page = sprintf(
                        //          '<label for="post-current-page-selector" class="screen-reader-text">%s</label>' .
                        //          "<input class='current-page' id='post-current-page-selector' type='input'
                        //              name='paged' value='%s' size='%d' aria-describedby='table-paging' />" .
                        //          "<span class='tablenav-paging-text'>",
                        //          /* translators: Hidden accessibility text. */
                        //          __( '現在のページ番号' ),
                        //          $last_character,
                        //          strlen( $total_pages )
                        //      );
                        //  }
                        $current = (get_query_var('paged')) ? get_query_var('paged') : 1;
                        var_dump($current."and".$total_pages);
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
                        var_dump($html_current_page);
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
                                     "<span aria-hidden='false' style='font-size: 30px;font-style:italic;color:#65574E' >&rsaquo;</span>" .
                                 '</a>',
                                 esc_url( add_query_arg( 'paged', min( $total_pages, $current + 1 ), $current_url ) 
                               //esc_url( remove_query_arg( 'paged', $trimmed_uri.($last_character+1) ),
                               ),
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
                                     "<span aria-hidden='false'style='font-size: 30px;font-style:italic;color:#65574E' >&raquo;</span>" .
                                 '</a>',
                                 esc_url( add_query_arg( 'paged', $total_pages, $current_url ) ),
                                 //esc_url( remove_query_arg( 'paged', $trimmed_uri.$total_pages ) ),
                                 /* translators: Hidden accessibility text. */
                                 __( 'Last page' ),
                                 //'&raquo;'
                             );
                         }
                         $pagination_links_class = 'pagination-links';
                         
                         if ( ! empty( $infinite_scroll ) ) {
                             $pagination_links_class .= ' hide-if-js';
                         }
                         $output = "";
                         $output .= "\n<span class='$pagination_links_class'>" . implode( "\n", $page_links ) . '</span>';
                         
                         if ( $total_pages ) {
                             $page_class = $total_pages < 2 ? ' one-page' : '';
                         } else {
                             $page_class = ' no-pages';
                         }
                         $_pagination = "<div class='tablenav-pages{$page_class}'>$output</div>";
                         echo apply_filters( 'comment_form_postpage_area', $_pagination)."</br>";
                        ?>
                    </div>
                 </body>
             </form>