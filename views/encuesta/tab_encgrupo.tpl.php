<!--  
  encgrupoView 

  @package
  @author lic. castellon
  @copyright DGGE
  @version $Id$ 2014.04.14
  @access public
-->

<div class="clear">
</div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/encgrupo/<?php echo $PATH_EVENT ?>/">

    <input name="egr_id" id="egr_id" type="hidden" value="<?php echo $egr_id; ?>" />
    <input name="path_event" id="path_event" type="hidden" value="<?php echo $PATH_EVENT; ?>" />

    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo; ?></caption>

        <tr>
            <td>C&oacute;digo:</td>
            <td colspan="2">
                <input autocomplete="off"
                       class="required alphanum"
                       id="egr_codigo"
                       maxlength="8"
                       name="egr_codigo" 
                       onkeyup="this.value=this.value.toUpperCase()"
                       size="15"
                       title="C&oacute;digo"
                       type="text"                        
                       value="<?php echo $egr_codigo; ?>" />
            </td>
        </tr>



        <tr>
            <td>Nombre:</td>
            <td colspan="2">
                <input autocomplete="off" 
                       class="required alphanum"
                       id="egr_nombre"
                       maxlength="96"
                       name="egr_nombre" 
                       onkeyup="this.value=this.value.toUpperCase()"
                       size="35" 
                       title="Nombre"
                       type="text"                        
                       value="<?php echo $egr_nombre; ?>" />
            </td>
        </tr>

        
        <tr>
            <td class="botones" colspan="4">
                <input id="btnSub" type="submit" value="Guardar" class="button" />
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" />
            </td>
        </tr>

    </table>
    <br />
    <br />
</form>


<script type="text/javascript">
    jQuery(document).ready(function($) {

        $("#cancelar").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/encgrupo/";
        });
                
    });


</script>