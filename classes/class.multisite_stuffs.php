<?php 

class MultiSiteTweaks{
	
	private $pages = array();
	private $testimonials = array();
	
	private $menu_name;
	private $theme_location;
	
	function __construct($pages, $testimonials, $nav_menu){
		$this->pages = $pages;
		$this->testimonials = $testimonials;
		$this->menu_name = $nav_menu['name'];
		$this->theme_location = $nav_menu['theme_location'];
		
		//hooks
		add_action('wpmu_new_blog', array(&$this, 'new_blog_just_created'), 10, 6);
	}
	
	function new_blog_just_created($blog_id, $user_id, $domain, $path, $site_id, $meta){
		//change to current blog
		switch_to_blog($blog_id);
		
		//creation of new pages
		$success_pages = array();
		if(count($this->pages) > 0){
			foreach($this->pages as $page){
				$args = array(
							'post_title' => $page['title'],
							'post_content' => $page['content'],
							'post_author' => $user_id,
							'post_status' => 'publish',
							'post_type' => 'page'
						);
				$success_pages[] = wp_insert_post($args);
			}
		}
		
		//nav menus
		$menu_exists = wp_get_nav_menu_object( $this->menu_name );
		if(!$menu_exists){
			$menu_id = wp_create_nav_menu($this->menu_name);
		}
		else{
			$menu_id = $menu_exists->term_id;
		}
		
		if(count($success_pages) > 0){
			foreach($success_pages as $su_p){
				$page = get_post($su_p);
				wp_update_nav_menu_item($menu_id, 0, array(
					'menu-item-title' => $page->post_title,
					'menu-item-status' => 'publish',
					'menu-item-url' => get_permalink($page->ID)
				));
			}
		}
		
		//registering the menu
		
		
		
		//testimonial categories add
		if(count($this->testimonials) > 0){
			foreach($this->testimonials as $t){
				wp_insert_term($t, 'testimonial-category');
			}
		}
		
		//restore the previous state
		restore_current_blog();
	}
	
}


//including configuration scripts
include MSTWEAK_DIR . 'configuration/pages-navmenus-testimonials.inc';
return new MultiSiteTweaks($pages, $testimonials, $nav_menu);