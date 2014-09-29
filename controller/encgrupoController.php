<?php

/**
 * encgrupoController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright DGGE
 * @version $Id$ 2014.04.14
 * @access public
 */
class encgrupoController extends baseController {

    function index() {
        $this->registry->template->egr_id = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        
        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('headerG');
        $this->registry->template->show('encuesta/tab_encgrupog.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $this->encgrupo = new tab_encgrupo ();
        $this->encgrupo->setRequest2Object($_REQUEST);
        $page = $_REQUEST ['page'];
        $rp = $_REQUEST ['rp'];
        $sortname = $_REQUEST ['sortname'];
        $sortorder = $_REQUEST ['sortorder'];
        if (!$sortname)
            $sortname = 'egr_id';
        if (!$sortorder)
            $sortorder = 'desc';
        $sort = "ORDER BY $sortname $sortorder";
        if (!$page)
            $page = 1;
        if (!$rp)
            $rp = 15;
        $start = (($page - 1) * $rp);
        $limit = "LIMIT $rp OFFSET $start ";
        $query = $_REQUEST ['query'];
        $qtype = $_REQUEST ['qtype'];
        $where = "";
        if ($query) {
            if ($qtype == 'egr_id')
                $where = " AND $qtype = '$query' ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }
        
        $sql = "SELECT * 
                FROM tab_encgrupo 
                WHERE egr_estado = 1 
                $where
                $sort 
                $limit ";        
        $result = $this->encgrupo->dbselectBySQL($sql);
        $total = $this->encgrupo->countBySQL("SELECT count(egr_id) 
                                        FROM tab_encgrupo 
                                        WHERE egr_estado = 1 
                                        $where");
        
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: text/x-json");
        
        $json = "";
        $json .= "{\n";
        $json .= "page: $page,\n";
        $json .= "total: $total,\n";
        $json .= "rows: [";
        $rc = false;
        $i = 0;
        foreach ($result as $un) {
            if ($rc)
                $json .= ",";
            $json .= "\n{";
            $json .= "id:'" . $un->egr_id . "',";
            $json .= "cell:['" . $un->egr_id . "'";
            $json .= ",'" . addslashes($un->egr_codigo) . "'";
            $json .= ",'" . addslashes($un->egr_nombre) . "'";            
            
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }
    
    function add() {
        $this->fondo = new fondo ();
        
        $this->registry->template->egr_id = "";
        $this->registry->template->egr_codigo = "";
        $this->registry->template->egr_nombre = "";        

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";

        
        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->titulo = "NUEVO ROL DE USUARIO";
        $this->registry->template->LIST_MENU = $this->menu->allMenu();
        
        $this->registry->template->show('headerF');
        $this->registry->template->show('encuesta/tab_encgrupo.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        
        $this->encgrupo = new tab_encgrupo ();
        $this->fondo = new tab_fondo ();
        $this->menu = new Tab_menu ();
        $this->usurolmenu = new Tab_usurolmenu ();

        $this->encgrupo->setRequest2Object($_REQUEST);
        $this->encgrupo->setEgr_codigo($_REQUEST ['egr_codigo']);
        $this->encgrupo->setEgr_nombre($_REQUEST ['egr_nombre']);
        $this->encgrupo->setEgr_estado(1);
        $idRol = $this->encgrupo->insert();

        //$this->usurolmenu->insert();
        Header("Location: " . PATH_DOMAIN . "/encgrupo/");
    }
    
    function edit() {
        Header("Location: " . PATH_DOMAIN . "/encgrupo/view/" . $_REQUEST ["egr_id"] . "/");
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->encgrupo = new Tab_encgrupo ();
        $this->encgrupo->setRequest2Object($_REQUEST);
        $row = $this->encgrupo->dbselectByField("egr_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row [0];
        $this->registry->template->titulo = "EDITAR ROL DE USUARIO";
        $this->registry->template->egr_id = $row->egr_id;
        $this->registry->template->egr_codigo = $row->egr_codigo;
        $this->registry->template->egr_nombre = $row->egr_nombre;        

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery";

        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;

        $this->registry->template->LIST_MENU = $this->menu->allMenuSeleccionado($row->egr_id);
        $this->registry->template->show('headerF');
        $this->registry->template->show('encuesta/tab_encgrupo.tpl');
        $this->registry->template->show('footer');
    }



    function update() {
        $this->encgrupo = new tab_encgrupo ();
        $this->encgrupo->setRequest2Object($_REQUEST);
        $this->encgrupo->setEgr_id($_REQUEST ['egr_id']);
        $this->encgrupo->setEgr_nombre($_REQUEST ['egr_nombre']);
        $this->encgrupo->setEgr_codigo($_REQUEST ['egr_codigo']);
        $this->encgrupo->update();

        Header("Location: " . PATH_DOMAIN . "/encgrupo/");
    }

    function delete() {
        $this->encgrupo = new tab_encgrupo ();
        $this->encgrupo->setRequest2Object($_REQUEST);
        $this->encgrupo->setEgr_id($_REQUEST ['egr_id']);
        $this->encgrupo->setEgr_estado(2);
        $this->encgrupo->update();
    }

    function verifyFields() {
        $encgrupo = new encgrupo ();
        $egr_codigo = trim($_POST['egr_codigo']);
        $Path_event = trim($_POST['Path_event']);
        if ($Path_event != 'update') {
            if ($rol->existeCodigo($egr_codigo)) {
                echo 'El c&oacute;digo ya existe, escriba otro.';
            }
            //if (strlen($uni_codigo) < 2 || strlen($uni_codigo) > 2) {
            //    echo 'El tama&ntilde;o debe de ser igual a 2.';
            //} 
            else {
                echo '';
            }
            } else {
                echo '';
            }
        }
        
    function verifCodigo() {
        $encgrupo = new encgrupo();
        $encgrupo->setRequest2Object($_REQUEST);
        $egr_codigo = trim($_POST['egr_codigo']);
        $Path_event = trim($_POST['Path_event']);
        if ($Path_event != 'update') {
            if ($encgrupo->existeCodigo($egr_codigo)) {
                echo 'El c&oacute;digo ya existe, escriba otro.';
            }
            else {
                echo '';
            }
        } else {
            echo '';
        }
    }
}
?>
