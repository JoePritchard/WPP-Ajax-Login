<?php
/*
Plugin Name: Ajax Login
Version : 1.0
Plugin URI: https://github.com/JoePritchard/WPP-Ajax-Login
Description: Provides an Ajax Login Dialogue via a shortcode
Version: Version 1.0
Author: Joe Pritchard
Author URI: 
License: 
*/



function login_stylesheet() {
    wp_enqueue_style( 'ajax-login-css', plugin_dir_url( __FILE__ ) . 'ajax-login-stylesheet.css' );

}
add_action( 'wp_enqueue_scripts', 'login_stylesheet' );





function login_form_creation(){

ob_start();

?>
<div id="ajax-login-form-container">
<form id="login" action="login" method="post">
        <h1>Site Login</h1>
		<table>
		<tr>
		<td>Username</td><td><input id="username" type="text" name="username"></td>
		</tr>
		<tr>
		<td>Password</td><td><input id="password" type="password" name="password"></td>
		</tr>
		</table>
		<div id="ajax-status"></div>
		<br />
		<Div id="ajax-login-spinner"><img width="70px" height="70px" src="<?php echo plugin_dir_url( __FILE__ ) . 'loading.gif';?>" /></div>
		<br />
        <input class="submit_button" type="submit" value="Login" name="submit">
        <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
    </form>
	</div>
<?php

  $content = ob_get_contents();
  ob_end_clean();
  return $content;

}


//	Now set up the Script...
function ajax_login_init(){
    wp_register_script('ajax-login-script', plugin_dir_url( __FILE__ ) . 'ajax-login-script.js', array('jquery') ); 
    wp_enqueue_script('ajax-login-script');
    wp_localize_script( 'ajax-login-script', 'ajax_login_object', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'redirecturl' => "//".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],
        'loadingmessage' => __('Sending user info, please wait...')
    ));

    // Enable the user with no privileges to run ajax_login() in AJAX
    add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );
}

//	Add the above initialise function to the appropriate hook.
add_action('init', 'ajax_login_init');


function ajax_login(){

    // First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-login-nonce', 'security' );

    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    $user_signon = wp_signon( $info, true );
    if ( is_wp_error($user_signon) ){
        echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.')));
    } else {
        echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...')));
    }

    die();
}


//	Finally add the shortcode
add_shortcode('ajax_login_form', 'login_form_creation');
?>