<div class="tfld-wrap">
    <h1><?php esc_html_e( get_admin_page_title() ); ?></h1>

    <h2><?php esc_html_e( 'About the author', 'tfldframework' ); ?></h2>

    <?php $options = get_option( 'tfld_simple_options' ); ?>

    <?php if ( $options) : ?>
        <ul>
        <?php foreach( $options as $option ): ?>
            <li><?php echo $option; ?></li>
        <?php endforeach; ?>
        </ul>

        <?php if( array_key_exists( 'name', $options ) ): ?>
            <h2><?php esc_html_e( 'Specific Option', 'tfldframework' ); ?></h2>
            <p><?php esc_html_e( $options['sponsor'] ); ?></p>
        <?php endif; ?>
    <?php endif; ?>
</div>
