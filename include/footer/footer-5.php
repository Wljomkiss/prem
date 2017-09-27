<footer class="footer-style-3 style-2">
	<div class="empty-lg-90 empty-md-90 empty-sm-60 empty-xs-60"></div>   
	<div class="container">
		<div class="footer-top">
			<div class="row">
				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="footer-item">
						<a href="<?php print esc_url( home_url( '/' ) ); ?>" class="f-logo">
							<?php nrg_premium_logo_2();?>
						</a>
						<div class="empty-sm-20 empty-xs-20"></div> 
						<?php if ( is_active_sidebar( 'footer_sidebar_5' ) ) : ?>
							<?php dynamic_sidebar( 'footer_sidebar_5' ); ?>
						<?php endif; ?>
						<div class="empty-sm-25 empty-xs-30"></div> 
						<div class="footer-folow">
							<?php nrg_premium_get_social(); ?>
						</div>
					</div>
					<div class="empty-lg-0 empty-md-0 empty-sm-0 empty-xs-40"></div>
				</div>
				<div class="col-md-3 col-sm-6 col-xs-12">
				   <?php if ( is_active_sidebar( 'footer_sidebar_6' ) ) : ?>
						<?php dynamic_sidebar( 'footer_sidebar_6' ); ?>
					<?php endif; ?>
				   <div class="empty-lg-0 empty-md-0 empty-sm-60 empty-xs-40"></div> 
				</div>
				<div class="col-md-3 col-sm-6 col-xs-12 clear-sm">
					<?php if ( is_active_sidebar( 'footer_sidebar_3' ) ) : ?>
						<?php dynamic_sidebar( 'footer_sidebar_3' ); ?>
					<?php endif; ?>
					<div class="empty-lg-0 empty-md-0 empty-sm-0 empty-xs-40"></div>
				</div>
				<div class="col-md-3 col-sm-6 col-xs-12">
					<?php if ( is_active_sidebar( 'footer_sidebar_1' ) ) : ?>
						<?php dynamic_sidebar( 'footer_sidebar_1' ); ?>
					<?php endif; ?>  
				</div>
			</div>
		</div>
		<div class="empty-lg-40 empty-md-40 empty-sm-40 empty-xs-40"></div> 
	</div>
	<div class="footer-bottom">
		<div class="container">
			<div class="empty-sm-40 empty-xs-40"></div>
			<?php nrg_premium_copyright(); ?>
			<?php wp_nav_menu(
				array(
					'container'      => '',
					'items_wrap'     => '<ul class="footer-link-menu fr">%3$s</ul>',
					'theme_location' => 'footer-menu',
					'depth'          => 1
				)
			); ?> 
			<div class="empty-sm-40 empty-xs-40"></div>
		</div> 
	</div>
</footer>
