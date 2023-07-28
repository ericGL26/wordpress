<?php
class Footer_Putter_Dashboard extends Footer_Putter_Admin {
	private $settings = array();

	function init() {
		add_action('admin_menu', array($this, 'admin_menu'));
		add_filter('plugin_action_links',array($this, 'plugin_action_links'), 10, 2 );
		add_action('admin_enqueue_scripts', array($this ,'register_tooltip_styles'));
		add_action('admin_enqueue_scripts', array($this ,'register_admin_styles'));
		add_action('load-widgets.php', array($this, 'add_tooltip_support'));
	}

	function admin_menu() {
	   $this->screen_id = add_menu_page($this->get_name(), $this->get_name(), 'manage_options', 
			$this->get_slug(), array($this,'page_content'), $this->icon);
		$intro = $this->message('menu_dashboard');				
		add_submenu_page($this->plugin->get_slug(), $this->get_name(), $intro, 'manage_options', $this->get_slug(), array($this, 'page_content') );
		add_action('load-'.$this->get_screen_id(), array($this, 'load_page'));
	}

	function page_content() {
		$title = $this->admin_heading(sprintf('%1$s (v%2$s)', $this->get_name(), $this->get_version()));		
		$this->print_admin_form($title, __CLASS__); 
	} 

	function load_page() {
		$this->init_tooltips();
 		add_action ('admin_enqueue_scripts',array($this, 'enqueue_admin'));		
		$this->add_meta_box('overview', $this->message('section_overview_title'), 'overview_panel');
		$this->add_meta_box('details',$this->message('section_details_title'), 'details_panel');
		$this->add_meta_box('news', $this->message('plugin_news'), 'news_panel', null, 'advanced');
	}

	function overview_panel($post, $metabox) {
      print $this->tabbed_metabox($metabox['id'],  array (
         $this->message('tab_intro') => $this->intro_panel(),
         $this->message('tab_features') => $this->features_panel(),
         $this->message('tab_version') => $this->version_panel(),
         $this->message('tab_help') => $this->help_panel(),
      ));
   }

	function intro_panel() {
		return sprintf('<p>%1$s</p>', $this->message('plugin_description'));
	}

	function features_panel() {
		return $this->message('plugin_features');
	}
	
   	function version_panel() {
		return sprintf('<p>%1$s %2$s</p>', 
		  sprintf($this->message('plugin_version'), $this->get_name(), $this->get_version()), 
		  sprintf($this->message('plugin_changelog'),$this->plugin->get_changelog()) ); 
	}
	
	function help_panel() {
		return sprintf($this->message('plugin_help'), $this->plugin->get_home());
    }


 	function details_panel($post,$metabox) {
		print $this->tabbed_metabox($metabox['id'], array(
         $this->message('tab_widgets') => $this->widgets_panel(),
         $this->message('tab_instructions') => $this->instructions_panel(),
         $this->message('tab_hooks') =>  $this->hooks_panel(),
         $this->message('tab_links') =>  $this->links_panel()
		));
   }
		
	function widgets_panel() {
    	return $this->message('help_widgets');
    }

	function instructions_panel() {; 
    	return  $this->message('help_pages').
    	   sprintf($this->message('help_update_business_information'), $this->plugin->get_module('credits', true)->get_url()) .
    	   sprintf($this->message('help_create_trademark_links'), $this->plugin->get_module('trademarks', true)->get_url()) .    	   
    	   sprintf($this->message('help_setup_footer_widgets'), admin_url('widgets.php'));
	}
	
	function hooks_panel() {
    	return $this->message('help_hooks');
	}
	
	function links_panel() {
 		return sprintf($this->message('help_links'),$this->plugin->get_home() ) ;
	}
	
}
