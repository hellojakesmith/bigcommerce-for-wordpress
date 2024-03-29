<?php


namespace BigCommerce\Cart;


use BigCommerce\Accounts\Login;
use BigCommerce\Api\v3\ApiException;
use BigCommerce\Api\v3\Api\CartApi;
use BigCommerce\Api\v3\Model\BaseItem;
use BigCommerce\Api\v3\Model\CartRequestData;
use BigCommerce\Api\v3\Model\LineItemGiftCertificateRequestData;
use BigCommerce\Api\v3\Model\LineItemRequestData;
use BigCommerce\Api\v3\Model\ProductOptionSelection;
use BigCommerce\Settings;
use BigCommerce\Util\Cart_Item_Iterator;

class Cart {
	const CART_COOKIE  = 'bigcommerce_cart_id';
	const COUNT_COOKIE = 'bigcommerce_cart_item_count';
	/**
	 * @var CartApi
	 */
	private $api;

	public function __construct( CartApi $api ) {
		$this->api = $api;
	}

	/**
	 * Get the cart ID from the cookie
	 *
	 * @return string
	 */
	public function get_cart_id() {
		if ( get_option( Settings\Cart::OPTION_ENABLE_CART, true ) ) {
			return isset( $_COOKIE[ self::CART_COOKIE ] ) ? $_COOKIE[ self::CART_COOKIE ] : '';
		} else {
			return false;
		}
	}

	/**
	 * Set the cookie that contains the cart ID
	 *
	 * @param string $cart_id
	 *
	 * @return void
	 */
	private function set_cart_id( $cart_id ) {
		/**
		 * Filter how long the cart cookie should persist
		 *
		 * @param int $lifetime The cookie lifespan in seconds
		 */
		$cookie_life = apply_filters( 'bigcommerce/cart/cookie_lifetime', 30 * DAY_IN_SECONDS );
		$secure      = ( 'https' === parse_url( home_url(), PHP_URL_SCHEME ) );
		setcookie( self::CART_COOKIE, $cart_id, time() + $cookie_life, COOKIEPATH, COOKIE_DOMAIN, $secure );
	}

	/**
	 * @param int   $product_id
	 * @param array $options
	 * @param int   $quantity
	 * @param array $modifiers
	 *
	 * @return \BigCommerce\Api\v3\Model\Cart|null
	 */
	public function add_line_item( $product_id, $options = [], $quantity = 1, $modifiers = [] ) {
		$request_data      = new CartRequestData();
		$option_selections = [];

		foreach ( $options as $option_key => $option_value ) {
			$option_selections[] = new ProductOptionSelection( [
				'option_id'    => $option_key,
				'option_value' => $option_value,
			] );
		}

		foreach ( $modifiers as $modifier_key => $modifier_value ) {
			$option_selections[] = new ProductOptionSelection( [
				'option_id'    => $modifier_key,
				'option_value' => $modifier_value,
			] );
		}
		$request_data->setLineItems( [
			new LineItemRequestData( [
				'quantity'          => $quantity,
				'product_id'        => $product_id,
				'option_selections' => $option_selections,
			] ),
		] );
		$request_data->setGiftCertificates( [] );

		return $this->add_request_to_cart( $request_data );
	}

	/**
	 * @param $certificate
	 *
	 * @return \BigCommerce\Api\v3\Model\Cart|null
	 */
	public function add_gift_certificate( $certificate ) {
		$request_data = new CartRequestData();
		$request_data->setLineItems( [] );
		$request_data->setGiftCertificates( [
			new LineItemGiftCertificateRequestData( $certificate ),
		] );

		return $this->add_request_to_cart( $request_data );
	}

	/**
	 * @param CartRequestData $request
	 *
	 * @return \BigCommerce\Api\v3\Model\Cart|null
	 */
	private function add_request_to_cart( CartRequestData $request ) {
		$cart    = null;
		$cart_id = $this->get_cart_id();
		$cart_id = $this->sanitize_cart_id( $cart_id );

		try {
			if ( $cart_id ) {
				$cart_response = $this->api->cartsCartIdItemsPost( $cart_id, $request );
				if ( $cart_response ) {
					$cart = $cart_response->getData();
				}
			}
		} catch ( ApiException $e ) {
			// request failed. next try to make a new cart
			$cart = null;
		}

		if ( empty( $cart ) ) { // either there was no cart ID passed, or the cart no longer exists
			$customer_id = (int) ( is_user_logged_in() ? get_user_option( Login::CUSTOMER_ID_META, get_current_user_id() ) : 0 );
			if ( $customer_id ) {
				$request->setCustomerId( $customer_id );
			}
			try {
				$cart    = $this->api->cartsPost( $request )->getData();
				$cart_id = $cart->getId();
				$this->set_cart_id( $cart_id );
			} catch ( ApiException $e ) {
				// request failed. cannot create a new cart
				$cart = null;
			}
		}
		if ( ! empty( $cart ) ) {
			$this->set_item_count_cookie( $cart );
		}

		return $cart;
	}

	public function sanitize_cart_id( $cart_id ) {
		if ( $cart_id ) {
			try {
				// make sure the cart is still there
				$cart = $this->api->cartsCartIdGet( $cart_id );
			} catch ( ApiException $e ) {
				if ( $e->getCode() == '404' ) {
					$cart_id = '';
				}
			}
		}

		return $cart_id;
	}

	/**
	 * Set a temporary cookie with the count of items
	 * in the cart. Front end will use it for updating
	 * the cart menu item.
	 *
	 * @param \BigCommerce\Api\v3\Model\Cart $cart
	 *
	 * @return void
	 */
	private function set_item_count_cookie( \BigCommerce\Api\v3\Model\Cart $cart ) {
		$count  = array_reduce(
			iterator_to_array( Cart_Item_Iterator::factory( $cart ) ),
			function ( $count, $item ) {
				if ( method_exists( $item, 'getParentId' ) && $item->getParentId() ) {
					return $count; // it's a child item, so don't count it
				}
				if ( method_exists( $item, 'getQuantity' ) ) {
					$count += $item->getQuantity();
				} else {
					$count += 1;
				}

				return $count;
			},
			0
		);
		$secure = ( 'https' === parse_url( home_url(), PHP_URL_SCHEME ) );
		setcookie( self::COUNT_COOKIE, $count, time() + MINUTE_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN, $secure );
	}

	public function get_cart_url() {
		$cart_page_id = get_option( Settings\Cart::OPTION_CART_PAGE_ID, 0 );
		if ( empty( $cart_page_id ) ) {
			$url = home_url( '/' );
		} else {
			$url = get_permalink( $cart_page_id );
		}

		/**
		 * Filter the URL to the cart page
		 *
		 * @param string $url     The URL to the cart page
		 * @param int    $page_id The ID of the cart page
		 */
		return apply_filters( 'bigcommerce/cart/permalink', $url, $cart_page_id );
	}

	/**
	 * @param string $cart_id The ID of the user's cart. Defaults to the ID found in the cart cookie
	 *
	 * @return string The URL for checking out with the given cart
	 */
	public function get_checkout_url( $cart_id ) {
		$cart_id = $cart_id ?: $this->get_cart_id();
		if ( empty( $cart_id ) ) {
			return '';
		}
		try {
			$redirects = $this->api->cartsCartIdRedirectUrlsPost( $cart_id )->getData();
		} catch ( ApiException $e ) {
			return '';
		}
		$checkout_url = $redirects[ 'checkout_url' ];
		$checkout_url = apply_filters( 'bigcommerce/checkout/url', $checkout_url );

		return $checkout_url;
	}
}