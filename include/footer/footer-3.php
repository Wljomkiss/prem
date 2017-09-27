<footer class="footer-style-3">
	<div class="empty-lg-90 empty-md-90 empty-sm-60 empty-xs-60"></div>   
	<div class="container">
		<div class="footer-top">
			<div class="row">
				<div class="col-md-3 col-sm-6 col-xs-12">
					<a href="<?php print esc_url( home_url( '/' ) ); ?>" class="f-logo">
						<?php nrg_premium_logo_2();?>
					</a>
					<?php if ( is_active_sidebar( 'footer_sidebar_1' ) ) : ?>
						<?php dynamic_sidebar( 'footer_sidebar_1' ); ?>
					<?php endif; ?>
				</div>
				<div class="col-md-3 col-sm-6 col-xs-12">
					<?php if ( is_active_sidebar( 'footer_sidebar_2' ) ) : ?>
						<?php dynamic_sidebar( 'footer_sidebar_2' ); ?>
					<?php endif; ?>
				</div>
				<div class="col-md-3 col-sm-6 col-xs-12">
					<?php if ( is_active_sidebar( 'footer_sidebar_3' ) ) : ?>
						<?php dynamic_sidebar( 'footer_sidebar_3' ); ?>
					<?php endif; ?>
				</div>
				<div class="col-md-3 col-sm-6 col-xs-12">
					<?php if ( is_active_sidebar( 'footer_sidebar_4' ) ) : ?>
						<?php dynamic_sidebar( 'footer_sidebar_4' ); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<!-- <div class="empty-lg-40 empty-md-40 empty-sm-40 empty-xs-40"></div> -->
		<div class="divid-line"></div>  
		<div class="footer-bottom">
			<?php nrg_premium_copyright(); ?>
			<div class="footer-folow">
				<?php nrg_premium_get_social(); ?>
			</div>
			<div class="empty-sm-35 empty-xs-30"></div>
		</div>
	</div>
</footer>