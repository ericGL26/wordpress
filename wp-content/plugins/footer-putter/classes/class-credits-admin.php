<?php
class Footer_Putter_Credits_Admin extends Footer_Putter_Admin{

	private $credits;
		
	function init() {
        $this->credits = $this->plugin->get_module('credits');
		add_action('admin_menu',array($this, 'admin_menu'));
	}

	function admin_menu() {
		$plugin_name = $this->get_name();
		$this->screen_id = add_submenu_page($this->get_parent_slug(), $plugin_name .' Credits', $this->message('menu_credits'), 'manage_options', $this->get_slug(), array($this,'page_content'));		
		add_action('load-'.$this->get_screen_id(), array($this, 'load_page'));
	}

	function page_content() {
		$title = $this->admin_heading(sprintf('%1$s (v%2$s)', $this->get_name(), $this->get_version()));			
		$this->print_admin_form($title, __CLASS__, $this->credits->get_keys()); 
	}   

	function load_page() {
 		if (isset($_POST['options_update'])) $this->save_credits();	
		$this->init_tooltips();
		$this->add_meta_box('introduction',  $this->message('section_credits_intro_title') , 'intro_panel');
		$this->add_meta_box('credits',   $this->message('section_credits_settings_title') , 'credits_panel', array ('options' => $this->credits->get_options()));
		$this->add_meta_box('news', $this->message('plugin_news'), 'news_panel', null, 'advanced');				add_action('admin_enqueue_scripts', array($this, 'enqueue_credits_styles'));
		add_action('admin_enqueue_scripts', array($this, 'enqueue_admin'));	
	}

	function enqueue_credits_styles() {
		wp_enqueue_style($this->get_code(), plugins_url('styles/footer-credits.css', dirname(__FILE__)), array(),$this->get_version());		
}		


	function save_credits() {
		check_admin_referer(__CLASS__);
		$settings = $this->message('settings_name');
		$saved = false;
  		$page_options = explode(',', stripslashes($_POST['page_options']));
  		if ($page_options) {
  			$options = $this->credits->get_options();
    		foreach ($page_options as $option) {
       			$val = array_key_exists($option, $_POST) ? trim(stripslashes($_POST[$option])) : '';
				$options[$option] = $val;
    		} //end for	;
            $saved =  $this->credits->save_options($options) ;
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

 	function credits_panel($post,$metabox) {
        $this->add_tooltips($this->credits->get_keys());
        $options = $metabox['args']['options'];
        $tabs = array(
            $this->message('tab_owner') => $this->owner_panel($options),
            $this->message('tab_address') => $this->address_panel($options));
        if ($this->utils->is_html5()) $tabs += array($this->message('tab_geo') => $this->geo_panel($options));
        $tabs += array(
            $this->message('tab_contact') => $this->contact_panel($options),
            $this->message('tab_legal') => $this->legal_panel($options));
        print $this->tabbed_metabox($metabox['id'], $tabs);
   }


	function owner_panel($terms) {
      return $this->fetch_text_field('owner', $terms['owner'], array('size' =>30)) . 		
         $this->fetch_text_field('country', $terms['country'], array('size' => 30)) ;
	}

	function address_panel($terms) {
        $s = $this->fetch_form_field('address', $terms['address'], 'textarea', array(), array('cols' => 30, 'rows' => 5));		
        if ($this->utils->is_html5()) {
        return $s .
			   $this->message('address_instructions').
			   $this->fetch_text_field('street_address', $terms['street_address'],  array('size' => 30)) .
			   $this->fetch_text_field('locality', $terms['locality'],  array('size' => 30)) .
			   $this->fetch_text_field('region', $terms['region'],  array('size' => 30)) .
			   $this->fetch_text_field('postal_code', $terms['postal_code'],  array('size' => 12)) ;	
		} else {
            return $s;
		}
	}
	
	function geo_panel($terms) {
         return $this->message('geo_instructions').
			   $this->fetch_text_field('latitude', $terms['latitude'], array('size' => 12)) .
			   $this->fetch_text_field('longitude', $terms['longitude'], array('size' => 12)) .	
			   $this->fetch_text_field('map', $terms['map'],  array('size' =>30));	
	}

	function contact_panel($terms) {
	  return
		$this->fetch_text_field('email', $terms['email'],  array('size' => 30)) . 		
		$this->fetch_text_field('telephone', $terms['telephone'],  array('size' => 30)) .	
		$this->fetch_form_field('privacy_contact', $terms['privacy_contact'], 'checkbox') .
		$this->fetch_form_field('terms_contact', $terms['terms_contact'], 'checkbox');
	}

 	function legal_panel($terms) {
 	 return
		$this->fetch_text_field('courts', $terms['courts'],  array('size' => 80)) .	
		$this->fetch_text_field('updated', $terms['updated'],  array('size' => 30)) .	
		$this->fetch_text_field('copyright_preamble', $terms['copyright_preamble'],  array('size' => 30)) .	
		$this->fetch_text_field('copyright_start_year', $terms['copyright_start_year'],  array('size' => 5));		
	}

	function intro_panel() {	 	
		printf('<p>%1$s</p>', $this->message('intro_instructions'));
	}
	
	

}
