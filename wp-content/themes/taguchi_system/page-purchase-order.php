<?php
/**
 * Purchase order MVP entry point.
 *
 * The template exposes semantic UI classes only. Visual implementation lives
 * in the Tailwind-backed order UI layer so the framework is replaceable.
 */

$order_ui_path = get_stylesheet_directory() . '/assets/css/order-ui.css';
if ( file_exists( $order_ui_path ) ) {
    wp_enqueue_style(
        'taguchi-order-ui',
        get_stylesheet_directory_uri() . '/assets/css/order-ui.css',
        array( 'site_styles' ),
        (string) filemtime( $order_ui_path )
    );
}

$order_ui_legacy_path = get_stylesheet_directory() . '/assets/css/order-ui-legacy.css';
if ( file_exists( $order_ui_legacy_path ) ) {
    wp_enqueue_style(
        'taguchi-order-ui-legacy',
        get_stylesheet_directory_uri() . '/assets/css/order-ui-legacy.css',
        array( 'taguchi-order-ui' ),
        (string) filemtime( $order_ui_legacy_path )
    );
}

$order_form_js_path = get_stylesheet_directory() . '/assets/js/order-form.js';
if ( file_exists( $order_form_js_path ) ) {
    wp_enqueue_script(
        'taguchi-order-form',
        get_stylesheet_directory_uri() . '/assets/js/order-form.js',
        array(),
        (string) filemtime( $order_form_js_path ),
        true
    );
}

get_header();
?>

<main class="order-page">
  <section class="order-shell" aria-labelledby="order-page-title">
    <header class="order-header">
      <p class="order-eyebrow">PURCHASE ORDER</p>
      <h1 id="order-page-title" class="order-title">資材発注</h1>
      <p class="order-description">
        現場から本社へ発注内容を送信します。入力内容は発注書として本社へ共有されます。
      </p>
    </header>

    <div class="order-panel">
      <div class="order-panel__notice" role="note">
        <strong>入力前にご確認ください</strong>
        <span>現場名・希望日・品名・数量を確認してから送信してください。</span>
      </div>

      <div class="order-form">
        <?php echo do_shortcode('[contact-form-7 id="a7ea7cc" title="purchase-order_form"]'); ?>
      </div>
    </div>
  </section>
</main>

<?php get_footer();
