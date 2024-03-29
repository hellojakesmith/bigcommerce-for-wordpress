<?php


namespace BigCommerce\Templates;


class Gift_Certificate_Page extends Controller {
	const FORM         = 'form';
	const INSTRUCTIONS = 'instructions';

	protected $template = 'components/gift-certificates/purchase-shortcode.php';

	protected function parse_options( array $options ) {
		$defaults = [];

		return wp_parse_args( $options, $defaults );
	}

	public function get_data() {
		return [
			self::FORM         => $this->get_form(),
			self::INSTRUCTIONS => $this->get_instructions(),
		];
	}

	private function get_form() {
		$controller = new Gift_Certificate_Form();

		return $controller->render();
	}

	private function get_instructions() {
		$controller = new Gift_Certificate_Redemption_Instructions();

		return $controller->render();
	}

}