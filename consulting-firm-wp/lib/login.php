<?php

// Custom login screen

function custom_login() {

echo '<style type="text/css">
  
  /*---------- BACKGROUND ----------*/
  
  body.login {
    background: #ffffff;
  }
  
  
  /*---------- LOGO ----------*/
  
  .login h1 a {
    width: 280px;
    height: 80px;
    background-size: 170px 60px !important; /* <----- make sure this matches image size! */
    background-image:url('.get_bloginfo('template_directory').'/assets/img/logo.png) !important;
    margin: 0 auto;
  }
  
  
  /*---------- FORM ----------*/
  
  .login form {
    position: relative !important;
    background: transparent;
    border: none;
    -webkit-box-shadow: none;
    box-shadow: none;
    padding: 0;
    margin: 0 auto;
    width: 300px;
  }
  
  /*--- Labels ---*/
  
  .login form label {
    width: 300px;
    margin-right: 10px;
    color: #8a8a8f;
  }
  
  /*--- Fields ---*/
  
  .login form .input, .login input[type="text"] {
    -webkit-border-radius: 0;
    -moz-border-radius: 0;
    border-radius: 0;
    -moz-box-shadow: none;
    -webkit-box-shadow: none;
    box-shadow: none;
    
    background: #ffffff;
    border: 2px solid #8a8a8f;
    color: #19191a;
  }

  .login form .input:focus, .login input[type="text"]:focus {
    border-color: #19191a;
  }
  
  /*--- Submit Button ---*/
  
  .btn {
    border-color: transparent;
  }
  
  .login .button-primary {
    width: 100%;
    height: 40px !important;
    line-height: 40px !important;
    margin-top: 18px;
    padding: 0;
    border: none;
    -webkit-border-radius: 0;
    -moz-border-radius: 0;
    border-radius: 0;
    font-weight: 600;
    letter-spacing: 2px;
    font-size: 14px;
    text-transform: uppercase;
    text-shadow: none;
    -webkit-box-shadow: none;
    box-shadow: none;
    
    background: #52c6d8;
    color: #fff;
  }
  
  .button-primary:hover, .button-primary:active, .button-primary:focus {
    background: #00a7b8 !important;
    text-shadow: none;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
  } 
  
  
  /*---------- LINKS ----------*/
  
  .login #nav a {
    text-shadow: none;
    color: #301d12 !important;
  }
  
  .login #nav a:hover {
    color: #301d12 !important;
  }
  
  
  /*---------- ERRORS ----------*/
  
  #login_error, .login .message {
    margin: 0 auto 16px auto;
  }
  
  div.error, .login #login_error, div.updated, .login .message {
    border: none;
    width: 280px;
    padding: 10px;
    -webkit-border-radius: 0;
    -moz-border-radius: 0;
    border-radius: 0;
    
    color: #fff;
    background: #8a8a8f;
  }
  
  div.error a, #login_error a {
    color: #fff !important;
    text-decoration: none;
  }
  
  div.error a:hover, #login_error a:hover {
    color: #fff !important;
    text-decoration: underline;
  }
  
  
  /*---------- MISC. ALIGNMENT ----------*/
  
  #login {
    width: 100%;
    height: 100%;
    padding: 0;
    margin: 0;
    position: absolute;
  }
  
  .login h1 {
    margin-top: 100px;
  }
  
  #login #lostpasswordform p.submit, #login form p.submit {
    width: 100%;
  }
  
  .login form .forgetmenot label {
    width: auto;
  }
  
  .login #backtoblog {
    display: none;
    visibility: hidden;
  }
  
  .login #nav {
    margin: 20px auto 0 auto;
    width: 300px;
    text-align: center;
  }

</style>';

}
add_action('login_head', 'custom_login');

//custom login logo url
function put_my_url(){
  return (home_url());
}
add_filter('login_headerurl', 'put_my_url');