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
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="favicon.ico" rel="shortcut icon" type="image/x-icon" />
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <style>
            body {
                padding-top: 50px;
                padding-bottom: 20px;
                font-size: 100%;
            }
        </style>
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="components/datetimepicker/jquery.datetimepicker.css"/ >

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="./">DateTime Calculator</a>
                </div>
                <div class="navbar-collapse collapse">
                </div><!--/.navbar-collapse -->
            </div>
        </div>

        <!-- Main jumbotron -->
        <div class="jumbotron">
            <div class="container">

                <form name="dtCalForm" id="dtCalForm" action="process.php" method="post" target="_self" enctype="application/x-www-form-urlencoded">
                    <div class="row">
                        <div class="col-md-5 required">From date &AMP; time <span class="required-field">*</span> :<br /><input id="fromDateTime" name="fromDateTime" type="text" class="required" /></div>
                        <div class="col-md-5 required">To date &AMP; time <span class="required-field">*</span> :<br /><input id="toDateTime" name="toDateTime" type="text" class="required" /></div>
                    </div>
                    <div id="radioGroup">Output unit :
                        <input type="radio" id="null" name="outputUnit" checked="checked" value="null"><label for="null">Default</label>
                        <input type="radio" id="second" name="outputUnit" value="second"><label for="second">Second(s)</label>
                        <input type="radio" id="minute" name="outputUnit" value="minute"><label for="minute">Minute(s)</label>
                        <input type="radio" id="hour" name="outputUnit" value="hour"><label for="hour">Hour(s)</label>
                        <input type="radio" id="year" name="outputUnit" value="year"><label for="year">Year(s)</label>
                    </div>
                    <div class="row">
                        <div class="col-md-4">From time zone :<br />
                            <div class="ui-widget custom-ui-body"><select name="fromTimeZone" id="fromTimeZone" class="custom-ui-body">
                                    <?php
                                    $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
                                    for ($i = 0; $i < count($tzlist); $i++) {
                                        if ("Australia/Adelaide" == $tzlist[$i]) {
                                            ?><option value="<?php echo $tzlist[$i]; ?>" selected="selected"><?php echo $tzlist[$i]; ?></option><?php
                                        } else {
                                            ?><option value="<?php echo $tzlist[$i]; ?>"><?php echo $tzlist[$i]; ?></option><?php
                                        }
                                    }
                                    ?>
                                </select></div>
                        </div>
                        <div class="col-md-4">To time zone:<br />
                            <div class="ui-widget custom-ui-body"><select name="toTimeZone" id="toTimeZone" class="custom-ui-body">
                                    <?php
                                    for ($i = 0; $i < count($tzlist); $i++) {
                                        if ("Australia/Adelaide" == $tzlist[$i]) {
                                            ?><option value="<?php echo $tzlist[$i]; ?>" selected="selected"><?php echo $tzlist[$i]; ?></option><?php
                                        } else {
                                            ?><option value="<?php echo $tzlist[$i]; ?>"><?php echo $tzlist[$i]; ?></option><?php
                                        }
                                    }
                                    ?>
                                </select></div>
                        </div>
                    </div><p></p>
                    <p><a id="dtCalFormReset" class="btn btn-primary btn-lg" role="button">Clear</a>&nbsp;<a id="dtCalFormSubmit" class="btn btn-primary btn-lg" role="button">Calculate &raquo;</a></p>
                </form>
            </div>
        </div>

        <div class="container">
            <!-- Example row of columns -->
            <div class="row">
                <div class="col-md-12">
                    <div id="results" class="well well-sm">Select required values and click calculate to view the results.</div>
                </div>
            </div>

            <hr>

            <footer>
                <p>&copy; Nuwan De Silva - 2014</p>
            </footer>
        </div> <!-- /container -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.0.min.js"><\/script>')</script>
        <script src="js/vendor/bootstrap.min.js"></script>
        <script language="javascript" type="text/javascript" src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
        <script language="javascript" type="text/javascript" src="components/datetimepicker/jquery.datetimepicker.js"></script>
        <script src="js/main.js"></script>
        <script language="javascript" type="text/javascript">
            $(function() {
                $('#radioGroup').buttonset();
                $('#fromDateTime').datetimepicker({
                    format: 'Y-m-d H:i:s',
                    inline: true
                });
                $('#toDateTime').datetimepicker({
                    format: 'Y-m-d H:i:s',
                    inline: true
                });

                $("#fromTimeZone").combobox();
                $("#toTimeZone").combobox();
            });
        </script>
    </body>
</html>
