<?php
/**
 * Plugin Name: Slyde
 * Plugin URI: http://github.com/jimmyandrade/slyde
 * Description: A flexible WordPress plugin for slides management
 * Version: 1.1.1
 * Author: Paulo H. Jimmy Andrade Mota C.
 * Author URI: http://github.com/jimmyandrade/
 */
use jimmyandrade\Slyde;
use jimmyandrade\Slider_Widget;
$loader = require ( plugin_dir_path( __FILE__ ) . 'inc/class-slyde.php' );
Slyde::get_instance();
