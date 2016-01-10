<script type="text/javascript">

    // get offset of the div from top
    var marker = jQuery('div.bottom-tools');
    var marker_offset = marker.offset();
    
    var window_height = jQuery(window).height();
    var window_width = jQuery(window).width();
    
    var fblike_pop_in_yPos = marker_offset.top - window_height - 300;
    
    var on_off_toggle = 'on';
    
    var off_forever_cookie = String( jQuery.cookie('fb_like_widget_off_forever') );
    console.log( 'Off forever cookie: ' + off_forever_cookie );
    
    if( off_forever_cookie == 'true' ){
        var off_forever = true;
    } else {
        var off_forever = false;
    }
    
    function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
            vars[key] = value;
        });
        return vars;
    }
    
    function toggle(){
                
        if( off_forever == false ){
            
            var elem = jQuery('#like_alternet_on_fb');
            
            elem.animate({
                marginLeft: parseInt(elem.css('marginLeft'),10) == 0 ? elem.outerWidth() : 0
            }, 500);
                                    
            if( on_off_toggle == 'on' ){
                on_off_toggle = 'off';
            } else {
                on_off_toggle = 'on';
            }
        }
        
    }
    
    function calculate_slide_div_top_offset(){
        return ( jQuery(window).height() / 4 ) * 3 + 'px';
    }
    
    function calculate_slide_div_left_offset(){
        return jQuery(window).width() - 460 + 'px';    
    }
    
    function turn_off_forever(){
        
        console.log('off_forever');
        toggle();
        off_forever = true;
        
        /* SET COOKIE */
        jQuery.cookie('fb_like_widget_off_forever', off_forever, { path: '/', expires: 1209600 }); 
        
    }
    
    function create_slide_div(){
        
                var html = '<div id="like_alternet_on_fb"><div style="margin: 10px 25px;"><div style="float:right" onclick="turn_off_forever();">[ X ]<div class="clear:both;"></div></div><div style="margin: 5px 0px; font-size: 12px;">Like Alternet Drugs on Facebook</div><iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2FAlterNetDrugs&amp;send=false&amp;layout=standard&amp;width=450&amp;show_faces=true&amp;font=arial&amp;colorscheme=light&amp;action=like&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:80px;" allowTransparency="true"></iframe></div></div>';
        jQuery('#root_subfooter').before( html );
        
        var slide_top_offset = calculate_slide_div_top_offset();
        var slide_left_offset = calculate_slide_div_left_offset();
        
        jQuery('#like_alternet_on_fb')
            .css('position','fixed')
            .css('top','-150px')
            .css('width','450px')
            .css('height','115px')
            .css('background','#E8E8FB')
            .css('border','10px solid #223BBE')
            .css('border-right','0px');
                                           
        toggle();
        
    }   
    
    function resize_slide_div(){
        
        var slide_top_offset = calculate_slide_div_top_offset();
        var slide_left_offset = calculate_slide_div_left_offset();
        jQuery('#like_alternet_on_fb')
            .css('top',slide_top_offset)
            .css('left',slide_left_offset);
        
    }
    
    /* HOOK SCRIPT INTO EVENTS */
    
    var paging = String( getUrlVars()["page"] );
    
    if( paging == 'off' ){
        var is_paging_off = true;
    } else {
        var is_paging_off = false;
    }
    
    //console.log( 'Is paging off ? [' + is_paging_off + '] ' + getUrlVars()["paging"] );
    
    var page = String( getUrlVars()["page"] );
    
    if( page == 'undefined' ){
        var is_first_page = true;
    } else {
        var is_first_page = false;
    }
    
    //console.log( 'Is first page ? [' + is_first_page + '] ' + page );

    jQuery(window).scroll(function() {
        
        var fblike_scrollYpos = jQuery(document).scrollTop();
        
        if( fblike_scrollYpos >= fblike_pop_in_yPos && on_off_toggle == 'off' ){
            toggle();
        }
        
        if( fblike_scrollYpos <= fblike_pop_in_yPos && on_off_toggle == 'on' ){
            toggle();   
        }
        
    });
    
    jQuery(window).ready(function(){
        console.log( "off_forever: " + off_forever );
        if( off_forever == false ){
            create_slide_div();
            timeoutID = window.setTimeout(resize_slide_div, 2000);
        }
    })
    
    jQuery(window).resize(function() {
        resize_slide_div();
    });
    
</script>