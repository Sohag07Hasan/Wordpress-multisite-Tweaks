<?php 

class MultiSiteTweaks{
	
	function __construct(){
		add_action('wpmu_new_blog', array(&$this, 'new_blog_just_created'), 10, 6);
	}
	
	function new_blog_just_created($blog_id, $user_id, $domain, $path, $site_id, $meta){
		
	}
	
}

