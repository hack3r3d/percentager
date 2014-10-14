<?php
class Percentager_Widget extends WP_Widget {
	function Percentager_Widget() {
	    $widget_ops = array('classname' => 'percentager', 'description' => 'Calculates percentages');
	    $control_ops = array('width' => '300', 'height' => '350', 'id_base' => 'percentager-widget');
	    $this->WP_Widget('percentager-widget', 'Percentager', $widget_ops, $control_ops);
	}
 
	function widget($args, $instance) {
	    extract($args);
	    $title = apply_filters('widget_title', $instance['title'] );
	    // Controlled by theme.
	    echo $before_widget;
	    if ($title) {
		echo $before_title . $title . $after_title;
	    }
	    $percentager =& $GLOBALS['percentager'];
	    $percentager->view();
	    // Controlled by theme.
	    echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
	    $instance = $old_instance;
	    $instance['title'] = strip_tags($new_instance['title']);
	    return $instance;
	}
 
	function form($instance) {
	    $defaults = array( 'title' => 'Percent Change Calculator');
	    $instance = wp_parse_args((array) $instance, $defaults);
	    $title = htmlspecialchars($instance['title']);
	    echo "<p>\n<label for=\"" . $this->get_field_name('title') . "\">Title:</label>\n";
	    echo "\n<input type=\"text\" id=\"" . $this->get_field_id('title') . "\" name=\"" . $this->get_field_name('title') . "\" value=\"" . $title . "\" style=\"width:100%\" />\n</p>\n";
	}
}
?>