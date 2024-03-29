<?php


namespace BigCommerce\Settings;


use BigCommerce\Import\Runner\Cron_Runner;
use BigCommerce\Import\Runner\Status;

/**
 * Class Import_Status
 *
 * Displays the import status on the settings page after the import button
 */
class Import_Status {
	/**
	 * @return void
	 * @action bigcommerce/settings/render/frequency
	 */
	public function render_status() {

		$current  = $this->current_status();
		$previous = $this->previous_status();
		$next     = $this->next_status();

		if ( $current[ 'message' ] ) {
			printf( '<div class="notice notice-info"><p class="import-status import-status-current">%s</p></div>', $current[ 'message' ] );
		}
		if ( $previous[ 'message' ] ) {
			$previous_output = sprintf( '<p class="import-status import-status-previous">%s</p>', $previous[ 'message' ] );
			if ( $previous[ 'status' ] === Status::FAILED ) {
				$previous_output = sprintf( '<div class="notice notice-error">%s</div>', $previous_output );
			}
			echo $previous_output;
		}
		if ( $next[ 'message' ] ) {
			printf( '<p class="import-status import-status-next">%s</p>', $next[ 'message' ] );
		}

	}

	/**
	 * @return array The message describing the current import and the status string
	 */
	private function current_status() {
		$status  = new Status();
		$current = $status->current_status();
		if ( $current[ 'status' ] === Status::NOT_STARTED ) {
			return [
				'message' => '',
				'status'  => $current[ 'status' ],
			];
		}

		switch ( $current[ 'status' ] ) {
			case Status::FETCHING_PRODUCT_IDS:
			case Status::FETCHED_PRODUCT_IDS:
				$status_string = __( 'Fetching product IDs from BigCommerce API', 'bigcommerce' );
				break;
			case Status::MARKING_DELETED_PRODUCTS:
			case Status::MARKED_DELETED_PRODUCTS:
				$status_string = __( 'Identifying products to remove from WordPress', 'bigcommerce' );
				break;
			case Status::PROCESSING_QUEUE:
			case Status::PROCESSED_QUEUE:
				$remaining     = $this->get_remaining_in_queue();
				$status_string = sprintf( __( 'Importing products. %d remaining.', 'bigcommerce' ), $remaining );
				break;
			case Status::FETCHING_STORE:
			case Status::FETCHED_STORE:
				$status_string = __( 'Fetching currency settings', 'bigcommerce' );
				break;
			default:
				$status_string = '';
				break;
		}

		if ( empty( $status_string ) ) {
			$status_string = __( 'Import in progress.', 'bigcommerce' );
		} else {
			$status_string = sprintf( __( 'Import in progress. Status: %s', 'bigcommerce' ), $status_string );
		}

		return [
			'message' => apply_filters( 'bigcommerce/settings/import_status/current', $status_string, $current[ 'status' ], $current[ 'timestamp' ] ),
			'status'  => $current[ 'status' ],
		];
	}

	/**
	 * @return array The message describing the previous import and the status string
	 */
	private function previous_status() {
		$status    = new Status();
		$previous  = $status->previous_status();
		$timestamp = strtotime( get_date_from_gmt( date( 'Y-m-d H:i:s', (int) $previous[ 'timestamp' ] ) ) );
		$date      = date_i18n( get_option( 'date_format', 'Y-m-d' ), $timestamp, false );
		$time      = date_i18n( get_option( 'time_format', 'H:i' ), $timestamp, false );
		switch ( $previous[ 'status' ] ) {
			case Status::COMPLETED:
				$status_string = sprintf( __( 'Last import completed on %s at %s', 'bigcommerce' ), $date, $time );
				break;
			case Status::FAILED:
				$status_string = sprintf( __( 'Last import failed on %s at %s', 'bigcommerce' ), $date, $time );
				break;
			case Status::NOT_STARTED:
				$status_string = '';
				break;
			default:
				$status_string = __( 'Last import did not finish.', 'bigcommerce' );
				break;
		}

		return [
			'message' => apply_filters( 'bigcommerce/settings/import_status/previous', $status_string, $previous[ 'status' ], $previous[ 'timestamp' ] ),
			'status'  => $previous[ 'status' ],
		];

	}

	/**
	 * @return array The message describing the next import and the status string
	 */
	private function next_status() {
		$next = wp_next_scheduled( Cron_Runner::START_CRON );
		if ( $next ) {
			$timestamp     = strtotime( get_date_from_gmt( date( 'Y-m-d H:i:s', (int) $next ) ) );
			$date          = date_i18n( get_option( 'date_format', 'Y-m-d' ), $timestamp, false );
			$time          = date_i18n( get_option( 'time_format', 'H:i' ), $timestamp, false );
			$status_string = sprintf( __( 'Next import scheduled to start on %s at %s', 'bigcommerce' ), $date, $time );
		} else {
			$status_string = ''; // an import is probably in progress
		}

		return [
			'message' => apply_filters( 'bigcommerce/settings/import_status/previous', $status_string, $next ),
			'status'  => $next,
		];

	}

	/**
	 * @return int The number of records remaining in the import queue
	 */
	private function get_remaining_in_queue() {
		/** @var \wpdb $wpdb */
		global $wpdb;
		$count = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->bc_import_queue}" );

		return (int) $count;
	}
}