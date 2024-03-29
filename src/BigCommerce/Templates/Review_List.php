<?php

namespace BigCommerce\Templates;

class Review_List extends Controller {
	const PRODUCT       = 'product';
	const REVIEWS       = 'reviews';
	const NEXT_PAGE_URL = 'next_page_url';
	const PAGINATION    = 'pagination';
	const WRAP          = 'wrap';

	protected $template = 'components/review-list.php';


	protected function parse_options( array $options ) {
		$defaults = [
			self::PRODUCT       => null,
			self::REVIEWS       => [],
			self::NEXT_PAGE_URL => '',
			self::WRAP          => true,
		];

		return wp_parse_args( $options, $defaults );
	}

	public function get_data() {
		$data = [
			self::REVIEWS    => $this->options[ self::REVIEWS ],
			self::PAGINATION => $this->get_pagination( $this->options[ self::NEXT_PAGE_URL ] ),
			self::WRAP       => $this->options[ self::WRAP ],
		];

		return $data;
	}


	protected function get_pagination( $next_page_url ) {
		if ( empty( $next_page_url ) ) {
			return '';
		}
		$component = new Review_List_Pagination( [
			Review_List_Pagination::NEXT_PAGE_URL => $next_page_url,
		] );

		return $component->render();
	}

}