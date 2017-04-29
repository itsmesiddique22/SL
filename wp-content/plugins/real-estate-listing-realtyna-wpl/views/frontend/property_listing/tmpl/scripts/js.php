<?php
/** no direct access **/
defined('_WPLEXEC') or die('Restricted access');
?>
<script type="text/javascript">
var wpl_ajax = <?php echo (wpl_global::check_addon('aps') ? wpl_global::get_setting('aps_ajax_listing') : 0); ?>;
var wpl_listing_request_str = '<?php echo wpl_global::generate_request_str(); ?>';
var wpl_listing_limit = <?php echo $this->model->limit; ?>;
var wpl_listing_total_pages = <?php echo $this->total_pages; ?>;
var wpl_listing_current_page = <?php echo $this->page_number; ?>;
var wpl_listing_last_search_time = 0;

/** CSS Class **/
var wpl_current_property_css_class = '<?php echo $this->property_css_class; ?>';

wplj(document).ready(function()
{
	main_win_size = wplj(window).width();
	if((main_win_size <= 480))
	{
		wplj('#wpl_property_listing_container .wpl_sort_options_container .wpl_sort_options_container_title').click(function()
		{
			wplj(this).next('ul').stop().slideToggle();
		});
	}

    if(!Modernizr.csstransitions)
    {
        wplj(".wpl_prp_top").hover(function()
        {
            wplj(this).children('.wpl_prp_top_boxes.front').hide();
        },
        function()
        {
            wplj(this).children('.wpl_prp_top_boxes.front').show();
        });
    }

    /** jQuery Triggers **/
    wpl_listing_set_js_triggers();
});

wplj(document).ajaxComplete(function()
{
    /** jQuery Triggers **/
   // wpl_listing_set_js_triggers();
});

wplj(window).resize(function()
{
	win_size = wplj(window).width();
	if((win_size <= 480))
	{
		wplj('#wpl_property_listing_container .wpl_sort_options_container .wpl_sort_options_container_title').unbind('click').click(function()
		{
			wplj(this).next('ul').slideToggle();
		});
	}
	else if(win_size > 480)
	{
		wplj('#wpl_property_listing_container .wpl_sort_options_container .wpl_sort_options_container_title').unbind('click');
		wplj('#wpl_property_listing_container .wpl_sort_options_container ul').show();
	}
});

function wpl_page_sortchange(order_string)
{
    order_obj = order_string.split('&');

    order_v1 = order_obj[0].split('=');
    order_v2 = order_obj[1].split('=');

    // AJAX
    if(wpl_ajax == '1')
    {
        //alert(wpl_current_property_css_class);
        wpl_listing_request_str = wpl_update_qs(order_v1[0], order_v1[1], wpl_listing_request_str);
        wpl_listing_request_str = wpl_update_qs(order_v2[0], order_v2[1], wpl_listing_request_str);

        wplj(".wpl_property_listing_list_view_container").fadeTo(300, 0.5);

		var request_str = 'wpl_format=f:property_listing:list&'+wpl_listing_request_str;
        var full_url = window.location.href;

        try {
            full_url = wpl_qs_apply(full_url, wpl_listing_request_str);
            history.pushState({search: 'WPL'}, "<?php echo addslashes(__('Search Results', 'wpl')); ?>", full_url);
        }
        catch (err) {
        }

        /** Load Markers **/
        if(typeof wpl_load_map_markers == 'function') wpl_load_map_markers(wpl_listing_request_str);

		wplj.ajax(
		{
			url: '<?php echo wpl_global::get_full_url(); ?>',
			data: request_str,
            dataType: 'json',
			type: 'GET',
			async: true,
			cache: false,
			timeout: 30000,
			success: function(data)
			{
                wplj.when( wplj(".wpl_property_listing_list_view_container").html(data.html) ).then(function() {
					wplj(".wpl-sort-options-selectbox .wpl_plist_sort").chosen({ width: 'initial' });

				});
                wplj(".wpl_property_listing_list_view_container").fadeTo(300, 1);
                if(typeof wpl_fix_no_image_size == 'function') setTimeout(function(){wpl_fix_no_image_size();}, 50);
                wpl_listing_enable_view(wpl_current_property_css_class);
			}
		});
    }
    // No AJAX
    else
    {
        url = window.location.href;

        url = wpl_update_qs(order_v1[0], order_v1[1], url);
        url = wpl_update_qs(order_v2[0], order_v2[1], url);

        /** Move to First Page **/
        url = wpl_update_qs('wplpage', '1', url);

        window.location = url;
    }
}

function wpl_pagesize_changed(page_size)
{
    // AJAX
    if(wpl_ajax == '1')
    {
        wpl_listing_request_str = wpl_update_qs('limit', page_size, wpl_listing_request_str);

        /** Move to First Page **/
        wpl_listing_request_str = wpl_update_qs('wplpage', '1', wpl_listing_request_str);

        wplj(".wpl_property_listing_list_view_container").fadeTo(300, 0.5);

		var request_str = 'wpl_format=f:property_listing:list&'+wpl_listing_request_str;
        var full_url = window.location.href;

        try {
            full_url = wpl_qs_apply(full_url, wpl_listing_request_str);
            history.pushState({search: 'WPL'}, "<?php echo addslashes(__('Search Results', 'wpl')); ?>", full_url);
        }
        catch (err) {
        }

        /** Load Markers **/
        if(typeof wpl_load_map_markers == 'function') wpl_load_map_markers(wpl_listing_request_str);

		wplj.ajax(
		{
			url: '<?php echo wpl_global::get_full_url(); ?>',
			data: request_str,
            dataType: 'json',
			type: 'GET',
			async: true,
			cache: false,
			timeout: 30000,
			success: function(data)
			{
                wplj.when( wplj(".wpl_property_listing_list_view_container").html(data.html) ).then(function() {
					wplj(".wpl-sort-options-selectbox .wpl_plist_sort").chosen({ width: 'initial' });
				});
                wplj(".wpl_property_listing_list_view_container").fadeTo(300, 1);

                if(typeof wpl_fix_no_image_size == 'function') setTimeout(function(){wpl_fix_no_image_size();}, 50);
                wpl_listing_enable_view(wpl_current_property_css_class);
			}
		});
    }
    // No AJAX
    else
    {
        url = window.location.href;
        url = wpl_update_qs('limit', page_size, url);

        /** Move to First Page **/
        url = wpl_update_qs('wplpage', '1', url);

        window.location = url;
    }
}

function wpl_paginate(page)
{
    // AJAX
    if(wpl_ajax == '1')
    {
        wpl_listing_request_str = wpl_update_qs('wplpage', page, wpl_listing_request_str);

        wplj(".wpl_property_listing_list_view_container").fadeTo(300, 0.5);

		var request_str = 'wpl_format=f:property_listing:list&'+wpl_listing_request_str;
        var full_url = window.location.href;

        try {
            full_url = wpl_qs_apply(full_url, wpl_listing_request_str);
            history.pushState({search: 'WPL'}, "<?php echo addslashes(__('Search Results', 'wpl')); ?>", full_url);
        }
        catch (err) {
        }

        /** Load Markers **/
        if(typeof wpl_load_map_markers == 'function') wpl_load_map_markers(wpl_listing_request_str);

		wplj.ajax(
		{
			url: '<?php echo wpl_global::get_full_url(); ?>',
			data: request_str,
            dataType: 'json',
			type: 'GET',
			async: true,
			cache: false,
			timeout: 30000,
			success: function(data)
			{
                wplj.when( wplj(".wpl_property_listing_list_view_container").html(data.html) ).then(function() {
					wplj(".wpl-sort-options-selectbox .wpl_plist_sort").chosen({ width: 'initial' });
				});
                wplj(".wpl_property_listing_list_view_container").fadeTo(300, 1);

                if(typeof wpl_fix_no_image_size == 'function') setTimeout(function(){wpl_fix_no_image_size();}, 50);
                wpl_listing_enable_view(wpl_current_property_css_class);
			}
		});
    }
    else
    {
        url = window.location.href;
        url = wpl_update_qs('wplpage', page, url);

        window.location = url;
    }
}

var wpl_set_property_css_class_once = false;
function wpl_set_property_css_class(pcc)
{
    /** Run this function only once **/
    if(wpl_set_property_css_class_once) return;
    else wpl_set_property_css_class_once = true;

    if((pcc == 'row_box' || pcc == 'grid_box') && typeof wpl_sp_selector_div != 'undefined')
    {
        /** Remove previous scroll listener **/
        wplj(wpl_sp_selector_div).off('scroll', wpl_scroll_pagination_listener);

        wpl_sp_selector_div = window;
        wpl_sp_append_div = '#wpl_property_listing_container';

        /** Add new scroll listener **/
        var wpl_scroll_pagination_listener = wplj(wpl_sp_selector_div).on('scroll', function()
        {
            wpl_scroll_pagination();
        });
    }
    else if(pcc == 'map_box' && typeof wpl_sp_selector_div != 'undefined')
    {
        /** Remove previous scroll listener **/
        wplj(wpl_sp_selector_div).off('scroll', wpl_scroll_pagination_listener);

        wpl_sp_selector_div = '.wpl_property_listing_listings_container';
        wpl_sp_append_div = '.wpl_property_listing_listings_container';

        /** Add new scroll listener **/
        var wpl_scroll_pagination_listener = wplj(wpl_sp_selector_div).on('scroll', function()
        {
            wpl_scroll_pagination();
        });
    }

    <?php if(isset($this->plisting_googlemap_activity_id) and $this->plisting_googlemap_activity_id): ?>
    // Resize the map
    if(typeof wpl_map<?php echo $this->plisting_googlemap_activity_id; ?> !== 'undefined')
    {
        setTimeout(function()
        {
            google.maps.event.trigger(wpl_map<?php echo $this->plisting_googlemap_activity_id; ?>, 'resize');
        }, 500);
    }
    <?php endif; ?>

    wpl_current_property_css_class = pcc;

    wplj.ajax(
    {
        url: '<?php echo wpl_global::get_full_url(); ?>',
        data: 'wpl_format=f:property_listing:ajax&wpl_function=set_pcc&pcc='+pcc,
        type: 'GET',
        dataType: 'json',
        cache: false,
        success: function(data)
        {
            wpl_set_property_css_class_once = false;
        }
    });
}


function wpl_listing_set_js_triggers()
{
    if(wplj(".wpl_property_listing_container").hasClass("wpl-property-listing-mapview"))
    {
        wplj("#wrapper #main_box").addClass("container_full_width");
    }
    else
    {
        wplj("#wrapper #main_box").removeClass("container_full_width");
    }
    wplj('#list_view').on('click', function()
    {
        wplj("#wrapper #main_box").removeClass("container_full_width");
        wplj('#grid_view, #map_view').removeClass('active');
        wplj('#list_view').addClass('active');

        wpl_set_property_css_class('row_box');

        wplj('.wpl_prp_cont').animate({opacity:0},function()
        {
            wpl_fix_no_image_size();

            <?php if(wpl_global::check_addon('aps')): ?>
            wplj('.wpl_property_listing_container').removeClass('wpl-property-listing-mapview');
            <?php endif; ?>

            wplj(this).removeClass('grid_box').removeClass('map_box').addClass('row_box');
			
			wplj('.wpl_property_listing_listings_container').removeClass('wpl-large-up-<?php echo $this->listing_columns; ?>').removeClass('wpl-medium-up-2').removeClass('wpl-small-up-1');

            wplj(this).stop().animate({opacity:1});
        });
    });

    wplj('#grid_view').on('click', function()
    {
        wplj("#wrapper #main_box").removeClass("container_full_width");
        wplj('#list_view, #map_view').removeClass('active');
        wplj('#grid_view').addClass('active');

        wpl_set_property_css_class('grid_box');

        wplj('.wpl_prp_cont').animate({opacity:0},function()
        {
            wpl_fix_no_image_size();

            <?php if(wpl_global::check_addon('aps')): ?>
            wplj('.wpl_property_listing_container').removeClass('wpl-property-listing-mapview');
            <?php endif; ?>

            wplj(this).removeClass('row_box').removeClass('map_box').addClass('grid_box');
			
			wplj('.wpl_property_listing_listings_container').addClass('wpl-large-up-<?php echo $this->listing_columns; ?>').addClass('wpl-medium-up-2').addClass('wpl-small-up-1');

            wplj(this).stop().animate({opacity:1});
        });
    });

    <?php if(wpl_global::check_addon('aps')): ?>

    wplj('#map_view').on('click', function()
    {

        wplj("#wrapper #main_box").addClass("container_full_width");
        wplj('#list_view, #grid_view').removeClass('active');
        wplj('#map_view').addClass('active');


        wpl_set_property_css_class('map_box');

        wplj('.wpl_property_listing_container').animate({opacity:0},function()
        {
            wpl_fix_no_image_size();

            wplj(this).addClass('wpl-property-listing-mapview');
            wplj('.wpl_prp_cont').removeClass('row_box').removeClass('grid_box').addClass('map_box');
			
			wplj('.wpl_property_listing_listings_container').removeClass('wpl-large-up-<?php echo $this->listing_columns; ?>').removeClass('wpl-medium-up-2').removeClass('wpl-small-up-1');

            wplj(this).stop().animate({opacity:1});
        });
    });
    <?php endif; ?>
}

function wpl_listing_enable_view(pcc)
{
    wpl_listing_set_js_triggers();
    if(pcc == 'grid_box')
    {
        wplj('#grid_view').trigger('click');
    }
    else if(pcc == 'row_box')
    {
        wplj('#list_view').trigger('click');
    }
    else if(pcc == 'map_box')
    {
        wplj('#map_view').trigger('click');
    }
}

function wpl_generate_rss()
{
    var rss = '';

    rss = wpl_update_qs('wplpage', '', wpl_listing_request_str);
    rss = wpl_update_qs('wplview', '', rss);
    rss = wpl_update_qs('wplpagination', '', rss);
    if(rss) rss = '?'+rss;

    window.open("<?php echo wpl_property::get_property_rss_link(); ?>"+rss);
}

function wpl_generate_print_rp()
{
    var prp = '';

    prp = wpl_update_qs('wplpage', '', wpl_listing_request_str);
    prp = wpl_update_qs('wplview', '', prp);
    prp = wpl_update_qs('wplpagination', '', prp);

    window.open("<?php echo wpl_property::get_property_print_link(); ?>?"+prp);
}

<?php if(wpl_global::check_addon('aps')): ?>
function map_view_toggle_listing()
{
	var proprty_listing_map_view_width = wplj('.wpl_property_listing_list_view_container').width();

    if(wplj('.map_view_handler').hasClass('op'))
    {
        wplj('.wpl_property_listing_list_view_container').animate({'margin-right': '-' + (proprty_listing_map_view_width - '30')}, function()
        {
            wplj('.map_view_handler').toggleClass('op');
            wplj('.wpl_property_listing_list_view_container').removeClass("open").addClass("close");
        });
    }
    else
    {
        wplj('.wpl_property_listing_list_view_container').animate({'margin-right': '0'}, function()
        {
            wplj('.map_view_handler').toggleClass('op');
            wplj('.wpl_property_listing_list_view_container').removeClass("close").addClass("open");
        });
    }
}

function wpl_generate_landing_page_generator()
{
    /** Open lightbox **/
    wplj._realtyna.lightbox.open("#wpl_landing_page_generator_link_lightbox", {reloadPage: false, cssClasses: {wrap : 'wpl-frontend-lightbox-wp'}});

    var ss = '';

    ss = wpl_update_qs('wplpage', '', wpl_listing_request_str);
    if(ss !== '') ss = wpl_update_qs('wplview', '', ss);

    var request_str = 'wpl_format=f:addon_aps:raw&wplmethod=landing_page'+(ss !== '' ? '&'+ss : '');
    var ajax = wpl_run_ajax_query('<?php echo wpl_global::get_wp_url(); ?>', request_str, false, 'HTML', 'GET');

	ajax.success(function(html)
	{
        wplj("#wpl_plisting_lightbox_content_container").html(html);
	});
}
<?php endif; ?>
</script>
