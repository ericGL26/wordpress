<?php
 abstract class Footer_Putter_Module {

    protected $plugin;
    protected $utils;
    protected $options;
    private $options_name;

    abstract function get_options_name();
    abstract function get_defaults();
    abstract function init();

    function __construct() {
        $this->plugin = Footer_Putter_Plugin::get_instance();
        $this->utils = $this->plugin->get_utils();
        $this->options = $this->plugin->get_options();
        $this->options_name = $this->get_options_name();
        if ($this->options_name) 
            $this->options->add_defaults( array($this->options_name => $this->get_defaults()) ) ;
        else
            $this->options->add_defaults( $this->get_defaults() ) ;        
        $this->init();
    }

    function get_keys() {
        return array_keys( $this->get_defaults());
    }

    function get_option($option_name, $cache = true) {
    	$options = $this->get_options($cache);
    	if ($option_name && $options && array_key_exists($option_name,$options))
            return $options[$option_name];
    	else
            return false;
    }

    function get_options($cache = true) {
        return $this->options->get_option($this->get_options_name(), $cache);
    }

    function save_options($options) {
 //   var_dump($options); exit;
        if ($options_name = $this->get_options_name()) $options = array($options_name => $options); //just update module options
        return $this->options->save_options($options) ;
    }

    function get_version() {
        return $this->plugin->get_version();
    }

}