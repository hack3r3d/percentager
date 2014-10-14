<?php
/*
  Plugin Name: Percentager
  Plugin URI: http://percentager.take88.com
  Description: Percentager is a WordPress for calculating percentages
  Version: 1.0
  Author: Keith Vance
  Author URI: http://percentager.take88.com
  License: GPL2
  
  Copyright 2010  Keith Vance (email: keith@take88.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.
  
  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.
  
  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
require 'widget.php';
define('PERCENTAGER_ADMIN_NONCE', 'percentager-adminpanel-0123');

if (!class_exists("Percentager")) {
    class Percentager {
	var $adminOptionName;
	function __construct() {
	    $this->adminOptionName = 'Percentager';
	}
	
	function adminOptions() {
	    $options = array(
			     );
	    $currentOptions = get_option($this->adminOptionName);
	    if (!empty($currentOptions)) {
		foreach ($currentOptions as $option=>$value) {
		    $options[$option] = $value;
		}
	    }
	    update_option($this->adminOptionName, $options);
	    return $options;
	}
	
	function init() {
	    if (is_admin()) {
		$this->adminOptions();
	    }
            wp_enqueue_script("jquery");
            wp_register_script('percentager_js', plugins_url('/js/percentager.js', __FILE__), FALSE, '1.0.0', 'all');
            wp_register_style('percentager_style', plugins_url('/css/percentager.css', __FILE__), false, '1.0.0', 'all');
	}
        
        function enqueue_style() {
            wp_enqueue_script('percentager_js', FALSE, array('jquery'));
            wp_enqueue_style('percentager_style');
        }
        
        function view() {
            ?>
<div class="percentager">
<form>
    <fieldset><input class="percentager_input" size="5" type="text" id="percentager_x" placeholder="X" name="x" value="" /></fieldset>
    <fieldset><input class="percentager_input" size="5" type="text" name="y" value="" id="percentager_y" placeholder="Y" /></fieldset>
</form>
    <div style="clear:both"></div>
The difference between <span class="percentager_x_viewer">X</span> and <span class="percentager_y_viewer">Y</span> is a <span id="percentager_z1" class="percentager_z_viewer">Z</span>
</div>
<?php
        }
		
	function printAdminPanel() {
	    $options = $this->adminOptions();
	    if ($_POST['update_percentager_options']) {
		if (is_admin() && check_admin_referer(PERCENTAGER_ADMIN_NONCE) && $_POST['percentager_username']) {
                    //** do your thang **/
//		    $options['percentager_username'] = $_POST['percentager_username'];
		}
		update_option($this->adminOptionName, $options);
		?><div class="updated"><p><strong><?php _e("Settings Updated.", "Percentager"); ?></strong></p></div><?php
	    }
	    ?>
a	    <div class="wrapper">
	    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
	    <?php 
		 if (function_exists('wp_nonce_field')) {
		     wp_nonce_field(PERCENTAGER_ADMIN_NONCE);
		 }
	    ?>
		 <h2>Percentager Options</h2>
		 <!-- p>
		 <label name="percentager_username">YouTube Username: </label><input type="text" size="25" name="percentager_username" value="<?php _e(apply_filters('format_to_edit', $options['percentager_username']), 'BoobTube') ?>" />
		 <br / -->
            </form>
	    </div>
<?php
	}
    }
}

if (class_exists("Percentager")) {
    $percentager = new Percentager();
}

if (isset($percentager)) {
    add_action('init', array(&$percentager, 'init'));
    add_action('wp_enqueue_scripts', array(&$percentager, 'enqueue_style'));
    add_action('admin_menu', 'Percentager_AdminPanel');
    add_action('widgets_init', 'Percentager_Widget');
}

if (!function_exists('Percentager_Widget')) {
    function Percentager_Widget() {
	register_widget('Percentager_Widget');
    }
}

if (!function_exists('Percentager_AdminPanel')) {
    function Percentager_AdminPanel() {
	if (!$GLOBALS['percentager']) {
	    return;
	}
    
	if (function_exists('add_options_page')) {
	    add_options_page('Percentager Admin Panel', 'Percentager', 9, basename(__FILE__), array(&$GLOBALS['percentager'], 'printAdminPanel'));
	}
    }
}
