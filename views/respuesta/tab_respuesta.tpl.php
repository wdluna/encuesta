<!--
  respuestaView

  @package
  @author lic. castellon
  @copyright DGGE
  @version $Id$ 2014.04.14
  @access public
-->

<link href="<?php echo $PATH_WEB ?>/js/javascript/msgbox/jquery.msgbox.css" rel="stylesheet" type="text/css" />
<script languaje="javascript" type="text/javascript" src="<?php echo $PATH_WEB ?>/js/javascript/msgbox/jquery.msgbox.js"></script>

<!--<div align="left"><a href="<?php echo $PATH_DOMAIN ?>/respuesta/"><img src="<?php echo $PATH_WEB ?>/img/back.png"></a>
</div>-->
<br /><br />
<p>
<table id="flex1" style="display: none"></table>
</p>
<div class="clear"></div>

<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/respuesta/<?php echo $PATH_EVENT ?>/" enctype="multipart/form-data">
    <input name="res_id" id="res_id" type="hidden" value="<?php echo $res_id; ?>" />


    <strong style="color: red" align="left"><?php echo $msm ?></strong>
	
    <table border="0" width="100%">
        <caption class="titulo">FORMULARIO DE ENCUESTA - <span class='error-requerid'>(*)</span> Campos requeridos</caption>

            <tr>
                <td>Entidad/Unidad:</td>
                <td>
                    <?php echo $uni_descripcion; ?>
                </td>
            </tr>
            
            <tr>
                <td>Encuesta:</td>
                <td>
                    <select name="enc_id" id="enc_id" class="required">
                        <?php echo $encuesta; ?>
                    </select> 
                </td>
            </tr>
            
            <tr>
                <td></td>
                <td>
                    <input name="res_codigo" 
                           type="hidden" 
                           id="res_codigo"
                           value="<?php echo $res_codigo; ?>" 
                           size="5" 
                           class="" 
                           maxlength="10" 
                           title="C&oacute;digo" />
                </td>
            </tr>            
			
            <tr>
                <td></td>
                <td>
                        <input name="res_titulo" 
                                   type="hidden" id="res_titulo"
                                   value="<?php echo $res_titulo; ?>" 
                                   size="120" 
                                   maxlength="1024" 
                                   class="required alphanum" 
                                   title="En este campo se debe registrar el t&iacute;tulo del encuesta." />                       
                </td>
            </tr>
            
            <tr>
                <td>                                        
                </td>
                <td align="right">
                    <input id="btnSub3" type="button" value="Guardar" class="button" />                    
                </td>                
                
            </tr>            
            
    </table>

    
    <?php echo $enccampo; ?>
		



<table width="100%" border="0"> 
    <tr><td colspan="2" height="15"></td></tr>
    <tr id="tr-botones">
        <td colspan="10" class="botones">
            <input type="hidden" name="accion" id="accion" value="guardar" />
            <input id="btnSub3" type="button" value="Guardar" class="button" /> 
            <!--<input id="btnSubB" type="button" value="Guardar y Nuevo" class="button2" />-->             
            <input id="btnSub" type="button" value="Guardar y salir" class="button2" />             
            <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" />
        </td>
    </tr>
</table>


</form>


<script type="text/javascript">



    jQuery(document).ready(function($) {

        $("#cancelar").click(function() {
            location.href = "<?php echo $PATH_DOMAIN ?>/respuesta/";
        });

        $("#btnSub").click(function() {
            $("#accion").val('guardar');
            $('form#formA').submit();
        });

        $("#btnSubB").click(function() {
            $("#accion").val('guardarnuevo');
            $('form#formA').submit();
        })
        $("#btnSub3").click(function() {
            $("#accion").val('guardarsinsalir');
            $('form#formA').submit();
        })
    });


    $(function() {

        $("#enc_id").change(function() {
            if ($("#enc_id").val() == "") {
            } else {
                $.ajax({
                    url: '<?php echo $PATH_DOMAIN ?>/encuesta/loadCodigoAjax/',
                    type: 'POST',
                    data: 'Ser_id=' + $("#enc_id").val(),
                    dataType: "json",
                    success: function(datos) {
                        if (datos) {
                            $("#enc_codigo").val(datos.enc_codigo);
                        }
                    }
                });
            }
        });

    });


    function verificar(){
        var suma = 0;
        var los_cboxes = document.getElementsByName('cap[]'); 
        for (var i = 0, j = los_cboxes.length; i < j; i++) {    
            if(los_cboxes[i].checked == true){
                suma++;
            }
        }

        if(suma == 0){
            alert('debe seleccionar una casilla');
            return false;
        }else{
            alert(suma);
        }
    }
</script>