<?php

class Footer_Putter_Trademarks_Admin extends Footer_Putter_Admin{

	public function init() {
		add_action('admin_menu',array($this, 'admin_menu'));
	}

	public function admin_menu() {
		$plugin_name = $this->get_name();
		$this->screen_id = add_submenu_page($this->get_parent_slug(), $plugin_name .' Trademarks', $this->message('menu_trademarks'), 'manage_options', 
			$this->get_slug(), array($this,'page_content'));
		add_action('load-'.$this->get_screen_id(), array($this, 'load_page'));			
	}

	public function page_content() {
 		$title = $this->admin_heading('Footer Trademarks');				
		$this->print_admin_form($title, __CLASS__); 
	} 	

	public function load_page() {
		$this->add_tooltip_support();
		$this->add_meta_box('trademarks', $this->message('section_trademarks_instructions_title'),  'trademarks_panel');
		$this->add_meta_box('news', $this->message('plugin_news'), 'news_panel', null, 'advanced');		
		add_action ('admin_enqueue_scripts',array($this, 'enqueue_admin'));	
	}

 	function trademarks_panel($post, $metabox) {       
        print $this->tabbed_metabox( $metabox['id'], array( 
            $this->message('tab_trademarks_instructions') => $this->instructions_panel(), 
            $this->message('tab_trademarks_tips') => $this->tips_panel(), 
            $this->message('tab_trademarks_screenshots') => $this->screenshots_panel()));
    }

	function instructions_panel() {
		$linkcat = admin_url('edit-tags.php?taxonomy=link_category');
		$addlink = admin_url('link-add.php');
		$widgets = admin_url('widgets.php');
		return sprintf($this->message('trademarks_intro'), $linkcat, $addlink, $widgets);
	}  

	function tips_panel() {
		return $this->message('trademarks_tips');
	}  
	 
	function screenshots_panel() {
		$img1 = plugins_url('images/add-link-category.jpg',dirname(__FILE__));		
		$img2 = plugins_url('images/add-link.jpg',dirname(__FILE__));
		return sprintf($this->message('trademarks_screenshots'), $img1, $img2);
	}

}