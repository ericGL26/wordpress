<?php
class Footer_Putter_Copyright_Widget extends Footer_Putter_Widget {

    private $footer;

	function __construct() {
		$widget_name = $this->message('copyright_widget_name');
		$widget_ops = array( 'description' => $this->message('copyright_widget_description') );
		parent::__construct('footer_copyright', $widget_name, $widget_ops);
		$this->footer = $this->plugin->get_module('footer'); 
	}
	
	function widget( $args, $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->footer->get_widget_defaults() );
		if ($this->hide_widget($instance['visibility'])) return; //check visibility requirements
        $args = $this->override_args($args, $instance) ;		
		extract( $args );		

		if ($footer = $this->footer->footer($instance)) 
			printf ('%1$s%2$s%3$s', $before_widget, $footer, $after_widget);
	}

	function update( $new_instance, $old_instance ) {
		$instance = $this->update_instance( $new_instance, $old_instance );
		$instance['nav_menu'] = !empty($new_instance['nav_menu']) ? $new_instance['nav_menu'] : 0;
		$instance['show_copyright'] = !empty($new_instance['show_copyright']) ? 1 : 0;
		$instance['show_telephone'] = !empty($new_instance['show_telephone']) ? 1 : 0;	
		$instance['show_email'] = !empty($new_instance['show_email']) ? 1 : 0;	
		$instance['show_address'] = !empty($new_instance['show_address']) ? 1 : 0;	
		$instance['use_microdata'] = !empty($new_instance['use_microdata']);
		$instance['center'] = !empty($new_instance['center']) ? 1 : 0;
		$instance['layout'] = $new_instance['layout'];
		$instance['show_return'] = !empty($new_instance['show_return']) ? 1 : 0;
		$instance['return_class'] = trim($new_instance['return_class']);
		$instance['footer_class'] = trim($new_instance['footer_class']);
		$instance['visibility'] = trim($new_instance['visibility']);
		return $instance;
	}

	function form( $instance ) {
		$this->form_init ($instance);
		$menu_terms = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
		if ( !$menu_terms ) {
			echo '<p>'. sprintf( __('No menus have been created yet. <a href="%s">Create some</a>.' ), admin_url('nav-menus.php') ) .'</p>';
			return;
		}
		$menus = array();
		$menus[0] = 'No menu';
		foreach ( $menu_terms as $term ) $menus[ $term->term_id ] = $term->name;
        print '<div class="diy-wrap">';
		$this->print_form_field('nav_menu',  'select', $menus);
        print ('<hr/><h4>Options</h4>');
		$this->print_form_field('center',  'checkbox');
		$this->print_form_field('show_copyright', 'checkbox');
		$this->print_form_field('show_address', 'checkbox');
		$this->print_form_field('show_telephone', 'checkbox');
		$this->print_form_field('show_email', 'checkbox');
		$this->print_form_field('show_return', 'checkbox');
		if ($this->utils->is_html5()) $this->print_form_field('use_microdata', 'checkbox');
		$this->print_form_field('layout', 'select', $this->get_layout_options());
		printf('<hr/><h4>%1$s</h4>', $this->message('custom_classes_heading'));
		print $this->message('custom_classes_instructions');
		$this->print_form_field('return_class', 'text', array(), array('size' => 10));
		$this->print_form_field('footer_class', 'text', array(), array('size' => 10));
        printf ('<hr/><h4>%1$s</h4>', $this->message('widget_presence_heading') );
		$this->print_form_field('visibility',  'radio', $this->get_visibility_options(), array('separator' => '<br />'));
      print '</div>';
	}  


    private function get_layout_options() {
        $options = array();
        $layouts = $this->footer->get_layouts();
        foreach ($layouts as $layout) {
            $id = 'layout_'. str_replace('-','_', $layout);
            $options[$layout] = $this->message($id);
        }
        return $options;
    }
}
