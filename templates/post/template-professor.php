<?php
get_header();

echo '<div style="max-width: 800px; margin: auto; padding: 60px 20px;">';

if ( has_post_thumbnail() ) {
  the_post_thumbnail();
}

echo '<h2 style="margin: 20px 0;">Greetings professor' . get_the_title() .'!</h2>';
if (have_posts()) {

  // Load posts loop.
  while (have_posts()) {
    the_post();

    the_content();
  }
}

echo '</div>';

get_footer();
