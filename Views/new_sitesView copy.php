
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- if (website is loaded) { -->
    <title>New Site</title>
 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" >
    <link rel="stylesheet" href="../bower_components/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css" >
</head>

<body class="new">
    <div class="container">
        <ol class="breadcrumb">
          <?php $url = Helper::makeUrl('sites', 'default'); ?>
          <li><a href="<?= $url ?>" >Home</a></li>
          <!-- if (website is loaded) { -->
          <li class="active">New Site</li> 
        </ol>

        <!-- if (website is loaded) { -->
        <h1>New Site</h1>
        <div class="row">

            <div class="col-md-5 well" id="form-container">
                <h2>Settings</h2>
                
                <form class="form-horizontal" method="post" id="theForm" enctype="multipart/form-data">

                    <div class="form-group form-group-lg">
                        <label for="artistName" class="col-sm-3 control-label">Artist Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="artistName" name="artistName" <?= $this->populate("artistName", "Artist Name"); ?> required>
                        </div>
                    </div>

                    <div class="well">
                        <h3>Styles</h3>

                        <div class="form-group form-group-lg">
                        <label for="theme" class="col-sm-3 control-label">Theme</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="theme" name="theme">
                                  <option value="1">Full Height Sections</option>
                                  <option value="2">Full-Screen Video</option>
                                  <option value="3">Centred Column</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group form-group-lg">
                        <label for="font" class="col-sm-3 control-label">Font</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="font" name="font">
                                  <option>---</option>
                                </select>
                                <p class="help-block">
                                    Choose a Google Font, available here: <a href="https://fonts.google.com/" target="_blank">fonts.google.com</a>
                                </p>
                            </div>
                        </div>

                        <div class="form-group form-group-lg">
                        <label for="color" class="col-sm-3 control-label">Text Colour</label>
                            <div class="col-sm-9">
                                <input class="form-control color-picker" id="color" name="color" type="text"  <?= $this->populate("color", "e.g. #ffffff"); ?> >
                            </div>
                        </div>

                        <div class="form-group form-group-lg">
                        <label for="background-color" class="col-sm-3 control-label">Background Colour</label>
                            <div class="col-sm-9">
                                <input class="form-control color-picker" id="background-color" name="background-color"  <?= $this->populate("background-color", "e.g. #ffffff"); ?> type="text">
                            </div>
                        </div>

                        <div class="form-group form-group-lg">
                        <label for="overlay-color" class="col-sm-3 control-label">Overlay Colour</label>
                            <div class="col-sm-9">
                                <input class="form-control color-picker" id="overlay-color" name="overlay-color" <?= $this->populate("background-color", "overlay-color"); ?>  type="text" >
                            </div>
                        </div>
                    </div>

                    <div class="well">
                        <h3>Meta Tags</h3>

                        <div class="form-group form-group-lg">
                        <label for="url" class="col-sm-3 control-label">URL</label>
                            <div class="col-sm-9">
                                <input class="form-control" id="url" name="url" type="text" <?= $this->populate("url", "URL"); ?> >
                            </div>
                        </div>

                        <div class="form-group form-group-lg">
                        <label for="title" class="col-sm-3 control-label">Title</label>
                            <div class="col-sm-9">
                                <input class="form-control" id="title" name="title" type="text"  <?= $this->populate("title", "Title"); ?> >
                            </div>
                        </div>

                        <div class="form-group form-group-lg">
                        <label for="description" class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-9">
                                <input class="form-control" id="description" name="description" type="text" <?= $this->populate("description", "Description"); ?> >
                            </div>
                        </div>

                        <div class="form-group form-group-lg">
                            <div for="ogImage" class="col-sm-3 control-label" style="padding-top:0;">Upload OG Image <a class="badge" data-toggle="popover" data-trigger="hover" tabindex="0" role="button" data-content="Open Graph image will be shown when the site is shared on Facebook or Twitter. Optimum size: 1200 x 630">?</a></div>
                            <div class="col-sm-9">
                                <div class="row" style="margin:0;">
                                    <label class="btn btn-default btn-lg btn-file col-sm-9">
                                        Browse <input type="file" class="file-input" id="ogImage" name="ogImage" style="display: none;">
                                    </label>
                                    <button class="btn btn-danger btn-lg col-sm-2 col-sm-offset-1 clear" data-input="ogImage">X</button>
                                </div>
                                <p class="help-block">
                                    <img src=<?php if(isset($this->siteObj) && property_exists($this->siteObj, 'ogImage')){ echo '"'.$this->siteObj->ogImage.'"'; } ?>  id="ogImageImg" class="img-thumbnail">
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <label for="artistLogo" class="col-sm-3 control-label">Upload Logo</label>
                        <div class="col-sm-9">
                            <div class="row" style="margin:0;">
                                <label class="btn btn-default btn-lg btn-file col-sm-9">
                                    Browse <input type="file" class="file-input" id="artistLogo" name="artistLogo" style="display: none;">
                                </label>
                                <button class="btn btn-danger btn-lg col-sm-2 col-sm-offset-1 clear" data-input="artistLogo">X</button>
                            </div>
                            <p class="help-block">
                                <img id="artistLogoImg" class="img-thumbnail" src=<?php if(isset($this->siteObj) && property_exists($this->siteObj, 'artistLogo')){ echo '"'.$this->siteObj->artistLogo.'"'; } ?> >
                            </p>
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <label for="artistBackground" class="col-sm-3 control-label" style="padding-top:0;">Upload Background</label>
                        <div class="col-sm-9">
                            <div class="row" style="margin:0;">
                                <label class="btn btn-default btn-lg btn-file col-sm-9">
                                    Browse <input type="file" class="file-input" id="artistBackground" name="artistBackground" style="display: none;"  >
                                </label>
                                <button class="btn btn-danger btn-lg col-sm-2 col-sm-offset-1 clear" data-input="artistBackground">X</button>
                            </div>
                            <p class="help-block">
                                <img id="artistBackgroundImg" class="img-thumbnail" src=<?php if(isset($this->siteObj) && property_exists($this->siteObj, 'artistBackground')){ echo '"'.$this->siteObj->artistBackground.'"'; } ?> >
                            </p>
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <label class="col-sm-3 control-label">Social Links</label>
                        <div class="col-sm-9">
                            <div class="form-inline" id="socialInputContainer">
                            </div>
                            <a class="btn btn-default btn-block btn-lg" id="addNewSocial">Add New</a>
                        </div>
                    </div>                    

                    <div class="form-group form-group-lg">
                        <label for="storeLink" class="col-sm-3 control-label">Store Link</label>
                        <div class="col-sm-9">
                            <input type="url" class="form-control" id="storeLink" name="storeLink"  <?= $this->populate("storeLink", "Store Link"); ?> >
                        </div>
                    </div>

                    <div class="well">
                        <h3>Upsell</h3>
                        <div class="form-group form-group-lg" id="upsell-group">
                            <label for="releaseTitle" class="col-sm-3 control-label">Title</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="releaseTitle" name="releaseTitle" <?= $this->populate("releaseTitle", "Release Title"); ?> >
                            </div>
                        </div>
                        <div class="form-group form-group-lg" id="upsell-group">
                            <label for="releasePackshot" class="col-sm-3 control-label">Packshot</label>
                            <div class="col-sm-9">
                                <div class="row" style="margin:0;">
                                    <label class="btn btn-default btn-lg btn-file col-sm-9">
                                        Upload Packshot <input type="file" class="file-input" id="releasePackshot" name="releasePackshot" style="display: none;">
                                    </label>
                                    <button class="btn btn-danger btn-lg col-sm-2 col-sm-offset-1 clear" data-input="releasePackshot">X</button>
                                </div>
                                <p class="help-block">
                                    <img id="releasePackshotImg" class="img-thumbnail" src=<?php if(isset($this->siteObj) && property_exists($this->siteObj, 'artistBackground')){ echo '"'.$this->siteObj->artistBackground.'"'; } ?>>
                                </p>
                            </div>
                        </div>
                        <div class="form-group form-group-lg" id="upsell-group">
                            <label class="col-sm-3 control-label">Buy Links</label>
                            <div class="col-sm-9">
                                <div class="form-inline" id="buyButtonContainer">
                                </div>
                                <a class="btn btn-default btn-block btn-lg" id="addNewBuyButton">Add Buy Link</a>
                            </div>
                        </div>
                    </div>

                    <div class="well">
                        <h3>Modules</h3>
                        <p>Drag each module to re-order them (If the theme allows it).</p>
                        <p>If left blank, module will not be visible</p>

                        <ul class="sortable">
                            <li id="moduleVideo">
                                <div class="well">
                                    <h3>Video</h3>
                                    <div class="form-group form-group-lg">
                                        <label for="youtubeTitle" class="col-sm-3 control-label">Video Title</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="youtubeTitle" name="youtubeTitle" <?= $this->populate("youtubeTitle", "Video Title"); ?> >
                                        </div>
                                    </div>

                                    <div class="form-group form-group-lg">
                                        <label for="youtubeLink" class="col-sm-3 control-label">YouTube Link</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="youtubeLink" name="youtubeLink" <?= $this->populate("youtubeLink", "YouTube Link"); ?> >
                                            <p class="help-block">Single video or playlist</p>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li id="moduleTour">
                                <div class="well">
                                <h3>Tour Dates</h3>
                                    <div class="form-group form-group-lg">
                                        <label for="songkickID" class="col-sm-3 control-label">Songkick ID <a class="badge" data-toggle="popover" data-html="true" data-trigger="hover" tabindex="0" role="button" data-content="e.g. <span style='opacity:0.5;'>songkick.com/artists/<span style='opacity:1;font-weight:bold;text-decoration:underline'>197928</span>-coldplay</span>">?</a></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="songkickID" name="songkickID" <?= $this->populate("songkickID", "Songkick ID"); ?> >
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li id="moduleSignup">
                                <div class="well">
                                <h3>Sign Up</h3>
                                    <div class="form-group form-group-lg">
                                        <div for="cdcID" class="col-sm-3 control-label">ExactTarget <a class="badge" data-toggle="popover" data-trigger="hover" tabindex="0" role="button" data-content="ExactTarget details can be requested from the CRM team">?</a></div>
                                        <div class="col-sm-9">
                                            <div class="form-inline" id="etContainer">
                                                <label class="control-label" for="cdcID">CDC ID</label><label class="control-label" for="triggerID">_trigger</label>
                                                <input type="text" class="form-control" id="cdcID" name="cdcID" <?= $this->populate("cdcID", "CDC ID"); ?>>
                                                <input type="text" class="form-control" id="triggerID" name="triggerID" <?= $this->populate("triggerID", "_trigger"); ?> > 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>

                    </div>

                    <div class="form-group form-group-lg">
                        <div for="trackingTags" class="col-sm-3 control-label">Tracking Tags <a class="badge" data-toggle="popover" data-trigger="hover" data-html="true" tabindex="0" role="button" data-content="Paste in Google Analytics tracking code, retargetting pixels or any other custom HTML/Javascript<br/><br/>The code is inserted before the closing body tag">?</a></div>
                        <div class="col-sm-9">
                            <textarea rows="10" class="form-control" id="trackingTags" name="trackingTags" <?= $this->populate("trackingTags", "e.g.

<script>
.......
</script>r"); ?>  ></textarea>
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" name="submit" class="btn btn-primary btn-block btn-lg submit">Create Site</button>
                        </div>
                    </div>

                </form>
            </div>

            <div class="col-md-6 col-md-offset-1" id="thePreview">
                <div class="preview-container well">
                    <h2>Preview</h2>
                    <p>For illustrative purposes only. Exact sizing/positioning may differ slightly.</p>
                    <div id="body" >
                        
                    </div>
                </div>
            </div>

        </div>

    </div>
