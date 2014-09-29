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
        
        if ($tiporeporte == 1) {
            require_once ('includes/libchart/classes/libchart.php'); 
            $chart = new PieChart();

            $dataSet = new XYDataSet();
            $dataSet->addPoint(new Point("Mozilla Firefox (10)", 10));
            $dataSet->addPoint(new Point("Konqueror (75)", 75));
            $dataSet->addPoint(new Point("Opera (50)", 50));
            $dataSet->addPoint(new Point("Safari (37)", 37));
            $dataSet->addPoint(new Point("Dillo (37)", 37));
            $dataSet->addPoint(new Point("Other (72)", 70));
            $chart->setDataSet($dataSet);

            $chart->setTitle("Pregunta 1");
            $chart->render("demo3.png");

//
//            $html = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";
//            $html .= "<html xmlns='http://www.w3.org/1999/xhtml'>";
//            $html .= "<head>";
//            $html .= 	"<title>Libchart pie chart demonstration</title>";
//            $html .= 	"<meta http-equiv='Content-Type' content='text/html; charset=ISO-8859-15' />";
//            $html .= "</head>";
//            $html .= "<body>";
//            $html .=	"<img alt='Pie chart'  src='demo3.png' style='border: 1px solid gray;' />";
//            $html .= "</body>";
//            $html .= "</html>";
            
            
        } else if ($tiporeporte == 2) {
            require_once ('includes/libchart/classes/libchart.php'); 

            $chart = new LineChart();

            $dataSet = new XYDataSet();
            $dataSet->addPoint(new Point("06-01", 273));
            $dataSet->addPoint(new Point("06-02", 421));
            $dataSet->addPoint(new Point("06-03", 642));
            $dataSet->addPoint(new Point("06-04", 799));
            $dataSet->addPoint(new Point("06-05", 1009));
            $dataSet->addPoint(new Point("06-06", 1406));
            $dataSet->addPoint(new Point("06-07", 1820));
            $dataSet->addPoint(new Point("06-08", 2511));
            $dataSet->addPoint(new Point("06-09", 2832));
            $dataSet->addPoint(new Point("06-10", 3550));
            $dataSet->addPoint(new Point("06-11", 4143));
            $dataSet->addPoint(new Point("06-12", 4715));
            $chart->setDataSet($dataSet);

            $chart->setTitle("Sales for 2006");
            $chart->render("demo3.png");          
            
            
        } else if ($tiporeporte == 3) {
            require_once ('includes/libchart/classes/libchart.php');

            $chart = new HorizontalBarChart(600, 170);

            $dataSet = new XYDataSet();
            $dataSet->addPoint(new Point("/wiki/Instant_messenger", 50));
            $dataSet->addPoint(new Point("/wiki/Web_Browser", 75));
            $dataSet->addPoint(new Point("/wiki/World_Wide_Web", 122));
            $chart->setDataSet($dataSet);
            $chart->getPlot()->setGraphPadding(new Padding(5, 30, 20, 140));

            $chart->setTitle("Most visited pages for www.example.com");
            $chart->render("demo3.png");  
            
        } else if ($tiporeporte == 4) {
            
            require_once ('includes/libchart/classes/libchart.php'); 

            $chart = new VerticalBarChart();

            $dataSet = new XYDataSet();
            $dataSet->addPoint(new Point("Jan 2005", 273));
            $dataSet->addPoint(new Point("Feb 2005", 421));
            $dataSet->addPoint(new Point("March 2005", 642));
            $dataSet->addPoint(new Point("April 2005", 800));
            $dataSet->addPoint(new Point("May 2005", 1200));
            $dataSet->addPoint(new Point("June 2005", 1500));
            $dataSet->addPoint(new Point("July 2005", 2600));
            $chart->setDataSet($dataSet);

            $chart->setTitle("Monthly usage for www.example.com");
            $chart->render("demo3.png");  
        
            
        } else if ($tiporeporte == 5) {
            // Excel
            
        }
        
        Header("Location: " . PATH_DOMAIN . "/imagen.html");

        
        
    }
    
    
    function loadAjaxPreguntas() {
        $enc_id = $_POST["Enc_id"];
        
        $sql = "SELECT
                tab_encuesta.enc_id,
                tab_encuesta.enc_codigo,
                tab_enccampo.ecp_id,
                tab_enccampo.ecp_orden,
                tab_enccampo.ecp_nombre,
                tab_enccampo.ecp_eti
                FROM
                tab_encuesta
                INNER JOIN tab_enccampo ON tab_encuesta.enc_id = tab_enccampo.enc_id
                WHERE tab_encuesta.enc_id =  '$enc_id'
                ORDER BY tab_enccampo.ecp_orden ";        
        
        $enccampo = new tab_enccampo();
        $result = $enccampo->dbSelectBySQL($sql);
        $res = array();
        foreach ($result as $row) {
            $res[$row->ecp_id] = $row->ecp_eti;
        }
        echo json_encode($res);
    }      
    
    
}

?>
