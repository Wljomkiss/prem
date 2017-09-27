<?php get_header(); ?>
<div class="container">
	<div class="row">
		<div class="col-md-8">
			<div class="archive-cont-wr">
				<h1 class="title"><?php esc_html_e( '404', 'nrg_premium' ); ?></h1>
				<?php if ( ! empty( nrgOption('error_title') ) ) { ?>
					<h2 class="subtitle"><?php echo esc_html( nrgOption('error_title') ); ?></h2>
				<?php } else { ?>
					<h2 class="subtitle"><?php echo esc_html('Page not found', 'nrg_premium'); ?></h2>
				<?php } ?>
				<?php if ( ! empty( nrgOption('error_btn_text') ) ) { ?>
					<a href="<?php echo esc_url( home_url( '/' ) );?>"><?php echo esc_html( nrgOption('error_btn_text') ); ?></a>
				<?php } else { ?>
					<a href="<?php echo esc_url( home_url( '/' ) );?>"><?php echo esc_html( 'HOME PAGE', 'nrg_premium' ); ?></a>
				<?php } ?>	
				<?php get_search_form( true ); ?>
			</div>
		</div>
		<div class="col-md-4">
			<?php if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar('sidebar') ); ?>
		</div>
	</div>
</div>	


<?php get_footer();