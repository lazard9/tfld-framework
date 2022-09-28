<?php

global $wpdb, $post;
// $ID = get_the_id();
$ourdb = $wpdb->prefix . 'ld_course_details';
$subtitle = $wpdb->get_var("SELECT `subtitle` FROM `$ourdb` WHERE `ID` = " . $post->ID . "");
$price = $wpdb->get_var("SELECT `price` FROM `$ourdb` WHERE `ID` = " . $post->ID . "");
$video = $wpdb->get_var("SELECT `video` FROM `$ourdb` WHERE `ID` = " . $post->ID . "");
$curriculum = $wpdb->get_var("SELECT `content` FROM `$ourdb` WHERE `ID` = " . $post->ID . "");

$all_ids = $wpdb->get_col("SELECT `ID` FROM `$ourdb`");

get_header();

if (have_posts()) {

    // Load posts loop.
    while (have_posts()) {
        the_post();

        echo '<div style="max-width: 800px; margin: auto; padding: 60px 20px;">';

        echo do_shortcode('[swiper_slider_01]');

        echo '<div class="entry-hrader"><h1 class="entry-title">' . get_the_title() . '</h1></div>';

        if ($author_id = get_post_meta(get_the_ID(), 'tfld_post_editor', true)) {

            echo '<div class="the-editor">Editor: ' . get_the_author_meta('display_name', $author_id) . '</div>';
        }

        echo '<div class="bg-blue-1 pad">
                    <h3>' . $subtitle . '</h3>
                    <div>' . $price . '</div>
                    <div>' . $video . '</div>
                    <div>' . $curriculum . '</div>
                </div>';

        foreach ($all_ids as $id) {
            echo $id . '<br/>';
            echo get_the_title($id) . '<br/>';
            echo get_the_post_thumbnail_url($id) . '<br/>';
        };

        $votes = get_post_meta($post->ID, "votes", true);
        $votes = ($votes == "") ? 0 : $votes;
?>
        This post has <div id='vote_counter'><?php echo $votes ?></div> votes<br>

<?php
        $nonce = wp_create_nonce("ajax_user_vote_nonce");
        $link = admin_url('admin-ajax.php?action=my_user_vote&post_id=' . $post->ID . '&nonce=' . $nonce);
        echo '<a class="user_vote" data-nonce="' . $nonce . '" data-post_id="' . $post->ID . '" href="' . $link . '">vote for this article</a>';

        echo '</div>';
    }
}

get_footer();
