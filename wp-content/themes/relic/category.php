<?php
/**
 * The Category template file
 * */
get_header();
$relic_category = single_term_title("", false);
?>
<section>
  <div class="breadcumb-bg">
    <div class="webpage-container container">
      <div class="site-breadcumb">				
        <h1><?php _e('Category ', 'relic'); echo ": " . $relic_category;?></h1> 				
        <ol class="breadcrumb breadcrumb-menubar">
<?php if (function_exists('relic_custom_breadcrumbs')) relic_custom_breadcrumbs(); ?>
        </ol>
      </div>
    </div>
  </div>    
  <div class="webpage-container"> 
    <div class="property-blog-page">
      <?php 
      
        get_template_part('content', get_post_format());  
      ?>
      <?php get_sidebar(); ?>
    </div>
  </div> 
</section>
<?php get_footer(); ?>
