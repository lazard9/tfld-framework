<?php defined('WPINC') or die();

/**
 * Load Shortcode
 *
 * @package TFLD Simple Features
 * 
 */

namespace TFLD\Includes\Shortcodes;

use TFLD\Includes\Abstracts\TFLD_Singleton;
use \WP_Query;

if (!class_exists('TFLD_Shortcodes', false)) : class TFLD_Shortcodes extends TFLD_Singleton
    {
        /**
         * Protected class constructor to prevent direct object creation
         *
         */
        protected function __construct()
        {
        }

        public function tfld_swiper_shortcode(): void
        {

            /**
             * Create Shortcode to Display Swiper slider
             *
             */
            echo <<<END
            <style type="text/css">
                .swiper {
                    height: 300px;
                }

                .swiper-slide {
                    overflow: hidden;
                }
            </style>
            <div class="swiper mySwiper1 swiper-h">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">Horizontal Slide 1</div>
                    <div class="swiper-slide">
                        <div class="swiper mySwiper2 swiper-v">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">Vertical Slide 1</div>
                                <div class="swiper-slide">Vertical Slide 2</div>
                                <div class="swiper-slide">Vertical Slide 3</div>
                                <div class="swiper-slide">Vertical Slide 4</div>
                                <div class="swiper-slide">Vertical Slide 5</div>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                    <div class="swiper-slide">Horizontal Slide 3</div>
                    <div class="swiper-slide">Horizontal Slide 4</div>
                </div>
                <!-- If we need pagination -->
                <div class="swiper-pagination"></div>
                <!-- If we need navigation buttons -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        END; // Heredoc https://www.php.net/manual/en/language.types.string.php#language.types.string.syntax.heredoc
        }

        /**
         * Initial posts display.
         * Create a short code.
         *
         * Usage echo do_shortcode('[ajax_load_more]');
         */
        public function tfld_ajax_lm_shortcode(): void
        {

            $is_infinite_scroll = get_option('tfld_main_settings');

            $button_text = ($is_infinite_scroll ?? ['checkbox-ajax']) ? 'Loading...' : 'Load More';

            /**
             * Page number.
             * If get_query_var( 'paged' ) is 2 or more, its a number pagination query.
             * If $_POST['page'] has a value which means its a loadmore request, which will take precedence.
             */
            $page_no = get_query_var('paged') ? get_query_var('paged') : 1;

            // Initial Post Load.
            $args = [
                'post_type'      => 'courses',
                'post_status'    => 'publish',
                'posts_per_page' => 4
            ];

            $query = new WP_Query($args);

            $total_pages = 2 * ($query->max_num_pages);

?>
            <div class="load-more-content-wrap">
                <div id="load-more-content" class="courses-list">
                    <?php
                    if ($query->have_posts()) :
                        // Loop Posts.
                        while ($query->have_posts()) : $query->the_post();
                            include TFLD_FRAMEWORK_DIR . '/template-parts/components/course-card.php';
                        endwhile;
                    endif;
                    ?>
                </div>
                <button id="load-more" style="display: block; margin: auto;" data-page="2">
                    <span><?php esc_html_e($button_text, 'tfldframework'); ?></span>
                </button>
                <?php if ($total_pages > 1) : ?>
                    <div id="post-pagination" style="display: none;" data-max-pages="<?php echo $total_pages; ?>">
                        <?php
                        echo paginate_links([
                            'base' => get_pagenum_link(1) . '%_%',
                            'format' => 'page/%#%',
                            'current' => $page_no,
                            'total' => $total_pages,
                            'prev_text' => __('« Prev', 'tfldframework'),
                            'next_text' => __('Next »', 'tfldframework'),
                        ]);
                        ?>
                    </div>
                <?php endif; ?>
            </div>
<?php
        }
    }
endif;
