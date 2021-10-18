<?php
/**
 * Plugin Name: Flying Analytics by FlyingPress
 * Plugin URI: https://wordpress.org/plugins/flying-analytics/
 * Description: Load Optimized & Self-hosted Google Analytics
 * Author: FlyingPress
 * Author URI: https://flying-press.com/
 * Version: 2.0.2
 * Text Domain: flying-analytics
 */

defined('ABSPATH') or die('Bye!');
define('FLYING_ANALYTICS_VERSION', '2.0.2');

require 'vendor/autoload.php';
FlyingAnalytics\Settings::init();
FlyingAnalytics\JavaScript::init();
FlyingAnalytics\Shortcuts::init();
