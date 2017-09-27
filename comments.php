<?php
/**
 * Comment template
 *
 * @package nrg_premium
 * @since 1.0.0
 *
 */

?>

<div class="row commens-wr">
    <?php if ( have_comments() ) { ?>
        <div class="col-md-6">
            <div class="comments">
                <h3><?php comments_number( esc_html__( '0', 'nrg_premium' ), esc_html__( '1', 'nrg_premium' ), esc_html__( '%', 'nrg_premium' ) );  esc_html_e( ' Comments ', 'nrg_premium' ); ?></h3>
                <div class="nrg_premium-comments-list" id="comments">
                <ul><?php wp_list_comments( array( 'callback' => 'nrg_premium_comment' ) ); ?></ul>
                    <nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
                        <div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'nrg_premium' ) ); ?></div>
                        <div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'nrg_premium' ) ); ?></div>
                    </nav>
                </div>
            </div>
        </div>
	<?php } ?>
    <div class="col-md-6">
    	<div class="comments">
            <?php comment_form(); ?>
        </div>
    </div>
</div>