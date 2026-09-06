<?php
/**
 * Taguchi Order MVP application behavior.
 *
 * Responsibility:
 * - detect the dedicated Contact Form 7 purchase-order submission
 * - assign a receipt ID
 * - render the same submitted data into a Japanese PDF
 * - attach that PDF to the administrative mail
 *
 * Presentation belongs to the theme. This file contains no page styling.
 */

defined( 'ABSPATH' ) || exit;

final class Taguchi_Order_MVP {
    private const FORM_TITLE = 'purchase-order_form';
    private const PDF_FIELD  = 'taguchi-order-pdf';

    private static string $receipt_id = '';

    public static function boot(): void {
        add_action( 'wpcf7_before_send_mail', array( self::class, 'prepare_order_mail' ), 20, 3 );
    }

    public static function prepare_order_mail( $contact_form, &$abort, $submission = null ): void {
        if ( ! self::is_purchase_order_form( $contact_form ) ) {
            return;
        }

        if ( ! class_exists( 'WPCF7_Submission' ) ) {
            self::fail( $abort, 'Contact Form 7 submission API is unavailable.' );
            return;
        }

        $submission = WPCF7_Submission::get_instance();
        if ( ! $submission ) {
            self::fail( $abort, 'Contact Form 7 submission could not be resolved.' );
            return;
        }

        $autoload = __DIR__ . '/vendor/autoload.php';
        if ( ! is_readable( $autoload ) ) {
            self::fail( $abort, 'mPDF is not installed. Run Composer install for taguchi-order-mvp.' );
            return;
        }

        require_once $autoload;

        if ( ! class_exists( '\\Mpdf\\Mpdf' ) ) {
            self::fail( $abort, 'mPDF class is unavailable after loading Composer dependencies.' );
            return;
        }

        $data = self::normalize_submission( (array) $submission->get_posted_data() );
        if ( empty( $data ) ) {
            self::fail( $abort, 'Purchase-order submission contains no printable fields.' );
            return;
        }

        self::$receipt_id = self::create_receipt_id();

        try {
            $pdf_path = self::create_pdf( self::$receipt_id, $data );
        } catch ( Throwable $error ) {
            self::fail( $abort, 'PDF generation failed: ' . $error->getMessage() );
            return;
        }

        if ( ! is_readable( $pdf_path ) ) {
            self::fail( $abort, 'Generated purchase-order PDF is not readable.' );
            return;
        }

        // CF7 manages lifecycle/cleanup for files registered on the submission.
        $submission->add_uploaded_file( self::PDF_FIELD, $pdf_path );

        $mail = (array) $contact_form->prop( 'mail' );
        $mail['subject'] = self::prefix_subject( (string) ( $mail['subject'] ?? '' ), self::$receipt_id );
        $mail['body'] = self::prepend_receipt_to_body( (string) ( $mail['body'] ?? '' ), self::$receipt_id );
        $mail['attachments'] = self::append_attachment_tag(
            (string) ( $mail['attachments'] ?? '' ),
            '[' . self::PDF_FIELD . ']'
        );

        $contact_form->set_properties( array( 'mail' => $mail ) );
    }

    private static function is_purchase_order_form( $contact_form ): bool {
        return is_object( $contact_form )
            && method_exists( $contact_form, 'title' )
            && self::FORM_TITLE === (string) $contact_form->title();
    }

    private static function normalize_submission( array $posted_data ): array {
        $normalized = array();

        foreach ( $posted_data as $key => $value ) {
            $key = (string) $key;

            // CF7/internal transport fields are not business data.
            if ( '' === $key || str_starts_with( $key, '_' ) || self::PDF_FIELD === $key ) {
                continue;
            }

            if ( is_array( $value ) ) {
                $value = implode( ' / ', array_map( 'sanitize_text_field', $value ) );
            } elseif ( is_scalar( $value ) ) {
                $value = sanitize_textarea_field( (string) $value );
            } else {
                continue;
            }

            if ( '' === trim( (string) $value ) ) {
                continue;
            }

            $normalized[ $key ] = (string) $value;
        }

        return $normalized;
    }

    private static function create_receipt_id(): string {
        return sprintf(
            'TS-%s-%04d',
            wp_date( 'Ymd-His' ),
            wp_rand( 0, 9999 )
        );
    }

    private static function create_pdf( string $receipt_id, array $data ): string {
        $upload = wp_upload_dir();
        if ( ! empty( $upload['error'] ) ) {
            throw new RuntimeException( (string) $upload['error'] );
        }

        $work_dir = trailingslashit( $upload['basedir'] ) . 'taguchi-order-mvp';
        if ( ! wp_mkdir_p( $work_dir ) ) {
            throw new RuntimeException( 'Unable to create the PDF work directory.' );
        }

        $filename = sanitize_file_name( 'purchase-order-' . $receipt_id . '.pdf' );
        $path = trailingslashit( $work_dir ) . $filename;

        $mpdf = new \Mpdf\Mpdf(
            array(
                'mode'       => '+aCJK',
                'format'     => 'A4',
                'orientation'=> 'P',
                'tempDir'    => $work_dir,
                'margin_top' => 14,
                'margin_right' => 14,
                'margin_bottom' => 14,
                'margin_left' => 14,
            )
        );

        $mpdf->SetTitle( '発注書 ' . $receipt_id );
        $mpdf->SetAuthor( '田口産業' );
        $mpdf->WriteHTML( self::render_pdf_html( $receipt_id, $data ) );
        $mpdf->Output( $path, \Mpdf\Output\Destination::FILE );

        return $path;
    }

    private static function render_pdf_html( string $receipt_id, array $data ): string {
        $rows = '';
        foreach ( $data as $key => $value ) {
            $rows .= sprintf(
                '<tr><th>%s</th><td>%s</td></tr>',
                esc_html( self::field_label( $key ) ),
                nl2br( esc_html( $value ) )
            );
        }

        return sprintf(
            '<!doctype html><html lang="ja"><head><meta charset="UTF-8"><style>
                body{font-family:sans-serif;color:#172033;font-size:10.5pt;line-height:1.6}
                h1{font-size:20pt;margin:0 0 4mm}
                .meta{color:#667085;font-size:9pt;margin-bottom:8mm}
                table{border-collapse:collapse;width:100%%}
                th,td{border:1px solid #cfd6e1;padding:3mm;vertical-align:top}
                th{background:#f5f7fa;text-align:left;width:30%%;font-weight:bold}
                .footer{color:#667085;font-size:8.5pt;margin-top:7mm}
            </style></head><body>
                <h1>発注書</h1>
                <div class="meta">受付番号: %s<br>受付日時: %s</div>
                <table>%s</table>
                <div class="footer">本書はWeb発注フォームの送信内容から自動生成されています。</div>
            </body></html>',
            esc_html( $receipt_id ),
            esc_html( wp_date( 'Y年n月j日 H:i:s' ) ),
            $rows
        );
    }

    private static function field_label( string $key ): string {
        $labels = array(
            'request-date' => '希望日',
            'site' => '現場',
            'site_select' => '現場',
            'site-name' => '現場名',
            'company' => '会社名',
            'company-name' => '会社名',
            'name' => '担当者名',
            'your-name' => '担当者名',
            'email' => 'メールアドレス',
            'your-email' => 'メールアドレス',
            'tel' => '電話番号',
            'phone' => '電話番号',
            'product' => '品名',
            'product-name' => '品名',
            'quantity' => '数量',
            'message' => '発注内容・備考',
            'your-message' => '発注内容・備考',
        );

        if ( isset( $labels[ $key ] ) ) {
            return $labels[ $key ];
        }

        return ucwords( str_replace( array( '-', '_' ), ' ', $key ) );
    }

    private static function prefix_subject( string $subject, string $receipt_id ): string {
        $subject = trim( $subject );
        return sprintf( '[発注 %s] %s', $receipt_id, $subject ?: '資材発注' );
    }

    private static function prepend_receipt_to_body( string $body, string $receipt_id ): string {
        return sprintf( "受付番号: %s\n\n%s", $receipt_id, ltrim( $body ) );
    }

    private static function append_attachment_tag( string $attachments, string $tag ): string {
        $lines = array_filter( array_map( 'trim', preg_split( '/\R/', $attachments ) ?: array() ) );
        if ( ! in_array( $tag, $lines, true ) ) {
            $lines[] = $tag;
        }
        return implode( "\n", $lines );
    }

    private static function fail( &$abort, string $reason ): void {
        $abort = true;
        error_log( '[taguchi-order-mvp] ' . $reason );
    }
}

Taguchi_Order_MVP::boot();
