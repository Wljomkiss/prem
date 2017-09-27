<footer class="footer-style-4">
	<div class="empty-lg-80 empty-md-80 empty-sm-60 empty-xs-60"></div> 
		<div class="container">
		<div class="row">
			<div class="col-md-6 col-sm-5 col-xs-12">
			<div class="footer-item">
			   <a href="<?php print esc_url( home_url( '/' ) ); ?>" class="f-logo">
					<?php nrg_premium_logo();?>
				</a>
			   <div class="empty-sm-10 empty-xs-10"></div>
				<?php if ( is_active_sidebar( 'footer_sidebar_5' ) ) : ?>
					<?php dynamic_sidebar( 'footer_sidebar_5' ); ?>
				<?php endif; ?> 
				<?php 
					$post_meta     = get_post_meta( get_the_ID(), '_custom_page_options', true );
					$footer_layout = nrgOption('footer_layout'); ?>
					<?php
					if(isset($post_meta['footer_layout']) && $post_meta['footer_layout'] == '6') {
						if (isset($post_meta['link_title_page']) && $post_meta['link_title_page'] && isset($post_meta['link_page']) && $post_meta['link_page']) { ?>
							<div class="empty-sm-20 empty-xs-20"></div>
							<div class="additional-link text-left sm type-2"><a href="<?php echo esc_html($post_meta['link_page']); ?>"><?php echo esc_html($post_meta['link_title_page']); ?></a></div>
						<?php } ?>
					<?php } else { ?>
						<div class="empty-sm-20 empty-xs-20"></div>
						<div class="additional-link text-left sm type-2"><a href="#">contact us</a></div>
					<?php } ?>
			</div>
			<div class="empty-lg-0 empty-md-0 empty-sm-40 empty-xs-30"></div>    
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12">
				<?php if ( is_active_sidebar( 'footer_sidebar_1' ) ) : ?>
					<?php dynamic_sidebar( 'footer_sidebar_1' ); ?>
				<?php endif; ?> 
				<div class="empty-lg-0 empty-md-0 empty-sm-40 empty-xs-30"></div>
			</div>
			<div class="col-md-2 col-sm-3 col-xs-12">
				<?php if ( is_active_sidebar( 'footer_sidebar_7' ) ) : ?>
					<?php dynamic_sidebar( 'footer_sidebar_7' ); ?>
				<?php endif; ?> 
			</div>
		</div>
	</div> 
	<div class="empty-lg-80 empty-md-80 empty-sm-60 empty-xs-60"></div>
</footer>