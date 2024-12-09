<?php
/**
 * The logger class using monolog
 *
 * This file contain class that handler the monolog logger .
 *
 * @link       https://junaidbinjaman.com
 * @since      1.0.0
 *
 * @package    Drd
 * @subpackage Drd/includes
 */

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The plugin Logger Class
 *
 * @since      1.0.0
 * @package    Drd
 * @subpackage Drd/includes
 * @author     Junaid Bin Jaman <junaid@allnextver.com>
 */
class Drd_Logger {

	/**
	 * The logger instance
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      Drd_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	private static $logger = null;

	/**
	 * Get the Monolog Logger instance
	 *
	 * @return Logger
	 */
	public static function get_logger() {
		if ( null === self::$logger ) {
			self::$logger = new Logger( 'your_plugin' );

			// Log to a file in the plugin directory.
			$log_file = plugin_dir_path( __FILE__ ) . '../app.log';
			self::$logger->pushHandler( new StreamHandler( $log_file, Logger::DEBUG ) );
		}

		return self::$logger;
	}

	/**
	 * Log info messages
	 *
	 * @param string $message The log message.
	 * @param array  $context The log context.
	 */
	public static function info( $message, $context = array() ) {
		self::get_logger()->info( $message, $context );
	}

	/**
	 * Log error messages
	 *
	 * @param string $message The log message.
	 * @param array  $context The log context.
	 */
	public static function error( $message, $context = array() ) {
		self::get_logger()->error( $message, $context );
	}

	/**
	 * Log error messages
	 *
	 * @param string $message The log message.
	 * @param array  $context The log context.
	 */
	public static function debug( $message, $context = array() ) {
		self::get_logger()->debug( $message, $context );
	}
}
