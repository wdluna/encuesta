<?php

/**
 * rpteRespuestaController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright DGGE
 * @version $Id$ 2014.04.24
 * @access public
 */

class rpteRespuestaBACKController Extends baseController {

    function index() {

        $encuesta = new encuesta();
        $enccampo = new enccampo();
        $this->registry->template->enc_id = $encuesta->obtenerSelectTodas();
        $this->registry->template->ecp_id = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "verRpte";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu();
        $liMenu = $this->menu->imprimirMenu("rpteRespuesta", $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        $this->registry->template->show('headerF');
        $this->registry->template->show('rpteRespuesta.tpl');
        $this->registry->template->show('footer');
    }

    function verRpte() {
        $where = "";
        $enc_id = $_POST['enc_id'];
        $ecp_id = $_POST['ecp_id'];        
        $tiporeporte = $_POST['tiporeporte'];
        $imagen = "";
        
        if ($tiporeporte == 1) {
            require_once ('includes/libchart/classes/libchart.php'); 
            $chart = new PieChart();
            $dataSet = new XYDataSet();
            
            $enccampo = new enccampo ();
            $pregunta = $enccampo->obtenerPregunta($ecp_id);
            $muestra = $enccampo->obtenerNroEntidades($ecp_id);
            // Data Encuesta, Pregunta
            $options = $this->obtenerRespuesta($enc_id, $ecp_id);             
            foreach($options as $option => $conteo){
                $dataSet->addPoint(new Point($option, $conteo));            
            }
                                                
            $chart->setDataSet($dataSet);
            $chart->setTitle("Pregunta: " . $pregunta . "\nMuestra: " . $muestra . " entidades");
            $imagen = "imagen1.png";
            $chart->render("images/" . $imagen);

        } else if ($tiporeporte == 2) {
            require_once ('includes/libchart/classes/libchart.php'); 

            $chart = new LineChart();
            $dataSet = new XYDataSet();
            
            $enccampo = new enccampo ();
            $pregunta = $enccampo->obtenerPregunta($ecp_id);
            $muestra = $enccampo->obtenerNroEntidades($ecp_id);
            // Data Encuesta, Pregunta
            $options = $this->obtenerRespuesta($enc_id, $ecp_id);             
            foreach($options as $option => $conteo){
                $dataSet->addPoint(new Point($option, $conteo));            
            }
            
            $chart->setDataSet($dataSet);
            $chart->setTitle("Pregunta: " . $pregunta . "\nMuestra: " . $muestra . " entidades");
            $imagen = "imagen2.png";
            $chart->render("images/" . $imagen);
            
            
        } else if ($tiporeporte == 3) {
            require_once ('includes/libchart/classes/libchart.php');

            $chart = new HorizontalBarChart(600, 170);
            $dataSet = new XYDataSet();

            $enccampo = new enccampo ();
            $pregunta = $enccampo->obtenerPregunta($ecp_id);
            $muestra = $enccampo->obtenerNroEntidades($ecp_id);
            // Data Encuesta, Pregunta
            $options = $this->obtenerRespuesta($enc_id, $ecp_id);             
            foreach($options as $option => $conteo){
                $dataSet->addPoint(new Point($option, $conteo));            
            }           
            
            $chart->setDataSet($dataSet);
            $chart->getPlot()->setGraphPadding(new Padding(5, 30, 20, 140));

            $chart->setTitle("Pregunta: " . $pregunta . "\nMuestra: " . $muestra . " entidades");
            $imagen = "imagen3.png";
            $chart->render("images/" . $imagen);

            
        } else if ($tiporeporte == 4) {
            
            require_once ('includes/libchart/classes/libchart.php'); 

            $chart = new VerticalBarChart();
            $dataSet = new XYDataSet();
            
            $enccampo = new enccampo ();
            $pregunta = $enccampo->obtenerPregunta($ecp_id);
            $muestra = $enccampo->obtenerNroEntidades($ecp_id);
            // Data Encuesta, Pregunta
            $options = $this->obtenerRespuesta($enc_id, $ecp_id);             
            foreach($options as $option => $conteo){
                $dataSet->addPoint(new Point($option, $conteo));            
            }
            
            $chart->setDataSet($dataSet);

            $chart->setTitle("Pregunta: " . $pregunta . "\nMuestra: " . $muestra . " entidades");
            $imagen = "imagen4.png";
            $chart->render("images/" . $imagen);

        
            
        } else if ($tiporeporte == 5) {
            $enccampo = new enccampo ();
            $pregunta = $enccampo->obtenerPregunta($ecp_id);
            $muestra = $enccampo->obtenerNroEntidades($ecp_id);
            
            $cadena .= '<table width="100%" border="0" >';
            $cadena .= '<tr><td colspan= "3" align="center">';
            $cadena .= '<span style="font-size: 30px;font-weight: bold;">';
            $cadena .= 'SISTEMA GENERAL DE ENCUESTAS - SOFTWARE LIBRE';
            $cadena .= '</span>';
            $cadena .= '</td></tr>';
            $cadena .= '<tr><td colspan= "3" align="left">';
            $cadena .= '<span style="font-size: 30px;font-weight: bold;">';
            $cadena .= "Pregunta: " . $pregunta;
            $cadena .= '</span>';
            $cadena .= '</td></tr>';            
            $cadena .= '<tr><td colspan= "3" align="left">';
            $cadena .= '<span style="font-size: 30px;font-weight: bold;">';
            $cadena .= "Muestra: " . $muestra;
            $cadena .= '</span>';
            $cadena .= '</td></tr>';

            // Body - Header
            $cadena .= '<tr bgcolor="#CCCCCC">';
            $cadena .= '<td width="5%" align="center"><span style="font-family: helvetica; font-size: 11px;font-weight: bold;">Nro.</span></td>';
            $cadena .= '<td width="60%" align="left"><span style="font-family: helvetica; font-size: 11px;font-weight: bold;">Titulo</span></td>';
            $cadena .= '<td width="35%" align="left"><span style="font-family: helvetica; font-size: 11px;font-weight: bold;">Cantidad</span></td>';
            $cadena .= '</tr>';

            
            // Data Encuesta, Pregunta
            $options = $this->obtenerRespuesta($enc_id, $ecp_id);
            $i=1;
            foreach($options as $option => $conteo){                
                // Data
                $cadena .= '<tr bgcolor="FFFFFF">';
                $cadena .= '<td width="5%" align="center"><span style="font-family: helvetica; font-size: 11px;">' . $i . '</span></td>';
                $cadena .= '<td width="60%" align="left"><span style="font-family: helvetica; font-size: 11px;">' . $option . '</span></td>';
                $cadena .= '<td width="35%" align="left"><span style="font-family: helvetica; font-size: 11px;">' . $conteo . '</span></td>';
                $cadena .= '</tr>';
                $i++;                
            }            
            
            $cadena .= '</table>'; 
            
            // Excel
            header("Content-type: application/vnd.ms-excel; name='excel'");
            header("Content-Disposition: filename=encuesta.xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            
        }
        
        
        if ($tiporeporte == 5) {
            echo $cadena;
        }else{
//            Header("Location: " . PATH_DOMAIN . "/imagen.html");            
            $this->registry->template->imagen = $imagen;
            $this->registry->template->show('imagen.tpl');            
        }      
    }
    
    
    function loadAjaxPreguntas() {
        $enc_id = $_POST["Enc_id"];
        
        $sql = "SELECT
                tab_encuesta.enc_id,
                tab_enccampo.ecp_id,
                tab_encgrupo.egr_codigo,
                tab_encgrupo.egr_nombre,
                tab_enccampo.ecp_orden,
                tab_enccampo.ecp_nombre,
                tab_enccampo.ecp_eti,
                tab_enccampo.ecp_tipdat,
                tab_enccampo.ecp_estado
                FROM
                tab_encuesta
                INNER JOIN tab_enccampo ON tab_enccampo.enc_id = tab_encuesta.enc_id
                INNER JOIN tab_encgrupo ON tab_encgrupo.egr_id = tab_enccampo.egr_id
                WHERE tab_encuesta.enc_id = '$enc_id'
                AND tab_enccampo.ecp_estado = 1
                ORDER BY 
                tab_encgrupo.egr_id,
                tab_enccampo.ecp_orden ";
        
        $enccampo = new tab_enccampo();
        $result = $enccampo->dbSelectBySQL($sql);
        $res = array();
        foreach ($result as $row) {
            $res[$row->ecp_id] = $row->ecp_nombre . " " . $row->ecp_eti . " (" . $row->ecp_tipdat . ")";
        }
        echo json_encode($res);
    }      
    

    function obtenerRespuesta($enc_id = null, $ecp_id = null) {
        //$encuesta = new tab_encuesta ();
        $enccampo = new tab_enccampo ();
        $enccampolista = new tab_enccampolista ();
        
        //$this->enccampolista = new tab_enccampolista();
        
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
                AND tab_enccampo.enc_id = '$enc_id'
                AND tab_enccampo.ecp_id = '$ecp_id'
                ORDER BY tab_enccampo.egr_id,
                tab_enccampo.ecp_orden ASC ";
        $row = $enccampo->dbselectBySQL($sql);
        $option = "";

        // Trace
        $valor = "";
	$egr_id = 0;
        $flag = false;
        foreach ($row as $val) {

            // Etiqueta
            if ($val->ecp_tipdat == 'Etiqueta') {
                $option .="<tr><td colspan='4'>" . $val->egr_codigo . DELIMITER . $val->ecp_orden . " " . $val->ecp_eti . "</td>";
                $option .="</tr>";
            

            // Lista
            } else if ($val->ecp_tipdat == 'Lista') {
                if ($val->ecp_obl==1){
                    $option .="<tr><td>" . $val->egr_codigo . DELIMITER . $val->ecp_orden . " " . $val->ecp_eti . "<span class='error-requerid'>(*)</span></td>";
                }else{
                    $option .="<tr><td>" . $val->egr_codigo . DELIMITER . $val->ecp_orden . " " . $val->ecp_eti . "</td>";
                }
                $option .= "<td colspan='3'>
                    <select name='" . $val->ecp_id . "' id='" . $val->ecp_id . "' title='" . $val->ecp_nombre . "' class=''>
                    <option value=''>(seleccionar)</option>";

                                
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
                        WHERE tab_enccampo.ecp_id = $val->ecp_id
                        ORDER BY tab_rescampovalor.res_id,
                        tab_enccampo.egr_id,
                        tab_enccampo.ecp_orden ";
                
                $row5 = $enccampo->dbselectBySQL($sql);
                $j=0;
                $respuestas = array();
                $conteo = array();
                
                if ($row5){
                    foreach ($row5 as $list) {
                        $opcion = $this->buscarOpcion($list->ecp_id, $list->ecl_id);
                        $respuestas[$j] = $opcion;                        
                        $j++;
                    }
                }
                
                // Lista de valores
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
                $row5 = $enccampo->dbselectBySQL($sql);                    
                if ($row5){
                    foreach ($row5 as $list) {                                            
                        $buscar = (array_keys($respuestas, $list->ecl_valor));
                        $contador = count($buscar);                        
                        // Ingresar datos a array  
                        if ($contador != 0){
                             $conteo[$list->ecl_valor] = $contador;
                        }
                        
                    }
                }
                
				
            
            
            // CheckBox
            } else if ($val->ecp_tipdat == 'CheckBox') {
                $otro = "";
                
                if ($val->ecp_obl==1){
                    $option .="<tr><td>" . $val->egr_codigo . DELIMITER . $val->ecp_orden . " " . $val->ecp_eti . "<span class='error-requerid'>(*)</span></td>";
                }else{
                    $option .="<tr><td>" . $val->egr_codigo . DELIMITER . $val->ecp_orden . " " . $val->ecp_eti . "</td>";
                }
                $option .= "<td colspan='3'>";

                // CheckBox
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
                        WHERE tab_enccampo.ecp_id = $val->ecp_id
                        ORDER BY tab_rescampovalor.res_id,
                        tab_enccampo.egr_id,
                        tab_enccampo.ecp_orden ";
                $row5 = $enccampo->dbselectBySQL($sql);                    

                
                $respuestas = array();
                $conteo = array();
                if ($row5){
                    
                    $j=0;
                    foreach ($row5 as $list) {
                        // Revisar
                        $flag = false;

                        $valores = explode (',',$list->rcv_valor);
                        for($i=0;$i<count($valores);$i++) {
                            if($val2->ecl_valor== 'Otro'){
                                if ($valores[$i]!= ""){
                                    // Find Option
                                    $opcion = 'Otro';
                                    $respuestas[$j] = $opcion;

//                                        $respuestas[$indice] = $valor;
//                                        $respuestas[$j] = $valores[$i];
                                }
                                if ($valores[$i] == $val2->ecl_id){
                                    $otro = $valores[$i+1];
                                    $flag = true;
                                    break;
                                }                                    
                            }else{
                                if ($valores[$i]!= ""){
                                    // Find Option
                                    $opcion = $this->buscarOpcion($list->ecp_id, $valores[$i]);
                                    $respuestas[$j] = $opcion;
                                }
                                if ($valores[$i] == $val2->ecl_id){
                                    $flag = true;
                                    break;
                                }
                            }
                            $j++;
                        }
                        $j++;
                    }

                }

                // Lista de valores
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
                $row5 = $enccampo->dbselectBySQL($sql);                    
                if ($row5){
                    foreach ($row5 as $list) {                                            
                        $buscar = (array_keys($respuestas, $list->ecl_valor));
                        $contador = count($buscar);                        
                        // Ingresar datos a array  
                        if ($contador != 0){
                             $conteo[$list->ecl_valor] = $contador;
                        }
                        
                    }
                }                
                
                
                
                

                
                
              
                

                
            // RadioButton
            } else if ($val->ecp_tipdat == 'RadioButton') {
                if ($val->ecp_obl==1){
                    $option .="<tr><td>" . $val->egr_codigo . DELIMITER . $val->ecp_orden . " " . $val->ecp_eti . "<span class='error-requerid'>(*)</span></td>";
                }else{
                    $option .="<tr><td>" . $val->egr_codigo . DELIMITER . $val->ecp_orden . " " . $val->ecp_eti . "</td>";
                }
                $option .= "<td colspan='3'>";


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
                        WHERE tab_enccampo.ecp_id = $val->ecp_id
                        ORDER BY tab_rescampovalor.res_id,
                        tab_enccampo.egr_id,
                        tab_enccampo.ecp_orden ";
                $row5 = $enccampo->dbselectBySQL($sql);
                $respuestas = array();
                $conteo = array();
                if ($row5){
                    
                    $j=0;
                    foreach ($row5 as $list) {
                        // Revisar
                        $flag = false;

                        $valores = explode (',',$list->rcv_valor);
                        for($i=0;$i<count($valores);$i++) {
                            if($val2->ecl_valor== 'Otro'){
                                if ($valores[$i]!= ""){
                                    // Find Option
                                    $opcion = 'Otro';
                                    $respuestas[$j] = $opcion;
                                }
                                if ($valores[$i] == $val2->ecl_id){
                                    $otro = $valores[$i+1];
                                    $flag = true;
                                    break;
                                }                                    
                            }else{
                                if ($valores[$i]!= ""){
                                    // Find Option
                                    $opcion = $this->buscarOpcion($list->ecp_id, $valores[$i]);
                                    $respuestas[$j] = $opcion;
                                }
                                if ($valores[$i] == $val2->ecl_id){
                                    $flag = true;
                                    break;
                                }
                            }
                            $j++;
                        }
                        $j++;
                    }

                }

                // Lista de valores
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
                $row5 = $enccampo->dbselectBySQL($sql);                    
                if ($row5){
                    foreach ($row5 as $list) {                                            
                        $buscar = (array_keys($respuestas, $list->ecl_valor));
                        $contador = count($buscar);                        
                        // Ingresar datos a array  
                        if ($contador != 0){
                             $conteo[$list->ecl_valor] = $contador;
                        }
                        
                    }
                }
                
                
				
            } else {
                $respuestas = array();
                $conteo = array();                
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
                        WHERE tab_enccampo.ecp_id = $val->ecp_id
                        ORDER BY tab_enccampo.egr_id,
                        tab_enccampo.ecp_orden";                
                $rescampovalor = new tab_rescampovalor();
                $row5 = $rescampovalor->dbselectBySQL($sql);
                
                if ($val->ecp_tipdat == 'Numero' || $val->ecp_tipdat == 'Decimal') {
                    if ($row5){                    
                        $j=0;
                        foreach ($row5 as $list) {
                            $suma += $row5->rcv_valor;                             
                        }
                        $conteo["Total "] = $suma;
                    }                    
                }else{
                    if ($row5){                    
                        $j=0;
                        foreach ($row5 as $list) {
    //                        $respuestas[$j] = $row5->rcv_valor; 
                            $conteo[$row5->rcv_valor] = 1;
                        }
                    }
                }
                

            }

            
        }
        
        return $conteo;

        
    }
    
    
    
    function buscarOpcion ($ecp_id = null, $ecl_id = null){
       $opcion = "";
       $sql = "SELECT
                tab_enccampolista.ecl_id,
                tab_enccampolista.ecl_valor
                FROM
                tab_enccampolista
                WHERE tab_enccampolista.ecl_estado = '1'
                AND tab_enccampolista.ecp_id = '$ecp_id'
                AND tab_enccampolista.ecl_id = '$ecl_id'
                ORDER BY 
                tab_enccampolista.ecl_id ";        
        $enccampo = new tab_enccampo();
        $result = $enccampo->dbSelectBySQL($sql);
        foreach ($result as $row) {
            $opcion = $row->ecl_valor;
        }        
        return $opcion;        
    }
    
    
    
}

?>
