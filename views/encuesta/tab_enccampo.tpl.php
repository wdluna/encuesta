<!--
  enccampogView

  @package
  @author lic. castellon
  @copyright DGGE
  @version $Id$ 2014.04.24
  @access public
-->

<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/enccampo/<?php echo $PATH_EVENT ?>/">

    <input name="ecp_id" id="ecp_id" type="hidden" value="<?php echo $ecp_id; ?>" />
    <input name="enc_id" id="enc_id" type="hidden" value="<?php echo $enc_id; ?>" />
    
    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo ?></caption>
        <tr>
            <td>Serie:</td>
            <td colspan=2><?php echo $enc_categoria; ?></td>
        </tr>

        <tr>
            <td width="175">Grupo:</td>
            <td colspan="2">
                <select name="egr_id" id="egr_id" class="required"
                        title="Grupo del dato">
                        <option value="">(seleccionar)</option>
                        <?php echo $egr_id; ?>
                </select>
            </td>
        </tr>
        
        
        <tr>
            <td width="75">Orden:</td>
            <td colspan="2"><input name="ecp_orden" type="text" id="ecp_orden"
                                   value="<?php echo $ecp_orden; ?>" size="3" autocomplete="off"
                                   class="onlynumeric" maxlength="10" title="Orden" /></td>
        </tr>

        <tr>
            <td width="75">Nombre Campo:</td>
            <td colspan="2"><input name="ecp_nombre" type="text" id="ecp_nombre"
                                   value="<?php echo $ecp_nombre; ?>" size="80" autocomplete="off"
                                 
                                   class="required alphanum" maxlength="64" title="Orden" /></td>
        </tr>
        
        <tr>
            <td width="175">Etiqueta:</td>
            <td colspan="2"><input name="ecp_eti" type="text" id="ecp_eti"
                                   value="<?php echo $ecp_eti; ?>" size="80" autocomplete="off"
                                   class="required alphanum" maxlength="1024" title="Orden" /></td>
        </tr>

        
        <tr>
            <td width="175">Tipo dato:</td>
            <td colspan="2">
                <select name="ecp_tipdat" id="ecp_tipdat" class="required"
                        title="Tipo de dato del campo">
                        <option value="">(seleccionar)</option>
                        <?php echo $ecp_tipdat; ?>
                </select>
            </td>
        </tr>
        
        <tr>
            <td colspan="3" class="botones">
                <input id="btnSub" type="submit" value="Guardar" class="button" /> 
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" /></td>
        </tr>
    </table>
</form>

<script type="text/javascript">

    jQuery(document).ready(function($) {
        $("#cancelar").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/enccampo/index/<?php echo VAR3; ?>/";
        });
    });

</script>
