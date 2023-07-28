<?php
class Footer_Putter_Credits extends Footer_Putter_Module  {

	const CSS_CLASS = 'footer-putter-credits';
	const CODE = 'footer-credits'; //shortcode prefix
	const SIDEBAR_ID = 'last-footer';

	protected $defaults = array(
        'site' => '',
        'owner' => '',
        'address' => '',
        'street_address' => '',
        'locality' => '',
        'region' => '',
        'postal_code' => '',
        'country' => '',
        'latitude' => '',
        'longitude' => '',
        'map' => '',
        'email' => '',
        'telephone' => '',
        'copyright' => '',
        'copyright_start_year' => '',
        'copyright_preamble' => '',
        'courts' => '',
        'updated' => '',
        'privacy_contact' => '',
        'terms_contact' => ''
	);



	function get_defaults() {
       return $this->defaults;
   }	

	function get_options_name() {
       return 'terms'; 
   }

	public function init() {
		if (!is_admin()) add_action('wp',array($this,'prepare'));
	}
	
	function prepare() {
		add_shortcode(self::CODE.'-contact', array($this, 'contact' ) );
		add_shortcode(self::CODE.'-copyright', array($this, 'copyright' ) );
		add_shortcode(self::CODE.'-menu', array($this, 'footer_menu' ) );

		add_filter('widget_text', 'do_shortcode', 11);
		add_action('wp_enqueue_scripts',array($this, 'enqueue_styles' ));

		if (is_page('privacy') && $this->get_option('privacy_contact'))
			add_filter('the_content', array($this, 'add_privacy_footer'),9 );	

		if (is_page('terms') && $this->get_option('terms_contact'))
			add_filter('the_content', array($this, 'add_terms_footer'),9 );	

		if (is_page('terms') || is_page('privacy') || is_page('affiliates') || is_page('disclaimer'))
			add_filter('the_content', array($this, 'terms_filter') );	
				
	}
	
	function enqueue_styles() {
		wp_enqueue_style('footer-credits', plugins_url('styles/footer-credits.css',dirname(__FILE__)), array(), $this->plugin->get_version());
    }
	
	function save_options($new_options) {
		$new_options = $this->sanitize_terms($new_options);
		return parent::save_options( $new_options) ;
	}


	function is_html5() {
		return $this->utils->is_html5();
	}

	private function sanitize_terms($new_terms) {
		$new_terms = wp_parse_args($new_terms, $this->defaults); //ensure terms are complete		
		$new_terms['site'] = $this->get_default_site();
		$new_terms['copyright'] = $this->get_copyright($new_terms['copyright_start_year']); //generate copyright
		return $new_terms;
	}
	
    private function get_default_term($key) {
		$default='';
    	switch ($key) {
   			case 'owner' : $default = $this->get_option('site'); break;
   			case 'copyright' : $default = $this->get_copyright($this->get_option('copyright_start_year')); break;
   			case 'copyright_start_year': $default = date('Y'); break;
			case 'copyright_preamble': $default = 'Copyright &copy;'; break;
   			case 'country' : $default = 'The United States'; break;
   			case 'courts' : $default = ucwords(sprintf('the courts of %1$s',$this->get_option('country'))); break;
   			case 'email' : $default = 'privacy@'.strtolower($this->get_option('site')); break;
   			case 'site' : $default = $this->get_default_site(); break;
   			case 'updated' : $default = date('d M Y'); break;
 			default: $default='';  //default is blank for others
   		}
   		return $default;
    }
	
	private function get_default_site() { 
		$domain = strtolower(parse_url(site_url(),PHP_URL_HOST));
		$p = strpos($domain,'www.') ;
		if (($p !== FALSE) && ($p == 0)) $domain = substr($domain,4);
		return $domain; 
	}
	
	public function get_copyright($startyear=''){
  		$thisyear = date("Y");
		$format = (empty( $startyear) || ($startyear==$thisyear)) ? '%1$s %3$s' : '%1$s %2$s-%3$s';
  		return sprintf($format, $this->get_option('copyright_preamble'), $startyear, $thisyear);
 	}

	public function return_to_top( $text, $class) {
		return sprintf( '<div class="footer-return %1$s"><span>%2$s</span></div>', trim($class), $text);
	}

    public function contact_info($params) {
        $org ='';
        if ($address = $this->contact_address($params['show_address'], $params['use_microdata'], $params['separator'])) $org .= $address;
        if ($telephone = $this->contact_telephone($params['show_telephone'], $params['use_microdata'])) $org .= $telephone;
        if ($email = $this->contact_email($params['show_email'], $params['use_microdata'])) $org .= $email;
		$format = '<div class="footer-putter-contact %1$s" ' . ($params['use_microdata'] ? ' itemscope="itemscope" itemtype="http://schema.org/Organization"' : '') . '>%2$s</div>';
        return sprintf($format, $params['footer_class'], $org);
    }

    private function contact_telephone($show_telephone, $microdata ) {
      if  ($show_telephone && ($telephone = $this->get_option('telephone')))
        if ($microdata)
            return sprintf('<span itemprop="telephone" class="telephone">%1$s</span>', $telephone) ;
        else
            return sprintf('<span class="telephone">%1$s</span>', $telephone) ;
      else
            return '';
    }

    private function contact_email($show_email, $microdata) {
      if  ($show_email && ($email = $this->get_option('email')))
            return sprintf('<a href="mailto:%1$s" class="email"%2$s>%1$s</a>', $email, $microdata ? ' itemprop="email"' : '') ;
      else
            return '';
    }

    private function contact_address($show_address, $microdata, $separator) {
      if  ($show_address)
        if ($microdata) {
            return $this->org_location($separator);
        } elseif ($address = $this->get_option('address'))
            return sprintf('<span class="address">%1$s%2$s</span>', $this->format_address($address, $separator), $this->get_option('country'));
      return '';
    }

    private function format_address ($address, $separator) {
		$s='';
		$addlines = explode(',', trim($address));
		foreach ($addlines as $a) {
			$a = trim($a);
			if (!empty($a)) $s .= $a . $separator;
		}
		return $s;
    }	
	
    private function org_location($separator) {
        $location = '';
        if ($loc_address = $this->location_address( $separator)) $location .=  $loc_address;
        if ($loc_geo = $this->location_geo()) $location .= $loc_geo;
        if ($loc_map = $this->location_map()) $location .= $loc_map;
        if ($location)
            return sprintf('<span itemprop="location" itemscope="itemscope" itemtype="http://schema.org/Place">%1$s</span>', $location) ;
        else
            return '';
    }

    private function location_address($separator) {
        $address = '';
        if ( $street_address = $this->get_option('street_address'))
            $address .=  sprintf('<span itemprop="streetAddress">%1$s</span>', $this->format_address($street_address, $separator)) ;
        if ( $locality = $this->get_option('locality'))
                $address .=  sprintf('<span itemprop="addressLocality">%1$s</span>', $this->format_address($locality, $separator)) ;
        if ( $region = $this->get_option('region'))
                $address .=  sprintf('<span itemprop="addressRegion">%1$s</span>', $this->format_address($region, $separator)) ;
        if ( $postal_code = $this->get_option('postal_code'))
                $address .=  sprintf('<span itemprop="postalCode">%1$s</span>', $this->format_address($postal_code, $separator)) ;
        if ( $country = $this->get_option('country'))
                $address .=  sprintf('<span itemprop="addressCountry">%1$s</span>', $country) ;

        if ($address)
            return sprintf('<span class="address" itemprop="address" itemscope="itemscope" itemtype="http://schema.org/PostalAddress">%1$s</span>',$address) ;
        else
            return '';
    }

    private function location_geo() {
        $geo = '';
        if ( $latitude = $this->get_option('latitude')) $geo .=  sprintf('<meta itemprop="latitude" content="%1$s" />', $latitude) ;
        if ( $longitude = $this->get_option('longitude')) $geo .=  sprintf('<meta itemprop="longitude" content="%1$s" />', $longitude) ;
        return $geo ? sprintf('<span itemprop="geo" itemscope="itemscope" itemtype="http://schema.org/GeoCoordinates">%1$s</span>', $geo) : '';
    }

    private function location_map() {
        if ( $map = $this->get_option('map'))
            return sprintf('<a rel="nofollow external" target="_blank" class="map" itemprop="map" href="%1$s">%2$s</a>', $map, __('Map')) ;
        else
            return '';
    }

	public function copyright_owner($params){
  		return sprintf('<span class="copyright">%1$s %2$s</span>', 
  			$this->get_copyright($params['copyright_start_year']), $params['owner']);
	}	
	
    public function contact($atts = array()) {
		$defaults = array();
		$defaults['show_telephone'] = $this->defaults['show_telephone'];
		$defaults['show_email'] = $this->defaults['show_email'];
		$defaults['show_address'] = $this->defaults['show_address'];
		$defaults['use_microdata'] = $this->defaults['use_microdata'];
		$defaults['separator'] = $this->defaults['separator'];
		$defaults['footer_class'] = '';	
  		$params = shortcode_atts( $defaults, $atts ); //apply plugin defaults  		
        return $this->contact_info($params);
    }

	public function copyright($atts = array()){
		$defaults = array();
		$defaults['owner'] = $this->get_option('owner');
		$defaults['copyright_start_year'] = $this->get_option('copyright_start_year');	
		$defaults['footer_class'] = '';	
  		$params = shortcode_atts( $defaults, $atts ); //apply plugin defaults  		
        return sprintf('<div class="footer-putter-copyright %1$s">%2$s</div>', $params['footer_class'],  $this->copyright_owner($params));
	}	

	public function footer_menu($atts = array()) {
 		$defaults = array('menu' => 'Footer Menu', 'echo' => false, 'container' => false, 'footer_class' => self::CSS_CLASS);
		if (isset($atts['nav_menu'])) $atts['menu'] = $atts['nav_menu']; 
   		$params = shortcode_atts( $defaults, $atts ); //apply plugin defaults	
        return sprintf ('<div class="footer-putter-menu><nav %1$s">%2$s</nav></div>', $params['footer_class'], wp_nav_menu($params));
	}


	public function terms_filter($content) {
		if ($terms = $this->get_options()) {
			$from = array();
			$to = array();
			foreach ($terms as $term => $value) {
				$from[] = '%%'.$term.'%%';
				$to[] = $value;
			}
			return str_replace($from,$to,$content);
		}
		return $content;
	}


    public function no_footer($content) { return ''; }  		

	public function add_privacy_footer($content) {
		$email = $this->get_option('email');	
		$address = $this->get_option('address');
		$country = $this->get_option('country');
		$owner = $this->get_option('owner');
		$contact = <<< PRIVACY
<h2>How to Contact Us</h2> 
<p>Questions about this statement or about our handling of your information may be sent by email to <a href="mailto:{$email}">{$email}</a>, or by post to {$owner} Privacy Office, {$address} {$country}. </p>
PRIVACY;
		return (strpos($content,'%%') == FALSE) ? ($content . $contact) : $content;
	}

	public function add_terms_footer($content) {
		$email = $this->get_option('email');	
		$address = $this->get_option('address');
		$country = $this->get_option('country');
		$courts = $this->get_option('courts');
		$owner = $this->get_option('owner');
		$copyright = $this->get_option('copyright');
		$updated = $this->get_option('updated');
		$terms_contact = $this->get_option('terms_contact');
		$disputes = <<< DISPUTES
<h2>Dispute Resolution</h2>
<p>These terms, and any dispute arising from the use of this site, will be governed by {$courts} without regard to its conflicts of laws provisions.</p>
DISPUTES;
		$terms = <<< TERMS
<h2>Feedback And Information</h2> 
<p>Any feedback you provide at this site shall be deemed to be non-confidential. {$owner} shall be free to use such information on an unrestricted basis.</p>
<p>The terms and conditions for this web site are subject to change without notice.<p>
<p>{$copyright} {$owner} All rights reserved.<br/> {$owner}, {$address} {$country}</p>
<p>Updated by The {$owner} Legal Team on {$updated}</p>
TERMS;
		if (strpos($content,'%%') == FALSE) {
			$content .= $courts ? $disputes : '';
			$content .= $address ? $terms : '';
		}
		return $content ;
	}



}
