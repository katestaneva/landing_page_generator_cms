
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/main.css">
</head>

<body class="dashboard">
<h4><a href="login/logout.php">Log out</a></h4>
    <div class="jumbotron">
        <div class="container">

            <h1>The Firepit Site Generator</h1>
            <p class="lead"><i>Logged In</i></p>
            <?php $url = Helper::makeUrl('new_sites', 'default'); ?>
            <p><a class="btn btn-primary btn-lg" href="<?= $url ?>" role="button">New Site &raquo;</a></p>

        </div>
    </div>

    <div class="container">
        <div>
            <div class="tab-content">
            <?php $url = Helper::makeUrl('sites', 'default'); ?>
                <?php  echo '<div role="tabpanel" class="table-responsive tab-pane fade in active" id="user-sites">
                        <table class="table table-hover table-striped"
                            <thead>
                                <tr><tH><a href="'.$url.'/artist'.'">Artist</a></tH>
                                <tH><a href="'.$url.'/username'.'">Created By</a></tH>
                                <tH><a href="'.$url.'/date_modified'.'">Date Modified</a></tH></tr>
                            </thead> 
                            <tbody>';
                            $sites = $sitesModel->fetchColumns(['id', 'artist', 'username', 'date_modified'], $orderBy, $limiter, $orderDirection );
                            foreach($sites as $site){
                                $url = Helper::makeUrl('new_sites', 'loadSite', [$site['id']]);
                                echo '<tr><td><a href="'.$url.'">'.$site['artist'].'</a></td>
                                <td>'.$site['username'].'</td><td>'.$site['date_modified'].'</td></tr>';
                            }
                    echo '</tbody></table></div>';
                ?>
            </div>

        </div>
    </div>
    <!-- SCRIPTS -->
    <script type="text/javascript" src="../bower_components/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-78277730-2', 'auto');
      ga('send', 'pageview');

    </script>
</body>

</html>


