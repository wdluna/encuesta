<?php

/**
 * loginController
 *
 * @package
 * @author lic. castellon
 * @copyright DGGE
 * @version $Id$ 2014.04.24
 * @access public
 */
class loginController extends baseController {

    function index() {
        if (!isset($_REQUEST ['user']) || !isset($_REQUEST ['pass'])) {
            Header("Location: " . PATH_DOMAIN . "/");
        }
        $this->user = new usuario ();
        $this->departamento = new departamento ();
        $this->unidad = new unidad ();
        $this->user->setRequest2Object($_REQUEST);
        if ($this->user->buscarUsuario($_REQUEST ['user'], md5($_REQUEST ['pass'])) == true) {
            $row = $this->user->obtenerDatosUsuario($_REQUEST ['user'], md5($_REQUEST ['pass']));
            $urm = new usurolmenu ();
            $privilegios = $urm->obtenerPrivilegiosUsuario($row->rol_id);
            $_SESSION ['USU_ID'] = $row->usu_id;
            $_SESSION ['USU_NOMBRES'] = $row->usu_nombres;
            $_SESSION ['USU_APELLIDOS'] = $row->usu_apellidos;
            $_SESSION ["USU_PRIVILEGIOS"] = serialize($privilegios);
            $_SESSION ['UNI_ID'] = $row->uni_id;  
            //$_SESSION ['UNI_DESCRIPCION'] = $row->uni_descripcion;
            $_SESSION ["ROL_COD"] = $row->rol_cod;
            $_SESSION ["ROL"] = $row->rol_descripcion;
            $_SESSION ["USU_ROL"] = $row->rol_id;
            $_SESSION ["USU_LOGIN"] = $row->usu_login;
            $_SESSION ["SER_ID"] = "";
            // State code
            $row2 = $this->departamento->obtenerDatosDepartamento($_REQUEST ['user'], md5($_REQUEST ['pass']));
            $_SESSION ["DEP_CODIGO"] = $row2->dep_codigo;
            $_SESSION ["DEP_NOMBRE"] = $row2->dep_nombre;
            // Unity Code
            $row3 = $this->unidad->obtenerDatosUnidad($_REQUEST ['user'], md5($_REQUEST ['pass']));
            $_SESSION ["UNI_CODIGO"] = $row3->uni_codigo;
            $_SESSION ["UNI_DESCRIPCION"] = $row3->uni_descripcion;

            Header("Location: " . PATH_DOMAIN . "/login/show/");

        } else {
            Header("Location: " . PATH_DOMAIN . "/login/error/");
        }
    }

    function error() {
        $this->registry->template->nivel = '';
        $this->registry->template->inventario = 'inventario';
        $this->registry->template->prestamos = 'prestamos';
        $this->registry->template->observaciones = "Usuario y/o contrase&ntilde;a incorrecta.";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "login";
        $this->registry->template->show('index.tpl');
    }

    function show() {
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->observaciones = "";
        $this->registry->template->PATH_EVENT = "";
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu('', $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
//        $this->encuesta = new encuesta ();
        $this->usuario = new usuario ();
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->show('headerG');
	}

    function load() {
        $encuesta = new tab_respuesta ();
        $encuesta->setRequest2Object($_REQUEST);
        $usuario = new usuario ();
        $page = $_REQUEST ['page'];
        $rp = $_REQUEST ['rp'];
        $sortname = $_REQUEST ['sortname'];
        $sortorder = $_REQUEST ['sortorder'];
        if (!$sortname)
            $sortname = 'uni_id';
        if (!$sortorder)
            $sortorder = 'desc';
        $sort = "ORDER BY $sortname $sortorder";
        if (!$page)
            $page = 1;
        if (!$rp)
            $rp = 15;
        $start = (($page - 1) * $rp);
        $limit = "LIMIT $rp OFFSET $start ";
        //
        $query = $_REQUEST ['query'];
        $qtype = $_REQUEST ['qtype'];
        $where = "";
        $tipo = $usuario->getTipo($_SESSION ['USU_ID']);
        $where = "";
        if ($query != "") {
            if ($qtype == 'uni_id')
                $where .= " and uni_id LIKE '$query' ";
            elseif ($qtype == 'usu_nombres')
                $where .= " and usu_nombres LIKE '%$query%' ";
            else
                $where .= " and $qtype LIKE '%$query%' ";
        }

        $sql = "SELECT (SELECT tab_unidad.uni_id FROM tab_unidad WHERE  tab_unidad.uni_id = tab_usuario.uni_id) AS uni_id, tab_usuario.usu_nombres, tab_usuario.usu_apellidos, tab_encuesta.ser_categoria, tab_encuesta.ser_id, tab_usuario.usu_id, tab_encuesta.ser_tipo
                FROM tab_usuario Inner Join tab_usu_encuesta ON tab_usuario.usu_id = tab_usu_encuesta.usu_id Inner Join tab_encuesta ON tab_usu_encuesta.ser_id = tab_encuesta.ser_id
                WHERE tab_usuario.usu_estado = '1' AND tab_usu_encuesta.use_estado = '1' AND tab_encuesta.ser_estado = '1' $where $sort $limit";
        
        $sql2 = "SELECT (SELECT tab_unidad.uni_id FROM tab_unidad WHERE  tab_unidad.uni_id = tab_usuario.uni_id) AS uni_id, tab_usuario.usu_nombres, tab_usuario.usu_apellidos, tab_encuesta.ser_categoria, tab_usuario.usu_id, tab_encuesta.ser_id, tab_encuesta.ser_tipo
                FROM tab_usuario Inner Join tab_usu_encuesta ON tab_usuario.usu_id = tab_usu_encuesta.usu_id Inner Join tab_encuesta ON tab_usu_encuesta.ser_id = tab_encuesta.ser_id
                WHERE tab_usuario.usu_estado =  '1' AND tab_usu_encuesta.use_estado =  '1' AND tab_encuesta.ser_estado =  '1'";
        $exp = new encuesta ();
        $total = $encuesta->dbSelectBySQL($sql2);
        $total = count($total);
        $result = $encuesta->dbSelectBySQL($sql);
        
        // Header
        header ( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
        header ( "Cache-Control: no-cache, must-revalidate" );
        header ( "Pragma: no-cache" );
        header("Content-type: text/x-json");
        $json = "";
        $json .= "{\n";
        $json .= "page: $page,\n";
        $json .= "total: $total,\n";
        $json .= "rows: [";
        $rc = false;
        $i = 0;
        $expusu = new tab_encusuario();
        foreach ($result as $un) {
            if ($rc)
                $json .= ",";
            $ser_id = $un->ser_id;
            $usu_id = $un->usu_id;

            // REVISED: CASTELLON
            // NUMBER EXPEDIENTS USER
            $sql = "SELECT count(tab_encusuario.eus_id) as con
                    FROM tab_respuesta Inner Join tab_encusuario ON tab_respuesta.exp_id = tab_encusuario.exp_id
                    WHERE tab_respuesta.exp_estado =  '1' AND tab_encusuario.eus_estado = '1' AND tab_respuesta.ser_id = '$ser_id' AND tab_encusuario.usu_id = '$usu_id'";
            $count = $encuesta->dbSelectBySQL($sql);
            $count = $count[0];

            $sDate = date("Y-m-d", time() + 0 * 24 * 60 * 60);
            //include 'includes/init.php';
            $sql = "SELECT tab_usuario.usu_login, tab_expfondo.exf_id, tab_expfondo.exp_id, tab_expfondo.fon_id, tab_expfondo.exf_fecha_exi, tab_expfondo.exf_fecha_exf, tab_usuario.usu_login, tab_respuesta.ser_id
                    FROM tab_expfondo Inner Join tab_encusuario ON tab_expfondo.exp_id = tab_encusuario.exp_id Inner Join tab_usuario ON tab_encusuario.usu_id = tab_usuario.usu_id Inner Join tab_respuesta ON tab_expfondo.exp_id = tab_respuesta.exp_id
                    WHERE tab_expfondo.fon_id =  '1' AND tab_expfondo.exf_estado =  '1' AND tab_expfondo.exf_fecha_exf <= '$sDate' AND tab_usuario.usu_estado =  '1' AND tab_respuesta.ser_id = '$ser_id' AND tab_respuesta.exp_estado =  '1' AND tab_usuario.usu_id = '$usu_id'
                    ORDER BY tab_expfondo.exf_fecha_exf ASC";
            $countF = $encuesta->dbSelectBySQL($sql);
            if (count($countF)) {
                $countF = $countF[0];
                $countF = $countF->conf;
            } else {
                $countF = 0;
            }
            $json .= "\n{";
            $json .= "id:'" . $un->uni_id . "',";
            $json .= "cell:['" . $un->uni_id . "'";
            $json .= ",'" . addslashes($un->usu_nombres) . "'";
            $json .= ",'" . addslashes($un->usu_apellidos) . "'";
            $json .= ",'" . addslashes($un->ser_categoria) . "'";
            $json .= ",'" . addslashes($un->ser_tipo) . "'";
            $json .= ",'" . addslashes($count->con) . "'";
            $json .= ",'" . addslashes($countF) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function logout() {
        $this->user = new usuario ();
        $this->user->setRequest2Object($_REQUEST);
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_EVENT = "login";
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        if (isset($_COOKIE [session_name()])) {
            setcookie(session_name(), '', time() - 300);
        }
        session_destroy();
        Header("Location: " . PATH_DOMAIN . "/");
    }

    function add() {
        $this->rol = new tab_rol ();
        $this->rol->setRequest2Object($_REQUEST);
        $this->rol->setRol_id = $_REQUEST ['rol_id'];
        $this->rol->setRol_titulo = $_REQUEST ['rol_titulo'];
        $this->rol->setRol_descripcion = $_REQUEST ['rol_descripcion'];
        $this->rol->setRol_cod = $_REQUEST ['rol_cod'];
        $this->rol->setRol_fecha_crea = $_REQUEST ['rol_fecha_crea'];
        $this->rol->setRol_fecha_mod = $_REQUEST ['rol_fecha_mod'];
        $this->rol->setRol_usuario_crea = $_REQUEST ['rol_usuario_crea'];
        $this->rol->setRol_usuario_mod = $_REQUEST ['rol_usuario_mod'];
        $this->rol->setRol_estado = 1;

        $this->rol->insert();
        Header("Location: " . PATH_DOMAIN . "/rol/");
    }

    function update() {
        $this->rol = new tab_rol ();
        $this->rol->setRequest2Object($_REQUEST);
        $this->rol->setRol_id = $_REQUEST ['rol_id'];
        $this->rol->setRol_titulo = $_REQUEST ['rol_titulo'];
        $this->rol->setRol_descripcion = $_REQUEST ['rol_descripcion'];
        $this->rol->setRol_cod = $_REQUEST ['rol_cod'];
        $this->rol->setRol_fecha_crea = $_REQUEST ['rol_fecha_crea'];
        $this->rol->setRol_fecha_mod = $_REQUEST ['rol_fecha_mod'];
        $this->rol->setRol_usuario_crea = $_REQUEST ['rol_usuario_crea'];
        $this->rol->setRol_usuario_mod = $_REQUEST ['rol_usuario_mod'];
        $this->rol->setRol_estado = $_REQUEST ['rol_estado'];

        $this->rol->update();
        Header("Location: " . PATH_DOMAIN . "/rol/");
    }

    function delete() {
        $this->rol = new tab_rol ();
        $this->rol->setRequest2Object($_REQUEST);
        $this->rol->setRol_id($_REQUEST ['rol_id']);
        $this->rol->setRol_estado(2);

        $this->rol->update();
    }

    function recepcion() {
        $url = explode('/', $_SERVER ['REQUEST_URI']);
    }

}

?>
