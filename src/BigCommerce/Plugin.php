<?php


namespace BigCommerce;

class Plugin {
	const VERSION = '0.11.1';

	protected static $_instance;

	/** @var \Pimple\Container */
	protected $container = null;

	/**
	 * @var Container\Provider[]
	 */
	private $providers = [];

	/**
	 * @param \Pimple\Container $container
	 */
	public function __construct( \Pimple\Container $container ) {
		$this->container = $container;
	}

	public function __get( $property ) {
		if ( array_key_exists( $property, $this->providers ) ) {
			return $this->providers[ $property ];
		}

		return null;
	}

	public function init() {
		$this->load_libraries();
		$this->load_functions();
		$this->load_service_providers();
	}

	private function load_libraries() {
	}

	private function load_functions() {
	}

	private function load_service_providers() {
		$this->providers[ 'accounts' ]          = new Container\Accounts();
		$this->providers[ 'analytics' ]         = new Container\Analytics();
		$this->providers[ 'api' ]               = new Container\Api();
		$this->providers[ 'assets' ]            = new Container\Assets();
		$this->providers[ 'cart' ]              = new Container\Cart();
		$this->providers[ 'cli' ]               = new Container\Cli();
		$this->providers[ 'compat' ]            = new Container\Compatibility();
		$this->providers[ 'currency' ]          = new Container\Currency();
		$this->providers[ 'customizer' ]        = new Container\Theme_Customizer();
		$this->providers[ 'forms' ]             = new Container\Forms();
		$this->providers[ 'gift_certificates' ] = new Container\Gift_Certificates();
		$this->providers[ 'import' ]            = new Container\Import();
		$this->providers[ 'pages' ]             = new Container\Pages();
		$this->providers[ 'post_types' ]        = new Container\Post_Types();
		$this->providers[ 'post_meta' ]         = new Container\Post_Meta();
		$this->providers[ 'rest' ]              = new Container\Rest();
		$this->providers[ 'rewrites' ]          = new Container\Rewrites();
		$this->providers[ 'schema' ]            = new Container\Schema();
		$this->providers[ 'settings' ]          = new Container\Settings();
		$this->providers[ 'shortcodes' ]        = new Container\Shortcodes();
		$this->providers[ 'taxonomies' ]        = new Container\Taxonomies();
		$this->providers[ 'templates' ]         = new Container\Templates();
		$this->providers[ 'widgets' ]           = new Container\Widgets();
		$this->providers[ 'editor' ]            = new Container\Editor();

		/**
		 * Filter the service providers the power the plugin
		 *
		 * @param Container\Provider[] $providers
		 */
		$this->providers = apply_filters( 'bigcommerce/plugin/providers', $this->providers );

		foreach ( $this->providers as $provider ) {
			$this->container->register( $provider );
		}
	}

	public function container() {
		return $this->container;
	}

	/**
	 * Determines is API credentials have been set, a prerequisite
	 * for much of the plugin functionality.
	 *
	 * @return bool
	 */
	public function credentials_set() {
		return apply_filters( 'bigcommerce/plugin/credentials_set', false );
	}

	/**
	 * @param null|\ArrayAccess $container
	 *
	 * @return self
	 * @throws \Exception
	 */
	public static function instance( $container = null ) {
		if ( ! isset( self::$_instance ) ) {
			if ( empty( $container ) ) {
				throw new \Exception( 'You need to provide a Pimple container' );
			}

			$className       = __CLASS__;
			self::$_instance = new $className( $container );
		}

		return self::$_instance;
	}
}