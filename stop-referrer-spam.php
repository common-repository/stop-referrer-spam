<?php
/**
 * Plugin Name: Stop Referrer Spam
 * Description: Blocks unwanted referral spam that mess up your analytics data!
 * Version: 1.3.2
 * Author: Krzysztof Wielogórski
 * Author URI: https://wielo.co
 * License: GPL2
 */

if (!defined('ABSPATH')) {
    die('Naughty, naughty!');
}

define('WSRS_PLUGIN_FILENAME', __FILE__);
define('WSRS_ROOT_DIR', __DIR__);

require_once(WSRS_ROOT_DIR.'/lib/WSRS_Initializer.php');
require_once(WSRS_ROOT_DIR.'/lib/WSRS_BlacklistHandler.php');
require_once(WSRS_ROOT_DIR.'/lib/WSRS_Config.php');
require_once(WSRS_ROOT_DIR.'/lib/WSRS_ConfigurationPage.php');
require_once(WSRS_ROOT_DIR.'/lib/WSRS_RequestHandler.php');
require_once(WSRS_ROOT_DIR.'/lib/WSRS_CronScheduler.php');
require_once(WSRS_ROOT_DIR.'/lib/WSRS_Helper.php');

(new WSRS_Initializer());
