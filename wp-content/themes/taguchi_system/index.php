<?php get_header(); ?>

<section class="topSec">
  <div class="container">
    <div class="row">
      <a href="<?php echo esc_url( home_url( '/purchase-order/' ) ); ?>" class="btn kaikakeBtn">
        <div class="txt__wrap">
          <p class="txt01">提携業者の方はこちら</p>
          <p class="txt02">買掛注文</p>
        </div>
      </a>
      <a href="<?php echo home_url(); ?>/products/" class="btn ecBtn">
        <div class="txt__wrap">
          <p class="txt01">一般の方はこちら</p>
          <p class="txt02">一般注文</p>
        </div>
      </a>
    </div>
  </div>
</section>

<?php get_footer();