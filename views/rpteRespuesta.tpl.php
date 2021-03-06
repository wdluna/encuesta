
<form id="formA" name="formA" method="post" class="validable" 
      action="<?php echo $PATH_DOMAIN ?>/rpteRespuesta/<?php echo $PATH_EVENT ?>/" target="_blank">

    <table width="100%" border="0">
        <caption class="titulo">
            GRÁFICOS ESTADÍSTICOS - ENCUESTAS
        </caption>

        <tr>
            <td>Encuesta:</td>
            <td>
                <select name="enc_id" id="enc_id">  
                    <option>(seleccionar)</option>>
                   <?php echo $enc_id; ?>
                </select>   
            </td>
        </tr>

        <tr>
            <td>Pregunta:</td>
            <td>
                <select name="ecp_id" id="ecp_id">  
                   <?php echo $ecp_id; ?>
                </select>   
            </td>
        </tr>

        
        <tr>
            <td >Tipo Reporte: </td>
            <td>
                <select name="tiporeporte" id="tiporeporte">
                    <option value="">(Seleccionar)</option>
                    <option value="1">1. Pie Chart</option>
                    <option value="2">2. Pie Chart, legend</option>
                    <option value="3">3. Simple line graph</option>
                    <option value="4">4. Bar chart</option>
                    <option value="5">5. Bar chart, unshaded</option>                    
                    <option value="6">6. Horizontal Bars</option>
                    <option value="7">7. Horizontal Bars, unshaded</option>
                    <option value="8">8. Horizontal thinbarline plot</option>                    
                    <option value="9">9. Linepoints plot with Data Value Labels</option>
                    <option value="10">10. Excel</option>                     
                </select>
            </td>
        </tr>
 
       
        <tr>
            <td class="botones" colspan="2">
                <input id="btnSub" type="submit" value="Reporte" class="button"/>
        </tr>
    </table>
</form>

<script type="text/javascript">

    jQuery(document).ready(function($) {
     $('#fecharegini').datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange:'c-5:c+10',
            dateFormat: 'yy-mm-dd',
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo',
                'Junio', 'Julio', 'Agosto', 'Septiembre',
                'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr',
                'May', 'Jun', 'Jul', 'Ago',
                'Sep', 'Oct', 'Nov', 'Dic']
        });
        $('#fecharegfin').datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange:'c-5:c+10',
            dateFormat: 'yy-mm-dd',
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo',
                'Junio', 'Julio', 'Agosto', 'Septiembre',
                'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr',
                'May', 'Jun', 'Jul', 'Ago',
                'Sep', 'Oct', 'Nov', 'Dic']
        });
        
        
        $("#enc_id").change(function(){
            if($("#enc_id").val()==""){
            }else{
                $.ajax({
                    url: '<?php echo $PATH_DOMAIN ?>/rpteRespuesta/loadAjaxPreguntas/',
                    type: 'POST',
                    data: 'Enc_id='+$("#enc_id").val(),
                    dataType:  		"json",
                    success: function(datos){
                        if(datos){
                            $("#ecp_id").find("option").remove();
                            $("#ecp_id").append("<option value=''>(seleccionar)</option>");
                            jQuery.each(datos, function(i,item){
                                $("#ecp_id").append("<option value='"+i+"'>"+item+"</option>");
                            });
                        }else{
                            $("#ecp_id").find("option").remove();
                            $("#ecp_id").append("<option value=''>-No hay preguntas-</option>");
                        }
                    }
                });

            }
        });        
        
    });
</script>
