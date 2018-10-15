<?php
/**
 * Login Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce; ?>

<?php do_action('woocommerce_before_customer_login_form'); ?>
<form method="post" class="login" id="login_ajax" action="<?php echo wp_login_url(); ?>">
	<div class="block-content">
		<div class="col-reg registered-account">
			<div class="email-input">
				<input type="text" class="form-control input-text username" name="username" id="username" placeholder="<?php esc_attr_e( 'Username', 'autusin' ) ?>" />
			</div>
			<div class="pass-input">
				<input class="form-control input-text password" type="password" placeholder="<?php esc_attr_e( 'Password', 'autusin' ) ?>" name="password" id="password" />
			</div>
			<div class="ft-link-p">
				<a href="<?php echo esc_url( wc_lostpassword_url() ); ?>" title="<?php esc_attr_e( 'Forgot your password', 'autusin' ) ?>"><?php esc_html_e( 'Forgot your password?', 'autusin' ); ?></a>
			</div>
			<div class="actions">
				<div class="submit-login">
					<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
					<input type="submit" class="button btn-submit-login" name="login" value="<?php esc_attr_e( 'Login', 'autusin' ); ?>" />
				</div>	
			</div>
			<div id="login_message"></div>
			
		</div>
		<div class="col-reg login-customer">
			<h2><?php esc_html_e( 'NEW HERE?', 'autusin' ); ?></h2>
			<p class="note-reg"><?php esc_html_e( 'Registration is free and easy!', 'autusin' ); ?></p>
			<ul class="list-log">
				<li><?php esc_html_e( 'Faster checkout', 'autusin' ); ?></li>
				<li><?php esc_html_e( 'Save multiple shipping addresses', 'autusin' ); ?></li>
				<li><?php esc_html_e( 'View and track orders and more', 'autusin' ); ?></li>
			</ul>
			<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php esc_attr_e( 'Register', 'autusin' ) ?>" class="btn-reg-popup"><?php esc_html_e( 'Create an account', 'autusin' ); ?></a>
		</div>
	</div>
</form>
<div class="clear"></div>
	
<?php do_action('woocommerce_after_cphone-icon-login ustomer_login_form'); ?>