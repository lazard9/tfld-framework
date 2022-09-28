<?php
get_header();

echo '<div style="max-width: 800px; margin: auto; padding: 60px 20px;">';

echo do_shortcode('[ajax_load_more]');

echo '</div>';

get_footer();
