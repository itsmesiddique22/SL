<?php get_header(); 
$wl_theme_options = weblizar_get_options();
$wl_theme_options['_frontpage'];
$imageURL = get_option( 'siteurl' ) . "/wp-content/uploads/2017/10/opportunity-bg-1024x331.jpg";
if ($wl_theme_options['_frontpage']=="1" && is_front_page())
{	get_template_part('home','slideshow'); 
	
	
	
	
	if($wl_theme_options['portfolio_home'] == "1") {
	get_template_part('home','portfolio'); 
	}
?>
<!-- style="padding: 0 50px;width: 50%;
    text-align: center;
    margin: 0 auto;" -->
<div><h3>&nbsp;</h3>
	<div class="col-lg-12" style="background-image:url('<?php echo $imageURL; ?>');background-size: cover;">
<div class="col-lg-12 bgcolor"  >
<h2 class="text-center font-color-fff">Welcome to SkyLord</h2>

<hr class="hr-color" />

<p class="welcome-test" >At SkyLord we pride ourselves on providing a friendly yet professional service which caters for everybody.</p>
<p class="welcome-test" >
Whether you're buying or selling, are a landlord or a tenant, we will help you every step of the way. We know that our success as an agency is based on your success as a client, so we work very hard to provide a top quality service.</p>
<p class="welcome-test">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing </p>
</div>
</div>
<!-- <div class="col-lg-4">	
<img src="<?php echo $imageURL; ?>" class="img-responsive" alt="<?php echo $imageURL; ?>">
</div> -->
<div style="clear:both"></div>
</div>
<div><h3>&nbsp;</h3></div>
<?php 
        /*if($wl_theme_options['fc_home'] == "1") {
	get_template_part('footer','callout');
	}

	if($wl_theme_options['service_home'] == "1") {
	get_template_part('home','services'); 
	}*/
	get_footer();
}
 else 
{	
	if(is_page()){
	get_template_part('page');
	}else{
		get_template_part('index');
	}
}	?>