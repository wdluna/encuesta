    <div id="dialogManual" title="Como migrar de Excel al SAD" align="left">
       <center> <img src="<?php echo PATH_DOMAIN."/web/img/fondomigrarexcel.png" ?>" width="300"></center><br>
        <B>Para migrar de excel al SAD debe verificar algunos puntos:</B>
   <ul>
       <li>Verificar que el documento sea office 2003 - 2007 (.xls).</li>
       <li>Verificar que fuera del marco de la tabla no tenga algun contenido caso contrario eliminar las columnas.</li>
       <li>Verificar que no tengan acentos los titulos como FONDO, SUBFONDO, SERIE, SECCION, SUBSECCION, encuesta.</li>
       <li>Verificar que la SERIE, SECCION O SUBSECCION este bien escrito al igual que el SAD</li>
       <li>Verificar que sea el mismo formato que migre</li>
       <li>Verificar que la fecha sea de formato texto</li>
       <li>Verificar que en los títulos del encabezado FONDO, SUBFONDO, SERIE, SECCION, SUBSECCION, encuesta no contengan spacios de salto</li>
   </ul>
    </div>
<form id="formA" name="formA" method="post" 
      class="validable" action="<?php echo $PATH_DOMAIN ?>/migrarExcel/<?php echo $PATH_EVENT ?>/"  enctype="multipart/form-data">

    <table width="100%" border="0">
        <caption class="titulo">
            MIGRACION DE EXCEL 
        </caption>
           <tr>
            <td id="labelcito">Formato: </td>
            <td>
                <select name="tiporeporte" id="tiporeporte">
                     <option value="1">GNT-SCT</option>
                     <option value="2">GNT-SCV</option>
                     <option value="3">GNT-SSA</option>
                     <option value="4">CONTRATACIONES</option>
                     <option value="5">CORRESPONDENCIA</option>
                     <option value="6">CONTABILIDAD</option>
                </select>
                <a href="javascript:manual()" style="color:white">LEAME</a>
            </td>
        </tr>
         <tr>
            <td id="labelcito">Archivo: </td>
            <td>
            <input type="file" name="archivo" id="archivo">
            </td>
        </tr>
        <tr id="tr-botones">
            <td></td> <td></td>
        </tr>
        <tr id="tr-botones">
            <td class="botones" colspan="2">
            <input id="btnSub" type="submit" value="Migrar" class="button"/>
        </tr>
        <tr id="tr-botones"><th colspan="2"><?php echo $error ?></th></tr>
    </table>
</form>

<script type="text/javascript">
function manual(){
$('#dialogManual').dialog('open');
}
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
    });
            $("#dialogManual").dialog({
            stackfix: true,
            autoOpen: false,
            height: 390,
            width: 500,
            modal: true,
            buttons: {
                Aceptar: function() {
                    var cantEjemplares = $("#nro_ini3").val();
                            $("#cantidad_ejem").val(cantEjemplares);
                            $('#formImprimir').submit();
                            $(this).dialog('close');
                }
            },
                close: function() {
            }
        });
</script>
