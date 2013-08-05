<?php 

/**
 * Plugin Name: Multisite Tweaks
 * Author: Mahibul Hasan Sohag
 * Description: Add new capabilites, Add some testimonials, Add some pages, Add a nav menu using those pages
 * */

define("MSTWEAK_FILE", __FILE__);
define("MSTWEAK_DIR", dirname(__FILE__) . '/');

//role capabilities management
include MSTWEAK_DIR . 'classes/role-cap-manager.php';

//other things
include MSTWEAK_DIR . 'classes/class.multisite_stuffs.php';

?>