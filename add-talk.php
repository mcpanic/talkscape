<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="/talkscape/css/bootstrap.min.css">
        <style>
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
        </style>
        <link rel="stylesheet" href="/talkscape/css/bootstrap-responsive.min.css">
        <link rel="stylesheet" href="/talkscape/css/main.css">

        <script src="/talkscape/js/vendor/modernizr-2.6.1-respond-1.1.0.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
        <![endif]-->

        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <!--
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    -->
                    <div class="row">
                        <a class="brand" href="#">TalkScape</a>
                        <h4>Add a talk</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="span12">
                    <form class="form-horizontal">
                        <legend>Talk Info</legend>
                        <div class="control-group">
                            <label class="control-label" for="slug">URL</label>
                            <div class="controls">
                              http://juhokim.com/talkscape/<input type="text" id="slug" placeholder="one word" class="input-medium">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="title">Title</label>
                            <div class="controls">
                              <input type="text" id="title" placeholder="talk title" class="input-xxlarge">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="speaker">Speaker Name</label>
                            <div class="controls">
                              <input type="text" id="speaker" placeholder="speaker name" class="input-xlarge">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="affiliation">Speaker Affiliation</label>
                            <div class="controls">
                              <input type="text" id="affiliation" placeholder="speaker affiliation" class="input-xlarge">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="event">Event</label>
                            <div class="controls">
                              <input type="text" id="event" placeholder="what occasion was this?" class="input-xlarge">
                            </div>
                        </div>                        
                        <div class="control-group">
                            <label class="control-label" for="date">Talk Date</label>
                            <div class="controls">
                              <input type="text" id="date" placeholder="talk date" class="input-xlarge">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="date">Video Link</label>
                            <div class="controls">
                              <input type="text" id="video_link" placeholder="Vimeo link" class="input-xlarge">
                            </div>
                        </div>   
                        <div class="control-group">
                            <label class="control-label" for="date">Video Local Link</label>
                            <div class="controls">
                              <input type="text" id="video_local_link" placeholder="link to the video file on the server" class="input-xlarge">
                            </div>
                        </div>                         
                        <div class="control-group">
                            <label class="control-label" for="date">Slides Link</label>
                            <div class="controls">
                              <input type="text" id="slides_link" placeholder="link to the slides" class="input-xlarge">
                            </div>
                        </div>                                
                        <div class="control-group">
                            <label class="control-label" for="date">Abstract</label>
                            <div class="controls">
                              <textarea id="abstract" rows="8" placeholder="abstract (xxxx characters)" class="input-xxlarge"></textarea>
                            </div>
                        </div>                                           
                        <button type="submit" class="btn btn-large btn-primary">Save</button>
                    </form>
                </div>
            </div>
            <hr>

            <footer>
                <p>TalkScape created by <a href="http://juhokim.com/">Juho Kim</a>. For feedback, comments, feature requests, and bug reports, please <a href="mailto:imjuhokim@gmail.com">email me</a>.</p>
            </footer>

        </div> <!-- /container -->

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="/talkscape/js/vendor/jquery-1.8.2.min.js"><\/script>')</script>

        <script src="/talkscape/js/vendor/bootstrap.min.js"></script>        
        <script src="http://a.vimeocdn.com/js/froogaloop2.min.js"></script>
        <script src="/talkscape/js/vendor/jquery.fitvids.js"></script>
        <script src="/talkscape/js/main.js"></script>

        <script type="text/javascript">

          var _gaq = _gaq || [];
          _gaq.push(['_setAccount', 'UA-1145660-2']);
          _gaq.push(['_trackPageview']);

          (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
          })();

        </script>
    </body>
</html>
