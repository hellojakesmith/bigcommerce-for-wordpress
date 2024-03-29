<?php

namespace BigCommerce\Templates;

use BigCommerce\Post_Types\Product\Product;

class Product_Reviews extends Controller {
	const PRODUCT = 'product';

	const HEADER        = 'header';
	const FORM          = 'form';
	const REVIEWS       = 'reviews';
	const NEXT_PAGE_URL = 'next_page_url';

	protected $template = 'components/product-reviews.php';

	protected function parse_options( array $options ) {
		$defaults = [
			self::PRODUCT       => null,
			self::REVIEWS       => [],
			self::NEXT_PAGE_URL => '',
		];

		return wp_parse_args( $options, $defaults );
	}

	public function get_data() {
		$data = [
			self::REVIEWS => $this->get_reviews( $this->options[ self::REVIEWS ], $this->options[ self::PRODUCT ], $this->options[ self::NEXT_PAGE_URL ] ),
			self::HEADER  => $this->get_header( $this->options[ self::PRODUCT ] ),
			self::FORM    => $this->get_form( $this->options[ self::PRODUCT ] ),
		];

		return $data;
	}

	protected function get_reviews( $reviews, Product $product, $next_page ) {
		$component = new Review_List( [
			Review_List::PRODUCT       => $product,
			Review_List::REVIEWS       => $reviews,
			Review_List::NEXT_PAGE_URL => $next_page,
		] );

		return $component->render();
	}

	protected function get_header( Product $product ) {
		$component = new Product_Rating( [
			Product_Rating::PRODUCT => $product,
		], 'components/product-rating-header.php' );

		return $component->render();
	}

	protected function get_form( Product $product ) {
		/**
		 * Filter whether to show the product review form for a product.
		 *
		 * @param bool $show    Whether to show the form. Defaults to true if the user is logged in, otherwise false.
		 * @param int  $post_id The ID of the product post
		 */
		if ( ! apply_filters( 'bigcommerce/product/reviews/show_form', is_user_logged_in(), $product->post_id() ) ) {
			return '';
		}

		$component = new Review_Form( [
			Review_Form::PRODUCT => $product,
		], 'components/review-form.php' );

		return $component->render();
	}

}