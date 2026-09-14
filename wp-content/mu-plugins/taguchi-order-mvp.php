<?php
/**
 * Plugin Name: Taguchi Order MVP
 * Description: 現場から本社への発注受付（CF7 → メール + PDF）を提供します。
 * Version: 0.1.0
 */

defined( 'ABSPATH' ) || exit;

$taguchi_order_files = array(
    __DIR__ . '/taguchi-order-mvp/site-select.php',
    __DIR__ . '/taguchi-order-mvp/bootstrap.php',
);

foreach ( $taguchi_order_files as $taguchi_order_file ) {
    if ( is_readable( $taguchi_order_file ) ) {
        require_once $taguchi_order_file;
    }
}
