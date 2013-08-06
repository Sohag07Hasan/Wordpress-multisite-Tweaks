<?php 

//do not change anything to the class if you don't know php
class SimpleWpRoleCap{
	private $capabilities;
	
	//constructor
	function __construct($cap){
		$this->capabilities = $cap;
		register_activation_hook(MSTWEAK_FILE, array(&$this, 'activate_the_plugin'));
		register_deactivation_hook(MSTWEAK_FILE, array(&$this, 'deactivate_the_plugin'));
		//add_action('init', array(&$this, 'activate_the_plugin'));
	}
	
	
	//fires during activation process is going on
	function activate_the_plugin(){
		
		$users = $this->get_users(array( 'role' => 'Administrator' ));
		
		if($users){
			foreach($users as $user){
				foreach($this->capabilities as $cap){
					$user->add_cap($cap);
				}
			}
		}
				
	}
	
	
	//fires during deactivation
	function deactivate_the_plugin(){
		
		$users = $this->get_users(array( 'role' => 'Administrator' ));
					
		if($users){
			foreach($users as $user){
				foreach($this->capabilities as $cap){
					$user->remove_cap($cap);
				}
			}
		}
		
	}
	
	
	//get users using WP_User_Query class
	function get_users($args){
		$users_query = new WP_User_Query($args);
		return $users_query->get_results();
	}
	
}


include MSTWEAK_DIR . 'configuration/role-capabilities.inc';

return new SimpleWpRoleCap($capabilities);
