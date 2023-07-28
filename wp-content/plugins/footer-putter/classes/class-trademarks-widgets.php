<?php

class Footer_Putter_Trademark_Widget extends Footer_Putter_Widget {


    private	$defaults = array(
    	'category' => false, 'limit' => '', 'orderby' => 'name', 'nofollow' => false, 'visibility' => '');
		
	function __construct() {
		add_filter('pre_option_link_manager_enabled', '__return_true' );
		$widget_name = $this->message('trademarks_widget_name');
		$widget_ops = array( 'description' => $this->message('trademarks_widget_description') );		
		parent::__construct('footer_trademarks', $widget_name, $widget_ops);
	}

    function orderby_options() {
        return array(
			'name' => $this->message( 'orderby_link_title'),
			'rating' => $this->message( 'orderby_link_rating'),
			'id' => $this->message( 'orderby_link_id'),
			'rand' => $this->message( 'orderby_random'));
    }

    function nofollow_links( $content) {
	    return preg_replace_callback( '/<a([^>]*)>(.*?)<\/a[^>]*>/is', array( &$this, 'nofollow_link' ), $content ) ;
    }

    function nofollow_link($matches) { //make link nofollow
		$attrs = shortcode_parse_atts( stripslashes ($matches[ 1 ]) );
		$atts='';
        $rel = ' rel="nofollow"';
		foreach ( $attrs AS $key => $value ) {
			$key = strtolower($key);
            $nofollow = '';
			if ('rel' == $key) {
              $rel = '';
              if (strpos($value, 'follow') === FALSE) $nofollow = ' nofollow';
            }
            $atts .= sprintf(' %1$s="%2$s%3$s"', $key, $value, $nofollow);
		}
		return sprintf('<a%1$s%2$s>%3$s</a>', $rel, $atts, $matches[ 2 ]);
	}

	function widget( $args, $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );
		if ($this->hide_widget($instance['visibility'])) return; //check visibility requirements

        $args = $this->override_args($args, $instance) ;
        $category = isset($instance['category']) ? $instance['category'] : false;
		$orderby = isset( $instance['orderby'] ) ? $instance['orderby'] : 'name';
		$order = $orderby == 'rating' ? 'DESC' : 'ASC';
		$limit = (isset( $instance['limit'] ) && $instance['limit']) ? $instance['limit'] : -1;
		$nofollow = isset( $instance['nofollow'] ) && $instance['nofollow'];
		extract($args, EXTR_SKIP);
		$links = wp_list_bookmarks(apply_filters('widget_links_args', array(
			'echo' => 0,
			'title_before' => $before_title, 'title_after' => $after_title,
			'title_li' => '', 'categorize' => false,
			'before' => '', 'after' => '',
			'category_before' => '', 'category_after' => '',
			'show_images' => true, 'show_description' => false,
			'show_name' => false, 'show_rating' => false,
			'category' => $category, 'class' => 'trademark widget',
			'orderby' => $orderby, 'order' => $order,
			'limit' => $limit,
		)));
		echo $before_widget;
        if ($nofollow)
		    echo $this->nofollow_links($links);
        else
            echo $links;
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $this->update_instance( $new_instance, $old_instance );
		$instance['orderby'] = 'name';
		if ( in_array( $new_instance['orderby'], array( 'name', 'rating', 'id', 'rand' ) ) )
			$instance['orderby'] = $new_instance['orderby'];
		$instance['category'] = intval( $new_instance['category'] );
		$instance['limit'] = ! empty( $new_instance['limit'] ) ? intval( $new_instance['limit'] ) : '';
		$instance['nofollow'] = !empty($new_instance['nofollow']);
		$instance['visibility'] = trim($new_instance['visibility']);
		return $instance;
	}

	function form( $instance ) {
		$this->form_init ($instance);
		print '<div class="diy-wrap">';
		$links = array();
		$link_cats = get_terms( 'link_category' );
		foreach ( $link_cats as $link_cat ) {
			$id = intval($link_cat->term_id);
			$links[$id] = $link_cat->name;
		}
		$this->print_form_field('category', 'select', $links);
		$this->print_form_field('orderby', 'select', $this->orderby_options());
		$this->print_form_field('limit',  'text', array(),  array('size' => 3 ,'maxlength' => 3));
		$this->print_form_field('nofollow',  'select', array( '1' => 'NoFollow Links', '' => 'Follow Links',));
		printf ('<hr/><h4>%1$s</h4>', $this->message('widget_presence_heading') );
		$this->print_form_field('visibility', 'radio', $this->get_visibility_options(), array('separator' => '<br />'));
		print '</div>';
	}

}