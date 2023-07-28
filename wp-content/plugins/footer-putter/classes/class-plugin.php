<?php
class Footer_Putter_Plugin {
	private $changelog = FOOTER_PUTTER_CHANGELOG;
	private $help = FOOTER_PUTTER_HELP;
  	private $home = FOOTER_PUTTER_HOME;
  	private $icon = FOOTER_PUTTER_ICON;
 	private $name = FOOTER_PUTTER_NAME;
	private $newsfeeds = array(FOOTER_PUTTER_NEWS);
 	private $path = FOOTER_PUTTER_PATH;
 	private $slug = FOOTER_PUTTER_SLUG;
 	private $version = FOOTER_PUTTER_VERSION;
	private $modules = array(
		'credits' => array('class'=> 'Footer_Putter_Credits','heading' => 'Credits', 'tip' => 'Footer Putter Credits.'),
		'trademarks' => array('class'=> 'Footer_Putter_Trademarks','heading' => 'Trademarks', 'tip' => 'Footer Putter Trademarks.'),
		'footer' => array('class'=> 'Footer_Putter_Footer','heading' => 'Footer', 'tip' => 'Footer Putter Footer.'),
	);

	private $defaults = array();
	private $message;
	private $news;
	private $options;
	private $tooltips;
	private $utils;

	private $admin_modules = array();
	private $public_modules = array();

 	public function init() {
		$d = dirname(__FILE__) . '/';
		require_once($d . 'class-options.php');
		require_once($d . 'class-utils.php');
		require_once($d . 'class-tooltip.php');
		require_once($d . 'class-message.php');
		require_once($d . 'class-module.php'); 
		$this->options = new Footer_Putter_Options( 'footer_credits_options', $this->defaults);
		$this->utils = new Footer_Putter_Utils();
		$this->tooltips = new Footer_Putter_Tooltip();
		$this->message = new Footer_Putter_Message();
		require_once ($d . 'class-widget.php'); 
		foreach ($this->modules as $module => $details) $this->init_module($module);
        if (is_admin()) 
            $this->admin_init(); 
	}

	public function admin_init() {
		$d = dirname(__FILE__) . '/';
		require_once($d . 'class-news.php');
		require_once($d . 'class-admin.php');
		$this->news = new Footer_Putter_News($this->version);
		require_once ($d . 'class-dashboard.php');
		new Footer_Putter_Dashboard($this); 
		foreach ($this->modules as $module => $details) $this->init_module($module, true);

	}
	
	static function get_instance() {
        static $instance = null;
        if (null === $instance) {
            $instance = new self(); 
            register_activation_hook($instance->path, array($instance, 'activate'));            
            add_action('init', array($instance, 'init'),0);
        }
        return $instance;
	}
   
  	protected function __construct() {}

	private function __clone() {}

  	private function __wakeup() {}

	public function get_changelog(){
		return $this->changelog;
	}

	public function get_help(){
		return $this->help;
	}
	
	public function get_home(){
		return $this->home;
	}

	public function get_icon(){
		return $this->icon;
	}

	public function get_message(){
		return $this->message;
	}

	public function get_modules(){
		return $this->modules;
	}

	public function get_name(){
		return $this->name;
	}

	public function get_news(){
		return $this->news;
	}

	public function get_newsfeeds(){
		return $this->newsfeeds;
	}

	public function get_options(){
		return $this->options;
	}

	public function get_path(){
		return $this->path;
	}

	public function get_prefix(){
        return sprintf('_%1$s_', $this->slug);
	}

	public function get_slug(){
		return $this->slug;
	}

	public function get_tooltips(){
		return $this->tooltips;
	}

	public function get_utils(){
		return $this->utils;
	}

	public function get_version(){
		return $this->version;
	}

	public function activate() { //called on plugin activation
        $this->set_activation_key();
	}
	
	private function deactivate($path ='') {
		if (empty($path)) $path = $this->path;
		if (is_plugin_active($path)) deactivate_plugins( $path );
	}

	private function get_activation_key() { 
    	return get_option($this->activation_key_name()); 
	}

   private function set_activation_key() { 
    	return update_option($this->activation_key_name(), true); 
	}

    private function unset_activation_key() { 
    	return delete_option($this->activation_key_name(), true); 
	}

   private function activation_key_name() { 
    	return strtolower(__CLASS__) . '_activation'; 
	}
	
   public function get_module($module, $is_admin = false) {
	   $modules = $is_admin ? $this->admin_modules: $this->public_modules;
		return array_key_exists($module, $modules) ? $modules[$module] : false;
	}
	
	private function init_module($module, $admin=false) {
		if (array_key_exists($module, $this->modules)
		&& ($class = $this->modules[$module]['class'])) {
			$prefix =  dirname(__FILE__) .'/class-'. $module;
			if ($admin) {
				$class = $class .'_Admin';
				$file = $prefix . '-admin.php';
				if (!class_exists($class) && file_exists($file)) {
					require_once($file);
                    $this->admin_modules[$module] = new $class($this, $module);
 				}
			} else {
				$file = $prefix . '.php';
				if (!class_exists($class) && file_exists($file)) {
					require_once($file);
                    $this->public_modules[$module] = new $class();  
                }                      
				$file = $prefix . '-widgets.php';
				if (file_exists($file)) require_once($file);
			}
    	}
	}
}
