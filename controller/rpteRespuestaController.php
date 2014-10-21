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

class rpteRespuestaController Extends baseController {

    function index() {

        $encuesta = new encuesta();
        $enccampo = new enccampo();
        
        $usuario = new usuario();        
//        $this->registry->template->enc_id = $encuesta->obtenerSelectTodas();
        $this->registry->template->enc_id = $usuario->allencuestaSeleccionadoOption($_SESSION['USU_ID']);
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
        
        /* Establecer configuracion regional al espaniol */
        setlocale(LC_ALL, 'es_ES');

        $where = "";
        $enc_id = $_POST['enc_id'];
        $ecp_id = $_POST['ecp_id'];        
        $tiporeporte = $_POST['tiporeporte'];
        $imagen = "";
        
        if ($tiporeporte == 1) {
            # Pie Chart Label Types - Multi-part labels
            require_once ('includes/phplot.php');
            
            $enccampo = new enccampo ();
            $pregunta = $enccampo->obtenerPregunta($ecp_id);
            $muestra = $enccampo->obtenerNroEntidades($ecp_id);
            
            // Data Encuesta, Pregunta
            $data = array();
            $data = $this->obtenerRespuesta($enc_id, $ecp_id);
            
            # PHPlot Example: Pie Chart Label Types - Data array
            # This is used by several examples. The data is 'altered' for appearance.
            $title = utf8_decode("ENCUESTA - SOFTWARE LIBRE\n". $pregunta . "\nMuestra: " . $muestra . " entidades");

            function mycallback($str)
            {
                list($percent, $label) = explode(' ', $str, 2);
                return sprintf('%s (%.1f%%)', $label, $percent);
            }

            $plot = new PHPlot(1400, 1000);
            $plot->SetImageBorderType('plain'); // Improves presentation in the manual
            $plot->SetPlotType('pie');
            $plot->SetDataType('text-data-single');
            $plot->SetDataValues($data);
            $plot->SetTitle($title);
            # Set label type: combine 2 fields and pass to custom formatting function
            $plot->SetPieLabelType(array('percent', 'label'), 'custom', 'mycallback');
            $plot->DrawGraph();
            
        } else if ($tiporeporte == 2) {
            // Simple line graph
            require_once ('includes/phplot.php');
            
            $enccampo = new enccampo ();
            $pregunta = $enccampo->obtenerPregunta($ecp_id);
            $muestra = $enccampo->obtenerNroEntidades($ecp_id);
            
            // Data Encuesta, Pregunta
            $data = array();
            $data = $this->obtenerRespuesta($enc_id, $ecp_id);
            
            # PHPlot Example: Pie Chart Label Types - Data array
            # This is used by several examples. The data is 'altered' for appearance.
            $title = utf8_decode("ENCUESTA - SOFTWARE LIBRE\nPregunta: ". $pregunta . "\nMuestra: " . $muestra . " entidades");

            $plot = new PHPlot(1400, 1000);
            $plot->SetImageBorderType('plain');

            $plot->SetPlotType('pie');
            $plot->SetDataType('text-data-single');
            $plot->SetDataValues($data);

            # Set enough different colors;
            $plot->SetDataColors(array('red', 'green', 'blue', 'yellow', 'cyan',
                                    'magenta', 'brown', 'lavender', 'pink',
                                    'gray', 'orange'));
            
            # Main plot title:
            $plot->SetTitle("ENCUESTA - SOFTWARE LIBRE\n". $pregunta . "\nMuestra: " . $muestra . " entidades");

            # Build a legend from our data array.
            # Each call to SetLegend makes one line as "label: value".
            foreach ($data as $row)
              $plot->SetLegend(implode(': ', $row));
            # Place the legend in the upper left corner:
            $plot->SetLegendPixels(5, 5);

            $plot->DrawGraph();
            

        // Falta
        } else if ($tiporeporte == 3) {
            // Simple line graph
            require_once ('includes/phplot.php');
            
            $enccampo = new enccampo ();
            $pregunta = $enccampo->obtenerPregunta($ecp_id);
            $muestra = $enccampo->obtenerNroEntidades($ecp_id);
            
            // Data Encuesta, Pregunta
            $data = array();
            $data = $this->obtenerRespuesta($enc_id, $ecp_id, 1);
            
            # PHPlot Example: Pie Chart Label Types - Data array
            # This is used by several examples. The data is 'altered' for appearance.
            $title = utf8_decode("ENCUESTA - SOFTWARE LIBRE\nPregunta: ". $pregunta . "\nMuestra: " . $muestra . " entidades");

            $plot = new PHPlot(1200, 1000);
            $plot->SetImageBorderType('plain');

            $plot->SetPlotType('lines');
            $plot->SetDataType('data-data');
            $plot->SetDataValues($data);

            # Main plot title:
            $plot->SetTitle("ENCUESTA - SOFTWARE LIBRE\n". $pregunta . "\nMuestra: " . $muestra . " entidades");

            # Make sure Y axis starts at 0:
            $plot->SetPlotAreaWorld(NULL, 0, NULL, NULL);

            $plot->DrawGraph();
            
        // Falta
        } else if ($tiporeporte == 4) {
            # PHPlot Example: Bar chart, annual data
            require_once ('includes/phplot.php');
            
            $enccampo = new enccampo ();
            $pregunta = $enccampo->obtenerPregunta($ecp_id);
            $muestra = $enccampo->obtenerNroEntidades($ecp_id);
            
            // Data Encuesta, Pregunta
            $data = array();
            $data = $this->obtenerRespuesta($enc_id, $ecp_id);
            
            # PHPlot Example: Pie Chart Label Types - Data array
            # This is used by several examples. The data is 'altered' for appearance.
            $title = utf8_decode("ENCUESTA - SOFTWARE LIBRE\n". $pregunta . "\nMuestra: " . $muestra . " entidades");

            $plot = new PHPlot(1200, 800);
            $plot->SetImageBorderType('plain');

            $plot->SetPlotType('bars');
            $plot->SetDataType('text-data');
            $plot->SetDataValues($data);

            # Let's use a new color for these bars:
//            $plot->SetDataColors('blue');
            # No 3-D shading of the bars:
            $plot->SetShading(5);
            # Make a legend for the 3 data sets plotted:
            $plot->SetLegend(array(''));
            
            # Force bottom to Y=0 and set reasonable tick interval:
            $plot->SetPlotAreaWorld(NULL, 0, NULL, NULL);
            $plot->SetYTickIncrement(2);
            # Format the Y tick labels as numerics to get thousands separators:
            $plot->SetYLabelType('data');
            $plot->SetPrecisionY(0);

            # Main plot title:
            $plot->SetTitle('Opcion');
            # Y Axis title:
            $plot->SetYTitle('Cantidad');
            $plot->SetXTitle('Sistema'); // 
            //
            # Turn off X tick labels and ticks because they don't apply here:
            $plot->SetXTickLabelPos('none');
            $plot->SetXTickPos('none');

            $plot->DrawGraph();

        } else if ($tiporeporte == 5) {
            # PHPlot Example: Bar chart, 3 data sets, unshaded
            require_once ('includes/phplot.php');
            
            $enccampo = new enccampo ();
            $pregunta = $enccampo->obtenerPregunta($ecp_id);
            $muestra = $enccampo->obtenerNroEntidades($ecp_id);
            
            // Data Encuesta, Pregunta
            $data = array();
            $data = $this->obtenerRespuesta($enc_id, $ecp_id);
            
            # PHPlot Example: Pie Chart Label Types - Data array
            # This is used by several examples. The data is 'altered' for appearance.
            $title = utf8_decode("ENCUESTA - SOFTWARE LIBRE\n". $pregunta . "\nMuestra: " . $muestra . " entidades");

            $plot = new PHPlot(1200, 800);
            $plot->SetImageBorderType('plain');

            
            # Force bottom to Y=0 and set reasonable tick interval:
            $plot->SetPlotAreaWorld(NULL, 0, NULL, NULL);
            $plot->SetYTickIncrement(2);
            # Format the Y tick labels as numerics to get thousands separators:
            $plot->SetYLabelType('data');
            $plot->SetPrecisionY(0);
            
            
            
            $plot->SetPlotType('bars');
            $plot->SetDataType('text-data');
            $plot->SetDataValues($data);

            # Main plot title:
            $plot->SetTitle(utf8_decode("ENCUESTA - SOFTWARE LIBRE\n". $pregunta . "\nMuestra: " . $muestra . " entidades"));
            # Y Axis title:
            $plot->SetYTitle('Cantidad');
            $plot->SetXTitle('Sistema'); // 
            
            # No 3-D shading of the bars:
            $plot->SetShading(0);

            # Make a legend for the 3 data sets plotted:
            $plot->SetLegend(array('Cantidad'));

            # Turn off X tick labels and ticks because they don't apply here:
            $plot->SetXTickLabelPos('none');
            $plot->SetXTickPos('none');

            $plot->DrawGraph();            

        // Horizontal    
        } else if ($tiporeporte == 6) {            
            # PHPlot Example - Horizontal Bars
            require_once ('includes/phplot.php');
            
            $enccampo = new enccampo ();
            $pregunta = $enccampo->obtenerPregunta($ecp_id);
            $muestra = $enccampo->obtenerNroEntidades($ecp_id);
            
            // Data Encuesta, Pregunta
            $data = array();
            $data = $this->obtenerRespuesta($enc_id, $ecp_id);
            

            $plot = new PHPlot(1200, 800);
            $plot->SetImageBorderType('plain'); // Improves presentation in the manual
            $plot->SetTitle(utf8_decode("ENCUESTA - SOFTWARE LIBRE\n". $pregunta . "\nMuestra: " . $muestra . " entidades"));
            $plot->SetXTitle('Cantidad'); // 
            $plot->SetYTitle('Sistema'); // 
            $plot->SetBackgroundColor('white');
            #  Set a tiled background image:
            #  Force the X axis range to start at 0:
            $plot->SetPlotAreaWorld(0);
            #  No ticks along Y axis, just bar labels:
            $plot->SetYTickPos('none');
            #  No ticks along X axis:
            $plot->SetXTickPos('none');
            #  No X axis labels. The data values labels are sufficient.
            $plot->SetXTickLabelPos('none');
            #  Turn on the data value labels:
            $plot->SetXDataLabelPos('plotin');
            #  No grid lines are needed:
            $plot->SetDrawXGrid(FALSE);
            #  Set the bar fill color:
//            $plot->SetDataColors('blue');
            #  Use less 3D shading on the bars:
            $plot->SetShading(2);
            $plot->SetDataValues($data);
            $plot->SetDataType('text-data-yx');
            $plot->SetPlotType('bars');
            $plot->DrawGraph();

        // Horizontal    
        } else if ($tiporeporte == 7) {            
            # PHPlot Example - Horizontal Bars unshaded
            require_once ('includes/phplot.php');
            
            $enccampo = new enccampo ();
            $pregunta = $enccampo->obtenerPregunta($ecp_id);
            $muestra = $enccampo->obtenerNroEntidades($ecp_id);
            
            // Data Encuesta, Pregunta
            $data = array();
            $data = $this->obtenerRespuesta($enc_id, $ecp_id);
            

            $plot = new PHPlot(1200, 800);
            $plot->SetImageBorderType('plain'); // Improves presentation in the manual
            $plot->SetTitle(utf8_decode("ENCUESTA - SOFTWARE LIBRE\n". $pregunta . "\nMuestra: " . $muestra . " entidades"));
            $plot->SetXTitle('Cantidad'); // 
            $plot->SetYTitle('Sistema'); // 
            $plot->SetBackgroundColor('white');
            #  Set a tiled background image:
            #  Force the X axis range to start at 0:
            $plot->SetPlotAreaWorld(0);
            #  No ticks along Y axis, just bar labels:
            $plot->SetYTickPos('none');
            #  No ticks along X axis:
            $plot->SetXTickPos('none');
            #  No X axis labels. The data values labels are sufficient.
            $plot->SetXTickLabelPos('none');
            #  Turn on the data value labels:
            $plot->SetXDataLabelPos('plotin');
            #  No grid lines are needed:
            $plot->SetDrawXGrid(FALSE);
            #  Set the bar fill color:
//            $plot->SetDataColors('blue');
            #  Use less 3D shading on the bars:
            $plot->SetShading(0);
            $plot->SetDataValues($data);
            $plot->SetDataType('text-data-yx');
            $plot->SetPlotType('bars');
            $plot->DrawGraph();
            
        } else if ($tiporeporte == 8) {
            
            # PHPlot example - horizontal thinbarline plot (impulse plot)
            require_once ('includes/phplot.php');
            
            $enccampo = new enccampo ();
            $pregunta = $enccampo->obtenerPregunta($ecp_id);
            $muestra = $enccampo->obtenerNroEntidades($ecp_id);
            
            // Data Encuesta, Pregunta
            $data = array();
            $data = $this->obtenerRespuesta($enc_id, $ecp_id, 1);
            
            $plot = new PHPlot(1000, 800);
            $plot->SetImageBorderType('plain'); // Improves presentation in the manual
            $plot->SetUseTTF(True);
            $plot->SetTitle(utf8_decode("ENCUESTA - SOFTWARE LIBRE\n". $pregunta . "\nMuestra: " . $muestra . " entidades"));
            $plot->SetXTitle('Cantidad'); // 179=superscript 3
            $plot->SetYTitle('Software'); // 176=degrees
            $plot->SetPlotType('thinbarline');
            $plot->SetDataType('data-data-yx');
            $plot->SetDataValues($data);
            $plot->SetPlotAreaWorld(0, 0, 20, 100);
            $plot->SetLineWidths(4);
            $plot->DrawGraph();
        
        } else if ($tiporeporte == 9) {
            
            # PHPlot Example: Linepoints plot with Data Value Labels
            require_once ('includes/phplot.php');
            
            $enccampo = new enccampo ();
            $pregunta = $enccampo->obtenerPregunta($ecp_id);
            $muestra = $enccampo->obtenerNroEntidades($ecp_id);
            
            // Data Encuesta, Pregunta
            $data = array();
            $data = $this->obtenerRespuesta($enc_id, $ecp_id);
            
            // Line Graph

            $plot = new PHPlot(1200, 1000);
            $plot->SetImageBorderType('plain'); // Improves presentation in the manual
            $plot->SetPlotType('linepoints');
            $plot->SetDataType('text-data');
            $plot->SetDataValues($data);
            $plot->SetTitle(utf8_decode("ENCUESTA - SOFTWARE LIBRE\n". $pregunta . "\nMuestra: " . $muestra . " entidades"));
            
            # Turn on Y data labels:
            $plot->SetYDataLabelPos('plotin');

            # Turn on X data label lines (drawn from X axis up to data point):
            $plot->SetDrawXDataLabelLines(True);

            # With Y data labels, we don't need Y ticks, Y tick labels, or grid lines.
            $plot->SetYTickLabelPos('none');
            $plot->SetYTickPos('none');
            $plot->SetDrawYGrid(False);
            # X tick marks are meaningless with this data:
            $plot->SetXTickPos('none');
            $plot->SetXTickLabelPos('none');

            $plot->DrawGraph();
            
        } else if ($tiporeporte == 10) {
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
            $cadena .= "Pregunta: " . utf8_decode($pregunta);
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
            $cadena .= '<td width="60%" align="left"><span style="font-family: helvetica; font-size: 11px;font-weight: bold;">Titulo (Id.)</span></td>';
            $cadena .= '<td width="35%" align="left"><span style="font-family: helvetica; font-size: 11px;font-weight: bold;">Cantidad</span></td>';
            $cadena .= '</tr>';

            
            // Data Encuesta, Pregunta
            $options = $this->obtenerRespuesta($enc_id, $ecp_id);
            $i=1;
            
            foreach($options as $option)
            {
                // Data
                $cadena .= '<tr bgcolor="FFFFFF">';
                $cadena .= '<td width="5%" align="center"><span style="font-family: helvetica; font-size: 11px;">' . $i . '</span></td>';
                $cadena .= '<td width="60%" align="left"><span style="font-family: helvetica; font-size: 11px;">' . $option[0] . '</span></td>';
                $cadena .= '<td width="35%" align="left"><span style="font-family: helvetica; font-size: 11px;">' . $option[1] . '</span></td>';
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
        
        
        if ($tiporeporte == 10) {
            echo $cadena;
        }else{
            $this->registry->template->imagen = $imagen;
            $this->registry->template->show('imagen.tpl');            
        }      
    }
    
    
    

    function obtenerRespuesta($enc_id = null, $ecp_id = null, $parameters = null) {
        
        $enccampo = new tab_enccampo ();
        $enccampolista = new tab_enccampolista ();
                
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
                            if (!$parameters){
                                $conteo[] = array($list->ecl_valor, $contador);
                            }else{
                                $conteo[] = array("''", $list->ecl_valor, $contador);
                            }                            
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
                            if (!$parameters){
                                $conteo[] = array($list->ecl_valor, $contador);
                            }else{
                                $conteo[] = array("''", $list->ecl_valor, $contador);
                            }
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
                            if (!$parameters){
                                $conteo[] = array($list->ecl_valor, $contador);
                            }else{
                                $conteo[] = array("''", $list->ecl_valor, $contador);
                            }                            
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
                        AND tab_rescampovalor.rcv_valor <> ''
                        ORDER BY tab_rescampovalor.res_id ";                
                $rescampovalor = new tab_rescampovalor();
                $row5 = $rescampovalor->dbselectBySQL($sql);
                
                //
                $unidad = new unidad ();
                if ($val->ecp_tipdat == 'Numero' || $val->ecp_tipdat == 'Decimal') {
                    if ($row5){                    
                        $j=0;
                        foreach ($row5 as $list) {
                            // Buscar id entidad
                            $uni_id = $unidad->buscarIdUnidad($list->res_id);
                            if ($uni_id!=0) $conteo[] = array($uni_id, $list->rcv_valor);
                            //$suma += $list->rcv_valor;                             
                        }
//                        $conteo["Total "] = $suma;
                        
                        
                    }                    
                }else{
                    if ($row5){                    
                        $j=0;
                        foreach ($row5 as $list) {    
//                            $conteo[$row5->rcv_valor] = 1;
                            if (!$parameters){
                                $conteo[] = array($list->rcv_valor, 1);
                            }else{
                                $conteo[] = array("''", $list->rcv_valor, 1);
                            }                            
                            
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
    
    
}

?>
