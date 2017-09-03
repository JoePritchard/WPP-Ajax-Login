# WPP-Ajax-Login
Provides a simple Ajax Login for Wordpress via a Shortcode
This is a Wordpress Plugin that provides a Shortcode that can be added on any page / post to let a user log in 
to the site via an AJAX login routine. They will log in and be left on the page, rather than the page being refreshed.

The shortcode is [ajax_login_form] and there are no configuration parameters.

The login form displayed is put in a DIV container called ajax-login-form-container - if you look in the 
CSS file within the Plugin folder you'll see this referenced and you can alter the CSS to suit your requirements. 
To see the elements in the form, just put the shortcode on a page, load the page, then use your browser inspect 
function to look at the elements.

The 'spinner' GIF (called loading.gif) is also in the folder and can be replaced if required.
