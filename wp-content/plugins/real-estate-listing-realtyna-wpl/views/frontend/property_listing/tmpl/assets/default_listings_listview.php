<?php
/** no direct access **/
defined('_WPLEXEC') or die('Restricted access');
?>
<?php if(wpl_global::check_addon('aps')): ?>
<i id="map_view_handler" class="map_view_handler cl" style="display: none;" onclick="map_view_toggle_listing()">&nbsp;</i>
<?php endif; ?>
<div class="wpl_sort_options_container ">
    <div class="hd_cover custom-breadcrum"> 
    <div class="">
        <div class="row">
            <div class="col-md-12">
                <div class="padding-custom" >
                <?php echo '<span >'  . ' '. __('Properties To', 'wpl') . '</span>'?>
                <!-- BreadCrumb . $this->total_pages -->
                <?php the_title();?></div>
                 <span class="wpl-sort-options-list"><?php echo $this->model->generate_sorts(array('type'=>1, 'kind'=>$this->kind)); ?></span>
    <span class="wpl-sort-options-selectbox"><?php echo $this->model->generate_sorts(array('type'=>0, 'kind'=>$this->kind)); ?></span>
            </div>
        </div>
    </div>  
</div>
    <div class="wpl_sort_options_container_title">

    <!--<?php echo __('Sort Option', 'wpl'); ?>--></div>
    
    <!-- <span class="wpl-sort-options-list"><?php echo $this->model->generate_sorts(array('type'=>1, 'kind'=>$this->kind)); ?></span>
    <span class="wpl-sort-options-selectbox"><?php echo $this->model->generate_sorts(array('type'=>0, 'kind'=>$this->kind)); ?></span> -->

    <!-- <?php if($this->property_css_class_switcher): ?>
    <div class="wpl_list_grid_switcher <?php if($this->switcher_type == "icon+text") echo 'wpl-list-grid-switcher-icon-text'; ?>">
           <div id="grid_view" class="grid_view <?php if($this->property_css_class == 'grid_box') echo 'active'; ?>">
            <?php if($this->switcher_type == "icon+text") echo '<span>'.__('Grid', 'wpl').'</span>'; ?>
        </div>
        <div id="list_view" class="list_view <?php if($this->property_css_class == 'row_box') echo 'active'; ?>">
            <?php if($this->switcher_type == "icon+text") echo '<span>'.__('List', 'wpl').'</span>'; ?>
        </div>
        <?php if(wpl_global::check_addon('aps')): ?>
            <div id="map_view" class="map_view <?php if($this->property_css_class == 'map_box') echo 'active'; ?>">
                <?php if($this->switcher_type == "icon+text") echo '<span>'.__('Map', 'wpl').'</span>'; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php endif; ?> -->

    <?php if(wpl_global::check_addon('pro') and $this->listings_rss_enabled): ?>
    <div class="wpl-rss-wp">
        <a class="wpl-rss-link" href="#" onclick="wpl_generate_rss();"><span><?php echo __('RSS', 'wpl'); ?></span></a>
    </div>
    <?php endif; ?>
    
    <?php if(wpl_global::check_addon('pro') and $this->print_results_page): ?>
    <div class="wpl-print-rp-wp">
        <a class="wpl-print-rp-link" href="#" onclick="wpl_generate_print_rp();"><span><i class="fa fa-print"></i></span></a>
    </div>
    <?php endif; ?>
    
    <?php if(wpl_global::check_addon('save_searches')): ?>
    <div class="wpl-save-search-wp wpl-plisting-link-btn">
        <a id="wpl_save_search_link_lightbox" class="wpl-save-search-link" data-realtyna-href="#wpl_plisting_lightbox_content_container" onclick="return wpl_generate_save_search();" data-realtyna-lightbox-opts="title:<?php echo __('Save this Search', 'wpl'); ?>"><span><?php echo __('Save Search', 'wpl'); ?></span></a>
    </div>
    <?php endif; ?>
    
    <?php if(wpl_global::check_addon('aps') and wpl_global::get_setting('aps_landing_page_generator') and wpl_users::check_access('landing_page')): ?>
    <div class="wpl-landing-page-generator-wp wpl-plisting-link-btn">
        <a id="wpl_landing_page_generator_link_lightbox" class="wpl-landing-page-generator-link" data-realtyna-href="#wpl_plisting_lightbox_content_container" onclick="return wpl_generate_landing_page_generator();" data-realtyna-lightbox-opts="title:<?php echo __('Landing Page Generator', 'wpl'); ?>"><span><?php echo __('Create Landing Page', 'wpl'); ?></span></a>
    </div>
    <?php endif; ?>
</div>

<div class="wpl-row wpl-expanded <?php if($this->property_css_class == "grid_box") echo "wpl-small-up-1 wpl-medium-up-2 wpl-large-up-".$this->listing_columns; ?>  wpl_property_listing_listings_container clearfix">
    <?php echo $this->properties_str; ?>
</div>

<?php if($this->wplpagination != 'scroll'): ?>
<div class="wpl_pagination_container">
    <?php echo $this->pagination->show(); ?>
</div>
<?php endif; ?>