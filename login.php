<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:600,400' rel='stylesheet' type='text/css'>
        <link href="css/style.css" rel="stylesheet">
        <link href="css/jquery-ui-1.10.3.css" rel="stylesheet">
        <link href="css/jquery.gritter.css" rel="stylesheet">
        <link rel="shortcut icon" href="images/icon.png">
        
        <title>Transporte Escolar</title>
    
    </head>

    <body>

        <div id="framework">

            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Transporte Escolar</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
             <div id="logar" class="container-fluid">
                <div id="canvas1" class="row">
                    <div class="col-xs-12 col-md-12 col-lg-10 col-lg-offset-1">
                         <p class="titulo-formu">Login</p>
                         <form id="login">
                            <div class="row">
                                <div class="col-md-6">
                                   <input class="input-formu" type="text" name="usuario" id="usuario" maxlength="100" value="" placeholder="Usuário" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                  <input class="input-formu" name="senha" id="senha" type="password" maxlength="12" value="" placeholder="Senha" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn" type="button" name="entrar" value="Entrar" id="entrar">Entrar</button>
                                </div>
                            </div>
                         </form>
                         <button class="btn btn-sm" type="button" name="cadastrar" value="Criar conta" id="cadastrar">Criar conta</button>
                    </div>
                </div>
            </div>
            <div hidden id="cadastro" class="container-fluid">
                <div id="canvas1" class="row">
                    <div class="col-xs-12 col-md-12 col-lg-10 col-lg-offset-1">
                         <p class="titulo-formu">Cadastro</p>
                         <form id="form-cadastro">
                            <div class="row">
                                <div class="col-md-6">
                                   <input class="input-formu" type="text" name="nome" id="nome" maxlength="100" value="" placeholder="Nome" />
                                </div>
                                <div class="col-md-6">
                                    <input class="input-formu" name="email" id="email" type="email" maxlength="255" value="" placeholder="E-mail" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                   <input class="input-formu" type="text" name="usuario" id="usuario-cadastro" maxlength="100" value="" placeholder="Usuário" />
                                </div>
                                <div class="col-md-6">
                                    <input class="input-formu" name="senha" id="senha-cadastro" type="password" maxlength="12" value="" placeholder="Senha" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn" type="button" name="salvar" value="Cadastrar" id="salvar">Cadastrar</button>
                                </div>
                            </div>
                         </form>
                    </div>
                </div>
        </div>
    </body>
    <script src="js/jquery-1.11.1.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/login.js" type="text/javascript"></script>
</html>