<?php
/**
 * Plugin Name: Taguchi Order MVP
 * Description: 現場から本社への発注受付（CF7 → メール + PDF）を提供します。
 * Version: 0.1.0
 */

defined( 'ABSPATH' ) || exit;

$taguchi_order_bootstrap = __DIR__ . '/taguchi-order-mvp/bootstrap.php';

if ( is_readable( $taguchi_order_bootstrap ) ) {
    require_once $taguchi_order_bootstrap;
}
