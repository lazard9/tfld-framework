<?php

/**
 * Post Card
 *
 * Note: Should be called with The Loop
 */

// get_the_ID() works in the loop!
if (empty(get_the_ID())) {
	return null;
}

$post_permalink = get_the_permalink();
$post_title = get_the_title();
?>

<article id="post-<?php the_ID(); ?>" class="course-item">
	<div class="p-2 mb-2">
		<!-- Testing tailwindcss utility classes! -->
		<a href="<?php echo esc_url($post_permalink); ?>" class="block">
			<figure class="course-image">
				<?php if (has_post_thumbnail()) {
					the_post_thumbnail('full', array('class' => 'course'));
				} ?>
			</figure>
		</a>
		<a href="<?php echo esc_url($post_permalink); ?>" title="<?php echo esc_html($post_title); ?>">
			<div class="course-title">
				<h3><?php the_title(); ?></h3>
			</div>
		</a>
	</div>
</article>