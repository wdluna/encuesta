<?php

/**
 * enccampo.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright DGGE
 * @version $Id$ 2014.04.24
 * @access public
 */
class enccampo extends tab_enccampo {

    function __construct() {
        //parent::__construct();
        $this->enccampo = new tab_enccampo();
    }

    function obtenerSelect($default = null) {
        $sql = "SELECT *
                FROM tab_enccampo
                WHERE tab_enccampo.ecp_estado = 1
                ORDER BY ecp_id ASC ";
        $row = $this->enccampo->dbselectBySQL($sql);
        $option = "";
        foreach ($row as $val) {
            if ($default == $val->ecp_id)
                $option .="<option value='" . $val->ecp_id . "' selected>" . $val->ecp_tipdat . "</option>";
            else
                $option .="<option value='" . $val->ecp_id . "'>" . $val->ecp_tipdat . "</option>";
        }
        return $option;
    }

    function obtenerSelectTipoDato($default = null) {
        $option = "";
        if ($default == 'Etiqueta') {
            $option .="<option value='Etiqueta' selected>Etiqueta</option>";
            $option .="<option value='Texto'>Texto</option>";
            $option .="<option value='TextArea'>Area de Texto</option>";
            $option .="<option value='Numero'>N&uacute;mero</option>";
            $option .="<option value='Fecha'>Fecha</option>";
            $option .="<option value='Decimal'>Decimal</option>";
            $option .="<option value='Lista'>Lista</option>";
            $option .="<option value='CheckBox'>Casilla de verificaci&oacute;n</option>";
            $option .="<option value='RadioButton'>Boton de opci&oacute;n</option>";
        } else if ($default == 'Texto') {
            $option .="<option value='Etiqueta'>Etiqueta</option>";
            $option .="<option value='Texto' selected>Texto</option>";
            $option .="<option value='TextArea'>Area de Texto</option>";
            $option .="<option value='Numero'>N&uacute;mero</option>";
            $option .="<option value='Fecha'>Fecha</option>";
            $option .="<option value='Decimal'>Decimal</option>";
            $option .="<option value='Lista'>Lista</option>";
            $option .="<option value='CheckBox'>Casilla de verificaci&oacute;n</option>";
            $option .="<option value='RadioButton'>Boton de opci&oacute;n</option>";
        } else if ($default == 'TextArea') {
            $option .="<option value='Etiqueta'>Etiqueta</option>";
            $option .="<option value='Texto'>Texto</option>";
            $option .="<option value='TextArea' selected>Area de Texto</option>";
            $option .="<option value='Numero'>N&uacute;mero</option>";
            $option .="<option value='Fecha'>Fecha</option>";
            $option .="<option value='Decimal'>Decimal</option>";
            $option .="<option value='Lista'>Lista</option>";
            $option .="<option value='CheckBox'>Casilla de verificaci&oacute;n</option>";
            $option .="<option value='RadioButton'>Boton de opci&oacute;n</option>";            
        } else if ($default == 'Numero') {
            $option .="<option value='Etiqueta'>Etiqueta</option>";
            $option .="<option value='Texto'>Texto</option>";
            $option .="<option value='TextArea'>Area de Texto</option>";
            $option .="<option value='Numero' selected>N&uacute;mero</option>";
            $option .="<option value='Fecha'>Fecha</option>";
            $option .="<option value='Decimal'>Decimal</option>";
            $option .="<option value='Lista'>Lista</option>";
            $option .="<option value='CheckBox'>Casilla de verificaci&oacute;n</option>";
            $option .="<option value='RadioButton'>Boton de opci&oacute;n</option>";
        } else if ($default == 'Fecha') {
            $option .="<option value='Etiqueta'>Etiqueta</option>";
            $option .="<option value='Texto'>Texto</option>";
            $option .="<option value='TextArea'>Area de Texto</option>";
            $option .="<option value='Numero'>N&uacute;mero</option>";
            $option .="<option value='Fecha' selected>Fecha</option>";
            $option .="<option value='Decimal'>Decimal</option>";
            $option .="<option value='Lista'>Lista</option>";
            $option .="<option value='CheckBox'>Casilla de verificaci&oacute;n</option>";
            $option .="<option value='RadioButton'>Boton de opci&oacute;n</option>";
        } else if ($default == 'Decimal') {
            $option .="<option value='Etiqueta'>Etiqueta</option>";
            $option .="<option value='Texto'>Texto</option>";
            $option .="<option value='TextArea'>Area de Texto</option>";
            $option .="<option value='Numero'>N&uacute;mero</option>";
            $option .="<option value='Fecha'>Fecha</option>";
            $option .="<option value='Decimal' selected>Decimal</option>";
            $option .="<option value='Lista'>Lista</option>";
            $option .="<option value='CheckBox'>Casilla de verificaci&oacute;n</option>";
            $option .="<option value='RadioButton'>Boton de opci&oacute;n</option>";
        } else if ($default == 'Lista') {
            $option .="<option value='Etiqueta'>Etiqueta</option>";
            $option .="<option value='Texto'>Texto</option>";
            $option .="<option value='TextArea'>Area de Texto</option>";
            $option .="<option value='Numero'>N&uacute;mero</option>";
            $option .="<option value='Fecha'>Fecha</option>";
            $option .="<option value='Decimal'>Decimal</option>";
            $option .="<option value='Lista' selected>Lista</option>";
            $option .="<option value='CheckBox'>Casilla de verificaci&oacute;n</option>";
            $option .="<option value='RadioButton'>Boton de opci&oacute;n</option>";
        } else if ($default == 'CheckBox') {
            $option .="<option value='Etiqueta'>Etiqueta</option>";
            $option .="<option value='Texto'>Texto</option>";
            $option .="<option value='TextArea'>Area de Texto</option>";
            $option .="<option value='Numero'>N&uacute;mero</option>";
            $option .="<option value='Fecha'>Fecha</option>";
            $option .="<option value='Decimal'>Decimal</option>";
            $option .="<option value='Lista'>Lista</option>";
            $option .="<option value='CheckBox' selected>Casilla de verificaci&oacute;n</option>";
            $option .="<option value='RadioButton'>Boton de opci&oacute;n</option>";
        } else if ($default == 'RadioButton') {
            $option .="<option value='Etiqueta'>Etiqueta</option>";
            $option .="<option value='Texto'>Texto</option>";
            $option .="<option value='TextArea'>Area de Texto</option>";
            $option .="<option value='Numero'>N&uacute;mero</option>";
            $option .="<option value='Fecha'>Fecha</option>";
            $option .="<option value='Decimal'>Decimal</option>";
            $option .="<option value='Lista'>Lista</option>";
            $option .="<option value='CheckBox'>Casilla de verificaci&oacute;n</option>";
            $option .="<option value='RadioButton' selected>Boton de opci&oacute;n</option>";
        } else {
            $option .="<option value='Etiqueta'>Etiqueta</option>";
            $option .="<option value='Texto'>Texto</option>";
            $option .="<option value='TextArea'>Area de Texto</option>";
            $option .="<option value='Numero'>N&uacute;mero</option>";
            $option .="<option value='Fecha'>Fecha</option>";
            $option .="<option value='Decimal'>Decimal</option>";
            $option .="<option value='Lista'>Lista</option>";
            $option .="<option value='CheckBox'>Casilla de verificaci&oacute;n</option>";
            $option .="<option value='RadioButton'>Boton de opci&oacute;n</option>";			
        }

        return $option;
    }

    function obtenerSelectCampos($enc_id = null) {
        $this->enccampolista = new tab_enccampolista();
        $sql = "SELECT
                tab_enccampo.ecp_id,
                tab_enccampo.enc_id,
                tab_enccampo.egr_id,
                tab_encgrupo.egr_nombre,
                tab_encgrupo.egr_codigo,                
                tab_enccampo.ecp_orden,
                tab_enccampo.ecp_eti,
                tab_enccampo.ecp_tipdat,
                tab_enccampo.ecp_estado,
                tab_enccampo.ecp_nombre
                FROM
                tab_enccampo
                INNER JOIN tab_encgrupo ON tab_enccampo.egr_id = tab_encgrupo.egr_id
                WHERE tab_enccampo.ecp_estado = 1
                AND tab_enccampo.enc_id = $enc_id
                ORDER BY tab_enccampo.egr_id,
                tab_enccampo.ecp_orden ASC ";
        $row = $this->enccampo->dbselectBySQL($sql);
        $option = "";
		
		
	$egr_id = 0;
        $flag = false;
        foreach ($row as $val) {
            
            if($egr_id != $val->egr_id){
                if ($flag){
                    if($egr_id != $val->egr_id){
                        $option .="</table>";
                        $option .="</div>";
                        
                        $divn = "div" . $val->egr_id;
                        $option .="<table border='0' width='100%'>";
                            $option .="<tr>";
                                $option .="<td width='5%'>";
                                        $option .="<label id='nro-slider'>" . $val->egr_id . "</label>";
                                $option .="</td>";
                                $option .="<td width='95%'>";
//                                        $option .="<input type='button' onclick='$('#div2').toggle(500);' id='title-slider2'  align='left' value='" . $val->egr_nombre . "' >";
                                        $option .="<input type='button' id='title-slider2'  align='left' value='" . $val->egr_nombre . "' >";
                                $option .="</td>";
                            $option .="</tr>";
                        $option .="</table>";                    
                        $option .="<div id='" . $divn . "' style='background-color:#eeeeee;border:0px solid;'>";
                                $option .="<table border='0' width='100%'>";
                        $flag = true;                        
                                                
                    }
                }else{
                    $divn = "div" . $val->egr_id;
                    $option .="<table border='0' width='100%'>";
                        $option .="<tr>";
                            $option .="<td width='5%'>";
                                    $option .="<label id='nro-slider'>" . $val->egr_id . "</label>";
                            $option .="</td>";
                            $option .="<td width='95%'>";
//                                    $option .="<input type='button' onclick='$('#div1').toggle(500);'  id='title-slider2'  align='left' value='" . $val->egr_nombre . "' >";
                                    $option .="<input type='button' id='title-slider2'  align='left' value='" . $val->egr_nombre . "' >";
                            $option .="</td>";
                        $option .="</tr>";
                    $option .="</table>";                    
                    $option .="<div id='" . $divn . "' style='background-color:#eeeeee;border:0px solid;'>";
                            $option .="<table border='0' width='100%'>";
                    $flag = true;
                }
            }
		
            // Data
            if ($val->ecp_tipdat == 'Etiqueta') {
                $option .="<tr><td colspan='4'>" . $val->egr_codigo . DELIMITER . $val->ecp_orden . " " . $val->ecp_eti . "</td>";
                $option .="</tr>";
                
            } else if ($val->ecp_tipdat == 'Lista') {
                $option .="<tr><td>" . $val->egr_codigo . DELIMITER . $val->ecp_orden . " " . $val->ecp_eti . "</td>";
                $option .= "<td colspan='3'>				
				<select name='" . $val->ecp_id . "' id='" . $val->ecp_id . "' title='" . $val->ecp_nombre . "' class=''>
				<option value='' selected='selected'>(seleccionar)</option>";

                // Lista
                $sql = "SELECT
                        tab_enccampo.ecp_id,
                        tab_enccampolista.ecl_id,
                        tab_enccampolista.ecl_orden,
                        tab_enccampolista.ecl_valor,
                        tab_enccampolista.ecl_estado
                        FROM
                        tab_enccampo
                        INNER JOIN tab_enccampolista ON tab_enccampo.ecp_id = tab_enccampolista.ecp_id
                        WHERE tab_enccampolista.ecl_estado = 1 
                        AND tab_enccampo.ecp_id = $val->ecp_id 
                        ORDER BY tab_enccampolista.ecl_orden ";
                $row2 = $this->enccampolista->dbselectBySQL($sql);
                foreach ($row2 as $val2) {
                    $option .="<option value='" . $val2->ecl_id . "'>" . $val2->ecl_valor . "</option>";
                }
//                $option .= "</select><span class='error-requerid'>*</span>";
                $option .="</td>";
                $option .="</tr>";

            // CheckBox
            }else if ($val->ecp_tipdat == 'CheckBox') {
                $option .="<tr><td>" . $val->egr_codigo . DELIMITER . $val->ecp_orden . " " . $val->ecp_eti . "</td>";
                $option .= "<td colspan='3'>";
				
                // Lista
                $sql = "SELECT
                        tab_enccampo.ecp_id,
                        tab_enccampolista.ecl_id,
                        tab_enccampolista.ecl_orden,
                        tab_enccampolista.ecl_valor,
                        tab_enccampolista.ecl_estado
                        FROM
                        tab_enccampo
                        INNER JOIN tab_enccampolista ON tab_enccampo.ecp_id = tab_enccampolista.ecp_id
                        WHERE tab_enccampolista.ecl_estado = 1 
                        AND tab_enccampo.ecp_id = $val->ecp_id 
                        ORDER BY tab_enccampolista.ecl_orden ";
                $row2 = $this->enccampolista->dbselectBySQL($sql);
                foreach ($row2 as $val2) {
                    //$option .="<option value='" . $val2->ecl_id . "'>" . $val2->ecl_valor . "</option>";
			$option .="<input class='required' type='checkbox' name='rcv_valorC[]' id='" . $val2->ecl_id . "' value='" . $val2->ecl_id . "'>" . $val2->ecl_valor . "";					
                        $option .="<br />";
                }
//                $option .= "<span class='error-requerid'>*</span>";
                
                // New Other
                $option .="<input class='required' type='checkbox' name='rcv_valorC[]' id='0' value='0'>Otro";					
                $option .="<br />";
                
                
                $option .="</td>";
                $option .="</tr>";
				
            // RadioButton
            }else if ($val->ecp_tipdat == 'RadioButton') {
                $option .="<tr><td>" . $val->egr_codigo . DELIMITER . $val->ecp_orden . " " . $val->ecp_eti . "</td>";
                $option .= "<td colspan='3'>";
				
                // Lista
                $sql = "SELECT
                        tab_enccampo.ecp_id,
                        tab_enccampolista.ecl_id,
                        tab_enccampolista.ecl_orden,
                        tab_enccampolista.ecl_valor,
                        tab_enccampolista.ecl_estado
                        FROM
                        tab_enccampo
                        INNER JOIN tab_enccampolista ON tab_enccampo.ecp_id = tab_enccampolista.ecp_id
                        WHERE tab_enccampolista.ecl_estado = 1 
                        AND tab_enccampo.ecp_id = $val->ecp_id 
                        ORDER BY tab_enccampolista.ecl_orden ";
                $row2 = $this->enccampolista->dbselectBySQL($sql);
                foreach ($row2 as $val2) {
                    //$option .="<option value='" . $val2->ecl_id . "'>" . $val2->ecl_valor . "</option>";
                    $option .="<input class='required' type='radio' name='rcv_valor' id='" . $val2->ecl_id . "' value='" . $val2->ecl_id . "'> " . $val2->ecl_valor . "";
                    $option .="<br />";
                }
//                $option .= "<span class='error-requerid'>*</span>";
                $option .="</td>";
                $option .="</tr>";
				
            } else {
                // Campo
                $option .="<tr><td>" . $val->egr_codigo . DELIMITER . $val->ecp_orden . " " . $val->ecp_eti . "</td>";
                if ($val->ecp_tipdat == 'Texto') {
                    $option .="<td colspan='3'>
                              <input name='" . $val->ecp_id . "' id='" . $val->ecp_id . "' value='' type='text'
                                     size='40' autocomplete='off' maxlength='1024' class=''
                                     title='" . $val->ecp_nombre . "' />
                              </td>";
                } else if ($val->ecp_tipdat == 'TextArea') {
                    $option .="<td colspan='3'>                                         
                            <textarea name='" . $val->ecp_id . "'
                                      id='" . $val->ecp_id . "'
                                      rows='4' cols='120'                          
                                      autocomplete='off'
                                      class='alphanum'
                                      maxlength='10024'
                                      title='" . $val->ecp_nombre . "' >
                            </textarea>
                            </td>";                    
                } else if ($val->ecp_tipdat == 'Numero') {
                    $option .="<td colspan='3'>
                              <input name='" . $val->ecp_id . "' id='" . $val->ecp_id . "' value='' type='text'
                                     size='40' autocomplete='off' maxlength='20' class='onlynumeric'
                                     title='" . $val->ecp_nombre . "' />
                              </td>";
                } else if ($val->ecp_tipdat == 'Decimal') {
                    $option .="<td colspan='3'>
                              <input name='" . $val->ecp_id . "' id='" . $val->ecp_id . "' value='' type='text'
                                     size='40' autocomplete='off' maxlength='20' class='numeric'
                                     title='" . $val->ecp_nombre . "' />
                              </td>";
                } else if ($val->ecp_tipdat == 'Fecha') {
                    $option .="<td colspan='3'>
                              <input name='" . $val->ecp_id . "' id='" . $val->ecp_nombre . "' value='' type='text'
                                     size='40' autocomplete='off' maxlength='20' class=''
                                     title='" . $val->ecp_nombre . "' />
                              </td>";

                    $option .="<script type='text/javascript'>";
                    $option .= "jQuery(document).ready(function($) { ";
                    $option .= "$('#" . $val->ecp_nombre . "').datepicker({
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
                            });";
                    $option .= "});";
                    $option .="</script>";
                }

                $option .="</tr>";
            }
			
			
            $egr_id = $val->egr_id;
			
			
        }
				
		
        return $option;
    }

    
    
    
    
    function obtenerSelectCamposEdit($enc_id = null, $res_id = null) {
        $this->enccampolista = new tab_enccampolista();
        $sql = "SELECT
                tab_enccampo.ecp_id,
                tab_enccampo.enc_id,
                tab_enccampo.egr_id,
                tab_encgrupo.egr_codigo,
                tab_encgrupo.egr_nombre,
                tab_enccampo.ecp_orden,
                tab_enccampo.ecp_eti,
                tab_enccampo.ecp_tipdat,
                tab_enccampo.ecp_estado,
                tab_enccampo.ecp_nombre,
                tab_enccampo.ecp_obl
                FROM
                tab_enccampo
                INNER JOIN tab_encgrupo ON tab_enccampo.egr_id = tab_encgrupo.egr_id
                WHERE tab_enccampo.ecp_estado = 1
                AND tab_enccampo.enc_id = $enc_id
                ORDER BY tab_enccampo.egr_id,
                tab_enccampo.ecp_orden ASC ";
        $row = $this->enccampo->dbselectBySQL($sql);
        $option = "";

        // Trace
        $valor = "";
	$egr_id = 0;
        $flag = false;
        foreach ($row as $val) {

            if($egr_id != $val->egr_id){
                if ($flag){
                    if($egr_id != $val->egr_id){
                        $option .="</table>";
                        $option .="</div>";
                        
                        $divn = "div" . $val->egr_id;
                        $option .="<table border='1' width='100%'>";
                            $option .="<tr>";
                                $option .="<td width='3%' style='background-color:#808080;'  >";
                                        $option .="<label id='nro-slider'>" . $val->egr_id . "</label>";
                                $option .="</td>";
                                $option .="<td width='97%' style='background-color:#FBED00; background: -moz-linear-gradient(top, #FBED00 10%, #FEC20E 100%); background: -webkit-linear-gradient(top, #FBED00 10%,#FEC20E 100%); ' >";
//                                        $option .="<input type='button' onclick='$('#div2').toggle(500);' id='title-slider2'  align='left' value='" . $val->egr_nombre . "' >";
                                        $option .="<input type='button' id='title-slider2'  align='left' value='" . $val->egr_nombre . "' > ";
                                $option .="</td>";
                            $option .="</tr>";
                        $option .="</table>";                    
                        $option .="<div id='" . $divn . "' style='background-color:#eeeeee;border:0px solid;'>";
                                $option .="<table border='1' width='100%'>";
                        $flag = true;                        
                                                
                    }
                }else{
                    $divn = "div" . $val->egr_id;
                    $option .="<table border='1' width='100%'>";
                        $option .="<tr>";
                            $option .="<td width='3%' style='background-color:#808080;'>";
                                    $option .="<label id='nro-slider'>" . $val->egr_id . "</label>";
                            $option .="</td>";
                            $option .="<td width='97%' style='background-color:#FBED00; background: -moz-linear-gradient(top, #FBED00 10%, #FEC20E 100%); background: -webkit-linear-gradient(top, #FBED00 10%,#FEC20E 100%); ' >";
//                                    $option .="<input type='button' onclick='$('#div1').toggle(500);'  id='title-slider2'  align='left' value='" . $val->egr_nombre . "' >";
                                    $option .="<input type='button' id='title-slider2'  align='left' value='" . $val->egr_nombre . "' >";
                            $option .="</td>";
                        $option .="</tr>";
                    $option .="</table>";                    
                    $option .="<div id='" . $divn . "' style='background-color:#eeeeee;border:0px solid;'>";
                            $option .="<table border='1' width='100%'>";
                    $flag = true;
                }
            }


            if ($val->ecp_tipdat == 'Etiqueta') {
                $option .="<tr><td colspan='4'>" . $val->egr_codigo . DELIMITER . $val->ecp_orden . " " . $val->ecp_eti . "</td>";
                $option .="</tr>";
            
            } else if ($val->ecp_tipdat == 'Lista') {
                if ($val->ecp_obl==1){
                    $option .="<tr><td>" . $val->egr_codigo . DELIMITER . $val->ecp_orden . " " . $val->ecp_eti . "<span class='error-requerid'>(*)</span></td>";
                }else{
                    $option .="<tr><td>" . $val->egr_codigo . DELIMITER . $val->ecp_orden . " " . $val->ecp_eti . "</td>";
                }
                $option .= "<td colspan='3'>
                    <select name='" . $val->ecp_id . "' id='" . $val->ecp_id . "' title='" . $val->ecp_nombre . "' class=''>
                    <option value=''>(seleccionar)</option>";

                // Lista
                $sql = "SELECT
                        tab_enccampo.ecp_id,
                        tab_enccampolista.ecl_id,
                        tab_enccampolista.ecl_orden,
                        tab_enccampolista.ecl_valor,
                        tab_enccampolista.ecl_estado
                        FROM
                        tab_enccampo
                        INNER JOIN tab_enccampolista ON tab_enccampo.ecp_id = tab_enccampolista.ecp_id
                        WHERE tab_enccampolista.ecl_estado = 1 
                        AND tab_enccampo.ecp_id = $val->ecp_id 
                        ORDER BY tab_enccampolista.ecl_orden ";
                $row2 = $this->enccampolista->dbselectBySQL($sql);
                foreach ($row2 as $val2) {
                    // Find value
                    // Find Value
                    $sql = "SELECT
                            tab_rescampovalor.rcv_id,
                            tab_rescampovalor.res_id,
                            tab_rescampovalor.ecp_id,
                            tab_rescampovalor.ecl_id,
                            tab_rescampovalor.rcv_valor,
                            tab_rescampovalor.rcv_estado
                            FROM
                            tab_enccampo
                            INNER JOIN tab_rescampovalor ON tab_enccampo.ecp_id = tab_rescampovalor.ecp_id
                            WHERE tab_rescampovalor.res_id = '$res_id'
                            AND tab_enccampo.ecp_id = $val->ecp_id
                            ORDER BY tab_enccampo.egr_id,
                            tab_enccampo.ecp_orden ";
                    $row5 = $this->enccampo->dbselectBySQL($sql);
                    // $valor = $row5[0]->ecl_id;
                    foreach ($row5 as $list) {
                        $valor = $list->ecl_id;
                    }

                    if ($valor == $val2->ecl_id){
                        $option .="<option value='" . $val2->ecl_id . "' selected>" . $val2->ecl_valor . "</option>";                       
                    } else{
                        $option .="<option value='" . $val2->ecl_id . "'>" . $val2->ecl_valor . "</option>";
                    }
                }
//                $option .= "</select><span class='error-requerid'>*</span>";
                $option .="</td>";
                $option .="</tr>";
				
            // CheckBox
            } else if ($val->ecp_tipdat == 'CheckBox') {
                if ($val->ecp_obl==1){
                    $option .="<tr><td>" . $val->egr_codigo . DELIMITER . $val->ecp_orden . " " . $val->ecp_eti . "<span class='error-requerid'>(*)</span></td>";
                }else{
                    $option .="<tr><td>" . $val->egr_codigo . DELIMITER . $val->ecp_orden . " " . $val->ecp_eti . "</td>";
                }
                $option .= "<td colspan='3'>";

                // CheckBox
                $sql = "SELECT
                        tab_enccampo.ecp_id,
                        tab_enccampolista.ecl_id,
                        tab_enccampolista.ecl_orden,
                        tab_enccampolista.ecl_valor,
                        tab_enccampolista.ecl_estado
                        FROM
                        tab_enccampo
                        INNER JOIN tab_enccampolista ON tab_enccampo.ecp_id = tab_enccampolista.ecp_id
                        WHERE tab_enccampolista.ecl_estado = 1 
                        AND tab_enccampo.ecp_id = $val->ecp_id 
                        ORDER BY tab_enccampolista.ecl_orden ";
                $row2 = $this->enccampolista->dbselectBySQL($sql);
                
                $name = "rcv_valorC&" . $val->ecp_id . "[]";                
                foreach ($row2 as $val2) {
                    // Find value
                    $sql = "SELECT
                            tab_rescampovalor.rcv_id,
                            tab_rescampovalor.res_id,
                            tab_rescampovalor.ecp_id,
                            tab_rescampovalor.ecl_id,
                            tab_rescampovalor.rcv_valor,
                            tab_rescampovalor.rcv_estado
                            FROM
                            tab_enccampo
                            INNER JOIN tab_rescampovalor ON tab_enccampo.ecp_id = tab_rescampovalor.ecp_id
                            WHERE tab_rescampovalor.res_id = '$res_id'
                            AND tab_enccampo.ecp_id = $val->ecp_id
                            ORDER BY tab_enccampo.egr_id,
                            tab_enccampo.ecp_orden ";
                    $row5 = $this->enccampo->dbselectBySQL($sql);
                    // $valor = $row5[0]->ecl_id;
                    
                    
                    $otro = "";                    
                    if ($row5){
                        
                        foreach ($row5 as $list) {
                            // Revisar
                            $flag = false;
                            $valores = explode (',',$list->rcv_valor);
                            for($i=0;$i<count($valores);$i++) {
                                if($val2->ecl_valor== 'Otro'){
                                    if ($valores[$i] == $val2->ecl_id){
                                        $otro = $valores[$i+1];
                                        $flag = true;
                                        break;
                                    }                                    
                                }else{
                                    if ($valores[$i] == $val2->ecl_id){
                                        $flag = true;
                                        break;
                                    }
                                }
                            }
                            
//                            foreach ($valores as $valor) {
//                                if ($valor == $val2->ecl_id){
//                                    $flag = true;
//                                    break;
//                                }
//                            }                                                        
                        }
                        
                        // Check value
                        if ($flag == true){
                            if ($val2->ecl_valor=='Otro'){
                                $option .="<input type='checkbox' name='" . $name . "' id='" . $val2->ecl_id . "' value='" . $val2->ecl_id . "' checked='checked' >" . $val2->ecl_valor . "";
                                
                                $option .="<input name='" . $name . "' id='" . $val->ecl_id . "' value='" . $otro . "' type='text'
                                     size='20' autocomplete='off' maxlength='128' class='alphanumeric'
                                     title='' />";                                
                            }else{
                                $option .="<input type='checkbox' name='" . $name . "' id='" . $val2->ecl_id . "' value='" . $val2->ecl_id . "' checked='checked' >" . $val2->ecl_valor . "";
                            }
                            $option .="<br />";
                        }else{
                            if ($val2->ecl_valor=='Otro'){
                                $option .="<input type='checkbox' name='" . $name . "' id='" . $val2->ecl_id . "' value='" . $val2->ecl_id . "'> " . $val2->ecl_valor . "";
                                
                                $option .="<input name='" . $name . "' id='" . $val->ecl_id . "' value='" . $otro . "' type='text'
                                     size='20' autocomplete='off' maxlength='128' class='alphanumeric'
                                     title='' />";                                                 
                                
                            }else{
                                $option .="<input type='checkbox' name='" . $name . "' id='" . $val2->ecl_id . "' value='" . $val2->ecl_id . "'> " . $val2->ecl_valor . "";
                            }
                            $option .="<br />";
                        }
                    }else{
                        // New Other
                        if ($val2->ecl_valor == "Otro"){
                            if ($valor == $val2->ecl_id){                            
                                $option .="<input type='checkbox' name='" . $name . "' id='" . $val2->ecl_id . "' value='" . $val2->ecl_id . "' checked='checked' >" . $val2->ecl_valor . "";                           
                                // New Other
                                $option .="<input name='" . $name . "' id='" . $val->ecl_id . "' value='" . $otro . "' type='text'
                                     size='20' autocomplete='off' maxlength='128' class='alphanumeric'
                                     title='' />";                                                 
                                
                                $option .="<br />";
                            }else{
                                $option .="<input type='checkbox' name='" . $name . "' id='" . $val2->ecl_id . "' value='" . $val2->ecl_id . "'> " . $val2->ecl_valor . "";                                
                                // New Other
                                $option .="<input name='" . $name . "' id='" . $val->ecl_id . "' value='' type='text'
                                     size='20' autocomplete='off' maxlength='128' class='alphanumeric'
                                     title='' />";                                
                                $option .="<br />";
                            }
                        // Anterior
                        }else{
                            if ($valor == $val2->ecl_id){                            
                                $option .="<input type='checkbox' name='" . $name . "' id='" . $val2->ecl_id . "' value='" . $val2->ecl_id . "' checked='checked' >" . $val2->ecl_valor . "";                           
                                $option .="<br />";
                            }else{
                                $option .="<input type='checkbox' name='" . $name . "' id='" . $val2->ecl_id . "' value='" . $val2->ecl_id . "'> " . $val2->ecl_valor . "";                        
                                $option .="<br />";
                            }
                        }
                    }
                    
                }
                
                
                
//                $option .= "<span class='error-requerid'>*</span>";
                $option .="</td>";
                $option .="</tr>";
            
            // RadioButton
            } else if ($val->ecp_tipdat == 'RadioButton') {
                if ($val->ecp_obl==1){
                    $option .="<tr><td>" . $val->egr_codigo . DELIMITER . $val->ecp_orden . " " . $val->ecp_eti . "<span class='error-requerid'>(*)</span></td>";
                }else{
                    $option .="<tr><td>" . $val->egr_codigo . DELIMITER . $val->ecp_orden . " " . $val->ecp_eti . "</td>";
                }
                $option .= "<td colspan='3'>";

                // Lista
                $sql = "SELECT
                        tab_enccampo.ecp_id,
                        tab_enccampolista.ecl_id,
                        tab_enccampolista.ecl_orden,
                        tab_enccampolista.ecl_valor,
                        tab_enccampolista.ecl_estado
                        FROM
                        tab_enccampo
                        INNER JOIN tab_enccampolista ON tab_enccampo.ecp_id = tab_enccampolista.ecp_id
                        WHERE tab_enccampolista.ecl_estado = 1 
                        AND tab_enccampo.ecp_id = $val->ecp_id 
                        ORDER BY tab_enccampolista.ecl_orden ";
                $row2 = $this->enccampolista->dbselectBySQL($sql);
                //
                $name= "rcv_valor&" . $val->ecp_id;                
                foreach ($row2 as $val2) {
                    // Find value
                    // Find Value
                    $sql = "SELECT
                            tab_rescampovalor.rcv_id,
                            tab_rescampovalor.res_id,
                            tab_rescampovalor.ecp_id,
                            tab_rescampovalor.ecl_id,
                            tab_rescampovalor.rcv_valor,
                            tab_rescampovalor.rcv_estado
                            FROM
                            tab_enccampo
                            INNER JOIN tab_rescampovalor ON tab_enccampo.ecp_id = tab_rescampovalor.ecp_id
                            WHERE tab_rescampovalor.res_id = '$res_id'
                            AND tab_enccampo.ecp_id = $val->ecp_id
                            ORDER BY tab_enccampo.egr_id,
                            tab_enccampo.ecp_orden ";
                    $row5 = $this->enccampo->dbselectBySQL($sql);
                    // $valor = $row5[0]->ecl_id;
                    foreach ($row5 as $list) {
                        $valor = $list->rcv_valor;
                    }
                    // Modified
                    if ($valor == $val2->ecl_id){
//                        $option .="<input type='radio' name='rcv_valor' id='" . $val2->ecl_id . "' value='" . $val2->ecl_id . "' checked='checked' > " . $val2->ecl_valor . "";
                        $option .="<input type='radio' name='" . $name . "' id='" . $val2->ecl_id . "' value='" . $val2->ecl_id . "' checked='checked' > " . $val2->ecl_valor . "";
                        $option .="<br />";
                    }else{
//                        $option .="<input type='radio' name='rcv_valor' id='" . $val2->ecl_id . "' value='" . $val2->ecl_id . "'> " . $val2->ecl_valor . "";
                        $option .="<input type='radio' name='" . $name . "' id='" . $val2->ecl_id . "' value='" . $val2->ecl_id . "'> " . $val2->ecl_valor . "";
                        $option .="<br />";
                    }
                }
//                $option .= "<span class='error-requerid'>*</span>";
                $option .="</td>";
                $option .="</tr>";
				
				
            } else {
                // Find Value
                $sql = "SELECT
                        tab_rescampovalor.rcv_id,
                        tab_rescampovalor.res_id,
                        tab_rescampovalor.ecp_id,
                        tab_rescampovalor.ecl_id,
                        tab_rescampovalor.rcv_valor,
                        tab_rescampovalor.rcv_estado
                        FROM
                        tab_enccampo
                        INNER JOIN tab_rescampovalor ON tab_enccampo.ecp_id = tab_rescampovalor.ecp_id
                        WHERE tab_rescampovalor.res_id = '$res_id'
                        AND tab_enccampo.ecp_id = $val->ecp_id
                        ORDER BY tab_enccampo.egr_id,
                        tab_enccampo.ecp_orden";
                $this->rescampovalor = new tab_rescampovalor();
                $row5 = $this->rescampovalor->dbselectBySQL($sql);
                if (isset($row5[0]->rcv_valor)) {
                    $valor = $row5[0]->rcv_valor;
                } else {
                    if ($val->ecp_tipdat == 'Numero' || $val->ecp_tipdat == 'Decimal'){
//                        $valor = "0";
                        $valor = "";
                    }else{
                        $valor = "";
                    }
                }
                
                
                
                // Campo
                if ($val->ecp_obl==1){
                    $option .="<tr><td>" . $val->egr_codigo . DELIMITER . $val->ecp_orden . " " . $val->ecp_eti . "<span class='error-requerid'>(*)</span></td>";
                }else{
                    $option .="<tr><td>" . $val->egr_codigo . DELIMITER . $val->ecp_orden . " " . $val->ecp_eti . "</td>";
                }
                if ($val->ecp_tipdat == 'Texto') {
                    $option .="<td colspan='3'>
                              <input name='" . $val->ecp_id . "' id='" . $val->ecp_id . "' value='" . $valor . "' type='text'
                                     size='40' autocomplete='off' maxlength='1024' class=''
                                     title='" . $val->ecp_nombre . "' />
                              </td>";
                } else if ($val->ecp_tipdat == 'TextArea') {
                    $option .="<td colspan='3'>                                         
                            <textarea name='" . $val->ecp_id . "'
                                      id='" . $val->ecp_id . "'
                                      rows='4' cols='50'                          
                                      autocomplete='off'
                                      class='alphanum'
                                      maxlength='10024'
                                      title='" . $val->ecp_nombre . "' >" 
                                      . $valor . 
                            "</textarea>
                            </td>";                    
                } else if ($val->ecp_tipdat == 'Numero') {
                    $option .="<td colspan='3'>
                              <input name='" . $val->ecp_id . "' id='" . $val->ecp_id . "' value='" . $valor . "' type='text'
                                     size='40' autocomplete='off' maxlength='20' class='onlynumeric'
                                     title='" . $val->ecp_nombre . "' />
                              </td>";
                } else if ($val->ecp_tipdat == 'Decimal') {
                    $option .="<td colspan='3'>
                              <input name='" . $val->ecp_id . "' id='" . $val->ecp_id . "' value='" . $valor . "' type='text'
                                     size='40' autocomplete='off' maxlength='20' class='numeric'
                                     title='" . $val->ecp_nombre . "' />
                              </td>";
                } else if ($val->ecp_tipdat == 'Fecha') {
                    $option .="<td colspan='3'>
                              <input name='" . $val->ecp_id . "' id='" . $val->ecp_nombre . "' value='" . $valor . "' type='text'
                                     size='10' autocomplete='off' maxlength='16' class=''
                                     title='" . $val->ecp_nombre . "' />
                              </td>";


                    $option .="<script type='text/javascript'>";
                    $option .= "jQuery(document).ready(function($) { ";
                    $option .= "$('#" . $val->ecp_nombre . "').datepicker({
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
                            });";
                    $option .= "});";
                    $option .="</script>";
                }

                $option .="</tr>";
            }

            $egr_id = $val->egr_id;

        }
        
        $option .="</table>";
        $option .="</div>";        
        
        return $option;
    }

    function obtenerSelectCamposShow($enc_id = null, $res_id = null) {
        $this->enccampolista = new tab_enccampolista();
        $sql = "SELECT
                tab_enccampo.ecp_id,
                tab_enccampo.enc_id,
                tab_enccampo.egr_id,
                tab_encgrupo.egr_codigo,
                tab_encgrupo.egr_nombre,
                tab_enccampo.ecp_orden,
                tab_enccampo.ecp_eti,
                tab_enccampo.ecp_tipdat,
                tab_enccampo.ecp_estado,
                tab_enccampo.ecp_nombre
                FROM
                tab_enccampo
                INNER JOIN tab_encgrupo ON tab_enccampo.egr_id = tab_encgrupo.egr_id
                WHERE tab_enccampo.ecp_estado = 1
                AND tab_enccampo.enc_id = $enc_id
                ORDER BY tab_enccampo.egr_id, 
                tab_enccampo.ecp_orden ASC ";
                
        $row = $this->enccampo->dbselectBySQL($sql);
        $option = "";
        $count = 0;
        // Trace
        if (count($row) > 0) {
            
            $egr_id = 0;
            
            foreach ($row as $val) {
                                
                if($egr_id != $val->egr_id){
                    $option .= '<tr><td align="left"><b>' . $val->egr_nombre . '</b></td></tr>';
                }
                
                
                if ($val->ecp_tipdat == 'Etiqueta') {                    
                    // Etiqueta
                    $option .="<tr>";                    
                    $option .='<td>' . '<b>' . $val->egr_codigo . DELIMITER . $val->ecp_orden . " " . $val->ecp_eti . '</b>';
                    $option .="</td>";
                    $option .="</tr>";
                    
                } else if ($val->ecp_tipdat == 'Lista') {

                    $option .="<tr>";

                    // Etiqueta
                    $option .='<td>' . '<b>' . $val->egr_codigo . DELIMITER . $val->ecp_orden . " " . $val->ecp_eti . '</b>';

                    // Lista
                    $sql = "SELECT
                            tab_enccampo.ecp_id,
                            tab_enccampolista.ecl_id,
                            tab_enccampolista.ecl_valor,
                            tab_enccampolista.ecl_estado
                            FROM
                            tab_enccampo
                            INNER JOIN tab_enccampolista ON tab_enccampo.ecp_id = tab_enccampolista.ecp_id
                            WHERE tab_enccampolista.ecl_estado = 1 
                            AND tab_enccampo.ecp_id = $val->ecp_id 
                            ORDER BY tab_enccampolista.ecl_orden ";
                    $row2 = $this->enccampolista->dbselectBySQL($sql);
                    foreach ($row2 as $val2) {
                        // Find value
                        $sql = "SELECT
                                tab_rescampovalor.rcv_id,
                                tab_rescampovalor.res_id,
                                tab_rescampovalor.ecp_id,
                                tab_rescampovalor.ecl_id,
                                tab_rescampovalor.rcv_valor,
                                tab_rescampovalor.rcv_estado
                                FROM
                                tab_enccampo
                                INNER JOIN tab_rescampovalor ON tab_enccampo.ecp_id = tab_rescampovalor.ecp_id
                                WHERE tab_rescampovalor.res_id = '$res_id'
                                AND tab_enccampo.ecp_id = $val->ecp_id
                                ORDER BY tab_enccampo.egr_id, 
                                tab_enccampo.ecp_orden";
                        $row5 = $this->enccampo->dbselectBySQL($sql);
                        if (isset($val2->ecl_valor)) {
                            $valor = $row5[0]->ecl_id;
                            if ($row5[0]->ecl_id == $val2->ecl_id)
                                $option .= ' ' . $val2->ecl_valor;
                        }else {
                            $valor = "";
                            $option .= "";
                        }
                    }

                    $option .="</td>";
                    $option .="</tr>";
                
                    
                }else if ($val->ecp_tipdat == 'CheckBox') {

                    $option .="<tr>";

                    // Etiqueta
                    $option .='<td>' . '<b>' .  $val->egr_codigo . DELIMITER . $val->ecp_orden . " " . $val->ecp_eti . '</b>';

                    // Lista
                    $sql = "SELECT
                            tab_enccampo.ecp_id,
                            tab_enccampolista.ecl_id,
                            tab_enccampolista.ecl_valor,
                            tab_enccampolista.ecl_estado
                            FROM
                            tab_enccampo
                            INNER JOIN tab_enccampolista ON tab_enccampo.ecp_id = tab_enccampolista.ecp_id
                            WHERE tab_enccampolista.ecl_estado = 1 
                            AND tab_enccampo.ecp_id = $val->ecp_id 
                            ORDER BY tab_enccampolista.ecl_orden ";
                    $row2 = $this->enccampolista->dbselectBySQL($sql);
                    foreach ($row2 as $val2) {
                        // Find value
                        $sql = "SELECT
                                tab_rescampovalor.rcv_id,
                                tab_rescampovalor.res_id,
                                tab_rescampovalor.ecp_id,
                                tab_rescampovalor.ecl_id,
                                tab_rescampovalor.rcv_valor,
                                tab_rescampovalor.rcv_estado
                                FROM
                                tab_enccampo
                                INNER JOIN tab_rescampovalor ON tab_enccampo.ecp_id = tab_rescampovalor.ecp_id
                                WHERE tab_rescampovalor.res_id = '$res_id'
                                AND tab_enccampo.ecp_id = $val->ecp_id
                                ORDER BY tab_enccampo.egr_id, 
                                tab_enccampo.ecp_orden";
                        $row5 = $this->enccampo->dbselectBySQL($sql);
                        if (isset($row5)) {                            
                            foreach ($row5 as $list) {
                                // Revisar
                                $flag = false;
                                $valores = explode (',',$list->rcv_valor);
                                foreach ($valores as $valor) {
                                    if ($valor == $val2->ecl_id){
                                        $flag = true;
                                        break;
                                    }
                                }                                                        
                            }
                            if ($flag == true){
                                $option .= ' ' . $val2->ecl_valor . ', '  ;
                            }else{
                                $option .= ' ';
                            }                            
                            
                        }else {
                            $valor = "";
                            $option .= "";
                        }
                    }

                    $option .="</td>";
                    $option .="</tr>";

                }else if ($val->ecp_tipdat == 'RadioButton') {

                    $option .="<tr>";

                    // Etiqueta
                    $option .='<td>' . '<b>' . $val->egr_codigo . DELIMITER . $val->ecp_orden . " " . $val->ecp_eti . '</b>';

                    // Lista
                    $sql = "SELECT
                            tab_enccampo.ecp_id,
                            tab_enccampolista.ecl_id,
                            tab_enccampolista.ecl_valor,
                            tab_enccampolista.ecl_estado
                            FROM
                            tab_enccampo
                            INNER JOIN tab_enccampolista ON tab_enccampo.ecp_id = tab_enccampolista.ecp_id
                            WHERE tab_enccampolista.ecl_estado = 1 
                            AND tab_enccampo.ecp_id = $val->ecp_id 
                            ORDER BY tab_enccampolista.ecl_orden ";
                    $row2 = $this->enccampolista->dbselectBySQL($sql);
                    foreach ($row2 as $val2) {
                        // Find value
                        $sql = "SELECT
                                tab_rescampovalor.rcv_id,
                                tab_rescampovalor.res_id,
                                tab_rescampovalor.ecp_id,
                                tab_rescampovalor.ecl_id,
                                tab_rescampovalor.rcv_valor,
                                tab_rescampovalor.rcv_estado
                                FROM
                                tab_enccampo
                                INNER JOIN tab_rescampovalor ON tab_enccampo.ecp_id = tab_rescampovalor.ecp_id
                                WHERE tab_rescampovalor.res_id = '$res_id'
                                AND tab_enccampo.ecp_id = $val->ecp_id
                                ORDER BY tab_enccampo.egr_id, 
                                tab_enccampo.ecp_orden";
                        $row5 = $this->enccampo->dbselectBySQL($sql);
                        if (isset($val2->ecl_valor)) {
                            $valor = $row5[0]->ecl_id;
                            if ($row5[0]->ecl_id == $val2->ecl_id)
                                $option .= ' ' . $val2->ecl_valor;
                        }else {
                            $valor = "";
                            $option .= "";
                        }
                    }

                    $option .="</td>";
                    $option .="</tr>";
                    
                    
                } else {
                    $option .="<tr>";
                    // Find Value
                    $sql = "SELECT
                            tab_rescampovalor.rcv_id,
                            tab_rescampovalor.res_id,
                            tab_rescampovalor.ecp_id,
                            tab_rescampovalor.ecl_id,
                            tab_rescampovalor.rcv_valor,
                            tab_rescampovalor.rcv_estado
                            FROM
                            tab_enccampo
                            INNER JOIN tab_rescampovalor ON tab_enccampo.ecp_id = tab_rescampovalor.ecp_id
                            WHERE tab_rescampovalor.res_id = '$res_id'
                            AND tab_enccampo.ecp_id = $val->ecp_id
                            ORDER BY tab_enccampo.egr_id, 
                            tab_enccampo.ecp_orden";
                    $this->rescampovalor = new tab_rescampovalor();
                    $row5 = $this->rescampovalor->dbselectBySQL($sql);
                    if (isset($row5[0]->rcv_valor)) {
                        $valor = $row5[0]->rcv_valor;
                    } else {
                        $valor = "";
                    }
                    // Etiqueta
                    $option .='<td>' . '<b>' . $val->egr_codigo . DELIMITER . $val->ecp_orden . " " . $val->ecp_eti . '</b>' . ' ' . $valor . "</td>";
                    $option .="</tr>";
                }
                
                // New
                $egr_id = $val->egr_id;
                
            }
        }
        return $option;
    }
	
    function obtenerSelectCamposMostrar($enc_id = null, $res_id = null) {
        $this->enccampolista = new tab_enccampolista();
        $sql = "SELECT
                tab_enccampo.ecp_id,
                tab_enccampo.enc_id,
                tab_enccampo.ecp_orden,
                tab_enccampo.ecp_eti,
                tab_enccampo.ecp_tipdat,
                tab_enccampo.ecp_estado,
                tab_enccampo.ecp_nombre
                FROM
                tab_enccampo
                WHERE tab_enccampo.ecp_estado = 1
                AND tab_enccampo.enc_id = $enc_id
                ORDER BY ecp_orden ASC ";
        $row = $this->enccampo->dbselectBySQL($sql);
        $option = "";

        // Trace
        foreach ($row as $val) {
            if ($val->ecp_tipdat == 'Lista') {
                // Lista
                $sql = "SELECT
                        tab_enccampo.ecp_id,
                        tab_enccampolista.ecl_id,
                        tab_enccampolista.ecl_valor,
                        tab_enccampolista.ecl_estado
                        FROM
                        tab_enccampo
                        INNER JOIN tab_enccampolista ON tab_enccampo.ecp_id = tab_enccampolista.ecp_id
                        WHERE tab_enccampolista.ecl_estado = 1 AND tab_enccampo.ecp_id = $val->ecp_id ";
                $row2 = $this->enccampolista->dbselectBySQL($sql);
                if ($row2){                     
                    foreach ($row2 as $val2) {
                        // Find value
                        $sql = "SELECT
                                tab_rescampovalor.rcv_id,
                                tab_rescampovalor.res_id,
                                tab_rescampovalor.ecp_id,
                                tab_rescampovalor.ecl_id,
                                tab_rescampovalor.rcv_valor,
                                tab_rescampovalor.rcv_estado
                                FROM
                                tab_enccampo
                                INNER JOIN tab_rescampovalor ON tab_enccampo.ecp_id = tab_rescampovalor.ecp_id
                                WHERE tab_rescampovalor.res_id = '$res_id'
                                AND tab_enccampo.ecp_id = $val->ecp_id
                                ORDER BY
                                tab_enccampo.ecp_orden";
                        $row5 = $this->enccampo->dbselectBySQL($sql);
                        if($row5){
                             
                            foreach ($row5 as $list) {
                                $rcv_valor = $list->rcv_valor;
                                $ecl_id = $list->ecl_id;
                            }
                            if ($rcv_valor) {
                                if ($row5[0]->ecl_id == $val2->ecl_id){
                                    // List
                                    $option .="<tr><td><strong>" . $val->ecp_eti . "</strong></td>";
                                    $option .= "<td colspan='3'>";                                
                                    $valor = $ecl_id;                                    
                                    $option .= $val2->ecl_valor;
                                    $option .="</td>";
                                    $option .="</tr>";                                    
                                }
                                                                 
//                            }else {
//                                $valor = "";
//                                $option .= "";
                            }                                                       
                        }
                    }                    
                }                
            } else {
                // Find Value
                $sql = "SELECT
                        tab_rescampovalor.rcv_id,
                        tab_rescampovalor.res_id,
                        tab_rescampovalor.ecp_id,
                        tab_rescampovalor.ecl_id,
                        tab_rescampovalor.rcv_valor,
                        tab_rescampovalor.rcv_estado
                        FROM
                        tab_enccampo
                        INNER JOIN tab_rescampovalor ON tab_enccampo.ecp_id = tab_rescampovalor.ecp_id
                        WHERE tab_rescampovalor.res_id = '$res_id'
                        AND tab_enccampo.ecp_id = $val->ecp_id
                        ORDER BY
                        tab_enccampo.ecp_orden";
                $this->rescampovalor = new tab_rescampovalor();
                $row5 = $this->rescampovalor->dbselectBySQL($sql);
                if ($row5){
                    if ($row5[0]->rcv_valor) {
                        $valor = $row5[0]->rcv_valor;
                        $option .="<tr><td><strong>" . $val->ecp_eti . "</strong></td>";
                        $option .="<td colspan='3'> " . $valor . "</td>";
                        $option .="</tr>";                        
                    }
                }
            }
        }
        return $option;
    }

    function obtenerCampos($enc_id = null) {
        $this->enccampo = new tab_enccampo();
        $sql = "SELECT *
                FROM
                tab_enccampo
                WHERE tab_enccampo.ecp_estado = 1
                AND tab_enccampo.enc_id = $enc_id
                ORDER BY ecp_orden ASC ";
        $row = $this->enccampo->dbselectBySQL($sql);
        if (count($row)) {
            return $row;
        } else {
            return null;
        }
    }
	
    function obtenerSelectCamposRepH($enc_id = null) {
        $width = 50;
        $this->enccampolista = new tab_enccampolista();
        $sql = "SELECT
                tab_enccampo.ecp_id,
                tab_enccampo.enc_id,
                tab_enccampo.ecp_orden,
                tab_enccampo.ecp_eti,
                tab_enccampo.ecp_tipdat,
                tab_enccampo.ecp_estado,
                tab_enccampo.ecp_nombre
                FROM
                tab_enccampo
                WHERE tab_enccampo.ecp_estado = 1
                AND tab_enccampo.enc_id = $enc_id
                ORDER BY ecp_orden ASC ";
        $row = $this->enccampo->dbselectBySQL($sql);
        $option = "";

        // Trace
        foreach ($row as $val) {
            $option .='<td width="' . $width . '" rowspan="3" align="center" valign="middle"><span style="font-size: 11px ;font-weight: bold;">' . $val->ecp_eti . '</span></td>';
        }
        return $option;
    }

    function obtenerSelectCamposRepC($enc_id = null, $res_id = null) {
        $width = 50;
        $this->enccampolista = new tab_enccampolista();
        $sql = "SELECT
                tab_enccampo.ecp_id,
                tab_enccampo.enc_id,
                tab_enccampo.ecp_orden,
                tab_enccampo.ecp_eti,
                tab_enccampo.ecp_tipdat,
                tab_enccampo.ecp_estado,
                tab_enccampo.ecp_nombre
                FROM
                tab_enccampo
                WHERE tab_enccampo.ecp_estado = 1
                AND tab_enccampo.enc_id = $enc_id
                ORDER BY ecp_orden ASC ";
        $row = $this->enccampo->dbselectBySQL($sql);
        $option = "";


        // Trace
        foreach ($row as $val) {
            if ($val->ecp_tipdat == 'Lista') {
                //$option .="<tr><td><strong>" . $val->ecp_eti . "</strong></td>";
                $option .= '<td bgcolor="#FFFFFF" width="' . $width . '">';
                // Lista
                $sql = "SELECT
                        tab_enccampo.ecp_id,
                        tab_enccampolista.ecl_id,
                        tab_enccampolista.ecl_valor,
                        tab_enccampolista.ecl_estado
                        FROM
                        tab_enccampo
                        INNER JOIN tab_enccampolista ON tab_enccampo.ecp_id = tab_enccampolista.ecp_id
                        WHERE tab_enccampolista.ecl_estado = 1 AND tab_enccampo.ecp_id = $val->ecp_id ";
                $row2 = $this->enccampolista->dbselectBySQL($sql);
                foreach ($row2 as $val2) {
                    // Find value
                    $sql = "SELECT
                            tab_rescampovalor.rcv_id,
                            tab_rescampovalor.res_id,
                            tab_rescampovalor.ecp_id,
                            tab_rescampovalor.ecl_id,
                            tab_rescampovalor.rcv_valor,
                            tab_rescampovalor.rcv_estado
                            FROM
                            tab_enccampo
                            INNER JOIN tab_rescampovalor ON tab_enccampo.ecp_id = tab_rescampovalor.ecp_id
                            WHERE tab_rescampovalor.res_id = '$res_id'
                            AND tab_enccampo.ecp_id = $val->ecp_id
                            ORDER BY
                            tab_enccampo.ecp_orden";
                    $row5 = $this->enccampo->dbselectBySQL($sql);
                    if (isset($row5[0]->rcv_valor)) {
                        $valor = $row5[0]->ecl_id;
                        if ($row5[0]->ecl_id == $val2->ecl_id)
                            $option .= '<span style="font-size: 11px;">' . $val2->ecl_valor . '</span>';
                    }else {
                        $valor = "";
                        $option .= '<span style="font-size: 11px;"></span>';
                    }
                }
                //$option .= "</select>";
                $option .="</td>";
                //$option .="</tr>";
            } else {
                // Find Value
                $sql = "SELECT
                        tab_rescampovalor.rcv_id,
                        tab_rescampovalor.res_id,
                        tab_rescampovalor.ecp_id,
                        tab_rescampovalor.ecl_id,
                        tab_rescampovalor.rcv_valor,
                        tab_rescampovalor.rcv_estado
                        FROM
                        tab_enccampo
                        INNER JOIN tab_rescampovalor ON tab_enccampo.ecp_id = tab_rescampovalor.ecp_id
                        WHERE tab_rescampovalor.res_id = '$res_id'
                        AND tab_enccampo.ecp_id = $val->ecp_id
                        ORDER BY
                        tab_enccampo.ecp_orden";
                $this->rescampovalor = new tab_rescampovalor();
                $row5 = $this->rescampovalor->dbselectBySQL($sql);
                if (isset($row5[0]->rcv_valor)) {
                    $valor = $row5[0]->rcv_valor;
                } else {
                    $valor = "";
                }

                // Campos
                //$option .="<tr><td><strong>" . $val->ecp_eti . "</strong></td>";
                $option .='<td bgcolor="#FFFFFF" width="' . $width . '"><span style="font-size: 11px;">' . $valor . '</span></td>';
                //$option .="</tr>";
            }
        }
        return $option;
    }

    function obtenerSelectCamposRepDoc($enc_id = null, $res_id = null) {
        $this->enccampolista = new tab_enccampolista();
        $sql = "SELECT
                tab_enccampo.ecp_id,
                tab_enccampo.enc_id,
                tab_enccampo.ecp_orden,
                tab_enccampo.ecp_eti,
                tab_enccampo.ecp_tipdat,
                tab_enccampo.ecp_estado,
                tab_enccampo.ecp_nombre
                FROM
                tab_enccampo
                WHERE tab_enccampo.ecp_estado = 1
                AND tab_enccampo.enc_id = $enc_id
                ORDER BY ecp_orden ASC ";
        $row = $this->enccampo->dbselectBySQL($sql);
        $option = "";
        $count = 0;
        // Trace
        if (count($row) > 0) {
            foreach ($row as $val) {


                if ($count == 0) {
                    $option .="<tr>";
                }
                if ($val->ecp_tipdat == 'Lista') {
                    $option .='<td bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;">' . $val->ecp_eti . ':</span></td>';
                    $option .= '<td><span style="font-size: 14px;">';
                    // Lista
                    $sql = "SELECT
                        tab_enccampo.ecp_id,
                        tab_enccampolista.ecl_id,
                        tab_enccampolista.ecl_valor,
                        tab_enccampolista.ecl_estado
                        FROM
                        tab_enccampo
                        INNER JOIN tab_enccampolista ON tab_enccampo.ecp_id = tab_enccampolista.ecp_id
                        WHERE tab_enccampolista.ecl_estado = 1 AND tab_enccampo.ecp_id = $val->ecp_id ";
                    $row2 = $this->enccampolista->dbselectBySQL($sql);
                    foreach ($row2 as $val2) {
                        // Find value
                        $sql = "SELECT
                            tab_rescampovalor.rcv_id,
                            tab_rescampovalor.res_id,
                            tab_rescampovalor.ecp_id,
                            tab_rescampovalor.ecl_id,
                            tab_rescampovalor.rcv_valor,
                            tab_rescampovalor.rcv_estado
                            FROM
                            tab_enccampo
                            INNER JOIN tab_rescampovalor ON tab_enccampo.ecp_id = tab_rescampovalor.ecp_id
                            WHERE tab_rescampovalor.res_id = '$res_id'
                            AND tab_enccampo.ecp_id = $val->ecp_id
                            ORDER BY
                            tab_enccampo.ecp_orden";
                        $row5 = $this->enccampo->dbselectBySQL($sql);
                        if (isset($val2->ecl_valor)) {
                            $valor = $row5[0]->ecl_id;
                            if ($row5[0]->ecl_id == $val2->ecl_id)
                                $option .= $val2->ecl_valor;
                        }else {
                            $valor = "";
                            $option .= "";
                        }
                    }

                    $option .="</span></td>";
                } else {
                    // Find Value
                    $sql = "SELECT
                        tab_rescampovalor.rcv_id,
                        tab_rescampovalor.res_id,
                        tab_rescampovalor.ecp_id,
                        tab_rescampovalor.ecl_id,
                        tab_rescampovalor.rcv_valor,
                        tab_rescampovalor.rcv_estado
                        FROM
                        tab_enccampo
                        INNER JOIN tab_rescampovalor ON tab_enccampo.ecp_id = tab_rescampovalor.ecp_id
                        WHERE tab_rescampovalor.res_id = '$res_id'
                        AND tab_enccampo.ecp_id = $val->ecp_id
                        ORDER BY
                        tab_enccampo.ecp_orden";
                    $this->rescampovalor = new tab_rescampovalor();
                    $row5 = $this->rescampovalor->dbselectBySQL($sql);
                    if (isset($row5[0]->rcv_valor)) {
                        $valor = $row5[0]->rcv_valor;
                    } else {
                        $valor = "";
                    }
                    // Campos
                    $option .='<td bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;">' . $val->ecp_eti . ":</span></td>";
                    $option .='<td><span style="font-size: 14px;">' . $valor . "</span></td>";
                }
                $count++;
                if ($count == 2) {
                    $option .="</tr>";
                    $count = 0;
                }
            }
            if ($count < 2) {
                $option .="</tr>";
            }
        }
        return $option;
    }


    function esOtro($ecl_id) {
        
        // Find Value
        $sql = "SELECT
            tab_enccampolista.ecl_id,
            tab_enccampolista.ecl_valor
            FROM
            tab_enccampolista
            WHERE tab_enccampolista.ecl_id = '$ecl_id'
            AND tab_enccampolista.ecl_estado = '1' ";
        $this->enccampolista = new tab_enccampolista();
        $row = $this->enccampolista->dbselectBySQL($sql);
        if (isset($row)) {
            foreach ($row as $val) {
                if ($val->ecl_valor == 'Otro'){
                    return true;
                }else{
                    return false;
                }
            }
        }
    }
    
    
    
    function obtenerPregunta($ecp_id) {
        
        // Find Value
        $sql = "SELECT
            tab_enccampo.ecp_id,
            tab_enccampo.ecp_eti
            FROM
            tab_enccampo
            WHERE tab_enccampo.ecp_id = '$ecp_id'
            AND tab_enccampo.ecp_estado = '1' ";
        $this->enccampo = new tab_enccampolista();
        $row = $this->enccampo->dbselectBySQL($sql);
        if (isset($row)) {
            foreach ($row as $val) {
                return $val->ecp_eti;
            }
        }
    }    
    
    
    function obtenerNroEntidades($ecp_id) {
        
        // Find Value
        $sql = "SELECT count(tab_rescampovalor.rcv_id) as contador
                FROM
                tab_enccampo
                INNER JOIN tab_rescampovalor ON tab_enccampo.ecp_id = tab_rescampovalor.ecp_id
                WHERE tab_enccampo.ecp_id = '$ecp_id'
                AND tab_enccampo.ecp_estado = '1' ";
        $this->enccampo = new tab_enccampolista();
        $row = $this->enccampo->dbselectBySQL($sql);
        if (isset($row)) {
            foreach ($row as $val) {
                return $val->contador;
            }
        }
    } 
    

}

?>
