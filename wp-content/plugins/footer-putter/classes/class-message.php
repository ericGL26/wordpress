<?php
class Footer_Putter_Message {

    function __construct() {}

	function build_tips($ids, $prefix='') {
        $prefix = $prefix ? ($prefix."_") : '';
        $tips = array();
        foreach ($ids as $id) $tips[$prefix.$id] = array('heading' => $this->message($prefix.$id.'_heading'), 'tip' => $this->message($prefix.$id.'_tip'));
        return $tips;
	}

    function message($message_id) {
        $message ='';
        switch ($message_id) {

             /* Plugin info */

            case 'plugin_changelog':
               $message = __('See the <a href="%1$s" rel="external" target="_blank">changelog</a> for the full plugin history.',
               'footer-putter'); break;

            case 'plugin_description':
               $message = __("
<p>Footer Putter allows you to put a footer to your site that adds credibility to your site, with BOTH visitors and search engines.</p>
<p>Google is looking for some indicators that the site is about a real business.</p>
<ol>
<li>The name of the business or site owner</li>
<li>A copyright notice that is up to date</li>
<li>A telephone number</li>
<li>A postal address</li>
<li>Links to Privacy Policy and Terms of Use pages</p>
</ol>
<p>Human visitors may pay some credence to this information but will likely be more motivated by trade marks, trust marks and service marks.</p>
               ",
               'footer-putter'); break;

            case 'plugin_features':
               $message = __("
<p>Plugin features: 
<ol>
<li>configurable copyright widget with optional contact details and footer menu;</li>
<li>configurable trademarks widget;</li>
<li>hide footer widgets or show different versions of the footer widgets on landing pages;</li>
<li>maintain site ownership details in one place;</li>
<li>include site ownership details automatically on privacy and terms and conditions pages</li>
</ol>
</p>
               ",
               'footer-putter'); break;
               
            case 'plugin_help':
               $message = __('For help and tutorials visit the <a href="%1$s" rel="external" target="_blank">Footer Putter plugin home page</a>.',
               'footer-putter'); break;
               
            case 'plugin_news':
               $message = __('Footer Putter News',
               'footer-putter'); break;

            case 'plugin_settings':
                $message = __('plugin settings',
                'footer-putter'); break;
               
            case 'plugin_version':
               $message = __('This version of %1$s is %2$s.',
               'footer-putter'); break;

            /* end plugin info */
 
            /* errors */

            case 'feed_empty':
                $message = __( 'The news feed is empty right now.' ,
                'footer-putter'); break;
            
            case 'feed_error':
                $message = __( 'Newsfeed error' ,
                'footer-putter'); break;

            case 'feed_missing':
                $message = __( 'Feed URL not supplied.',
                'footer-putter'); break;
            
            case 'feed_failure':
                $message = __( 'Could not retrieve feed %s' ,
                'footer-putter'); break;
            
            /* END errors */

             /* Menu Items */

            case 'menu_dashboard':
               $message = __('Dashboard',
               'footer-putter'); break;

            case 'menu_credits':
               $message = __('Credits',
               'footer-putter'); break;

            case 'menu_footer':
               $message = __('Footer',
               'footer-putter'); break;

            case 'menu_trademarks':
               $message = __('Trademarks',
               'footer-putter'); break;

             /* END Menu Items */
  
             /* Section titles */

            case 'section_overview_title':
               $message = __('Overview',
               'footer-putter'); break;

            case 'section_details_title':
               $message = __('Details',
               'footer-putter'); break;

            case 'section_credits_intro_title':
               $message = __('Credits Introduction',
               'footer-putter'); break;

            case 'section_credits_settings_title':
               $message = __('Credits Settings',
               'footer-putter'); break;

            case 'section_trademarks_intro_title':
               $message = __('Trademarks Introduction',
               'footer-putter'); break;

            case 'section_trademarks_instructions_title':
               $message = __('Trademarks Instructions',
               'footer-putter'); break;

            case 'section_footer_intro_title':
               $message = __('Footer Introduction',
               'footer-putter'); break;

            case 'section_footer_settings_title':
               $message = __('Footer Settings',
               'footer-putter'); break;

            case 'section_footer_preview_title':
               $message = __('Footer Preview',
               'footer-putter'); break;

             /* END SECTION TITLES */

            /* Settings */                       
 
            case 'settings_not_found':
               $message = __('settings have not been found.',
               'footer-putter'); break;
               
            case 'settings_saved':
               $message = __('settings saved successfully.',
               'footer-putter'); break;

            case 'settings_unchanged':
               $message = __('settings have not been changed.',
               'footer-putter'); break;
 
             /* END Settings */

            /*  tabs */
         
            case 'tab_advanced':
               $message = __('Advanced',
               'footer-putter'); break;
               
            case 'tab_contact':
               $message = __('Contact',
               'footer-putter'); break;

            case 'tab_features':
               $message = __('Features',
               'footer-putter'); break;
               
            case 'tab_help':
               $message = __('Help',
               'footer-putter'); break;

            case 'tab_hooks':
               $message = __('Footer Hooks',
               'footer-putter'); break;

            case 'tab_instructions':
               $message = __('Instructions',
               'footer-putter'); break;
               
            case 'tab_intro':
               $message = __('Intro',
               'footer-putter'); break;

            case 'tab_address':
               $message = __('Address',
               'footer-putter'); break;

            case 'tab_geo':
               $message = __('Geolocation',
               'footer-putter'); break;
                              
            case 'tab_legal':
               $message = __('Legal',
               'footer-putter'); break;

            case 'tab_links':
               $message = __('Useful Links',
               'footer-putter'); break;
               
            case 'tab_owner':
               $message = __('Owner',
               'footer-putter'); break;

            case 'tab_return':
               $message = __('Retun To Top',
               'footer-putter'); break;
               
             case 'tab_trademarks_instructions':
               $message = __('Instructions',
               'footer-putter'); break;
               
             case 'tab_trademarks_tips':
               $message = __('Tips',
               'footer-putter'); break;
               
             case 'tab_trademarks_screenshots':
               $message = __('Screenshots',
               'footer-putter'); break;
               
             case 'tab_version':
               $message = __('Version',
               'footer-putter'); break;

             case 'tab_widgets':
               $message = __('Widgets',
               'footer-putter'); break;
  
             /* END TABS */
             
      		/* TOOLTIPS */
            case 'address_heading':
               $message = __('Full Address',
               'footer-putter'); break;
            case 'address_tip':
               $message = __('Enter the full address that you want to appear in the footer and the privacy and terms pages.',
               'footer-putter'); break;

            case 'country_heading':
               $message = __('Country',
               'footer-putter'); break;
            case 'country_tip':
               $message = __('Enter the country where the legal entity is domiciled.',
               'footer-putter'); break;

            case 'copyright_preamble_heading':
               $message = __('Copyright Text',
               'footer-putter'); break;
            case 'copyright_preamble_tip':
               $message = __('Something like:<br/> Copyright &copy; All Rights Reserved.',
               'footer-putter'); break;

            case 'copyright_start_year_heading':
               $message = __('Copyright Start',
               'footer-putter'); break;
            case 'copyright_start_year_tip':
               $message = __('The start year of the business appears in the copyright statement in the footer and an on the Terms and Conditions page.',
               'footer-putter'); break;

            case 'courts_heading':
               $message = __('Legal Jurisdiction',
               'footer-putter'); break;
            case 'courts_tip':
               $message = __('The Courts that have jurisdiction over any legal disputes regarding this site. For example: <i>the state and federal courts in Santa Clara County, California</i>, or <i>the Law Courts of England and Wales</i>.',
               'footer-putter'); break;

            case 'email_heading':
               $message = __('Email Address',
               'footer-putter'); break;
            case 'email_tip':
               $message = __('Enter the email address here if you want it to appear in the footer and in the privacy statement.',
               'footer-putter'); break;

            case 'footer_class_heading':
               $message = __('Footer Class',
               'footer-putter'); break;
            case 'footer_class_tip':
               $message = __('Add any custom class you want to apply to the footer. The plugin comes with a class <i>white</i> that marks the text in the footer white. This is useful where the footer background is a dark color.',
               'footer-putter'); break;

            case 'footer_filter_hook_heading':
               $message = __('Footer Filter Hook',
               'footer-putter'); break;
            case 'footer_filter_hook_tip':
               $message = __('If you want to kill off the footer created by your theme, and your theme allows you to filter the content of the footer, then enter the hook where the theme filters the footer. This may stop you getting two footers; one created by your theme and another created by this plugin.',
               'footer-putter'); break;

            case 'footer_hook_heading':
               $message = __('Footer Action Hook',
               'footer-putter'); break;
            case 'footer_hook_tip':
               $message = __('The hook where the footer widget area is added to the page. This field is only required if the theme does not already provide a suitable widget area where the footer widgets can be added.',
               'footer-putter'); break;

            case 'footer_remove_heading':
               $message = __('Remove All Actions',
               'footer-putter'); break;
            case 'footer_remove_tip':
               $message = __('Click the checkbox to remove any other actions at the above footer hook. This may stop you getting two footers; one created by your theme and another created by this plugin. For some themes you will check this option as you will typically want to replace the theme footer by the plugin footer.',
               'footer-putter'); break;

            case 'hide_wordpress_heading':
               $message = __('Hide WordPress Link',
               'footer-putter'); break;
            case 'hide_wordpress_tip':
               $message = __('Hide link to WordPress.org',
               'footer-putter'); break;

            case 'latitude_heading':
               $message = __('Latitude',
               'footer-putter'); break;
            case 'latitude_tip':
               $message = __('Enter the latitude of the organization&#39;s location - maybe be used by Google or local search.',
               'footer-putter'); break;

            case 'locality_heading':
               $message = __('Locality (City)',
               'footer-putter'); break;
            case 'locality_tip':
               $message = __('Enter the town or city.',
               'footer-putter'); break;
 
            case 'longitude_heading':
               $message = __('Longitude',
               'footer-putter'); break;
            case 'longitude_tip':
               $message = __('Enter the longitude of the organization&#39;s location - maybe be used by Google or local search.',
               'footer-putter'); break;

            case 'map_heading':
               $message = __('Locality (City)',
               'footer-putter'); break;
            case 'map_tip':
               $message = __('Enter the URL of a map that shows the organization&#39;s location',
               'footer-putter'); break;

            case 'microdata_heading':
               $message = __('Use Microdata',
               'footer-putter'); break;
            case 'microdata_tip':
               $message = __('Mark up the organization details with HTML5 microdata.',
               'footer-putter'); break;
 
            case 'owner_heading':
               $message = __('Owner/Business Name',
               'footer-putter'); break;
            case 'owner_tip':
               $message = __('Enter the name of the legal entity that owns and operates the site.',
               'footer-putter'); break;

            case 'postal_code_heading':
               $message = __('Postal Code (Zipcode)',
               'footer-putter'); break;
            case 'postal_code_tip':
               $message = __('Enter the postal code.',
               'footer-putter'); break;

            case 'privacy_contact_heading':
               $message = __('Add Privacy Contact',
               'footer-putter'); break;
            case 'privacy_contact_tip':
               $message = __('Add a section to the end of the Privacy page with contact and legal information.',
               'footer-putter'); break;

            case 'region_heading':
               $message = __('State (Region)',
               'footer-putter'); break;
            case 'region_tip':
               $message = __('Enter the state, province, region or county.',
               'footer-putter'); break;

            case 'return_class_heading':
               $message = __('Return To Top Class',
               'footer-putter'); break;
            case 'return_class_tip':
               $message = __('Add any custom class you want to apply to the Return To Top link.',
               'footer-putter'); break;

           case 'return_text_heading':
               $message = __('Link Text',
               'footer-putter'); break;
            case 'return_text_tip':
               $message = __('The text of the Return To Top link. For example, <i>Return To Top</i> or <i>Back To Top</i>.',
               'footer-putter'); break;

            case 'street_address_heading':
               $message = __('Street Address',
               'footer-putter'); break;
            case 'street_address_tip':
               $message = __('Enter the first line of the address that you want to appear in the footer and the privacy and terms pages.',
               'footer-putter'); break;

            case 'telephone_heading':
               $message = __('Telephone Number',
               'footer-putter'); break;
            case 'telephone_tip':
               $message = __('Enter a telephone number here if you want it to appear in the footer of the installed site.',
               'footer-putter'); break;
               
            case 'terms_contact_heading':
               $message = __('Add Terms Contact',
               'footer-putter'); break;
            case 'terms_contact_tip':
               $message = __('Add a section to the end of the Terms page with contact and legal information.',
               'footer-putter'); break;

            case 'updated_heading':
               $message = __('Last Updated',
               'footer-putter'); break;
            case 'updated_tip':
               $message = __('This will be defaulted as today. For example, June 30th, 2020.',
               'footer-putter'); break;

            case 'html_title_heading':
               $message = __('Widget Title',
               'footer-putter'); break;
            case 'html_title_tip':
               $message = __('Enhanced widget title can contain some HTML such as links, spans and breaks.',
               'footer-putter'); break;
               
            case 'class_heading':
               $message = __('Widget Class',
               'footer-putter'); break;
            case 'class_tip':
               $message = __('Class to place on widget instance to make CSS customization easier.',
               'footer-putter'); break;

              case 'nav_menu_heading':
               $message = __('Footer Menu',
               'footer-putter'); break;
            case 'nav_menu_tip':
               $message = __('Choose the menu to display in the footer.',
               'footer-putter'); break;

            case 'center_heading':
               $message = __('Center Menu',
               'footer-putter'); break;
            case 'center_tip':
               $message = __('Center the footer horizontally.',
               'footer-putter'); break;

            case 'layout_heading':
               $message = __('Layout',
               'footer-putter'); break;
            case 'layout_tip':
               $message = __('Choose order and layout in which menu, copyright and contact are placed, + means same line, | means new line.',
               'footer-putter'); break;

            case 'show_copyright_heading':
               $message = __('Show Copyright',
               'footer-putter'); break;
            case 'show_copyright_tip':
               $message = __('Show copyright holder an year range.',
               'footer-putter'); break;

            case 'show_address_heading':
               $message = __('Show Address',
               'footer-putter'); break;
            case 'show_address_tip':
               $message = __('Show contact address.',
               'footer-putter'); break;

            case 'show_telephone_heading':
               $message = __('Show Telephone Number',
               'footer-putter'); break;
            case 'show_telephone_tip':
               $message = __('Show telephone number(s).',
               'footer-putter'); break;

            case 'show_email_heading':
               $message = __('Show Email Address',
               'footer-putter'); break;
            case 'show_email_tip':
               $message = __('Show email.',
               'footer-putter'); break;

            case 'use_microdata_heading':
               $message = __('Use HTML5 Microdata',
               'footer-putter'); break;
            case 'use_microdata_tip':
               $message = __('Express organization, contact and any geo-coordinates using HTML5 microdata.',
               'footer-putter'); break;

            case 'show_return_heading':
               $message = __('Show Return To Top Links',
               'footer-putter'); break;
            case 'show_return_tip':
               $message = __('Show link to return to the top of the page.',
               'footer-putter'); break;

            case 'return_class_heading':
               $message = __('Return To Top',
               'footer-putter'); break;
            case 'return_class_tip':
               $message = __('Add custom classes to apply to the return to top links.',
               'footer-putter'); break;

            case 'footer_class_heading':
               $message = __('Footer Credits',
               'footer-putter'); break;
            case 'footer_class_tip':
               $message = __('Add custom classes to apply to the footer menu, copyright and contact information.',
               'footer-putter'); break;

            case 'visibility_heading':
               $message = __('Show or Hide',
               'footer-putter'); break;
            case 'visibility_tip':
               $message = __('Determine on which pages the footer widget is displayed.',
               'footer-putter'); break;

            case 'title_heading':
               $message = __('Label',
               'footer-putter'); break;
            case 'title_tip':
               $message = __('Label appears only in the Widget Dashboard to make widget identification easier.',
               'footer-putter'); break;

            case 'category_heading':
               $message = __('Category',
               'footer-putter'); break;
            case 'category_tip':
               $message = __('Select Link Category for Your Trademarks.',
               'footer-putter'); break;
               
            case 'limit_heading':
               $message = __('# of links',
               'footer-putter'); break;
            case 'limit_tip':
               $message = __('Number of trademarks to show.',
               'footer-putter'); break;
 
            case 'orderby_heading':
               $message = __('Order By',
               'footer-putter'); break;
            case 'orderby_tip':
               $message = __('Sort by name, rating, ID or random.',
               'footer-putter'); break;

            case 'nofollow_heading':
               $message = __('Rel=nofollow',
               'footer-putter'); break;
            case 'nofollow_tip':
               $message = __('Mark the links with rel=nofollow.',
               'footer-putter'); break;               

            /* END tooltips */ 

            /* WIDGETS  */

            case 'copyright_widget_name':
               $message = __('Footer Copyright Widget',
               'footer-putter'); break;

            case 'copyright_widget_description':
               $message = __('A widget displaying menu links, copyright and company details',
               'footer-putter'); break;

            case 'trademarks_widget_name':
               $message = __('Trademarks Widget',
               'footer-putter'); break;

            case 'trademarks_widget_description':
               $message = __('Trademarks, Service Marks and Kitemarks',
               'footer-putter'); break;

            case 'layout_single':
               $message = __('Single line: Menu + copyright + contact',
               'footer-putter'); break;

            case 'layout_single_alt':
               $message = __('Single line: Menu + contact + copyright',
               'footer-putter'); break;
               
            case 'layout_contact_below':
               $message = __('2 lines: Menu + copyright | Contact',
               'footer-putter'); break;

            case 'layout_copyright_below':
               $message = __('2 lines: Menu + contact | Copyright',
               'footer-putter'); break;
               
            case 'layout_menu_above':
               $message = __('2 lines: Menu | Copyright + contact',
               'footer-putter'); break;

            case 'layout_menu_above_alt':
               $message = __('2 lines: Menu | Contact + copyright',
               'footer-putter'); break;

            case 'layout_stacked':
               $message = __('3 lines : Menu | Copyright | Contactt',
               'footer-putter'); break;               

            case 'layout_stacked_alt':
               $message = __('3 lines : Menu | Contact | Copyright',
               'footer-putter'); break;                    

            case 'orderby_link_title':
               $message = __('Link title',
               'footer-putter'); break;

            case 'orderby_link_rating':
               $message = __('Link rating',
               'footer-putter'); break;

            case 'orderby_link_id':
               $message = __('Link ID',
               'footer-putter'); break;

            case 'orderby_random':
               $message = __('Random',
               'footer-putter'); break;


            case 'visibility_all':
               $message = __('Show on all pages',
               'footer-putter'); break;


            case 'visibility_hide_landing':
               $message = __('Hide on landing pages',
               'footer-putter'); break;

            case 'visibility_show_landing':
               $message = __('Show only on landing pages',
               'footer-putter'); break;
  
            /* END WIDGETS  */


            /* MISC  */

            case 'address_instructions':
               $message = __('<p>Leave the above address field blank and fill in the various parts of the organization address below if you want to be able to use HTML5 microdata.</p>',
               'footer-putter'); break;

            case 'advanced_instructions':
               $message = __('<p>You can place the Copyright and Trademark widgets in any existing widget area. However, if your theme does not have a suitably located widget area in the footer then you can create one by specifying the hook where the Widget Area will be located.</p>
<p>You may use a standard WordPress hook like <i>get_footer</i> or <i>wp_footer</i> or choose a hook that is theme-specific such as <i>twentyten_credits</i>, 
<i>twentyeleven_credits</i>, <i>twentytwelve_credits</i>,<i>twentythirteen_credits</i>, <i>twentyfourteen_credits</i>, etc. If you using a Genesis child theme and the theme does not have a suitable widget area then use 
the hook <i>genesis_footer</i> or maybe <i>genesis_after</i>. See what looks best. Click for <a href="%1$s">suggestions of which hook to use for common WordPress themes</a>.</p>',
               'footer-putter'); break;

            case 'widget_presence_heading':
               $message = __('Widget Presence',
               'footer-putter'); break;
               
            case 'custom_classes_heading':
               $message = __('Custom Classes',
               'footer-putter'); break;
               
            case 'custom_classes_instructions':
               $message = __('<p>Add any custom CSS classes you want apply to the footer section content to change the font color and size.</p><p>For your convenience we have defined 3 color classes <i>dark</i>, <i>light</i> and <i>white</i>, and 2 size classes, 
<i>small</i> and <i>tiny</i>. Feel free to use these alongside your own custom CSS classes.</p>',
               'footer-putter'); break;
               
            case 'geo_instructions':
               $message = __('<p>The geographical co-ordinates are optional and are visible only to the search engines.</p>',
               'footer-putter'); break;

            case 'intro_advanced_instructions':
               $message = __('The following information is concerned with the static footer content and its WordPress hooks which govern its precise location.',
               'footer-putter'); break;

            case 'intro_instructions':
               $message = __('The following information is used in the Footer Copyright Widget and optionally at the end of the Privacy Statement and Terms and Conditions pages.',
               'footer-putter'); break;

            case 'preview_instructions':
               $message = __('Note: The preview below is purely illustrative. Actual footer layout on the site will vary based on footer widget settings.',
               'footer-putter'); break;

            case 'remove_instructions':
               $message = __('If your WordPress theme supplies a filter hook rather than an action hook where it generates the footer, and you want to suppress the theme footer, then specify the hook below. For example, entering <i>genesis_footer_output</i> will suppress the standard Genesis child theme footer.',
               'footer-putter'); break;


            case 'trademarks_intro':
               $message = __('
<p class="attention">There are no settings on this page.</p>
<p class="attention">However, links are provided to where you set up trademarks or other symbols you want to appear in the footer.</p>

<p class="bigger">Firstly go to the <a href="%1$s">Link Categories</a> and set up a link category called <i>Trust Marks</i> or something similar.</p>
<p class="bigger">Next go to the <a href="%2$s">Add Link</a> and add a link for each trademark
specifying the Image URL, and optionally the link URL and of course adding each link to your chosen link category. 
<p class="bigger">Finally go to the <a href="%3$s">Appearance | Widgets</a> and drag a trademark widget into the custom footer widget
area and select <i>Trust Marks</i> as the link category.</p>               ',
               'footer-putter'); break;
               
            case 'trademarks_tips':
               $message = __('
<h3>Image File Size</h3>
<p>The plugin uses each trademark image "as is" so you need to provide trademark images that are suitably sized. </p>
<p>For a consistent layout make sure all images are the same height. A typical height will be of the order of 50px to 100px depending on how prominently you want them to feature.</p>
<h3>Image File Type</h3>
<p>If your trademark images are JPG files on a white background, and your footer has a white background then using JPGs will be fine. Otherwise your footer look better if you use PNG files that have a transparent background</p>
               ',
               'footer-putter'); break;

            case 'trademarks_screenshots':
               $message = __('
<p>Below are annotated screenshots of creating the link category and adding a link .
<h4>Add A Link Category</h4>
<p><img class="dashed-border" src="%1$s" alt="Screenshot of adding a trademark link category" /></p>
<h4>Add A Link</h4>
<p><img class="dashed-border" src="%1$s" alt="Screenshot of adding a trademark link " /></p>
                ',
               'footer-putter'); break;
               
            /* END MISC */ 
 
            /* HELP  */
            case 'help_create_trademark_links':
               $message = __('
<h4>Create Trademark Links</h4>
<ol>
<li>Go to <a href="%1$s"><i>Footer Trademarks</i></a> and follow the instructions:</li>
<li>Create a link category with a name such as <i>Trademarks</i></li>
<li>Add a link for each of your trademarks and put each in the <i>Trademarks</i> link category</li>
<li>For each link specify the link URL and the image URL</li>
</ol>             
               ',
               'footer-putter'); break;

            case 'help_hooks':
               $message = __("
<p>The footer hook is only required if your theme does not already have a footer widget area into which you can drag the two widgets.</p>
<p>For some themes, the footer hook is left blank, for others use a WordPress hook such as <i>get_footer</i> or <i>wp_footer</i>, 
or use a theme-specific hook such as <i>twentytfourteen_credits</i>, <i>twentyfifteen_credits</i>, <i>genesis_footer</i>, <i>pagelines_leaf</i>, etc.</p>
               ",
               'footer-putter'); break;

            case 'help_links':
               $message = __('
<ul>
<li><a rel="external" target="_blank" href="%1$s">Footer Putter Plugin Home</a></li>
<li><a rel="external" target="_blank" href="https://www.diywebmastery.com/footer-credits-compatible-themes-and-hooks/">Themes and Recommended Footer Hooks</a></li>
<li><a rel="external" target="_blank" href="https://www.diywebmastery.com/4098/how-to-add-a-different-footer-on-landing-pages/">How To Use A Different Footer On Landing Pages</a></li>
<li><a rel="external" target="_blank" href="https://www.diywebmastery.com/4109/using-html5-microdata-footer/">Using HTML5 Microdata for better SEO and Local Search</a></li>
</ul>
               ',
               'footer-putter'); break;
               
            case 'help_pages':
               $message = __('
<h4>Create Standard Pages And Footer Menu</h4>
<ol>
<li>Create a <i>Privacy Policy</i> page with the slug/permalink <em>privacy</em>, choose a page template with no sidebar.</li>
<li>Create a <i>Terms of Use</i> page with the slug/permalink <em>terms</em>, choose a page template with no sidebar.</li>
<li>Create a <i>Contact</i> page with a contact form.</li>
<li>Create an <i>About</i> page, with information either about the site or about its owner.</li>
<li>If the site is selling an information product you may want to create a <i>Disclaimer</i> page, regarding any claims about the product performance.</li>
<li>Create a WordPress menu called <i>Footer Menu</i> and add the above pages to the footer menu.</li>
</ol>
               ',
               'footer-putter'); break;

            case 'help_setup_footer_widgets':
               $message = __('
<h4>Set Up Footer Widgets</h4>
<ol>
<li>Go to <a href="%1$s"><i>Appearance > Widgets</i></a></li>
<li>Drag a <i>Footer Copyright Widget</i> and a <i>Footer Trademarks widget</i> into a suitable footer Widget Area</li>
<li>For the <i>Footer Trademarks</i> widget and choose your link category, e.g. <i>Trademarks</i>, and select a sort order</li>
<li>For the <i>Footer Copyright</i> widget, select the <i>Footer Menu</i> and choose what copyright and contact information you want to you display</li>
<li>Review the footer of the site. You can use the widget to change font sizes and colors using pre-defined classes such as <i>tiny</i>, <i>small</i>, <i>dark</i>, <i>light</i> or <i>white</i> or add your own custom classes</li> 
<li>You can also choose to suppress the widgets on special pages such as landing pages.</li> 
<li>If the footer is not in the right location you can use the <i>Footer Hook</i> feature described below to add a new widget area called <i>Credibility Footer</i> where you can locate the footer widgets.</li> 
</ol>
               ',
               'footer-putter'); break;
               
            case 'help_update_business_information':
               $message = __('
<h4>Update Business Information</h4>
<ol>
<li>Go to <a href="%1$s">Footer Credits</a> and update the Site Owner details, contact and legal information.</li>
<li>Optionally include contact details such as telephone and email. You may also want to add Geographical co-ordinates for your office location for the purposes of local search.</li>
</ol>               
               ',
               'footer-putter'); break;
                              
            case 'help_widgets':
               $message = __('
<p>The plugin defines two widgets: 
<ol>
<li>a <b>Footer Copyright Widget</b> that places a line at the foot of your site containing as many of the items listed above that you want to disclose.</li>
<li>a <b>Trademarks Widget</b> that displays a line of trademarks that you have previously set up as links.
</ol></p>
<p>Typically you will drag both widgets into the Custom Footer Widget Area.</p>
<p>The widgets have settings that allow you to control both the footer content and the layout, and also whether or not the widgets appear at all on landing pages.</p>
               ',
               'footer-putter'); break;

            /* END HELP */ 

 

        }
       return $message;     
    }

}