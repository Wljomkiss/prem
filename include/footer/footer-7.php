<footer class="footer-style-1 footer-7">
	<div class="empty-lg-60 empty-md-60 empty-sm-50 empty-xs-40"></div> 
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<a href="<?php print esc_url( home_url( '/' ) ); ?>" class="f-logo">
					<?php nrg_premium_logo();?>
				</a>
			</div>
			<div class="col-md-6 col-md-offset-3">
				<div class="empty-sm-40 empty-xs-40"></div>
				<?php echo do_shortcode('[yikes-mailchimp form="1"]');?>
			</div>
			<div class="col-md-12">
				<?php nrg_premium_copyright(); ?>
				<div class="empty-sm-30 empty-xs-30"></div>
				<div class="footer-folow color-link-2">
					<?php nrg_premium_get_social(); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="empty-lg-90 empty-md-80 empty-sm-60 empty-xs-60"></div> 
</footer>
