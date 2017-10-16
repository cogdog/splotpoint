jQuery(document).ready(function () {
 
    jQuery(document).keydown(function(e) {
        var url = false;
        
		switch(e.which) {
			case 37: // Left arrow key code - go prev
				url = jQuery('.nav-previous a').attr('href');
				break;
			case 38: // up arrow key code - go home
				url = jQuery('.site-title a').attr('href');
				break;
			case 39: // right arrow key code - go next
				url = jQuery('.nav-next a').attr('href');
				break;	
		}        
        
        if (url) {
            window.location = url;
        }
    });
 });
