<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="language" content="es" />
        <meta name="robots" content="all" />
        <meta name="author" content="DGGE" />
        <meta name="copyright" content="ABC" />
        <meta name="category" content="General" />
        <meta name="rating" content="General" />
        <meta name="keywords" content="abc,archivo,digital" />
        <title>Sistema de Encuestas</title>
        <link rel="shortcut icon" href="favicon.ico" />
        <link href="<?php echo $PATH_WEB; ?>/css/login.css" rel="stylesheet" 
              type="text/css" />
    </head>

    <body>
        <div class="wrap">
            <div id="content">
                <div id="main">
                    <div align="center"> <img src="<?php echo $PATH_WEB; ?>/css/logo.png"></div>                                        
                    <div class="footer">Ministerio de Planificaci&oacute;n del Desarrollo<br />Direcci&oacute;n General de Gobierno Electr&oacute;nico<br />Sistema de Encuestas v.1.0</div>
                    <br/>
                    <div class="full_w">                        
                        <form method="post" action="<?php echo $PATH_DOMAIN; ?>/<?php echo $PATH_EVENT; ?>/">
                            <dl class="zend_form">
                                <dt id="usuario-label"><label for="usuario" class="required">Nombre</label></dt>
                                <dd>
                                    <input type="text" name="user" id="user" value="" size="35" class="text">
                                </dd>
                                <dt id="pass-label"><label for="pass" class="alphanum required">Contrase&ntilde;a</label></dt>
                                <dd>
                                    <input type="password" name="pass" id="pass" value="" size="33" class="alphanum">
                                </dd>
                                <dt id="login-label">&nbsp;</dt><dd id="login-element">
                                    <input type="submit" value="Ingresar" class="ok" name="Enviar" />
                                    <input type="reset" value="Cancelar" class="cancel" name="Enviar" />
                                </dd>

                            </dl>
                        </form>
                        <div id="error"><?php echo $observaciones; ?></div>
                    </div>

                </div>
            </div>
        </div>
    </body>
</html>