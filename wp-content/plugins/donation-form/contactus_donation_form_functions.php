<?php

//CUS API LIBRARY
if (!class_exists('cUsComAPI_DF')) {
    require_once('libs/cusAPI.class.php');
}

// AJAX REQUEST HOOKS
require_once('contactus_donation_form_ajx_request.php');

if (!function_exists('cUsDF_admin_header')) {

    function cUsDF_admin_header() {
        
        global $current_screen;

        if ($current_screen->id == 'toplevel_page_cUs_donation_form_plugin') {
            
            wp_enqueue_style( 'cUsDF_Styles', plugins_url('style/cUsDF_style.css', __FILE__), false, '1');
            wp_enqueue_style( 'colorbox', plugins_url('scripts/colorbox/colorbox.css', __FILE__), false, '1');
            wp_enqueue_style( 'bxslider', plugins_url('scripts/bxslider/jquery.bxslider.css', __FILE__), false, '1');
            wp_enqueue_style( 'wp-jquery-ui-dialog' );
			
			wp_enqueue_style( 'other_info_styles', plugins_url('style/styles.css', __FILE__), false, '1');
			wp_register_script( 'other_info_scripts', plugins_url('scripts/main.js?pluginurl=' . dirname(__FILE__), __FILE__), array('jquery'), '1.0', true);

            wp_register_script( 'cUsDF_Scripts', plugins_url('scripts/cUsDF_scripts.js?pluginurl=' . dirname(__FILE__), __FILE__), array('jquery'), '1.0', true);
            wp_localize_script( 'cUsDF_Scripts', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
            wp_register_script( 'colorbox', plugins_url('scripts/colorbox/jquery.colorbox-min.js', __FILE__), array('jquery'), '1.4.33', true);
            wp_register_script( 'bxslider', plugins_url('scripts/bxslider/jquery.bxslider.js', __FILE__), array('jquery'), '4.1.1', true);

            wp_enqueue_script('jquery'); //JQUERY WP CORE
            wp_enqueue_script('jquery-ui-core');
            wp_enqueue_script('jquery-ui-accordion');
            wp_enqueue_script('jquery-ui-tabs');
            wp_enqueue_script('jquery-ui-button');
            wp_enqueue_script('jquery-ui-selectable');
            wp_enqueue_script('jquery-ui-dialog');
            wp_enqueue_script('colorbox');
            wp_enqueue_script('tooltip');
            wp_enqueue_script('bxslider');
			wp_enqueue_script('other_info_scripts');
            
            wp_enqueue_script('cUsDF_Scripts');
        }
    }

}
add_action('admin_enqueue_scripts', 'cUsDF_admin_header'); // cUsDF_admin_header hook
//END CONTACTUS.COM PLUGIN STYLES CSS

function donation_plugin_links($links, $file) {
    $plugin_file = 'contactus-donation-form/contactus_donation_form.php';
    if ($file == $plugin_file) {
        $links[] = '<a target="_blank" style="color: #42a851; font-weight: bold;" href="http://help.contactus.com/">' . __("Get Support", "cus_donation_plugin") . '</a>';
    }
    return $links;
}

add_filter('plugin_row_meta', 'donation_plugin_links', 10, 2);


/**
 * This should create the setting button in plugin CF7 cloud database
 * */
function cUsDF_action_links($links, $file) {
    $plugin_file = 'contactus-donation-form/contactus_donation_form.php';
    //make sure it is our plugin we are modifying
    if ($file == $plugin_file) {
        $settings_link = '<a href="' .
                admin_url('admin.php?page=cUs_donation_form_plugin') . '">' . __('Settings', 'cus_plugin') . '</a>';
        array_unshift($links, $settings_link);
    }
    return $links;
}

add_filter("plugin_action_links", 'cUsDF_action_links', 10, 4);

//Display the validation errors and update messages

/*
 * Admin notices
 */

function cUsDF_admin_notices() {
    settings_errors();
}

add_action('admin_notices', 'cUsDF_admin_notices');

if ( is_admin() ) {
    add_action('media_buttons', 'set_media_cus_donation_forminsert_button', 100);
    function set_media_cus_donation_forminsert_button() {
        $xHtml_mediaButton = '<a href="javascript:;" class="insertShortcode" title="'.__('Insert Donation Form').'">';
            $xHtml_mediaButton .= '<img hspace="5" src="'.plugins_url('style/images/favicon.gif', __FILE__).'" alt="'.__('Insert Donation Form').'" />';
        $xHtml_mediaButton .= '</a>';
        //print $xHtml_mediaButton;
    }
}


function cUsDF_JS_into_html() {
    if (!is_admin()) {
        
        $pageID = get_the_ID();
        $pageSettings = get_post_meta( $pageID, 'cUsDF_FormByPage_settings', false );
        
        if(is_array($pageSettings) && !empty($pageSettings)){ //NEW VERSION 3.0
            
            $boolTab        = $pageSettings[0]['tab_user'];
            $cus_donation_version    = $pageSettings[0]['cus_donation_version'];
            $form_key       = $pageSettings[0]['form_key'];
            
            if($cus_donation_version == 'tab'){
                
                $userJScode = '<script type="text/javascript" src="//cdn.contactus.com/cdn/forms/' . $form_key . '/contactus.js"></script>';
                echo $userJScode;
				
            }
            
        }else{ //PREVIOUS VERSIONS 2.5
            
            $formOptions    = get_option('cUsDF_FORM_settings');//GET THE NEW FORM OPTIONS
            $getTabPages    = get_option('cUsDF_settings_tabpages');
            
            $getInlinePages = get_option('cUsDF_settings_inlinepages');
            $form_key       = get_option('cUsDF_settings_form_key');
            $boolTab        = $formOptions['tab_user'];
            $cus_donation_version    = $formOptions['cus_donation_version'];
            
            if( !empty($getTabPages) && in_array('home', $getTabPages) && is_home() ){
                $getHomePage    = get_option('cUsDF_HOME_settings');
                $boolTab        = $getHomePage['tab_user'];
                $cus_donation_version    = $getHomePage['cus_donation_version'];
                $form_key       = $getHomePage['form_key'];
            }
            
            $userJScode = '<script type="text/javascript" src="//cdn.contactus.com/cdn/forms/' . $form_key . '/contactus.js"></script>';

            //the theme must have the wp_footer() function included
            //include the contactUs.com JS before the </body> tag
            switch ($cus_donation_version) {
                case 'tab':
                    if (strlen($form_key) && $boolTab){
                        echo $userJScode;
                    }
                    break;
                case 'selectable':
                    if (strlen($form_key) && is_array($getTabPages) && in_array($pageID, $getTabPages)){
                        echo $userJScode;
                    }
                    break;
            }
            
        }
          
    }
}
add_action('wp_footer', 'cUsDF_JS_into_html'); // ADD JS BEFORE BODY TAG

function cUsDF_inline_home() {

    $formOptions    = get_option('cUsDF_FORM_settings'); // GET THE NEW FORM OPTIONS
    $form_key       = get_option('cUsDF_settings_form_key');
    $cus_donation_version    = $formOptions['cus_donation_version'];
    if ($cus_donation_version == 'inline' || $cus_donation_version == 'selectable') {
        $inlineJS_output = '<div style="min-height: 300px; width: 350px;clear:both;"><script type="text/javascript" src="//cdn.contactus.com/cdn/forms/' . $form_key . '/inline.js"></script></div>';
    }else{
        $inlineJS_output = '';
    }

    echo $inlineJS_output;
}

function cUsDF_page_settings_cleaner() {
    $aryPages = get_pages();
    foreach ($aryPages as $oPage) {
        delete_post_meta($oPage->ID, 'cUsDF_FormByPage_settings');//reset values
        cUsDF_inline_shortcode_cleaner_by_ID($oPage->ID); //RESET SC
    }
}

function cUsDF_inline_shortcode_cleaner() {
    $aryPages = get_pages();
    foreach ($aryPages as $oPage) {
        $pageContent = $oPage->post_content;
        $pageContent = str_replace('[show-contactus.com-donation-form]', '', $pageContent);
        $aryPage = array();
        $aryPage['ID'] = $oPage->ID;
        $aryPage['post_content'] = $pageContent;
        wp_update_post($aryPage);
    }
}

function cUsDF_inline_shortcode_cleaner_by_ID($inline_req_page_id) {
    $oPage = get_page( $inline_req_page_id );
    
    $pageContent = $oPage->post_content;
    $pageContent = str_replace('[show-contactus.com-donation-form]', '', $pageContent);
    $aryPage = array();
    $aryPage['ID'] = $oPage->ID;
    $aryPage['post_content'] = $pageContent;
    wp_update_post($aryPage); 
}

add_shortcode("show-contactus.com-donation-form", "cUsDF_shortcode_handler"); //[show-contactus.com-donation-form]

function cUsDF_shortcode_handler($aryFormParemeters) {
    
    $cUsDF_credentials = get_option('cUsDF_settings_userCredentials'); //GET USERS CREDENTIALS V3.0 API 1.9
    
    if(!empty($cUsDF_credentials)){ 
        
        $pageID = get_the_ID();
        $pageSettings = get_post_meta( $pageID, 'cUsDF_FormByPage_settings', false );
        $inlineJS_output = '';

        if(is_array($pageSettings) && !empty($pageSettings)){ //NEW VERSION 3.0

            $boolTab        = $pageSettings[0]['tab_user'];
            $cus_donation_version    = $pageSettings[0]['cus_donation_version'];
            $form_key       = $pageSettings[0]['form_key'];

            if(strlen($formkey)) $form_key = $formkey;

            if ($cus_donation_version == 'inline' || $cus_donation_version == 'selectable') {
               $inlineJS_output = '<div style="min-height: 300px; min-width: 340px; clear:both;"><script type="text/javascript" src="//cdn.contactus.com/cdn/forms/' . $form_key . '/inline.js"></script></div>';
            }

        }elseif(is_array($aryFormParemeters)){

            if($aryFormParemeters['version'] == 'tab'){
                $Fkey = $aryFormParemeters['formkey'];
                update_option('cUsDF_settings_FormKey_SC', $Fkey);
                do_action('wp_footer', $Fkey);
                add_action('wp_footer', 'cUsDF_shortcodeTab'); // ADD JS BEFORE BODY TAG
            }else{
                $inlineJS_output = '<div style="min-height: 300px; min-width: 340px; clear:both;"><script type="text/javascript" src="//cdn.contactus.com/cdn/forms/' . $aryFormParemeters['formkey'] . '/inline.js"></script></div>';
            }

        }else{   //OLDER VERSION < 2.5 //UPDATE 
            $formOptions    = get_option('cUsDF_FORM_settings');//GET THE NEW FORM OPTIONS
            $form_key       = get_option('cUsDF_settings_form_key');
            $cus_donation_version    = $formOptions['cus_donation_version'];

            if ($cus_donation_version == 'inline' || $cus_donation_version == 'selectable') {
                $inlineJS_output = '<div style="min-height: 300px; min-width: 340px; clear:both;"><script type="text/javascript" src="//cdn.contactus.com/cdn/forms/' . $form_key . '/inline.js"></script></div>';
            }

        }

        return $inlineJS_output;
    }else{
        
        return '<p>Donation Form by ContactUs.com user Credentials Missing . . . <br/>Please Login Again <a href="'.get_admin_url().'admin.php?page=cUs_donation_form_plugin" target="_blank">here</a>, Thank You.</p>';
        
    }
    
}

function cUsDF_shortcodeTab($Args) {
    
    $form_key = get_option('cUsDF_settings_FormKey_SC');
    
    if ( !is_admin() && strlen($form_key) ) {
        $userJScode = '<script type="text/javascript" src="//cdn.contactus.com/cdn/forms/' . $form_key . '/contactus.js"></script>';
        echo $userJScode;
    }
}


function cUsDF_inline_shortcode_add($inline_req_page_id) {
    
    if($inline_req_page_id != 'home'){
        $oPage = get_page($inline_req_page_id);
        $pageContent = $oPage->post_content;
        $pageContent = $pageContent . "\n[show-contactus.com-donation-form]";
        $aryPage = array();
        $aryPage['ID'] = $inline_req_page_id;
        $aryPage['post_content'] = $pageContent;
        return wp_update_post($aryPage);
    }
}

$cus_donation_dirbase = trailingslashit(basename(dirname(__FILE__)));
$cus_donation_dir = trailingslashit(WP_PLUGIN_DIR) . $cus_donation_dirbase;
$cus_donation_url = trailingslashit(WP_PLUGIN_URL) . $cus_donation_dirbase;
define('cUsDF_DIR', $cus_donation_dir);
define('cUsDF_URL', $cus_donation_url);

// WIDGET CALL
include_once('contactus_donation_form_widget.php');

function cUsDF_register_widgets() {
    register_widget('contactus_donation_form_Widget');
}

add_action('widgets_init', 'cUsDF_register_widgets');

//CONTACTUS.COM ADD DONATION FORM TO PLUGIN PAGE

// Add option page in admin menu
if (!function_exists('cUsDF_admin_menu')) {

    function cUsDF_admin_menu() {
        add_menu_page('Donation Form by ContactUs.com ', 'Donation Form', 'edit_themes', 'cUs_donation_form_plugin', 'cUsDF_menu_render', plugins_url("style/images/favicon.gif", __FILE__));
    }

}
add_action('admin_menu', 'cUsDF_admin_menu'); // cUsDF_admin_menu hook


if (!function_exists('cUsDF_plugin_db_uninstall')) {

    function cUsDF_plugin_db_uninstall() {

        $cUsDF_api = new cUsComAPI_DF();
        $cUsDF_api->DF_resetData(); //RESET DATA
        
        cUsDF_page_settings_cleaner();
        
    }
    
}

register_uninstall_hook(__FILE__, 'cUsDF_plugin_db_uninstall');

/* Display a notice that can be dismissed */
add_action('admin_notices', 'cUsDF_update_admin_notice');
function cUsDF_update_admin_notice() {
	
        global $current_user ;
        $user_id = $current_user->ID;
        
        $aryUserCredentials = get_option('cUsDF_settings_userCredentials');
        $form_key           = get_option('cUsDF_settings_form_key');
        $cUs_API_Account    = $aryUserCredentials['API_Account'];
        $cUs_API_Key        = $aryUserCredentials['API_Key'];
        
	if ( ! get_user_meta($user_id, 'cUsDF_ignore_notice') && !strlen($cUs_API_Account) && !strlen($cUs_API_Key) && strlen($form_key)) {
            echo '<div class="updated"><p>';
            printf(__('Donation Form has been updated to v3.1!. Pleas take time to activate your check our new features <a href="%1$s">here</a>. | <a href="%2$s">Hide Notice</a>'), 'admin.php?page=cUs_donation_form_plugin', '?cUsDF_ignore_notice=0');
            echo "</p></div>";
	}
        
}
add_action('admin_init', 'cUsDF_nag_ignore');
function cUsDF_nag_ignore() {
	global $current_user;
        $user_id = $current_user->ID;
        if ( isset($_GET['cUsDF_ignore_notice']) && '0' == $_GET['cUsDF_ignore_notice'] ) {
             add_user_meta($user_id, 'cUsDF_ignore_notice', 'true', true);
	}
}


/*
 * Method in charge to update default form key
 * @since 4.01
 * @param string $form_key Form Key to validate
 * @return null
 */
function DF_updateDefaultFormKey($form_key) {
    $default_form_key = get_option('cUsDF_settings_form_key');
    if ($default_form_key != $form_key) {
        update_option('cUsDF_settings_form_key', $form_key);
    }
}



?>
