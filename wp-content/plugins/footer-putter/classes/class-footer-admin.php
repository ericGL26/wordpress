<?php
class Footer_Putter_Footer_Admin extends Footer_Putter_Admin{

	private $footer;
		
	function init() {
        $this->footer = $this->plugin->get_module('footer');
		add_action('admin_menu',array($this, 'admin_menu'));
	}

	function admin_menu() {
		$plugin_name = $this->get_name();
		$this->screen_id = add_submenu_page($this->get_parent_slug(), $plugin_name .' Footer', 'Footer', 'manage_options', $this->get_slug(), array($this,'page_content'));		
		add_action('load-'.$this->get_screen_id(), array($this, 'load_page'));
	}

	function page_content() {
		$title = $this->admin_heading(sprintf('%1$s (v%2$s)', $this->get_name(), $this->get_version()));			
		$this->print_admin_form($title, __CLASS__, $this->footer->get_keys()); 
	}   

	function load_page() {
 		if (isset($_POST['options_update'])) $this->save_footer();	
		$this->init_tooltips();
		$this->add_meta_box('introduction',  $this->message('section_footer_intro_title') , 'intro_panel');
		$this->add_meta_box('footer',  $this->message('section_footer_settings_title') , 'footer_panel', array ('options' => $this->options->get_options()));
		$this->add_meta_box('example',  $this->message('section_footer_preview_title'), 'preview_panel', null, 'advanced');
		$this->add_meta_box('news', $this->message('plugin_news'), 'news_panel', null, 'advanced');		
		add_action('admin_enqueue_scripts', array($this, 'enqueue_footer_styles'));
		add_action('admin_enqueue_scripts', array($this, 'enqueue_admin'));	
	}

	function enqueue_footer_styles() {
		wp_enqueue_style($this->get_code(), plugins_url('styles/footer-credits.css', dirname(__FILE__)), array(),$this->get_version());		
}		


	function save_footer() {
		check_admin_referer(__CLASS__);
		$settings = $this->message('settings_name');
		$saved = false;
  		$page_options = explode(',', stripslashes($_POST['page_options']));
  		if ($page_options) {
  			$options = $this->options->get_options();
    		foreach ($page_options as $option) {
       			$val = array_key_exists($option, $_POST) ? trim(stripslashes($_POST[$option])) : '';
       			switch ($option) {       			
                    case 'footer_remove' : $options[$option] = !empty($val); break;
                    case 'footer_hook': 
                    case 'footer_filter_hook': $options[$option] = preg_replace('/\W-\//','',$val); break;
					default: $options[$option] = trim($val); 	                    
                }
    		} //end for	;
            $saved =  $this->footer->save_options($options) ;
   			if ($saved)  {
            	$updated = true;
				$this->add_admin_notice($settings, $this->message('settings_saved'));
            } else {
      			$this->add_admin_notice($settings, $this->message('settings_unchanged'), true);
            }
  		} else {
         	$this->add_admin_notice($settings, $this->message('settings_not_found'), true);
  		}	
  		return $saved;
	}

 	function footer_panel($post,$metabox) {
        $this->add_tooltips($this->footer->get_keys());
        $options = $metabox['args']['options'];
        print $this->tabbed_metabox($metabox['id'], array(
            $this->message('tab_return') => $this->return_panel($options),
            $this->message('tab_advanced') => $this->advanced_panel($options)
		));
   }

 	function return_panel($options) {		 	
		return $this->fetch_text_field('return_text', $options['return_text'], array('size' => 20));		
	}

 	function advanced_panel($options) {		 	
		$url = 'https://www.diywebmastery.com/footer-credits-compatible-themes-and-hooks/';
        $twenty_something = ($theme = wp_get_theme()) && (strpos(strtolower($theme->get('Name')), 'twenty') !== FALSE);		
        return sprintf($this->message('advanced_instructions'), $url) .
            $this->fetch_text_field('footer_hook', $options['footer_hook'],  array('size' => 50)) .		
            $this->fetch_form_field('footer_remove', $options['footer_remove'], 'checkbox') .
            sprintf('<p>%1$s</p>', $this->message('remove_instructions')) . 
            $this->fetch_text_field('footer_filter_hook', $options['footer_filter_hook'],  array('size' => 50)). 
            ($twenty_something ? $this->fetch_form_field('hide_wordpress', $options['hide_wordpress'],  'checkbox') : '');
	} 


 	function preview_panel() {			
		printf ('<p><i>%1$s</i></p><hr/>%2$s', 
		  $this->message('preview_instructions'),
		  $this->footer->footer(array('nav_menu' => 'Footer Menu')));
	}

	function intro_panel() {	 	
		printf('<p>%1$s</p>', $this->message('intro_advanced_instructions'));
	}

}
