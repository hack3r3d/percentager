jQuery(document).ready(function() {
    var x = y = 0;
    
    jQuery('.percentager_input').keyup(function(data) {
        if (jQuery(this).attr('name') == 'x') {
            jQuery('.percentager_x_viewer').html(jQuery(this).val());
            x = jQuery(this).val();
        } else if (jQuery(this).attr('name') == 'y') {
            jQuery('.percentager_y_viewer').html(jQuery(this).val());
            y = jQuery(this).val();
        }
        
        var change = calc_percent_change(x, y);
        
        if (change > 0) {
            jQuery('.percentager_z_viewer').html(change + ' percent increase');
        } else if (change < 0) {
            jQuery('.percentager_z_viewer').html(change + ' percent decrease');
        }
    });
});

function calc_percent_change(x, y) {
    if (x > 0 && y > 0) {
        return (y - x)/x * 100;
    }
}