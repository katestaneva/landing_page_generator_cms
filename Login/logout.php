<?php require $_SERVER['DOCUMENT_ROOT'].'/oldGenerator/login/sessions.php';
// Destroy the session variables!
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>The Firepit Site Generator</title>
</head>
<body id="logout">
	<div class="container">
		<div class="form-group">&nbsp;</div>
        <div class="col-sm-8 col-lg-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                  <h1 class="panel-title">The Firepit Site Generator</h1>
                </div>
                <div class="panel-body">
                	<h4>You have successfully logged out.</h4>
                    <p>Visit <a href="/">the home page</a> to login again.</p>
                </div>
        	</div>
		</div>
	</div>
</body>
</html>
