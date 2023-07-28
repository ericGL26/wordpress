<?php
class Footer_Putter_Footer extends Footer_Putter_Module  {

	const CSS_CLASS = 'footer-putter-credits';
	const CODE = 'footer-credits'; //shortcode prefix
	const SIDEBAR_ID = 'last-footer';

	protected $defaults = array(
		'return_text' => 'Return To Top',
		'footer_hook' => '',
		'footer_remove' => true,
 		'footer_filter_hook' => ''
	);

	protected $widget_defaults = array(
		'nav_menu' => 0,
		'center' => true,
		'layout' => false,
		'separator' => '&nbsp;&middot;&nbsp;',		
		'show_copyright' => true,
		'show_telephone' => true,
		'show_email' => false,
		'show_address' => true,
		'show_return' => true,
		'return_text' => 'Return To Top',
		'return_class' => '',
		'footer_class' => '',
		'footer_hook' => '',
		'footer_remove' => true,
 		'footer_filter_hook' => '',
 		'visibility' => '' ,
        'use_microdata' => false,
        'hide_wordpress' => false
	);


    private $layouts = array(
        'single', 'single-alt', 'contact-below', 'copyright-below', 
	    'menu-above', 'menu-above-alt', 'stacked', 'stacked-alt');
	
    private $credits;

    protected $is_landing = false;

	function get_defaults() {
       return $this->theme_specific_defaults($this->defaults); 
   }	

	function get_options_name() {
       return ''; //push all the options to the top level 
   }

	function get_widget_defaults() {
       return $this->widget_defaults; 
   }

	public function init() {
        $this->credits = $this->plugin->get_module('credits');
		add_action('widgets_init',array($this,'register'),20);
		add_filter( 'wp_nav_menu_items', array($this, 'fix_home_link'), 10, 2 );
		if (!is_admin()) add_action('wp',array($this,'prepare'));
	}

	function register() {
		$this->register_sidebars();
		$this->register_widgets();
	}

    private function register_sidebars() {
    	if ($this->options->get_option('footer_hook')) {
			$tag = 'div';
			register_sidebar( array(
				'id' => self::SIDEBAR_ID,
				'name'	=> __( 'Credibility Footer' ),
				'description' => __( 'Custom footer section for copyright, trademarks, etc.'),
				'before_widget' => '<'.$tag.' id="%1$s" class="widget %2$s"><div class="wrap">',
				'after_widget'  => '</div></'.$tag.'>'				
			) );
		}
    }
	
	private function register_widgets() {
		if (class_exists('Footer_Putter_Copyright_Widget')) register_widget('Footer_Putter_Copyright_Widget');
		if (class_exists('Footer_Putter_Trademark_Widget')) register_widget('Footer_Putter_Trademark_Widget');
	}	
	
	function prepare() {
		add_shortcode(self::CODE, array($this, 'footer' ) );
		add_shortcode(self::CODE.'-return', array($this, 'footer_return' ) );
		add_filter('widget_text', 'do_shortcode', 11);
		add_action('wp_enqueue_scripts',array($this, 'enqueue_styles' ));

		$this->is_landing = $this->utils->is_landing_page();
			
		//insert custom footer at specified hook
		if ($footer_hook = $this->options->get_option('footer_hook'))  {
			if ($this->options->get_option('footer_remove')) {
				remove_all_actions( $footer_hook); 
				if ($footer_hook =='wp_footer') {
					add_action( 'wp_footer', 'wp_print_footer_scripts', 20);  //put back the footer scripts             
					add_action( 'wp_footer', 'wp_admin_bar_render', 1000 ); //put back the admin bar
				}
			}
			add_action( $footer_hook, array($this, 'custom_footer')); 
		}
	
 		//suppress footer output
 		if ($ffs = $this->options->get_option('footer_filter_hook')) 
 			add_filter($ffs, array($this, 'no_footer'),100); 
	}
	
	function enqueue_styles() {
		wp_enqueue_style('footer-credits', plugins_url('styles/footer-credits.css',dirname(__FILE__)), array(), $this->plugin->get_version());
    }

	function get_layouts() { return $this->layouts; }	

	function is_html5() {
		return $this->utils->is_html5();
	}

	public function return_to_top( $text, $class) {
		return sprintf( '<div class="footer-return %1$s"><span>%2$s</span></div>', trim($class), $text);
	}

	public function footer($atts = array()) {
  		$params = shortcode_atts( $this->widget_defaults, $atts ); //apply plugin defaults

		if ($params['center']) {
			$return_class = 'return-center';
			$footer_class = 'footer-center';
			$clear = '';
		} else {
			$return_class = ' return-left';
			$footer_class = ' footer-right';
			$clear = '<div class="clear"></div>';
		}	
        $layout = isset($atts['layout']) ? $atts['layout'] : 'single';

		$format = '<div class="%4$s %5$s %6$s">'.$this->get_footer_content_order($layout).'</div>%7$s';
		return (empty($params['show_return']) ? '' :
			$this->return_to_top($params['return_text'], $return_class. ' ' . $params['return_class'])) . 
			sprintf($format,
				(empty($params['nav_menu']) ? '' : $this->credits->footer_menu($params)),
				(empty($params['show_copyright']) ? '' : $this->credits->copyright($params)),
				$this->credits->contact_info($params),
				self::CSS_CLASS,
				$footer_class, 	
                $layout, 
				$clear
			);				
	}

    private function get_footer_content_order($layout) {
        switch ($layout) {
            case 'single-alt': 
            case 'copyright-below': 
            case 'menu-above-alt': 
            case 'stacked-alt': return '%1$s%3$s%2$s'; 
         }
         return  '%1$s%2$s%3$s';
    } 

	public function custom_footer() {
		if ( is_active_sidebar( self::SIDEBAR_ID) ) {
         	$class = 'custom-footer'. ($this->get_option('hide_wordpress') ? ' hide-wordpress' :'');
			if ($this->is_html5()) {
				printf('<footer class="%1$s" itemscope="itemscope" itemtype="http://schema.org/WPFooter">', $class);
				dynamic_sidebar( self::SIDEBAR_ID );
				echo '</footer><!-- end .custom-footer -->';
			} else {
				printf('<div class="%1$s">', $class);
				dynamic_sidebar( self::SIDEBAR_ID );
				echo '</div><!-- end .custom-footer -->';
			}
		}
	}

    public function no_footer($content) { return ''; }  		


	function fix_home_link( $content, $args) {
		$class =  is_front_page()? ' class="current_page_item"' : '';
		$home_linktexts = array('Home','<span>Home</span>');
		foreach ($home_linktexts as $home_linktext) {
			$home_link = sprintf('<a>%1$s</a>',$home_linktext);
			if (strpos($content, $home_link) !== FALSE) 
				$content = str_replace ($home_link,sprintf('<a href="%1$s"%2$s>%3$s</a>',home_url(),$class,$home_linktext),$content); 
		} 
		return $content;
	}

	function footer_return($atts = array()) {
 		$defaults = array('return_text' => $this->defaults['return_text'],  'return_class' => $this->defaults['return_class']);
   		$params = shortcode_atts( $defaults, $atts ); //apply plugin defaults	
        return $this->return_to_top($params['return_text'], $params['return_class']);
	}

	function theme_specific_defaults($defaults) {
		switch (basename( TEMPLATEPATH ) ) {  
			case 'twentyten': 
				$defaults['footer_hook'] = 'twentyten_credits'; break;
			case 'twentyeleven': 
				$defaults['footer_hook'] = 'twentyeleven_credits'; break;
			case 'twentytwelve': 
				$defaults['footer_hook'] = 'twentytwelve_credits'; break;
			case 'twentythirteen': 
				$defaults['footer_hook'] = 'twentythirteen_credits'; break;
			case 'twentyfourteen': 
				$defaults['footer_hook'] = 'twentyfourteen_credits'; break;
			case 'twentyfifteen': 
				$defaults['footer_hook'] = 'twentyfifteen_credits'; break;
			case 'twentysixteen': 
				$defaults['footer_hook'] = 'twentysixteen_credits'; break;
			case 'twentyseventeen': 
				$defaults['footer_hook'] = 'get_template_part_template-parts/footer/site'; break;
			case 'generatepress': 
				$defaults['footer_hook'] = 'generate_credits'; break;
			case 'delicate': 
				$defaults['footer_hook'] = 'get_footer'; break;
			case 'genesis': 
				$defaults['footer_hook'] = 'genesis_footer';
				$defaults['footer_filter_hook'] = 'genesis_footer_output';
				break;
			case 'graphene': 
				$defaults['footer_hook'] = 'graphene_footer'; break;
			case 'pagelines': 
				$defaults['footer_hook'] = 'pagelines_leaf'; break;
			default: 
				$defaults['footer_hook'] = 'wp_footer';
				$defaults['footer_remove'] = false;				
				break;
		}
	   return $defaults;
    }
}
