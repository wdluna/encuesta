<!--
  unidadView

  @package
  @author lic. castellon
  @copyright DGGE
  @version $Id$ 2014.04.24
  @access public
-->

<div class="clear"></div><br><br><br>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/unidad/<?php echo $PATH_EVENT ?>/">
    <input name="uni_id" id="uni_id" type="hidden" value="<?php echo $uni_id; ?>" />
    <input name="path_event" id="uni_id" type="hidden" value="<?php echo $PATH_EVENT; ?>" />
    
    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo ?></caption>


        
   
        <tr>
            <td>Departamento:</td>
            <td><select name="dep_id" id="dep_id" class="required"
                        title="Departamento">
                    <option value="">(seleccionar)</option>
                    <?php echo $dep_id; ?>
                </select>
            <span class="error-requerid">*</span>
            </td>
        </tr>

        <tr>
            <td>Depende de:</td>
            <td><select name="uni_par" id="uni_par" class=""
                        title="Depende de">
                    <option value="">(seleccionar)</option>
                    <?php echo $uni_par; ?>
                </select>
            <span class="error-requerid">*</span>
            </td>
        </tr>
        

        <tr>
            <td>C&oacute;digo:</td>
            <td><input name="uni_codigo" type="text" id="uni_codigo"
                       value="<?php echo $uni_codigo; ?>" maxlength="8" size="15" 
                       onkeyup="this.value=this.value.toUpperCase()"
                       autocomplete="off" title="C&oacute;digo" />
            
            </td>                        
        </tr>        
        
        <tr>
            <td>Entidad:</td>
            <td><input name="uni_descripcion" type="text" id="uni_descripcion"
                       value="<?php echo $uni_descripcion; ?>" maxlength="8" size="100" 
                       onkeyup="this.value=this.value.toUpperCase()"
                       autocomplete="off" title="Unidad Descripci&oacute;n" />
            
            </td>                        
        </tr>

        
        <tr>
            <td colspan="4" class="botones">
                <input id="btnSub" type="submit" value="Guardar" class="button" /> 
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" />
            </td>
        </tr>

    </table>
</form>
</div>
<div class="clear"></div>
</div>
</div>

<script type="text/javascript">

    jQuery(document).ready(function($) {
        
        $("#cancelar").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/unidad/";
        });        
    }); 
    

    $("#fon_id").change(function(){
        if($("#fon_id").val()==""){
        }else{
            $.ajax({
                url: '<?php echo $PATH_DOMAIN ?>/unidad/loadAjaxUnidades/',
                type: 'POST',
                data: 'Fon_id='+$("#fon_id").val(),
                dataType:  		"json",
                success: function(datos){
                    if(datos){
                        $("#uni_par").find("option").remove();
                        $("#uni_par").append("<option value=''>(seleccionar)</option>");
                        jQuery.each(datos, function(i,item){
                            $("#uni_par").append("<option value='"+i+"'>"+item+"</option>");
                        });
                    }else{
                        $("#uni_par").find("option").remove();
                        $("#uni_par").append("<option value=''>-No hay unidades-</option>");
                    }
                }
            });

        }
    });


    $("#ubi_id").change(function(){
        if($("#ubi_id").val()==""){
        }else{
            $.ajax({
                url: '<?php echo $PATH_DOMAIN ?>/ubicacion/loadAjaxPisos/',
                type: 'POST',
                data: 'edif='+$("#ubi_id").val(),
                dataType:  		"json",
                success: function(datos){
                    if(datos){
                        $("#uni_piso").find("option").remove();
                        $("#uni_piso").append("<option value=''>(seleccionar)</option>");
                        jQuery.each(datos, function(i,item){
                            $("#uni_piso").append("<option value='"+i+"'>"+item+"</option>");
                        });
//                    }else{
//                        $("#uni_piso").find("option").remove();
//                        $("#uni_piso").append("<option value=''>-No hay pisos-</option>");
                    }
                }
            });

        }
    });
    
    

</script>
</body>
</html>

