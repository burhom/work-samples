<footer id="footer">
  <div class="container">
    <div class="row">
	    <?php
	    $phoneURL = get_field('footer_phone', get_option('page_on_front'));
	    $emailURL = get_field('footer_email', get_option('page_on_front'));
	    ?>
      <div class="text-center"><a href="tel:<?php echo $phoneURL; ?>"><?php echo $phoneURL; ?></a><span class="hidden-xs">|</span><br class="visible-xs" /><a href="mailto:<?php echo $emailURL; ?>"><?php echo $emailURL; ?></a><br>
        <div class="copy">&copy; <?php echo date('Y') ?> Dila Construction. All Rights Reserved.</div>
      </div>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>