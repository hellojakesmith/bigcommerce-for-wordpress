<?php


namespace BigCommerce\Shortcodes;

use \BigCommerce\Templates;

class Account_Profile implements Shortcode {

	const NAME = 'bigcommerce_account_profile';


	public function __construct() {
	}

	public function render( $attr, $instance ) {
		if ( ! is_user_logged_in() ) {
			return '';
		}

		$component = new Templates\Profile_Form();

		return $component->render();
	}

}