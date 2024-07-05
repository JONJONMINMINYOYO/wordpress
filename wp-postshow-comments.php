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
        $postshow_initial_url = set_url_scheme( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
        if( $postshow_initial_url =='http://localhost/wordpress/wp-postshow-comments.php') { 
        $target_url ="http://localhost/wordpress/wp-postshow-comments.php?post_id_select=&search_email=&search_keyword=&paged=1" ;
                wp_redirect($target_url);
                exit;
            }
        global $wp_query;
        global $wpdb;

        $postshow_list = new WP_Comments_List_Table();  
        //20240620  文章のpost_nameの取得  koui  start   
        $query = new WP_Query();
        $postshow_table = new WP_List_Table(); 
        $paged = get_query_var('paged');
            $query_params = array(
                'post_type'      => 'post',
                'posts_per_page' => get_option('posts_per_page'), 
                'paged'          => (get_query_var('paged')) ? get_query_var('paged') : 1,
            );
        $query->query($query_params);
        $posts = $query->posts;
        $post_ids = array_column($posts, 'ID');
        $post_names = array_column($posts, 'post_title');
        $combined_array = array_combine($post_ids, $post_names);
    ?>
    <form method="get">
     <table>
                <tr class="form-field">
                    <th colspan="8" scope="row"><label for="postshow-post_name"><?php _e( 'Post検索エリア' ); ?></label></th>
                </tr>
                    <td colspan="2">
                        <p class="post_id_select">
                            <label class="post_id_select" for="post_id_select">post_ID</label>
                            <select name="post_id_select" id="post_id_select">
                            <option value="">選んでください</option> <!-- 空白のオプションを追加する --> 
                                <?php foreach ($post_ids as $post_option) : ?>
                                    <option value="<?php echo esc_attr($post_option); ?>"><?php echo esc_html($post_option); 
                                    if(!isset($_GET['post_id_select']) ) { 
                                        $_GET['post_id_select'] = $post_option;   
                                }
                                    ?></option>   
                                <?php endforeach; ?>
                            </select>
                            <div id="result"></div>
                            <?php
                                if (!empty($combined_array)) {
                                    echo '<div class="post_name_select" style="width: 300px; overflow: hidden; text-overflow: ellipsis;">';
                                    foreach ($combined_array as $post_id => $post_name) {
                                        if ($post_id == $_GET['post_id_select']) {
                                            echo "post_ID:$post_id の該当Post_nameは: $post_name";
                                        }
                                    }
                                    echo '</div>';
                                }
                                ?>
                            <input type="submit" value="送信する" onclick="keep_postname();">
                        </p>
                    </td>
                           <script>
                            document.addEventListener('DOMContentLoaded', function () {                  
                                    selectElement.addEventListener('change', function () {
                                        document.getElementById('postemail-search').value = '';
                                        document.getElementById('keyword-search').value = '';
                                        urlParams.set('post_id_select', selectedValue);
                                    });
                                });

                                function onClickRedirect() {
                                    window.location.href = '<?php echo home_url(); ?>';
                                }   
                                
                                function search_clear() {
                                    document.getElementById('keyword-search').value = '';
                                    document.getElementById('postemail-search').value = '';
                                } 

                                const selectElement = document.getElementById('post_id_select');
                                const resultContainer = document.getElementById('result');
                                selectElement.addEventListener('change', function() {
                                    const selectedValue = selectElement.value;
                                    resultContainer.innerHTML = '';
                                        if (selectedValue) {
                                            resultContainer.innerHTML = `選択したPostのIDは :${selectedValue}`;
                                        }
                                });
                                function clearSearchKeyword() {
                                    <?php
                                    if(isset($_GET['post_id_select'])) {
                                   
                                    }
                                    ?>
                                    document.getElementById('keyword-search').value = '';
                                    var Email_Input = document.getElementById('postemail-search');
                                    var Email_Length = Email_Input.value.length;
                                    if(Email_Length <= 0){
                                            event.preventDefault();
                                            alert('メールが空白です、もう一度入力してください。');
                                        }
                                }

                                function clearSearchEmail() {
                                    document.getElementById('postemail-search').value = '';
                                    var Keyword_Input = document.getElementById('keyword-search');
                                    var Keyword_Length = Keyword_Input.value.length;
                                    if(Keyword_Length <= 0){
                                            event.preventDefault();
                                            alert('キーワードが空白です、もう一度入力してください。');
                                        }
                                }

                                <?php
                                    global $query;
                                    global $wp_query;			
                                    $wp_query = new WP_Query();
                                    $WP_Comments_List_Table = new WP_Comments_List_Table();  
                                    $WP_List_Table = new WP_List_Table(); 
                                        
                                    $current_url_template = set_url_scheme( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
                                    $parts_page = explode('asd-', $current_url_template);
                                    $postshow_base_url_page = $parts_page[0] . 'asd-';
                                ?>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var nowPostShowInput = document.getElementById('now-postshow-selector');
                                    nowPostShowInput.addEventListener('keypress', function(event) {
                                        if (event.keyCode === 13 || event.key === 'Enter') {			
                                            var total_pages = document.getElementsByClassName("postshow-total-pages")[0].innerHTML;
                                            var nowpostshowpage = this.value;
                                            if(total_pages < nowpostshowpage){
                                                event.preventDefault();
                                                alert('最大ページ数を超えてはいけません。');
                                            }
                                            var isNumeric = /^\d+$/.test(nowpostshowpage);
                                            if (isNumeric && nowpostshowpage != 0) {
                                            //var currentPageUrl = window.location.href;
                                            }else {
                                                event.preventDefault();
                                                alert('有効な数字を入力してください！');
                                            }
                                        }
                                    });
                                });
                            </script>

                    <td colspan="2">
                        <p class="postemail-search">
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
                        <button id="clear-table-btn" type="button" class="initial-button" onclick="search_clear()">クリア</button>
                        <button type="button" class="homepage-button" onclick="onClickRedirect()">ホームページ</button>
                    </tr>
            </table>
          <?php  
            $limit = 3; 
            $page = 1;
            if(!isset($_GET['page']) || (!isset($_GET['paged']))){
                $page = $_GET['paged'] == null ? $_GET['page']: $_GET['paged'];
            }
          
           // $offset = ($page - 1) * $limit; 
            $offset     = ( $page > 0 ) ? $limit * ( $page - 1 ) : 1;        
            $post_id_select = isset($_GET['post_id_select']) ? sanitize_text_field($_GET['post_id_select']) : '';
            $search_email = isset($_GET['search_email']) ? sanitize_text_field($_GET['search_email']) : '';
            $search_keyword = isset($_GET['search_keyword']) ? sanitize_text_field($_GET['search_keyword']) : '';
            $sql = "SELECT * FROM {$wpdb->prefix}comments WHERE 1 = 1 ";
            $sql_count = "SELECT COUNT(*) FROM {$wpdb->prefix}comments WHERE 1 = 1 ";

        if ("" !=($post_id_select) && isset($post_id_select)) {
            $sql .= " AND comment_post_ID = " . esc_sql($post_id_select);
            $sql_count.= " AND comment_post_ID LIKE '%" . esc_sql($post_id_select) . "%'";
        }

        if ("" !=($search_email) && isset($search_email)) {
            $sql .= " AND comment_author_email LIKE '%" . esc_sql($search_email) . "%'";
            $sql_count.= " AND comment_author_email LIKE '%" . esc_sql($search_email) . "%'";
        }

        if ("" !=($search_email) && isset($search_email)) {
            $sql .= " AND comment_author_email LIKE '%" . esc_sql($search_email) . "%'";
            $sql_count.= " AND comment_author_email LIKE '%" . esc_sql($search_email) . "%'";
        }

         if ("" !=($search_keyword) && isset($search_keyword)) {
                $escaped_keyword = esc_sql($search_keyword);

                $sql_by_keyword = " AND ( comment_ID LIKE '%$escaped_keyword%' OR 
                comment_post_ID LIKE '%$escaped_keyword%' OR 
                comment_author LIKE '%$escaped_keyword%' OR
                comment_author_email LIKE '%$escaped_keyword%' OR
                comment_author_url LIKE '%$escaped_keyword%' OR
                comment_author_IP LIKE '%$escaped_keyword%' OR
                comment_content LIKE '%$escaped_keyword%' OR
                comment_approved LIKE '%$escaped_keyword%' OR
                comment_type LIKE '%$escaped_keyword%' OR
                comment_parent LIKE '%$escaped_keyword%' OR
                user_id LIKE '%$escaped_keyword%' OR
                comment_author_tel LIKE '%$escaped_keyword%' OR
                comment_sex LIKE '%$escaped_keyword%') ";
                $sql .=  $sql_by_keyword;
                $sql_count .=  $sql_by_keyword;       
            } 
            $sql .= " LIMIT $limit OFFSET $offset";

            $comments = $wpdb->get_results($sql);
            $total_comments = $wpdb->get_var($sql_count);
           // $total_pages = ceil($total_comments / $limit);
            $total_pages = (ceil($total_comments / $limit)> 1 ) ? (ceil($total_comments / $limit) ) : 1;
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
                        
                         $prev_link2 = render_block_core_comments_pagination_previous( $attributes, $content,$block);

                         $next_link2 = get_next_comments_link( "", $total_pages );

                         $removable_query_args = wp_removable_query_args();
                         
                         $current_url_postshow = set_url_scheme( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
                     
                         $current_url_postshow = remove_query_arg( $removable_query_args, $current_url_postshow );

                        //  if ($current_url_postshow == "http://localhost/wordpress/wp-postshow-comments.php"){
                        //     $_GET['post_id_select'] =null;
                        //     $_GET['search_email'] =null;
                        //     $_GET['search_keyword'] =null;
                         
                        //  }
                         if (strpos($current_url_postshow, "page=") !== false) {
                            $parts = explode('page=', $current_url_postshow);
                            $base_url = $parts[0] . 'paged=';
                            $pos = strpos($current_url_postshow, "page=") + strlen("page=");
                            $current = (int) substr($current_url_postshow, $pos);
                        } elseif (strpos($current_url_postshow, "paged=") !== false) {
                            $parts = explode('paged=', $current_url_postshow);
		                    $base_url = $parts[0] . 'paged=';
                            $pos = strpos($current_url_postshow, "paged=") + strlen("paged=");
                            $current = (int) substr($current_url_postshow, $pos);
                        }else{
                            $current = null;    
                        }               
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
                                 $base_url.'1',
                                 /* translators: Hidden accessibility text. */
                                 //__( 'First page' ),
                                 __( '' ),
                                 //'&laquo;'
                             );               
                         }
                         
                         if ( $disable_prev ) {
                             $page_links[] = '<span class="postshow button disabled" aria-hidden="true">&lsaquo;</span>';
                         } else {
                             $page_links[] = sprintf(
                                 "<a class='prev-page button' href='%s'>" .
                                     "<span class='screen-reader-text'>%s</span>" .
                                     "<span aria-hidden='true' style='font-size: 30px;font-style:italic;color:#65574E' >&lsaquo;</span>" .
                                 '</a>',
                                 $base_url.($current - 1 ),
                                 //esc_url( remove_query_arg( 'paged', $trimmed_uri.($last_character-1)) ),
                                 /* translators: Hidden accessibility text. */
                                 //__( 'Previous page' ),
                                 __( '' ),
                                 //'&lsaquo;'
                             );
                         }
                 
                        $html_current_page = sprintf(
                                 '<label for="post-search-page-selector" class="screen-reader-text">%s</label>' .
                                "<input class='current-page' id='now-postshow-selector' type='input'
                                     name='paged' value='%s' size='%d' aria-describedby='table-paging' />" .
                                 "<span class='tablenav-paging-text'>",
                                  /* translators: Hidden accessibility text. */
                                __( '現在のページ番号' ),
                                $current < 1 ?"1":$current,
                                strlen( $total_pages )
                              );
                        // var_dump($html_current_page);
                        $html_total_pages = sprintf( "<span class='postshow-total-pages'>%s</span>", number_format_i18n( $total_pages ) );
                         
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
                                 //esc_url( add_query_arg( 'paged', min( $total_pages, $current + 1 ), $current_url_postshow )   ),
                                 //esc_url( remove_query_arg( 'paged', $trimmed_uri.($last_character+1) ),
                                 $base_url.($current + 1 ),
                                 /* translators: Hidden accessibility text. */
                                 __( '' ),
                                 //__( 'Next page' ),
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
                                 $base_url.$total_pages,
                                 //esc_url( add_query_arg( 'paged', $total_pages, $current_url_postshow ) ),
                                 //esc_url( remove_query_arg( 'paged', $trimmed_uri.$total_pages ) ),
                                 /* translators: Hidden accessibility text. */
                                 __( '' ),
                                 //__( 'Last page' ),
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