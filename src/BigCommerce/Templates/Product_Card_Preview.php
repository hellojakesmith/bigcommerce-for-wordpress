<?php


namespace BigCommerce\Templates;


use BigCommerce\Post_Types\Product\Product;

class Product_Card_Preview extends Product_Card {

	protected function get_title( Product $product ) {
		$component = new Product_Title( [
			Product_Title::PRODUCT => $product,
			Product_Title::SHOW_CONDITION => false,
			Product_Title::SHOW_INVENTORY => false,
			Product_Title::USE_PERMALINK  => false,
		] );

		return $component->render();
	}

	protected function get_form( Product $product ) {
		return '';
	}

	protected function get_popup_template( Product $product ) {
		return '';
	}
}