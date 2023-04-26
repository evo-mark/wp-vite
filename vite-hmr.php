<?php

/**
 * Plugin Name: Vite HMR
 * Plugin URI: https://southcoastweb.co.uk
 * Description: Additional Wordpress functionality for the southcoastweb website.
 * Version: 1.0.0
 * Author: southcoastweb
 * Author URI: https://southcoastweb.co.uk
 * License: None
 * Text Domain: scw-vite-hmr
 *
 * @package scw-vite-hmr
 */

require_once "vendor/autoload.php";

use Southcoastweb\WordpressVite\WpVite;

WpVite::run();
