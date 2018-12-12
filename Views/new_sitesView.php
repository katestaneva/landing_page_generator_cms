
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- if (website is loaded) { -->
    <title>New Site</title>
 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- <link rel="stylesheet" href="../css/main.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" >
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="js/view.js"></script>
    <script src="js/main.js"></script>
</head>

<body class="new">
    <div class="container">
        <ol class="breadcrumb">
          <?php $url = Helper::makeUrl('sites', 'default'); ?>
            <li><a href="<?= $url ?>" >Home</a></li>
            <!-- if (website is loaded) { -->
            <li class="active">New Site</li> 
        </ol>

        <h1>New Site</h1>

        
        <div class="container content">
            <div class="row">

                <div class="col-lg-5 col-lg-push-6">
                    <div class="preview-container well">
                        <h2>Preview</h2>
                        <p>For illustrative purposes only. Exact sizing/positioning may differ slightly.</p>
                        <div id="body" >
                            
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-lg-pull-5">
                    <?php  echo $adminContent ?>
                </div>
            </div>
        </div>
    </div>

