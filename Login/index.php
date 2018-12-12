<?php
header('Cache-Control: no-cache, must-revalidate');
header('Cache-Control: private');
header('Pragma: no-cache');
header('Expires: Mon, 26 Jul 2014 05:00:00 GMT');

if(!isset($_SESSION) ){
    // For added security, regenerate the sesssion id.
    session_regenerate_id(true);
}


// Turn on PHP error reporting to debug.
/*
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
*/

// Check if this is the staging or production environment. If you already declare these in a config file, these values can also be set there.
// Set the SiteCode to be used when checking user credentials.
// Also set the default admin home page - If a user logged in via tools.warnerartists.com then they will be directed here after authentication.

if($_SERVER['SERVER_NAME']=='generator.thefirepit.co.uk.457elmp02.blackmesh.com'){
    $sitecode = 'FGS';
    $adminurl = 'http://generator.thefirepit.co.uk.457elmp02.blackmesh.com/';
}elseif($_SERVER['SERVER_NAME']=='localhost'){
    $sitecode = 'localhost';
    //if needed set path for localhost dev environment and use across the app
    // $_SESSION['localhostConfigPath'] = '';
    $_SESSION['localhostConfigPath'] = '/oldGenerator';
    $adminurl = $_SERVER['SERVER_NAME'].$_SESSION['localhostConfigPath'];
}else{
    $sitecode = 'FPG';
    $adminurl = 'http://generator.thefirepit.co.uk/';
}
$redirecturl = '';

// Set the credentials for the web service user to login and check user details.
$wslogin = 'firepitgenerator';
$wspassword = '0GJSTD97@dGTk*reJd';

// Declare the SOAP service url and disable WSDL cache
ini_set('soap.wsdl_cache_enabled', '0');
$wsdl = 'https://tools.warnerartists.com/api/remotelogin.asmx?WSDL';
$service = new SoapClient($wsdl);


if(!empty($_POST)) {

    // Page was loaded with POST data so use the regular login web service.
    // Get username and password from post data
    if (isset($_POST['username'])) {$loginusr = $_POST['username'];}else{$loginusr = '';}
    if (isset($_POST['password'])) {$loginpss = $_POST['password'];}else{$loginpss = '';}
    if (isset($_POST['prevurl'])) {$prevurl = $_POST['prevurl'];}else{$prevurl = $adminurl;}

    $ret = $service->__call('Login', array(
        'parameters' => array(
            'Authentication' => array('Username' => $wslogin, 'Password' => $wspassword), 'User' => array('Username' => $loginusr, 'Password' => $loginpss), 'Sitecode' => $sitecode
            )
        )
    );

  if (gettype($ret) == 'object' && isset($ret->LoginResult)) {
     if ($ret->LoginResult->Response == 'Success') {
            //bypass login for localhost testing
            //if(1){if(1){
                
            $_SESSION['login'] = '1';
            $_SESSION['userid'] = $ret->LoginResult->UserID;
            $_SESSION['username'] = $ret->LoginResult->Username;
            $_SESSION['role'] = $ret->LoginResult->Role->Roles;
            $_SESSION['country'] = $ret->LoginResult->CountryISO->string;
            $_SESSION['firstname'] = $ret->LoginResult->Forename; 
            $_SESSION['surname'] = $ret->LoginResult->Surname;
            $_SESSION['email'] = $ret->LoginResult->Email;

            $redirecturl = $prevurl;

            // If the page has both POST data and a transferkey then clear the transfer key from the redirect URL.
            if (isset($_GET['transferkey'])){
                 $redirecturl = $adminurl;
                // echo 'both post and get data exists here.';
            }

        } else {
            $errormsg = 'Sorry, there was an error with your login: '.$ret->LoginResult->Response;
        }
    }

}elseif (isset($_GET['transferkey'])){
    //echo 'The transfer key exists.';

    // If the transfer key exists then the user came from the marketing suite, first reset the current session to make sure the latest permissions are loaded.
            $_SESSION['login'] = '0';
            $_SESSION['userid'] = '';
            $_SESSION['username'] = '';
            $_SESSION['role'] = '';
            $_SESSION['country'] = '';
            $_SESSION['firstname'] = '';
            $_SESSION['surname'] = '';
            $_SESSION['email'] = '';
    // Then get the transfer key
    $transferkey = $_GET['transferkey'];
    // Validate the transfer key using the validateTransfer web service.
    $ret   = $service->__call('ValidateTransfer', array(
        'parameters' => array(
            'Authentication' => array('Username' => $wslogin, 'Password' => $wspassword), 'Transferkey' => $transferkey
            )
        )
    );

    if (gettype($ret) == 'object' && isset($ret->ValidateTransferResult)) {
          //echo '<pre>'.var_dump($ret).'</pre>';
         // Create the session variables based on the user profile.
         //echo '<br/>Response: '.$ret->ValidateTransferResult->Response;
        if ($ret->ValidateTransferResult->Response == 'Success') {
            $_SESSION['login'] = '1';
            $_SESSION['userid'] = $ret->ValidateTransferResult->UserID;
            $_SESSION['username'] = $ret->ValidateTransferResult->Username;
            $_SESSION['role'] = $ret->ValidateTransferResult->Role->Roles;
            $_SESSION['country'] = $ret->ValidateTransferResult->CountryISO->string;
            $_SESSION['firstname'] = $ret->ValidateTransferResult->Forename;
            $_SESSION['surname'] = $ret->ValidateTransferResult->Surname;
            $_SESSION['email'] = $ret->ValidateTransferResult->Email;

            $redirecturl = $adminurl;
        } else {
            $errormsg = 'Sorry, there was an error with your login: '.$ret->ValidateTransferResult->Response;
        }
    }

} else {
    // if the user navigates to the login page while they already have an active session, then tell them to log-out or go home.
    if(isset($_SESSION['login']) && $_SESSION['login'] == '1') {
        echo '<!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>The Firepit Site Generator</title>
        </head>
            <body id="login">
            <div class="container">
                <div class="form-group">&nbsp;</div>
                <div class="col-sm-8 col-lg-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                  <h1 class="panel-title">The Firepit Site Generator</h1>
                </div>
                <div class="panel-body"><h4>You are already logged in.</h4><h4><a href="/login/logout.php">Log out</a> or <a href="/">Return to home page</a></h4></div>
        </div></div></div></body></html>';
        die;
    }
}

// If the user does not have a country assigned in their profile then set it based on their current IP address.
if (isset($_SESSION['country']) && $_SESSION['country'] == ''){
    $_SESSION['country'] = geoip_country_code_by_name($_SERVER['REMOTE_ADDR']);
};

// An edge case: if user has multiple countries in their profile, use their current IP address to select which one of those territories to use.
// If their IP doesn't match a country in their profile then fallback to the first country assigned to them (usually alphabetical).
if (isset($_SESSION['country']) && is_array($_SESSION['country'])){
    $countrycode = geoip_country_code_by_name($_SERVER['REMOTE_ADDR']);
    if (in_array($countrycode, $_SESSION['country'])) {
        $_SESSION['country'] =  $countrycode;
    }else{
        $_SESSION['country'] = $_SESSION['country'][0];
    }
};

// If a user has no role assigned for this app, it should fall-back to a standard User account.
if (isset($_SESSION['role']) && is_array($_SESSION['role'])){
     $_SESSION['role'] = 'User';
}
// If a user has been assigned multiple roles then give them permissions for the highest role they have.
if (isset($_SESSION['role']) && is_array($_SESSION['role'])){
    if (in_array('Admin', $_SESSION['role'])) {
        $_SESSION['role'] = 'Admin';
    }elseif (in_array('User', $_SESSION['role'])) {
        $_SESSION['role'] = 'User';
    }elseif (in_array('Web Service', $_SESSION['role'])) {
        $_SESSION['role'] = 'Web Service';
    }else{
         $_SESSION['role'] = 'User';
    }
};

// Everything is good, redirect the user to either the URL they came from or the admin home page.
if (!empty($redirecturl)){ header ('Location: '.$redirecturl); }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The Firepit Site Generator</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
    <style>
        body {
          padding-top: 40px;
          padding-bottom: 40px;
          background-color: #eee;
        }

        .container {
          max-width: 600px;
          padding: 15px;
          margin: 0 auto;
        }
        .form-signin .form-signin-heading,
        .form-signin .checkbox {
          margin-bottom: 10px;
        }
        .form-signin .checkbox {
          font-weight: normal;
        }
        .form-signin .form-control {
          position: relative;
          height: auto;
          -webkit-box-sizing: border-box;
             -moz-box-sizing: border-box;
                  box-sizing: border-box;
          padding: 10px;
          font-size: 16px;
        }
        .form-signin .form-control:focus {
          z-index: 2;
        }
        .form-signin input[type="text"] {
          margin-bottom: -1px;
          border-bottom-right-radius: 0;
          border-bottom-left-radius: 0;
        }
        .form-signin input[type="password"] {
          margin-bottom: 10px;
          border-top-left-radius: 0;
          border-top-right-radius: 0;
        }
    </style>
  </head>
<body id="login" class="loginpage">
    <div class="container">
                
                    
            <div class="panel-body">
                  <?php
                  // Get the current URL so that the page can reload after authenticating
                  $url  = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
                  $url .= ( $_SERVER["SERVER_PORT"] !== 80 ) ? ":".$_SERVER["SERVER_PORT"] : "";
                  $url .= $_SERVER["REQUEST_URI"];
                  if (!empty($errormsg)){ echo '<div class="alert alert-danger">'.$errormsg.'</div>'; }
                  ?>
                <form method="post" action="" class="form-signin">
                    <h2 class="form-signin-heading">The Firepit Site Generator</h2>
                    <h5>Login with your WMG Marketing Suite account</h5>

                    <label for="inputEmail" class="sr-only">Email/Username</label>
                    <input type="text" name="username" id="inputEmail" class="form-control" placeholder="Email/Username" required autofocus>
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>

                    
                    <input type="hidden" name="prevurl" value="<? echo $url; ?>">
                    <button type="submit" name="login" class="btn btn-primary btn-lg btn-block">Log In</button>
                </form>
            </div>

            <div class="panel-footer">
                <p>Forgotten your password? Please visit <a href="https://tools.warnerartists.com" target="_blank">https://tools.warnerartists.com</a> to reset it.</p>
                <p>If you need an account, don't have access to this tool or have any trouble logging in, please contact <a href="mailto:tools@warnerartists.com" target="_blank">tools@warnerartists.com</a></p>
            </div>
                
            
    </div> <!-- /container -->

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-78277730-2', 'auto');
  ga('send', 'pageview');

</script>
</body>


<script type="text/javascript" src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</html>
