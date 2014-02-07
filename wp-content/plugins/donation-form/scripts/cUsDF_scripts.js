
var cUsDF_myjq = jQuery.noConflict();

cUsDF_myjq(window).error(function(e){
    e.preventDefault();
});

cUsDF_myjq(document).ready(function($) {
    
    try{
        cUsDF_myjq( "#cUsDF_tabs" ).tabs({active: false});
        
        cUsDF_myjq( ".goto_shortcodes" ).click(function(){
            cUsDF_myjq( "#cUsDF_tabs" ).tabs({ active: 2 });
        });
        
        cUsDF_myjq("li.gotohelp a").unbind('click');
        
        cUsDF_myjq('.selectable_cf, .selectable_tabs_cf').bxSlider({
            slideWidth: 160,
            minSlides: 4,
            maxSlides: 4,
            moveSlides:1,
            infiniteLoop:false,
            //captions:true,
            pager:true,
            slideMargin: 5
        });
        
        cUsDF_myjq('.template_slider').bxSlider({
            slideWidth: 160,
            minSlides: 4,
            maxSlides: 4,
            moveSlides:1,
            infiniteLoop:false,
            preloadImages:'all',    
            //captions:true,
            pager:true,
            slideMargin: 5
        });
        
        
        cUsDF_myjq(".tooltip_formsett").colorbox({iframe:true, innerWidth:'75%', innerHeight:'80%'}); 
        
        cUsDF_myjq( '.bx-loading' ).hide();
        cUsDF_myjq( '.options' ).buttonset();
        
        cUsDF_myjq( '.form_types' ).buttonset();//TEMPLATE SELECTION
        cUsDF_myjq ('.form_types input[type=radio]').change(function() {
            var form_type = this.value;
            cUsDF_myjq('#Template_Desktop_Form').val('');//RESET ON CHANGE
            cUsDF_myjq('#Template_Desktop_Tab').val('');//RESET ON CHANGE

            switch (form_type) {
                case 'contact_form': 
                    cUsDF_myjq( '.Template_Contact_Form' ).fadeIn();
                    cUsDF_myjq( '.Template_Newsletter_Form' ).hide();
                    break;
                case 'newsletter_form':
                    cUsDF_myjq( '.Template_Newsletter_Form' ).fadeIn();
                    cUsDF_myjq( '.Template_Contact_Form' ).hide();
                    break;
            }
        });
        
        cUsDF_myjq(".selectable_cf, .selectable_news").selectable({//SELECTED CONTACT FORM TEMPLATE
            selected: function(event, ui) {
                var idEl = cUsDF_myjq(ui.selected).attr('id');
                cUsDF_myjq(ui.selected).addClass("ui-selected").siblings().removeClass("ui-selected");           
                cUsDF_myjq('#Template_Desktop_Form').val(idEl);           
            }                   
        });
        
        cUsDF_myjq(".selectable_tabs_cf, .selectable_tabs_news").selectable({//SELECTED FORM TAB TEMPLATE
            selected: function(event, ui) {
                var idEl = cUsDF_myjq(ui.selected).attr('id');
                cUsDF_myjq(ui.selected).addClass("ui-selected").siblings().removeClass("ui-selected");        
                cUsDF_myjq('#Template_Desktop_Tab').val(idEl);           
            }                   
        });
        
        cUsDF_myjq(".selectable_ucf, .selectable_unews").selectable({//SELECTED CONTACT FORM TEMPLATE
            selected: function(event, ui) {
                var idEl = cUsDF_myjq(ui.selected).attr('id');
                cUsDF_myjq(ui.selected).addClass("ui-selected").siblings().removeClass("ui-selected");           
                cUsDF_myjq('#uTemplate_Desktop_Form').val(idEl);           
            }                   
        });
        
        cUsDF_myjq(".selectable_tabs_ucf, .selectable_tabs_unews").selectable({//SELECTED FORM TAB TEMPLATE
            selected: function(event, ui) {
                var idEl = cUsDF_myjq(ui.selected).attr('id');
                cUsDF_myjq(ui.selected).addClass("ui-selected").siblings().removeClass("ui-selected");           
                cUsDF_myjq('#uTemplate_Desktop_Tab').val(idEl);           
            }                   
        });
        
        cUsDF_myjq( '#inlineradio' ).buttonset();

        cUsDF_myjq( "#terminology" ).accordion({
            collapsible: true,
            heightStyle: "content",
            active: false,
            icons: { "header": "ui-icon-info", "activeHeader": "ui-icon-arrowreturnthick-1-n" }
        });
        
        cUsDF_myjq( "#user_forms" ).accordion({
            collapsible: true,
            heightStyle: "content",
            active: true,
            icons: { "header": "ui-icon-circle-plus", "activeHeader": "ui-icon-circle-minus" }
        });
        
        cUsDF_myjq( ".user_templates" ).accordion({
            collapsible: true,
            heightStyle: "content",
            icons: { "header": "ui-icon-circle-plus", "activeHeader": "ui-icon-circle-minus" }
        });
        
        cUsDF_myjq( "#form_examples, #tab_examples" ).accordion({
            collapsible: true,
            heightStyle: "content",
            icons: { "header": "ui-icon-info", "activeHeader": "ui-icon-arrowreturnthick-1-n" }
        });
        
        cUsDF_myjq( ".form_templates_aCc" ).accordion({
            collapsible: true,
            heightStyle: "content",
            icons: { "header": "ui-icon-circle-plus", "activeHeader": "ui-icon-circle-minus" }
        });
        
        cUsDF_myjq( ".signup_templates" ).accordion({
            collapsible: true,
            heightStyle: "content",
            icons: { "header": "ui-icon-info", "activeHeader": "ui-icon-arrowreturnthick-1-n" }
        });
        
        var glow = $('.toDash');
        setInterval(function(){
            glow.hasClass('glow') ? glow.removeClass('glow') : glow.addClass('glow');
        }, 9000);
        
       
    }catch(err){
        cUsDF_myjq('.advice_notice').html('Oops, something wrong happened, please try again later!').slideToggle().delay(2000).fadeOut(2000);
    }
    
    cUsDF_myjq('.cUsDF_LoginUser').click(function(){ // LOGIN ALREADY USERS
        var email = cUsDF_myjq('#login_email').val();
        var pass = cUsDF_myjq('#user_pass').val();
        cUsDF_myjq('.loadingMessage').show();
        
        if(!email.length){
            cUsDF_myjq('.advice_notice').html('User Email is a required and valid field!').slideToggle().delay(2000).fadeOut(2000);
            cUsDF_myjq('#login_email').focus();
            cUsDF_myjq('.loadingMessage').fadeOut();
        }else if(!pass.length){
            cUsDF_myjq('.advice_notice').html('User password is a required field!').slideToggle().delay(2000).fadeOut(2000);
            cUsDF_myjq('#user_pass').focus();
            cUsDF_myjq('.loadingMessage').fadeOut();
        }else{
            var bValid = checkRegexp( email, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "eg. sergio@jquery.com" );  
            if(!bValid){
                cUsDF_myjq('.advice_notice').html('Please enter a valid User Email!').slideToggle().delay(2000).fadeOut(2000);
                cUsDF_myjq('.loadingMessage').fadeOut();
            }else{
                
                cUsDF_myjq('.cUsDF_LoginUser').val('Loading . . .').attr('disabled', true);
                
                cUsDF_myjq.ajax({ type: "POST", dataType:'json', url: ajax_object.ajax_url, data: {action:'cUsDF_loginAlreadyUser',email:email,pass:pass},
                    success: function (data) {
                        //alert(data);
                        switch (data.status) {
                            case 1:

                                cUsDF_myjq('.cUsDF_LoginUser').val('Success . . .');
                                
                                message = '<p>Welcome to ContactUs.com</p>';
                                
                                setTimeout(function(){
                                    cUsDF_myjq('#cUsDF_loginform').slideUp().fadeOut();
                                    location.reload();
                                },2500)
                                
                                cUsDF_myjq('.notice').html(message).show().delay(3000).fadeOut();
                                cUsDF_myjq('.cUsDF_LoginUser').val('Login').attr('disabled', false);
                                
                            break;
                            case 2:
                                
                                cUsDF_myjq('.cUsDF_LoginUser').val('Error . . .');
                                
                                message =  '<p>Seems like you don\'t have one Default Donation Form added in your ContactUs.com account!.</p>';

                                message += '<p>To create a new Donation Form in your ContactUs.com account '; 

								message += '<a href="https://admin.contactus.com/partners/index.php?loginName='+data.cUs_API_Account;
								
								message += '&userPsswd='+data.cUs_API_Key+'&confirmed=1&redir_url='+data.deep_link_view+'?';
								
								message += encodeURIComponent('pageID=81&id=0&do=addnew&formType=donation');
								
								message += ' " target="_blank" title="NOTE: You will be redirected to your ContactUs.com admin panel to edit your form configurations.">Click Here</a></p>';

								message += '<p><strong>NOTE:</strong> You will be redirected to your ContactUs.com admin panel to edit your form configurations.</p>';
                                
                                linkHref = cUsDF_myjq(".toAdmin").attr('href') + '&uE='+data.uE+"&uC="+data.uC;
                                
                                cUsDF_myjq('#dialog-message').html(message);
                                
                                cUsDF_myjq(".toAdmin").attr({'href':linkHref});
                                
                                cUsDF_myjq.messageDialogLogin('Default Donation Form Required!');
                                
                                cUsDF_myjq('.cUsDF_LoginUser').val('Login').attr('disabled', false);
                                
                                //cUsDF_myjq('.advice_notice').html(message).show();
                                
                            break;
                            case 3:
                                cUsDF_myjq('.cUsMC_LoginUser').html('Login').removeAttr('disabled');
                                message = '<p>There has been an application error. <br/> <br/> <b>' + data.message + '</b>. <br/> Please try again.</a></p>';
                                cUsDF_myjq('.advice_notice').html(message).show().delay(10000).fadeOut();
                                cUsDF_myjq('.loadingMessage').fadeOut();
								 cUsDF_myjq('.cUsDF_LoginUser').val('Login').attr('disabled', false);
                            break;
                            default:
                                cUsDF_myjq('.cUsDF_LoginUser').val('Login').attr('disabled', false);
                                message = '<p>There has been an application error. <b>' + data + '</b>. Please try again.</a></p>';
                                cUsDF_myjq('.advice_notice').html(message).show().delay(6000).fadeOut();
								 cUsDF_myjq('.cUsDF_LoginUser').val('Login').attr('disabled', false);
                                break;
                        }
                        
                        cUsDF_myjq('.loadingMessage').fadeOut();
                        

                    },
                    async: false
                });
            }
        }
    });
    
    cUsDF_myjq.messageDialogLogin = function(title){
        try{
            cUsDF_myjq( "#dialog-message" ).dialog({
                modal: true,
                title: title,
                minWidth: 520,
                buttons: {
                    Ok: function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
        }catch(err){
            //console.log(err);
        }
        
    }
    
    cUsDF_myjq.messageDialog = function(title, msg){
        try{
            cUsDF_myjq( "#dialog-message" ).html(msg);
            cUsDF_myjq( "#dialog-message" ).dialog({
                modal: true,
                title: title,
                minWidth: 520,
                buttons: {
                    Ok: function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
        }catch(err){
            //console.log(err);
        }
        
    }
    
	 cUsDF_myjq("#cUsDF_SendTemplates").on('click', function(){
    	
		   var Template_Desktop_Form = cUsDF_myjq('#Template_Desktop_Form').val();
           var Template_Desktop_Tab = cUsDF_myjq('#Template_Desktop_Tab').val();
           cUsDF_myjq('.loadingMessage').show();
           
           if(!Template_Desktop_Form.length){
               cUsDF_myjq('.advice_notice').html('Please select a form template before continuing.').slideToggle().delay(2000).fadeOut(2000);
               cUsDF_myjq('.loadingMessage').fadeOut();
               cUsDF_myjq( ".signup_templates" ).accordion({ active: 0 });
           }else if(!Template_Desktop_Tab.length){
               cUsDF_myjq('.advice_notice').html('Please select a tab template before continuing.').slideToggle().delay(2000).fadeOut(2000);
               cUsDF_myjq('.loadingMessage').fadeOut();
               cUsDF_myjq( ".signup_templates" ).accordion({ active: 1 });
           }else{
    		   cUsDF_myjq("#cUsDF_SendTemplates").colorbox({ inline:true, maxWidth:'100%', minHeight:'430px', scrolling:false, overlayClose:false, escKey:false, closeButton:false });
    	   }
    });
	

    //SENT LIST ID AJAX CALL /// STEP 2
    try{
        cUsDF_myjq('#cUsDF_CreateCustomer').click(function() {
            
            var postData = {};

            var cUsDF_first_name = cUsDF_myjq('#cUsDF_first_name').val();
            var cUsDF_last_name = cUsDF_myjq('#cUsDF_last_name').val();
            var cUsDF_email = cUsDF_myjq('#cUsDF_email').val();
            var cUsDF_emailValid = checkRegexp( cUsDF_email, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "eg. sergio@jquery.com" );
            var cUsDF_pass = cUsDF_myjq('#cUsDF_password').val();
            var cUsDF_pass2 = cUsDF_myjq('#cUsDF_password_r').val();
            var cUsDF_web = cUsDF_myjq('#cUsDF_web').val();
            var cUsDF_webValid = checkURL(cUsDF_web);
			
           cUsDF_myjq('.loadingMessage').show();
           
           if( !cUsDF_first_name.length){
               cUsDF_myjq('.advice_notice').html('Your First Name is a required field').slideToggle().delay(2000).fadeOut(2000);
               cUsDF_myjq('#cUsDF_first_name').focus();
               cUsDF_myjq('.loadingMessage').fadeOut();
           }else if( !cUsDF_last_name.length){
               cUsDF_myjq('.advice_notice').html('Your Last Name is a required field').slideToggle().delay(2000).fadeOut(2000);
               cUsDF_myjq('#cUsDF_last_name').focus();
               cUsDF_myjq('.loadingMessage').fadeOut();
           }else if(!cUsDF_email.length){
               cUsDF_myjq('.advice_notice').html('Email is a required field!').slideToggle().delay(2000).fadeOut(2000);
               cUsDF_myjq('#apikey').focus();
               cUsDF_myjq('.loadingMessage').fadeOut();
           }else if(!cUsDF_pass.length){
               cUsDF_myjq('.advice_notice').html('Password is a required field!').slideToggle().delay(2000).fadeOut(2000);
               cUsDF_myjq('#cUsDF_password').focus();
               cUsDF_myjq('.loadingMessage').fadeOut();
           }else if(cUsDF_pass.length < 8){
               cUsDF_myjq('.advice_notice').html('Password must be 8 characters or more!').slideToggle().delay(2000).fadeOut(2000);
               cUsDF_myjq('#cUsDF_password').focus();
               cUsDF_myjq('.loadingMessage').fadeOut();
           }else if(cUsDF_pass2 != cUsDF_pass){
               cUsDF_myjq('.advice_notice').html('The passwords do not match -- please double check them.').slideToggle().delay(2000).fadeOut(2000);
               cUsDF_myjq('#cUsDF_password_r').focus();
               cUsDF_myjq('.loadingMessage').fadeOut();
           }else if(!cUsDF_emailValid){
               cUsDF_myjq('.advice_notice').html('Please, enter a valid Email').slideToggle().delay(2000).fadeOut(2000);
               cUsDF_myjq('#cUsDF_email').focus();
               cUsDF_myjq('.loadingMessage').fadeOut();
           }else if(!cUsDF_web.length){
               cUsDF_myjq('.advice_notice').html('Your Website is a required field').slideToggle().delay(2000).fadeOut(2000);
               cUsDF_myjq('#cUsDF_web').focus();
               cUsDF_myjq('.loadingMessage').fadeOut();
           }else if(!cUsDF_webValid){
               cUsDF_myjq('.advice_notice').html('Please enter a valid and complete URL.').slideToggle().delay(2000).fadeOut(2000);
               cUsDF_myjq('#cUsDF_web').focus();
               cUsDF_myjq('.loadingMessage').fadeOut();
           }else{
                cUsDF_myjq('#cUsDF_CreateCustomer').val('Loading . . .').attr('disabled', true);
                
                postData = {action: 'cUsDF_verifyCustomerEmail', fName:str_clean(cUsDF_first_name),lName:str_clean(cUsDF_last_name),Email:cUsDF_email,credential:cUsDF_pass,website:cUsDF_web};
                
                cUsDF_myjq.ajax({ 
                    type: "POST", 
                    url: ajax_object.ajax_url,
                    data: postData,
                    success: function(data) {
						
						//alert(data);
					
                        switch(data){
                            case '1':  
							
                                message = '<h4>Continue your form customization.</h4>';
                                // location.reload();
                               setTimeout(function(){
                                    cUsDF_myjq('.step1').slideDown().fadeOut();
                                    cUsDF_myjq('.step2').slideUp().fadeIn();
                                },3000);
                                
                               cUsDF_myjq('#cUsDF_CreateCustomer').val('Continue to Step 2').attr('disabled', false); 
                                
                            break;
                            case '2':
                            	
                                cUsDF_myjq("#cUsDF_SendTemplates").colorbox.close();
                                cUsDF_myjq(".img_loader").css({display:'none'});

                                message = 'There is already an account with that email address. Please login or if you have forgotten the password, select the option to reset it.';
                                cUsDF_myjq('#cUsDF_CreateCustomer').val('Continue to Step 2').attr('disabled', false); 
                                setTimeout(function(){
                                    cUsDF_myjq('#login_email').val(cUsDF_email).focus();
                                    cUsDF_myjq('#cUsDF_userdata').fadeOut();
                                    cUsDF_myjq('#cUsDF_settings').slideDown('slow');
                                    cUsDF_myjq('#cUsDF_loginform').delay(1000).fadeIn();
                                },2000)
                            break;  
                            default:
                                message = '<p>There has been an application error. <b>' + data + '</b>. Please try again.</a></p>';
                                cUsDF_myjq('#cUsDF_CreateCustomer').val('Continue to Step 2').attr('disabled', false);
                            break;
                        }
                        
                        cUsDF_myjq('.loadingMessage').fadeOut();
                        cUsDF_myjq('.advice_notice').html(message).show().delay(4000).fadeOut(2000);

                    },
                    fail: function(){
                       message = '<p>There has been an application error. Please try again.</a></p>';
                       cUsDF_myjq('#cUsDF_CreateCustomer').val('Continue to Step 2').attr('disabled', false); 
                    }
                });
           }
            
        });
    }catch(err){
        cUsDF_myjq('.advice_notice').html('Oops, something wrong happened, please try again later!').slideToggle().delay(2000).fadeOut(2000);
        cUsDF_myjq('#cUsDF_CreateCustomer').val('Continue to Step 2').attr('disabled', false);
    }
    
    try{ cUsDF_myjq('.btn-skip').click(function() {
	
			cUsDF_myjq('.skip-button').hide();
            cUsDF_myjq('#save').hide();
            cUsDF_myjq('#open-intestes').hide();
           
           var Template_Desktop_Form = cUsDF_myjq('#Template_Desktop_Form').val();
           var Template_Desktop_Tab = cUsDF_myjq('#Template_Desktop_Tab').val();
		   
		   cUsDF_myjq(".img_loader").css({display:'inline-block'});
		   
           cUsDF_myjq('.loadingMessage').show();
           
           if(!Template_Desktop_Form.length){
               cUsDF_myjq('.advice_notice').html('Please select your Contact Us Template form').slideToggle().delay(2000).fadeOut(2000);
               cUsDF_myjq('.loadingMessage').fadeOut();
               cUsDF_myjq( ".signup_templates" ).accordion({ active: 0 });
           }else if(!Template_Desktop_Tab.length){
               cUsDF_myjq('.advice_notice').html('Please select a tab template before continuing.').slideToggle().delay(2000).fadeOut(2000);
               cUsDF_myjq('.loadingMessage').fadeOut();
               cUsDF_myjq( ".signup_templates" ).accordion({ active: 1 });
           }else{
		   
		    // this are optional so do not passcheck
           var CU_category 		= 	cUsDF_myjq('#CU_category').val();
           var CU_subcategory 	= 	cUsDF_myjq('#CU_subcategory').val();
           
           // check if other goal is set
           /*if( cUsDF_myjq('#other_goal').val() != '' ){
           		var CU_goals = cUsDF_myjq('#other_goal').val();
           }else{*/
           		
           		var new_goals = '';
           		var CU_goals = cUsDF_myjq('input[name="the_goals[]"]').each(function(){
           			new_goals += cUsDF_myjq(this).val()+',';	
           		});
           		
           		if( cUsDF_myjq('#other_goal').val() )
           			new_goals += cUsDF_myjq('#other_goal').val()+',';	
		   
		   
                
                cUsDF_myjq('#cUsDF_SendTemplates').val('Loading . . .').attr('disabled', true);
                
                cUsDF_myjq.ajax({ type: "POST", url: ajax_object.ajax_url, data: {action:'cUsDF_createCustomer',Template_Desktop_Form:Template_Desktop_Form,Template_Desktop_Tab:Template_Desktop_Tab,CU_category:CU_category,CU_subcategory:CU_subcategory,CU_goals:new_goals},
                    success: function(data) {
					
					
					//alert(JSON.stringify(data));

                        switch(data){
                            case '1':
                                message = '<p>Success!</p>';
                                message += '<p>Welcome to ContactUs.com -- make yourself at home.</p>';
                                
                                setTimeout(function(){
                                    cUsDF_myjq('.step3').slideUp().fadeOut();
                                    cUsDF_myjq('.step4').slideDown().delay(800);
                                    location.reload();
                                },2000);
                                break;
                             case '2':
                                
                                cUsDF_myjq('.skip-button').show();
            					cUsDF_myjq('#save').show();
								
								cUsDF_myjq("#cUsDF_SendTemplates").colorbox.close();
                                cUsDF_myjq(".img_loader").css({display:'none'});

                                message = 'There is already an account with that email address. Please login or if you have forgotten the password, select the option to reset it.';
                                cUsDF_myjq('#cUsDF_SendTemplates').val('Build my account').attr('disabled', false); 
                                setTimeout(function(){
                                    cUsDF_myjq('#login_email').val(cUsDF_email).focus();
                                    cUsDF_myjq('#cUsDF_userdata').fadeOut();
                                    cUsDF_myjq('#cUsDF_settings').slideDown('slow');
                                    cUsDF_myjq('#cUsDF_loginform').delay(1000).fadeIn();
                                },2000);
                                break;  
                            default:
                                message = '<p>There has been an application error. <b>' + data + '</b>. Please try again.</a></p>';
                                cUsDF_myjq('#cUsDF_SendTemplates').val('Build my account').attr('disabled', false); 
                                break;
                        }
                        
                        cUsDF_myjq('.loadingMessage').fadeOut();
                        cUsDF_myjq('.advice_notice').html(message).show().delay(1900).fadeOut(800);

                    },
                    async: false
                });
           }
           
            
        });
    }catch(err){
        cUsDF_myjq('.advice_notice').html('Oops, something wrong happened, please try again later!').slideToggle().delay(2000).fadeOut(2000);
        cUsDF_myjq('#cUsDF_SendTemplates').val('Build my account').attr('disabled', false); 
    }
    
    //UPDATE TEMPLATES FOR ALREADY USERS
    try{ cUsDF_myjq('#cUsDF_UpdateTemplates').click(function() {
           
           var Template_Desktop_Form = cUsDF_myjq('#uTemplate_Desktop_Form').val();
           var Template_Desktop_Tab = cUsDF_myjq('#uTemplate_Desktop_Tab').val();
           cUsDF_myjq('.loadingMessage').show();
           
           if(!Template_Desktop_Form.length){
               cUsDF_myjq('.advice_notice').html('Please select a form template before continuing.').slideToggle().delay(2000).fadeOut(2000);
               cUsDF_myjq('.loadingMessage').fadeOut();
               cUsDF_myjq( "#form_examples" ).accordion({ active: 0 });
           }else if(!Template_Desktop_Tab.length){
               cUsDF_myjq('.advice_notice').html('Please select a tab template before continuing.').slideToggle().delay(2000).fadeOut(2000);
               cUsDF_myjq('.loadingMessage').fadeOut();
               cUsDF_myjq( "#form_examples" ).accordion({ active: 1 });
           }else{
                
                cUsDF_myjq('#cUsDF_UpdateTemplates').val('Loading . . .').attr('disabled', true);
                
                cUsDF_myjq.ajax({ type: "POST", url: ajax_object.ajax_url, data: {action:'cUsDF_UpdateTemplates',Template_Desktop_Form:Template_Desktop_Form,Template_Desktop_Tab:Template_Desktop_Tab},
                    success: function(data) {

                        switch(data){
                            case '1':
                                message = '<p>Success!</p>';
                                
                                setTimeout(function(){
                                    cUsDF_myjq('.step3').slideUp().fadeOut();
                                    cUsDF_myjq('.step4').slideDown().delay(800);
                                    location.reload();
                                },2000)
                                break;
                             
                            default:
                                message = '<p>There has been an application error. <b>' + data + '</b>. Please try again.</a></p>';
                                cUsDF_myjq('#cUsDF_UpdateTemplates').val('Update my template').attr('disabled', false); 
                                break;
                        }
                        
                        cUsDF_myjq('.loadingMessage').fadeOut();
                        cUsDF_myjq('.advice_notice').html(message).show().delay(1900).fadeOut(800);

                    },
                    async: false
                });
           }
           
            
        });
    }catch(err){
        cUsDF_myjq('.advice_notice').html('Oops, something wrong happened, please try again later!').slideToggle().delay(2000).fadeOut(2000);
        cUsDF_myjq('#cUsDF_UpdateTemplates').val('Update my template').attr('disabled', false); 
    }
    
    try{ cUsDF_myjq('.load_def_formkey').click(function() { //loading default template
            
        cUsDF_myjq('.loadingMessage').show();
          
        cUsDF_myjq('.load_def_formkey').html('Loading . . .');

        cUsDF_myjq.ajax({ type: "POST", url: ajax_object.ajax_url, data: {action:'cUsDF_LoadDefaultKey'},
            success: function(data) {

                switch(data){
                    case '1':
                        message = '<p>New form Loaded correctly. . . .</p>';
                        cUsDF_myjq('.load_def_formkey').html('Completed . . .');
                        setTimeout(function(){
                            location.reload();
                        },2000)
                        break;
                }

                cUsDF_myjq('.loadingMessage').fadeOut();
                cUsDF_myjq('.advice_notice').html(message).show().delay(1900).fadeOut(800);
                 

            },
            async: false
        });
           
            
        });
    }catch(err){
        cUsDF_myjq('.advice_notice').html('Oops, something wrong happened, please try again later!').slideToggle().delay(2000).fadeOut(2000);
        cUsDF_myjq('.load_def_formkey').html('Update my template'); 
    }
    
    
    cUsDF_myjq.changePageSettings = function(pageID, cus_donation_version, form_key) { //loading default template
        
        if(!cus_donation_version.length){
            cUsDF_myjq('.advice_notice').html('Please select TAB or INLINE').slideToggle().delay(2000).fadeOut(2000);
        }else if(!form_key.length){
            cUsDF_myjq('.advice_notice').html('Please select your Contact Us Form Template').slideToggle().delay(2000).fadeOut(2000);
        }else{
            
            cUsDF_myjq('.save_message_'+pageID).show();
            
            cUsDF_myjq.ajax({type: "POST", url: ajax_object.ajax_url, data: {action:'cUsDF_changePageSettings',pageID:pageID,cus_donation_version:cus_donation_version, form_key:form_key },
                success: function(data) {

                    switch(data){
                        case '1':
                            message = '<p>Saved Successfully . . . .</p>';
                            cUsDF_myjq('.save_message_'+pageID).html(message);
                            cUsDF_myjq('.save-page-'+pageID).val('Completed . . .');

                            setTimeout(function(){
                                cUsDF_myjq('.save_message_'+pageID).fadeOut();
                                cUsDF_myjq('.save-page-'+pageID).val('Save');
                                cUsDF_myjq('.form-templates-'+pageID).slideUp();
                            },2000);

                            break
                    }

                },
                async: false
            });
        }  
            
    }
    
    cUsDF_myjq.deletePageSettings = function(pageID) { //loading default template

        cUsDF_myjq.ajax({type: "POST", url: ajax_object.ajax_url, data: {action:'cUsDF_deletePageSettings',pageID:pageID},
            success: function(data) {

                //console.log('Success . . .');

            },
            async: false
        });
           
            
    }
    
    
    //CHANGE FORM TEMPLATES
    cUsDF_myjq.changeFormTemplate = function(formID, form_key, Template_Desktop_Form) { //loading default template
        
        if(!Template_Desktop_Form.length || !form_key.length){
            cUsDF_myjq('.advice_notice').html('Please select your Contact Us Form Template').slideToggle().delay(2000).fadeOut(2000);
        }else{
            
            cUsDF_myjq('.save_message_'+formID).show();
            
            cUsDF_myjq.ajax({type: "POST", url: ajax_object.ajax_url, data: {action:'cUsDF_changeFormTemplate',Template_Desktop_Form:Template_Desktop_Form, form_key:form_key },
                success: function(data) {

                    switch(data){
                        case '1':
                            message = '<p>Saved Successfully . . . .</p>';
                            cUsDF_myjq('.save_message_'+formID).html(message);
                            cUsDF_myjq('.form_thumb_'+formID).attr('src','https://admin.contactus.com/popup/tpl/'+Template_Desktop_Form+'/scr.png');

                            setTimeout(function(){
                                cUsDF_myjq('.save_message_'+formID).fadeOut();
                            },2000);

                            break
                    }

                },
                async: false
            });
        }  
            
    }
    
    //CHANGE FORM TEMPLATES
    cUsDF_myjq.changeTabTemplate = function(formID, form_key, Template_Desktop_Tab) { //loading default template
        
        
        if(!Template_Desktop_Tab.length || !form_key.length){
            cUsDF_myjq('.advice_notice').html('Please select your Contact Us Tab Template').slideToggle().delay(2000).fadeOut(2000);
        }else{
            
            cUsDF_myjq('.save_tab_message_'+formID).show();
            
            cUsDF_myjq.ajax({type: "POST", url: ajax_object.ajax_url, data: {action:'cUsDF_changeTabTemplate',Template_Desktop_Tab:Template_Desktop_Tab, form_key:form_key },
                success: function(data) {

                    switch(data){
                        case '1':
                            message = '<p>Saved Successfully . . . .</p>';
                            cUsDF_myjq('.save_tab_message_'+formID).html(message);
                            cUsDF_myjq('.tab_thumb_'+formID).attr('src','https://admin.contactus.com/popup/tpl/'+Template_Desktop_Tab+'/scr.png');

                            setTimeout(function(){
                                cUsDF_myjq('.save_tab_message_'+formID).fadeOut();
                            },2000);

                            break
                    }

                },
                async: false
            });
        }  
            
    }
    
    
    cUsDF_myjq('.cUsDF_LogoutUser').click(function(){
        
        cUsDF_myjq( "#dialog-message" ).html('Please confirm you would like to unlink your account.');
        cUsDF_myjq( "#dialog-message" ).dialog({
            resizable: false,
            width:430,
            title: 'Close your account session?',
            height:180,
            modal: true,
            buttons: {
                "Yes": function() {
                    
                    cUsDF_myjq('.loadingMessage').show();
                    cUsDF_myjq.ajax({ type: "POST", url: ajax_object.ajax_url, data: {action:'cUsDF_logoutUser'},
                        success: function(data) {
                            cUsDF_myjq('.loadingMessage').fadeOut();
                              location.reload();
                        },
                        async: false
                    });
                    
                    cUsDF_myjq( this ).dialog( "close" );
                    
                },
                Cancel: function() {
                    cUsDF_myjq( this ).dialog( "close" );
                }
            }
        });
        
    });
    
    
    cUsDF_myjq('.form_version').click(function(){
        
        var value = cUsDF_myjq(this).val();
         
        var msg = '';
        switch(value){
            case 'select_version':
                msg = '<p>Custom form templates must be added to each page individually. Would you like to continue?</p>';
                break;
            case 'tab_version':
                msg = '<p>You are about to change to Default Form Settings, only your Default form will show up in all of your site</p>';
                break;
        }
        
        cUsDF_myjq( "#dialog-message" ).html(msg);
        cUsDF_myjq( "#dialog-message" ).dialog({
            resizable: false,
            width:430,
            title: 'Change your Form Settings?',
            height:180,
            modal: true,
            buttons: {
                "Yes": function() {
                    
                    switch(value){
                        case 'select_version':
                            cUsDF_myjq('.tab_button').addClass('gray').removeClass('green').attr('disabled', false);
                            cUsDF_myjq('.custom').addClass('green').removeClass('disabled').attr('disabled', true);
                            cUsDF_myjq('.ui-buttonset input').removeAttr('checked');
                            cUsDF_myjq('.ui-buttonset label').removeClass('ui-state-active');

                            cUsDF_myjq('.loadingMessage').show();
                            cUsDF_myjq.ajax({ type: "POST", url: ajax_object.ajax_url, data: {action:'cUsDF_saveCustomSettings',cus_donation_version:'selectable',tab_user:0},
                                success: function(data) {
                                	//alert(data);
                                    cUsDF_myjq('.loadingMessage').fadeOut();
                                    cUsDF_myjq('.notice_success').html('<p>Custom settings saved.</p>').fadeIn().delay(2000).fadeOut(2000);
                                    //location.reload();
                                },
                                async: false
                            });

                            break;
                        case 'tab_version':
                            cUsDF_myjq('.custom').addClass('gray').removeClass('green').attr('disabled', false);
                            cUsDF_myjq('.tab_button').removeClass('gray').addClass('green').attr('disabled', true);

                            cUsDF_myjq('.loadingMessage').show();
                            cUsDF_myjq.ajax({ type: "POST", url: ajax_object.ajax_url, data: {action:'cUsDF_saveCustomSettings',cus_donation_version:'tab',tab_user:1},
                                success: function(data) {
                                    cUsDF_myjq('.loadingMessage').fadeOut();
                                    cUsDF_myjq('.notice_success').html('<p>Tab settings saved . . .</p><p>Your default Contact Form will appear in all your website.</p>').fadeIn().delay(5000).fadeOut(2000);
                                    //location.reload();
                                },
                                async: false
                            });

                            break;
                    }

                    cUsDF_myjq('.cus_versionform').fadeOut();
                    cUsDF_myjq('.' + value).fadeToggle();
                    
                    cUsDF_myjq( this ).dialog( "close" );
                    
                },
                Cancel: function() {
                    cUsDF_myjq( this ).dialog( "close" );
                }
            }
        });
        
    });
    
    cUsDF_myjq('.btab_enabled').click(function(){
        var value = cUsDF_myjq(this).val();
        cUsDF_myjq('.tab_user').val(value);
        cUsDF_myjq('.loadingMessage').show();
       
        setTimeout(function(){
            cUsDF_myjq('#cUsDF_button').submit();
        },1500);
        
    });
    
    cUsDF_myjq('#contactus_settings_page').change(function(){
        cUsDF_myjq('.show_preview').fadeOut();
        cUsDF_myjq('.save_page').fadeOut( "highlight" ).fadeIn().val('>> Save your settings');
    });
    
    cUsDF_myjq('.callout-button').click(function() {
        cUsDF_myjq('.getting_wpr').slideToggle('slow');
    });
    
    cUsDF_myjq('#cUsDF_yes').click(function() {
        cUsDF_myjq('#cUsDF_userdata, #cUsDF_templates').fadeOut();
        //alert('opening login');
        cUsDF_myjq('#cUsDF_settings').slideDown('slow');
        cUsDF_myjq('#cUsDF_loginform').delay(600).fadeIn();
    });
    cUsDF_myjq('#cUsDF_no').click(function() {
        cUsDF_myjq('#cUsDF_loginform, #cUsDF_templates').fadeOut();
        cUsDF_myjq('#cUsDF_settings').slideDown('slow');
        cUsDF_myjq('#cUsDF_userdata').delay(600).fadeIn();
    });
    
    $('.form_template, .step2, #cUsDF_settings').css("display","none");
    
    function checkRegexp( o, regexp, n ) {
        if ( !( regexp.test( o ) ) ) {
            return false;
        } else {
            return true;
        }
    }
    
    function checkURL(url) {
        return /^(ht|f)tps?:\/\/[a-z0-9-\.]+\.[a-z]{2,4}\/?([^\s<>\#%"\,\{\}\\|\\\^\[\]`]+)?$/.test(url);
    }
    
    function str_clean(str){
           
        str = str.replace("'" , " ");
        str = str.replace("," , "");
        str = str.replace("\"" , "");
        str = str.replace("/" , "");

        return str;
    }
    $('.insertShortcode').click(function(){
        console.log('Code')
    });
    
    function contactUs_mediainsert() {
        console.log('sentTo');
        send_to_editor('[show-contactus.com-form]');
    }
    
    
});
