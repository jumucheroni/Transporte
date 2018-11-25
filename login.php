<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link href="css/jquery-ui-1.10.3.css" rel="stylesheet">
        <link href="css/jquery.gritter.css" rel="stylesheet">
        <link href="css/datepicker3.css" rel="stylesheet">
        <link href="css/styles.css" rel="stylesheet">
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link rel="shortcut icon" href="images/icon.png">
        
        <title>Transporte Escolar</title>
    
    </head>

    <body>
        <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#"><img src="img/logo.png" width="85px" height="45px" /></a>
                </div>
            </div>
        </nav>
        <div id="logar" class="row">
            <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">Logar</div>
                    <div class="panel-body">
                        <form id="login" role="form">
                            <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Usuario" name="usuario" id="usuario" type="usuario" autofocus="" maxlength="100">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Senha" name="senha" id="senha" type="password" value="" maxlength="12">
                            </div>
                            <button class="btn btn-primary" type="button" name="entrar" value="Entrar" id="entrar">Entrar</button>
                            </fieldset>
                         </form>
                         
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
            <div hidden id="alert">
                
            </div>
        </div>
    </body>
    <script src="js/jquery-1.11.1.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/login.js" type="text/javascript"></script>
</html>