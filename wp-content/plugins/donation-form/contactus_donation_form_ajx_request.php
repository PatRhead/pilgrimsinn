<?php

// loginAlreadyUser handler function...
add_action('wp_ajax_cUsDF_loginAlreadyUser', 'cUsDF_loginAlreadyUser_callback');
function cUsDF_loginAlreadyUser_callback() {
    
    $cUsDF_api  =   new cUsComAPI_DF();
    
    // print_r(get_class_methods(new cUsComAPI_DF()) ); exit;
    
    $cUs_email  =   $_REQUEST['email'];
    $cUs_pass   =   $_REQUEST['pass'];
    
    $cUsDF_API_credentials = $cUsDF_api->getAPICredentials($cUs_email, $cUs_pass); //api hook;
    //print_r( $cUsDF_API_credentials ); exit;
    if($cUsDF_API_credentials){
        $cUs_json = json_decode($cUsDF_API_credentials);
        
        switch ( $cUs_json->status ) {
            case 'success':
                
                $cUs_API_Account    = $cUs_json->api_account;
                $cUs_API_Key        = $cUs_json->api_key;
                
                if(strlen(trim($cUs_API_Account)) && strlen(trim($cUs_API_Key))){
                    
                    $aryUserCredentials = array(
                        'API_Account' => $cUs_API_Account,
                        'API_Key'     => $cUs_API_Key
                    );
                    update_option('cUsDF_settings_userCredentials', $aryUserCredentials);
                    
                    $cUsDF_API_getKeysResult = $cUsDF_api->getFormKeysAPI($cUs_API_Account, $cUs_API_Key, $form_type = ''); //api hook;
                    $cUs_jsonKeys = json_decode( $cUsDF_API_getKeysResult );

                    
                    // get a default deeplink
                    update_option('cUsDF_default_deep_link_view', $cUsDF_api->get_deeplink( $cUs_jsonKeys->data ) ); // DEFAULT FORM KEYS

                    
                    if($cUs_jsonKeys->status == 'success'){
                        
                        $postData = array( 'email' => $cUs_email, 'credential' => $cUs_pass);
                        update_option('cUsDF_settings_userData', $postData);
                        
                        // if there is a Donation form set in admin
                        if( count($cUs_jsonKeys->data) > 0)
                            foreach ($cUs_jsonKeys->data as $key => $value) {
                                if ( $value->form_type == 'donation' && $value->default == 1){ //GET DEFAULT DONATION FORM KEY // ebe
                                   $defaultFormKey     = $value->form_key;
                                   $deeplinkview       = $value->deep_link_view;
                                   $defaultFormId      = $value->form_id;
                                }
                            }

                        
						
						// here is no donation form is available then get data to create donation form deeplink
                        if(!strlen($defaultFormKey)){
                                //echo 2; //NO ONE Donation FORM 
                                //echo('there is no default donation form'); exit;
                                $cUs_API_Account    = $cUs_json->api_account;
                        		$cUs_API_Key        = $cUs_json->api_key;
                                
                                
                                $aryResponse = array(
                                    'status' => 2,
                                    'cUs_API_Account' 	=> $cUs_API_Account,
                                    'cUs_API_Key' 		=> $cUs_API_Key,
                                    'deep_link_view'	=> urlencode($cUsDF_api->get_deeplink( $cUs_jsonKeys->data ))
                                );
								
								//print_r( $aryResponse ); exit;
                                
                        }else{
                            
                            $aryFormOptions = array('tab_user' => 1,'cus_donation_version' => 'tab'); //DEFAULT SETTINGS / FIRST TIME
                            
                            update_option('cUsDF_FORM_settings', $aryFormOptions ); // UPDATE FORM SETTINGS
                            update_option('cUsDF_settings_form_key', $defaultFormKey); // DEFAULT FORM KEYS
                            update_option('cUsDF_settings_form_id', $defaultFormId); // DEFAULT FORM KEYS
                            update_option('cUsDF_default_deep_link_view', $cUsDF_api->get_deeplink($deeplinkview) ); // DEFAULT FORM KEYS
                            update_option('cUsDF_settings_form_keys', $cUs_jsonKeys); // ALL FORM KEYS
                            
                            //print_r( get_option('cUsDF_settings_form_keys') ); exit;
                           
                            $aryResponse = array('status' => 1);
                            
                        } 

                            //echo 1;
                        
                    }elseif( $cUs_jsonKeys->status == 'error' ){

                        // try to get api_account and api_key cause a donation form was not found and we need this data to create a deeplink

                        $cUs_API_Account    = $cUs_json->api_account;
                        $cUs_API_Key        = $cUs_json->api_key;
						
						//echo $cUs_API_Account; exit;

                        $aryResponse = array( 'status' => 2, 'message' => $cUs_json->error );

                    } 
                    
                }else{
                    $aryResponse = array('status' => 3, 'message' => $cUs_json->error);
                }
                
                break;

            case 'error':
                $aryResponse = array('status' => 3, 'message' => $cUs_json->error);
                break;
        }
    }
    
    echo json_encode($aryResponse);
    
    die();
}

// loginAlreadyUser handler function...
add_action('wp_ajax_cUsDF_LoadDefaultKey', 'cUsDF_LoadDefaultKey_callback');
function cUsDF_LoadDefaultKey_callback() {
    
    $cUsDF_api = new cUsComAPI_DF();
    $cUsDF_userData = get_option('cUsDF_settings_userData'); //get the saved user data
    $cUs_email = $cUsDF_userData['email'];
    $cUs_pass = $cUsDF_userData['credential'];
    
    $cUsDF_API_result = $cUsDF_api->getFormKeysAPI($cUs_email, $cUs_pass); //api hook;
    if($cUsDF_API_result){
        $cUs_json = json_decode($cUsDF_API_result);

        switch ( $cUs_json->status  ) {
            case 'success':
                
                foreach ($cUs_json as $oForms => $oForm) {
                    if ($oForms !='status' && $oForm->form_type == 0 && $oForm->default == 1){//GET DEFAULT CONTACT FORM KEY
                       $defaultFormKey = $oForm->form_key;
                    }
                }
                
                update_option('cUsDF_settings_form_key', $defaultFormKey); 
                
                echo 1;
                break;

            case 'error':
                echo $cUs_json->error;
                //$cUsDF_api->DF_resetData(); //RESET DATA
                break;
        }
    }
    
    die();
}


// cUsDF_verifyCustomerEmail handler function...
add_action('wp_ajax_cUsDF_verifyCustomerEmail', 'cUsDF_verifyCustomerEmail_callback');
function cUsDF_verifyCustomerEmail_callback() {
    
    if      ( !strlen(filter_input(INPUT_POST, 'fName',FILTER_SANITIZE_STRING)) ){      echo 'Missing First Name, is required field';      die();
    }elseif  ( !strlen(filter_input(INPUT_POST, 'lName',FILTER_SANITIZE_STRING)) ){      echo 'Missing Last Name, is required field';       die();
    }elseif  ( !strlen(filter_input(INPUT_POST, 'Email',FILTER_VALIDATE_EMAIL)) ){      echo 'Missing/Invalid Email, is required field';   die();
    }elseif  ( !strlen(filter_input(INPUT_POST, 'website')) ){    echo 'Missing Website, is required field';         die();
    }else{
        
        $cUsDF_api = new cUsComAPI_DF(); //CONTACTUS.COM API
        
        $postData = array(
            'fname' => filter_input(INPUT_POST, 'fName',FILTER_SANITIZE_STRING),
            'lname' => filter_input(INPUT_POST, 'lName',FILTER_SANITIZE_STRING),
            'email' => filter_input(INPUT_POST, 'Email',FILTER_VALIDATE_EMAIL),
            'phone' => filter_input(INPUT_POST, 'Phone', FILTER_SANITIZE_NUMBER_INT),
            'credential' => filter_input(INPUT_POST, 'credential'),
            'website' => filter_input(INPUT_POST, 'website')
        );

        $cUsDF_API_EmailResult = $cUsDF_api->verifyCustomerEmail(filter_input(INPUT_POST, 'Email',FILTER_VALIDATE_EMAIL)); //EMAIL VERIFICATION
        if($cUsDF_API_EmailResult) {
            $cUsDF_jsonEmail = json_decode($cUsDF_API_EmailResult);
			
			//print_r( $cUsDF_jsonEmail ); exit;
            
            switch ($cUsDF_jsonEmail->result){
                case 0 :
                    //echo 'No Existe';
                    echo 1;
                    update_option('cUsDF_settings_userData', $postData);
					
                    break;
                case 1 :
                    //echo 'Existe';
                    echo 2;//ALREDY CUS USER
                    delete_option('cUsDF_settings_userData');
                    break;
            }
            
        }else{
            echo 'Ouch! unfortunately there has being an error during the application, please try again';
            exit();
        }
         
    }
    
    die();
}


// cUsDF_createCustomer handler function...
add_action('wp_ajax_cUsDF_createCustomer', 'cUsDF_createCustomer_callback');
function cUsDF_createCustomer_callback() {
    
    $cUsDF_userData = get_option('cUsDF_settings_userData'); //get the saved user data
    
    if      ( !strlen($cUsDF_userData['fname']) ){      echo 'Missing First Name, is required field';      die();
    }elseif  ( !strlen($cUsDF_userData['lname']) ){      echo 'Missing Last Name, is required field';       die();
    }elseif  ( !strlen($cUsDF_userData['email']) ){      echo 'Missing/Invalid Email, is required field';   die();
    }elseif  ( !strlen($cUsDF_userData['website']) ){    echo 'Missing Website, is required field';         die();
    }elseif  ( !strlen(filter_input(INPUT_POST, 'Template_Desktop_Form',FILTER_SANITIZE_STRING)) ){    echo 'Missing Form Template';         die();
    }elseif  ( !strlen(filter_input(INPUT_POST, 'Template_Desktop_Tab',FILTER_SANITIZE_STRING)) ){    echo 'Missing Tab Template';         die();
    }else{
        
        $cUsDF_api = new cUsComAPI_DF(); //CONTACTUS.COM API
        
        $postData = array(
            'fname' => $cUsDF_userData['fname'],
            'lname' => $cUsDF_userData['lname'],
            'email' => $cUsDF_userData['email'],
            'website' => $cUsDF_userData['website'],
            'phone' => preg_replace('/[^0-9]+/i', '', $cUsDF_userData['phone']),
            'Template_Desktop_Form' => filter_input(INPUT_POST, 'Template_Desktop_Form',FILTER_SANITIZE_STRING),
            'Template_Desktop_Tab' => filter_input(INPUT_POST, 'Template_Desktop_Tab',FILTER_SANITIZE_STRING),
            'Main_Category' => filter_input(INPUT_POST, 'CU_category',FILTER_SANITIZE_STRING),
            'Sub_Category' => filter_input(INPUT_POST, 'CU_subcategory',FILTER_SANITIZE_STRING),
            'Goals' => filter_input(INPUT_POST, 'CU_goals',FILTER_SANITIZE_STRING)
        );
        
        $cUsDF_API_result = $cUsDF_api->createCustomer($postData, $cUsDF_userData['credential']);

        if($cUsDF_API_result) {

            $cUs_json = json_decode($cUsDF_API_result);

            switch ( $cUs_json->status ) {

                case 'success':
                    
                    echo 1;//GREAT
                    update_option('cUsDF_settings_form_key', $cUs_json->form_key ); //finally get form key form contactus.com // SESSION IN

                    $aryFormOptions = array( //DEFAULT SETTINGS / FIRST TIME
                        'tab_user'          => 1,
                        'cus_donation_version'       => 'tab'
                    ); 
                    update_option('cUsDF_FORM_settings', $aryFormOptions );//UPDATE FORM SETTINGS
                    update_option('cUsDF_settings_userData', $postData);
                    
                    $cUs_API_Account    = $cUs_json->api_account;
                    $cUs_API_Key        = $cUs_json->api_key;

                    $aryUserCredentials = array(
                        'API_Account' => $cUs_API_Account,
                        'API_Key'     => $cUs_API_Key
                    );

                    update_option('cUsDF_settings_userCredentials', $aryUserCredentials);
                    
                    
                    // ********************************
                    // get here the default deeplink after creating customer
                    $cUsDF_API_getKeysResult = $cUsDF_api->getFormKeysAPI( $cUs_API_Account, $cUs_API_Key, $form_type = 'donation' ); //api hook;

                    $cUs_jsonKeys = json_decode( $cUsDF_API_getKeysResult );

                    // save the form id for this donation new user
                    update_option( 'cUsDF_settings_form_id', $cUs_jsonKeys->data[0]->form_id );

                    // get a default deeplink
                    update_option('cUsDF_default_deep_link_view', $cUsDF_api->get_deeplink( $cUs_jsonKeys->data ) ); // DEFAULT FORM KEYS
                    // *********************************

                break;

                case 'error':

                    if($cUs_json->error[0] == 'Email exists'){
                        echo 2;//ALREDY CUS USER
                        //$cUsDF_api->DF_resetData(); //RESET DATA
                    }else{
                        //ANY ERROR
                        echo $cUs_json->error;
                        //$cUsDF_api->DF_resetData(); //RESET DATA
                    }
                    
                break;


            }
            
        }else{
             //echo 3;//API ERROR
             echo $cUs_json->error;
             // $cUsDF_api->DF_resetData(); //RESET DATA
        }
        
         
    }
    
    die();
}

// cUsDF_createCustomer handler function...
add_action('wp_ajax_cUsDF_UpdateTemplates', 'cUsDF_UpdateTemplates_callback');
function cUsDF_UpdateTemplates_callback() {
    
    $cUsDF_userData = get_option('cUsDF_settings_userData'); //get the saved user data
    
    if      ( !strlen($cUsDF_userData['email']) ){      echo 'Missing/Invalid Email, is required field!';   die();
    }elseif  ( !strlen($_REQUEST['Template_Desktop_Form']) ){    echo 'Missing Form Template!';         die();
    }elseif  ( !strlen($_REQUEST['Template_Desktop_Tab']) ){    echo 'Missing Tab Template!';         die();
    }else{
        
        $cUsDF_api = new cUsComAPI_DF(); //CONTACTUS.COM API
        $form_key  = get_option('cUsDF_settings_form_key');
        $postData  = array(
            'email' => $cUsDF_userData['email'],
            'credential' => $cUsDF_userData['credential'],
            'Template_Desktop_Form' => $_REQUEST['Template_Desktop_Form'],
            'Template_Desktop_Tab' => $_REQUEST['Template_Desktop_Tab']
        );
        
        $cUsDF_API_result = $cUsDF_api->updateFormSettings($postData, $form_key);
        if($cUsDF_API_result) {

            $cUs_json = json_decode($cUsDF_API_result);

            switch ( $cUs_json->status  ) {

                case 'success':
                    echo 1;//GREAT

                break;

                case 'error':
                    //ANY ERROR
                    echo $cUs_json->error;
                    //$cUsDF_api->DF_resetData(); //RESET DATA
                break;


            }
            
        }else{
             //echo 3;//API ERROR
             echo $cUs_json->error;
             // $cUsDF_api->DF_resetData(); //RESET DATA
        }
         
    }
    
    die();
}

add_action('wp_ajax_cUsDF_changeFormTemplate', 'cUsDF_changeFormTemplate_callback');
function cUsDF_changeFormTemplate_callback() {
    
    $cUsDF_userData = get_option('cUsDF_settings_userCredentials'); //get the saved user data
   
    if      ( !strlen($cUsDF_userData['API_Account']) ){     echo 'Missing API Account!';   die();
    }elseif  ( !strlen($cUsDF_userData['API_Key']) ){         echo 'Missing Form Key!';         die();
    }elseif  ( !strlen($_REQUEST['Template_Desktop_Form']) ){    echo 'Missing Form Template!';         die();
    }elseif  ( !strlen($_REQUEST['form_key']) ){    echo 'Missing Form Key!';         die();
    }else{
        
        $cUsDF_api = new cUsComAPI_DF(); //CONTACTUS.COM API
        $form_key = $_REQUEST['form_key'];
        
        $postData = array(
            'API_Account'       => $cUsDF_userData['API_Account'],
            'API_Key'           => $cUsDF_userData['API_Key'],
            'Template_Desktop_Form' => $_REQUEST['Template_Desktop_Form']
        );
        
        $cUsDF_API_result = $cUsDF_api->updateFormSettings($postData, $form_key);
        if($cUsDF_API_result) {

            $cUs_json = json_decode($cUsDF_API_result);

            switch ( $cUs_json->status  ) {

                case 'success':
                    echo 1;//GREAT

                break;

                case 'error':
                    //ANY ERROR
                    echo $cUs_json->error;
                    //$cUsDF_api->DF_resetData(); //RESET DATA
                break;


            } 
        }else{
             //echo 3;//API ERROR
             echo $cUs_json->error;
             // $cUsDF_api->DF_resetData(); //RESET DATA
        } 
        
         
    } 
    
    die();
}

add_action('wp_ajax_cUsDF_changeTabTemplate', 'cUsDF_changeTabTemplate_callback');
function cUsDF_changeTabTemplate_callback() {
    
    $cUsDF_userData = get_option('cUsDF_settings_userCredentials'); //get the saved user data
   
    if       ( !strlen($cUsDF_userData['API_Account']) ){       echo 'Missing API Account!';   die();
    }elseif  ( !strlen($cUsDF_userData['API_Key']) ){           echo 'Missing Form Key!';      die();
    }elseif  ( !strlen($_REQUEST['Template_Desktop_Tab']) ){    echo 'Missing Tab Template!';  die();
    }elseif  ( !strlen($_REQUEST['form_key']) ){                echo 'Missing Form Key!';      die();
    }else{
        
        $cUsDF_api = new cUsComAPI_DF(); //CONTACTUS.COM API
        $form_key = $_REQUEST['form_key'];
        
        $postData = array(
            'API_Account'       => $cUsDF_userData['API_Account'],
            'API_Key'           => $cUsDF_userData['API_Key'],
            'Template_Desktop_Tab' => $_REQUEST['Template_Desktop_Tab']
        );
        
        $cUsDF_API_result = $cUsDF_api->updateFormSettings($postData, $form_key);
        if($cUsDF_API_result) {

            $cUs_json = json_decode($cUsDF_API_result);

            switch ( $cUs_json->status  ) {

                case 'success':
                    echo 1;//GREAT

                break;

                case 'error':
                    //ANY ERROR
                    echo $cUs_json->error;
                    //$cUsDF_api->DF_resetData(); //RESET DATA
                break;


            } 
        }else{
             //echo 3;//API ERROR
             echo $cUs_json->error;
             // $cUsDF_api->DF_resetData(); //RESET DATA
        } 
        
         
    }
    
    die();
}


// save custom selected pages handler function...
add_action('wp_ajax_cUsDF_saveCustomSettings', 'cUsDF_saveCustomSettings_callback');
function cUsDF_saveCustomSettings_callback() {

    //echo $_REQUEST['tab_user']; exit;
        
    $aryFormOptions = array( //DEFAULT SETTINGS / FIRST TIME
        'tab_user'          => $_REQUEST['tab_user'],
        'cus_donation_version'       => $_REQUEST['cus_donation_version']
    ); 
    update_option('cUsDF_FORM_settings', $aryFormOptions );//UPDATE FORM SETTINGS
    
    cUsDF_page_settings_cleaner();
    
    delete_option( 'cUsDF_settings_inlinepages' );
    delete_option( 'cUsDF_settings_tabpages' );
   
    
    die();
}

// save custom selected pages handler function...
add_action('wp_ajax_cUsDF_deletePageSettings', 'cUsDF_deletePageSettings_callback');
function cUsDF_deletePageSettings_callback() {
    
    $pageID = $_REQUEST['pageID'];
    
    delete_post_meta($pageID, 'cUsDF_FormByPage_settings');//reset values
    cUsDF_inline_shortcode_cleaner_by_ID($pageID); //RESET SC
    
    $aryTabPages = get_option('cUsDF_settings_tabpages');
    $aryTabPages = DF_removePage($pageID,$aryTabPages);
    update_option( 'cUsDF_settings_tabpages', $aryTabPages); //UPDATE OPTIONS
            
    $aryInlinePages = get_option('cUsDF_settings_inlinepages');
    $aryInlinePages = DF_removePage($pageID,$aryInlinePages);
    update_option( 'cUsDF_settings_inlinepages', $aryInlinePages); //UPDATE OPTIONS
    
    die();
}

// save custom selected pages handler function...
add_action('wp_ajax_cUsDF_changePageSettings', 'cUsDF_changePageSettings_callback');
function cUsDF_changePageSettings_callback() {
    
    $pageID = $_REQUEST['pageID'];
    delete_post_meta($pageID, 'cUsDF_FormByPage_settings');//reset values
    cUsDF_inline_shortcode_cleaner_by_ID($pageID); //RESET SC
    $aryTabPages = get_option('cUsDF_settings_tabpages');
    $aryInlinePages = get_option('cUsDF_settings_inlinepages');
    
    switch ($_REQUEST['cus_donation_version']){
        case 'tab':
            
            $tabUser = 1;
            
            $aryTabPages[] = $pageID;
            $aryTabPages = array_unique($aryTabPages);
            update_option('cUsDF_settings_tabpages', $aryTabPages); //UPDATE OPTIONS
            
            if(!empty($aryInlinePages)){
                $aryInlinePages = DF_removePage($pageID,$aryInlinePages);
                update_option( 'cUsDF_settings_inlinepages', $aryInlinePages); //UPDATE OPTIONS
            }
            
            echo 1;
            
            break;
        case 'inline':
            
            $tabUser = 0;
            
            $aryInlinePages[] = $pageID;
            $aryInlinePages = array_unique($aryInlinePages);
            update_option( 'cUsDF_settings_inlinepages', $aryInlinePages); //UPDATE OPTIONS
            
            if(!empty($aryTabPages)){
                $aryTabPages = DF_removePage($pageID,$aryTabPages);
                update_option( 'cUsDF_settings_tabpages', $aryTabPages); //UPDATE OPTIONS
            }
            
            cUsDF_inline_shortcode_add($pageID); //ADDING SHORTCODE FOR INLINE PAGES
            
            echo 1;
            
            break;
    } 
    
    $aryFormOptions = array( //DEFAULT SETTINGS / FIRST TIME
        'tab_user'          => $tabUser,
        'form_key'          => $_REQUEST['form_key'],   
        'cus_donation_version'       => $_REQUEST['cus_donation_version']
    );
    
    if($pageID != 'home'){
        update_post_meta($pageID, 'cUsDF_FormByPage_settings', $aryFormOptions);//SAVE DATA ON POST TYPE PAGE METAS
    }else{
       update_option('cUsDF_HOME_settings', $aryFormOptions );//UPDATE FORM SETTINGS 
    }
    
    die();
}

function DF_removePage($valueToSearch, $arrayToSearch){
    $key = array_search($valueToSearch,$arrayToSearch);
    if($key!==false){
        unset($arrayToSearch[$key]);
    }
    return $arrayToSearch;
}

// logoutUser handler function...
add_action('wp_ajax_cUsDF_logoutUser', 'cUsDF_logoutUser_callback');
function cUsDF_logoutUser_callback() {
    
    $cUsDF_api = new cUsComAPI_DF();
    $cUsDF_api->DF_resetData(); //RESET DATA
    
    delete_option( 'cUsDF_settings_api_key' );  
    delete_option( 'cUsDF_settings_form_key' );  
    delete_option( 'cUsDF_settings_list_Name' );  
    delete_option( 'cUsDF_settings_list_ID' ); 
    delete_option('cUsDF_default_deep_link_view');
    
    echo 'Deleted.... User data'; //none list
    
    die();
}

//GET TEMPLATES LIST

// sendTemplateID handler function...
add_action('wp_ajax_cUsDF_getTemplates', 'cUsDF_getTemplates_callback');
function cUsDF_getTemplates_callback() {
    echo 1; //none list
    
    die();
}

// sendTemplateID handler function...
add_action('wp_ajax_cUsDF_sendTemplateID', 'cUsDF_sendTemplateID_callback');
function cUsDF_sendTemplateID_callback() {
    echo 1; //none list
    
    die();
}


?>
