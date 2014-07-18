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
        <link href="<?php echo $PATH_WEB ?>/css/style.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $PATH_WEB ?>/css/flexigrid/flexigrid.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $PATH_WEB ?>/css/base/ui.all.css" rel="stylesheet" type="text/css" />
        
        <script type="text/javascript" src="<?php echo $PATH_WEB ?>/js/jquery-1.3.2.js"></script>	
        <script type="text/javascript" src="<?php echo $PATH_WEB ?>/ui/jquery.ui.core.js"></script>	
        <script type="text/javascript" src="<?php echo $PATH_WEB ?>/ui/jquery.ui.widget.js"></script>
        <script type="text/javascript" src="<?php echo $PATH_WEB ?>/ui/jquery.ui.mouse.js"></script>
        <script type="text/javascript" src="<?php echo $PATH_WEB ?>/ui/jquery.ui.position.js"></script>
        <script type="text/javascript" src="<?php echo $PATH_WEB ?>/ui/jquery.ui.resizable.js"></script>
        <script type="text/javascript" src="<?php echo $PATH_WEB ?>/ui/jquery.ui.stackfix.js"></script>
        <script type="text/javascript" src="<?php echo $PATH_WEB ?>/ui/jquery.ui.dialog.js"></script>
        <script type="text/javascript" src="<?php echo $PATH_WEB ?>/ui/jquery.ui.datepicker.js"></script>
        <script type="text/javascript" src="<?php echo $PATH_WEB ?>/ui/jquery.effects.core.js"></script>	
        <script type="text/javascript" src="<?php echo $PATH_WEB ?>/js/validable.js"></script>
        <script type="text/javascript" src="<?php echo $PATH_WEB ?>/js/flexigridBuscador.js"></script>
        <script type="text/javascript" src="<?php echo $PATH_WEB ?>/js/personalizados.js"></script>    
<link href="<?php echo $PATH_WEB ?>/js/javascript/msgbox/jquery.msgbox.css" rel="stylesheet" type="text/css" />
<script languaje="javascript" type="text/javascript" src="<?php echo $PATH_WEB ?>/js/javascript/msgbox/jquery.msgbox.js"></script>


        <script type="text/javascript">
            $(function() {
                /* para el acordeon */
		
                $(".pagClik").click(function(){
                    if($("."+$(this).attr('id')+"x").is(':visible')){
                        $("."+$(this).attr('id')+"x").hide();
                    }else{
                        $("."+$(this).attr('id')+"x").slideDown();
                    }
                });
                $("#menuarch a").click(function(){
                    var d = $(this).attr('di');
                    if($("."+d+"a").is(':visible')){
                        $("."+d+"a").hide();
                    }else{
                        $("."+d+"a").slideDown();
                    }
                });        
                $(".suboptAct").click(function(){
                    if($("#"+$(this).attr('id')+"x").is(':visible')){
                        $("#"+$(this).attr('id')+"x").hide();
                    }else{
                        $("#"+$(this).attr('id')+"x").slideDown();
                    }
                });
                $(".suboptAct").dblclick(function(){
                    location.href = $(this).attr('href');
                });
                // end	
                $("#menu4 dt a").click(function(){
                    var id = $(this).attr('id');
                    $("#menu4 dl").each(function(x,el){
                        if($("dt a",this).attr('id')==id){
                            if($(this).attr('class')=='Act'){
                                $(this).removeClass('Act');
                            }else{
                                $(this).attr('class','Act');
                            }
                        }						
                    });
                });
            })
	
        </script>
    </head>

    <body>
        <form id="rpt" name="rpt" target="_blank" method="post" action="">
            <input name="page" id="page" type="hidden" value="" /> 
            <input name="qtype" id="qtype" type="hidden" value="" /> 
            <input name="query" id="query" type="hidden" value="" />
            <input name="rp" id="rp" type="hidden" value="" /> 
            <input name="sortname" id="sortname" type="hidden" value="" /> 
            <input name="sortorder" id="sortorder" type="hidden" value="" />
        </form>
        <div id="wrapper">
            <div id="header">
                <a href="<?php echo $PATH_DOMAIN; ?>" class="logo">SISTEMA DE ENCUESTAS</a>
                <a href="<?php echo $PATH_DOMAIN; ?>" class="logot bold2">SISTEMA DE ENCUESTAS</a> <span
                    class="user">Bienvenid@ <?php echo $_SESSION['USU_NOMBRES']; ?> <?php echo $_SESSION['USU_APELLIDOS']; ?>|                    
                    <?php echo $_SESSION['ROL']; ?>| 
                    <a href="<?php echo $PATH_DOMAIN; ?>/perfil/view/" title="Configuracion de perfil">
                        <span class="color2 boldU">Configuraci&oacute;n</span></a> | 
                    <a href="<?php echo $PATH_DOMAIN; ?>/login/logout/" title="Salir">
                        <span class="color2 boldU">Salir</span></a>

                    <div align="right"><?php echo $_SESSION['DEP_NOMBRE'] . '/'. $_SESSION['UNI_DESCRIPCION']; ?></div>
                    <div align="right">&Uacute;ltima sesi&oacute;n: <?php echo utf8_encode(strftime("%A %d de %B del %Y")); ?></div>
                </span>
            </div>
            <div id="container">
                <div id="containerTop">
                    
                            <div class="boxMenutop">
                                <div id="dlmenu">
                                    <ul id="menu4">
                                        <?php echo $men_titulo; ?>
                                    </ul>
                                </div>
                                <div class="clear"></div>
                            </div>
                        
                        <div class="clear"></div>
                        <br />                        
                        <div class="clear"></div>
                        <div class="boxPub"></div>
                        <br />
                        <div class="clear"></div>
                        <div class="clear"></div>
                        <div class="clear"></div>
                    
                    <div id="contentIn0">