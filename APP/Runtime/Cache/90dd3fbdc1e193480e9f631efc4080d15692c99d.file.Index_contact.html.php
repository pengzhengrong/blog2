<?php /* Smarty version Smarty-3.1.6, created on 2016-06-20 16:40:03
         compiled from "./APP/Home/View/Index_contact.html" */ ?>
<?php /*%%SmartyHeaderCode:9169437715767a6224baab3-79638438%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '90dd3fbdc1e193480e9f631efc4080d15692c99d' => 
    array (
      0 => './APP/Home/View/Index_contact.html',
      1 => 1466412001,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9169437715767a6224baab3-79638438',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5767a62252374',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5767a62252374')) {function content_5767a62252374($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("Common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('title'=>"blog"), 0);?>

</head>
<body>
<?php echo $_smarty_tpl->getSubTemplate ("Common/loader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="all-elements">
<?php echo $_smarty_tpl->getSubTemplate ("Common/left.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    
    <div class="header">
        <a href="#" class="main-logo"></a>
        <a href="#" class="open-menu"><i class="fa fa-navicon"></i></a>
        <a href="#" class="open-call"><i class="fa fa-phone"></i></a>
        <a href="#" class="open-mail"><i class="fa fa-envelope-o"></i></a>
    </div> 
    
    <a href="#" class="footer-ball"><i class="fa fa-navicon"></i></a>
    
    <!-- Page Content-->
    <div id="content" class="snap-content">        
        <div class="maps-container">
            <iframe class="responsive-image maps" src="https://maps.baidu.com/?ie=UTF8&amp;ll=47.595131,-122.330414&amp;spn=0.006186,0.016512&amp;t=h&amp;z=17&amp;output=embed"></iframe>
        </div>

        <div class="content">
            <div class="decoration"></div>
            <div class="one-half-responsive">
                <h4>Send us an email!</h4>
                <p>Use the form to send us a message, it's AJAX and PHP powered and it's easy to use!</p>
                <div class="container no-bottom">
                    <div class="contact-form no-bottom"> 
                        <div class="formSuccessMessageWrap" id="formSuccessMessageWrap">
                            <div class="big-notification green-notification">
                                <h3 class="uppercase">Message Sent </h3>
                                <a href="#" class="close-big-notification">x</a>
                                <p>Your message has been successfuly sent. Please allow up to 48 hours for a reply! Thank you!</p>
                            </div>
                        </div>

                        <form action="php/contact.php" method="post" class="contactForm" id="contactForm">
                            <fieldset>
                                <div class="formValidationError" id="contactNameFieldError">
                                    <div class="static-notification-red tap-dismiss-notification">
                                        <p class="center-text uppercase">Name is required!</p>
                                    </div>
                                </div>             
                                <div class="formValidationError" id="contactEmailFieldError">
                                    <div class="static-notification-red tap-dismiss-notification">
                                        <p class="center-text uppercase">Mail address required!</p>
                                    </div>
                                </div> 
                                <div class="formValidationError" id="contactEmailFieldError2">
                                    <div class="static-notification-red tap-dismiss-notification">
                                        <p class="center-text uppercase">Mail address must be valid!</p>
                                    </div>
                                </div> 
                                <div class="formValidationError" id="contactMessageTextareaError">
                                    <div class="static-notification-red tap-dismiss-notification">
                                        <p class="center-text uppercase">Message field is empty!</p>
                                    </div>
                                </div>   
                                <div class="formFieldWrap">
                                    <label class="field-title contactNameField" for="contactNameField">Name:<span>(required)</span></label>
                                    <input type="text" name="contactNameField" value="" class="contactField requiredField" id="contactNameField"/>
                                </div>
                                <div class="formFieldWrap">
                                    <label class="field-title contactEmailField" for="contactEmailField">Email: <span>(required)</span></label>
                                    <input type="text" name="contactEmailField" value="" class="contactField requiredField requiredEmailField" id="contactEmailField"/>
                                </div>
                                <div class="formTextareaWrap">
                                    <label class="field-title contactMessageTextarea" for="contactMessageTextarea">Message: <span>(required)</span></label>
                                    <textarea name="contactMessageTextarea" class="contactTextarea requiredField" id="contactMessageTextarea"></textarea>
                                </div>
                                <div class="formSubmitButtonErrorsWrap">
                                    <input type="submit" class="buttonWrap button button-green contactSubmitButton" id="contactSubmitButton" value="SUBMIT" data-formId="contactForm"/>
                                </div>
                            </fieldset>
                        </form>       
                    </div>
                </div>
            </div>
            <div class="decoration hide-if-responsive"></div>
            <div class="one-half-responsive last-column">
                <div class="container no-bottom">
                    <h4>Contact Information</h4>
                    <p>
                        <strong>Postal Information</strong><br>
                        PO Box 16122 Collins Street West<br>
                        Victoria 8007 Australia
                    </p>
                    <p>
                        <strong>Envato Headquarters</strong><br>
                        121 King Street, Melbourne <br>
                        Victoria 3000 Australia
                    </p>
                    <p>
                        <strong>Contact Information:</strong><br>
                        <a href="#" class="contact-call"><i class="fa fa-phone"></i>Phone: + 123 456 7890</a>
                        <a href="#" class="contact-text"><i class="fa fa-comments"></i>Message: + 123 456 7890</a>
                        <a href="#" class="contact-mail"><i class="fa fa-envelope"></i>Email: mail@doamin.com</a>
                        <a href="#" class="contact-facebook"><i class="fa fa-facebook"></i>Fanpage: enabled.labs</a>
                        <a href="#" class="contact-twitter"><i class="fa fa-twitter"></i>Twitter: @iEnabled</a>
                    </p>
                </div>            
            </div>
            
            <div class="decoration"></div>
            
        </div>
        <!-- Page Footer-->
        <?php echo $_smarty_tpl->getSubTemplate ("Common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


</body>

<?php }} ?>