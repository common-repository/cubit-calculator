<?php

/**
 * Plugin Name:       Cubit Calculator Number Grid
 * Plugin URI:        https://cubit-calculator.one/
 * Description:       Add the Royal Cubit calculator number grid to your site as a shortcode
 * Version:           1.3.2
 * Requires at least: 6.2.0
 * Requires PHP:      8.1.0
 * Author:            Paul Faulkner
 * Author URI:        https://headwall-hosting.com/
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       cubit-calculator
 * Domain Path:       /languages
 */

defined('WPINC') || die();

const CUBIT_CALC_NAME = 'cubit-calculator';
const CUBIT_CALC_VERSION = '1.3.2';

define('CUBIT_CALC_DIR', trailingslashit(plugin_dir_path(__FILE__)));
define('CUBIT_CALC_URL', trailingslashit(plugin_dir_url(__FILE__)));

define('CUBIT_CALC_ASSETS_DIR', trailingslashit(CUBIT_CALC_DIR . 'assets'));
define('CUBIT_CALC_ASSETS_URL', trailingslashit(CUBIT_CALC_URL . 'assets'));

require_once CUBIT_CALC_DIR . 'constants.php';
require_once CUBIT_CALC_DIR . 'functions-private.php';

require_once CUBIT_CALC_DIR . 'includes/class-plugin.php';
require_once CUBIT_CALC_DIR . 'includes/shortcode-number-grid.php';

$cubit_calculator_plugin = new Cubit_Calculator\Plugin(CUBIT_CALC_NAME, CUBIT_CALC_VERSION);
$cubit_calculator_plugin->run();
