<?php

/**
 * respuestaController
 *
 * @package
 * @author lic. castellon
 * @copyright DGGE
 * @version $Id$ 2014.04.14
 * @access public
 */
class respuestaController Extends baseController {

    function index() {
        if (isset($_REQUEST['enc_id'])) {
            $this->registry->template->enc_id = $_REQUEST['enc_id'];
            $_SESSION ['ENC_ID'] = $_REQUEST['enc_id'];
            // New
            $this->registry->template->enc_id = $_REQUEST['enc_id'];
        } else {
            $this->registry->template->enc_id = 0;
        }

        // Admin user
        $usuario = new usuario();
        $adm = $usuario->esAdm();
        $this->registry->template->adm = $adm;
        $rol = $_SESSION ["ROL_COD"];
        $this->registry->template->rol = $rol;
        
        // Answer count
        $respuesta = new respuesta();
        $total = $respuesta->contRespuestas ();
        $this->registry->template->total = $total;
        
        $this->registry->template->res_id = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";

        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('headerG');
        $this->registry->template->show('respuesta/tab_respuestag.tpl');
        $this->registry->template->show('footer');
    }


    function load() {


        $this->tab_respuesta = new tab_respuesta ();
        $this->tab_respuesta->setRequest2Object($_REQUEST);
               
        $page = $_REQUEST ['page'];
        $rp = $_REQUEST ['rp'];
        $sortname = $_REQUEST ['sortname'];
        $sortorder = $_REQUEST ['sortorder'];
        if (!$sortname) {
            $sortname = " tab_encuesta.enc_id,
                tab_respuesta.res_id ";
        } else {
            if ($sortname=='encargado'){
                $sortname = " tab_usuario.usu_nombres, tab_usuario.usu_apellidos ";
            }else if ($sortname=='dias'){
                $sortname = " tab_encuesta.enc_id,
                tab_respuesta.res_id ";
            }else if ($sortname=='avance'){
                $sortname = " tab_encuesta.enc_id,
                tab_respuesta.res_id ";
            }else {
                $sortname = $sortname;
            }
        }
        if (!$sortorder)
            $sortorder = 'desc';
        $sort = "ORDER BY $sortname $sortorder";
        if (!$page)
            $page = 1;
        if (!$rp)
            $rp = 15;
        $start = (($page - 1) * $rp);
        $limit = "LIMIT $rp OFFSET $start ";
        $query = strtoupper(trim($_REQUEST ['query']));
        $qtype = $_REQUEST ['qtype'];

        $where = "";
        if ($query != "") {
            $_SESSION ["ENC_ID"] = null;
            if ($qtype == 'res_id')
                $where .= " and tab_respuesta.res_id = '$query' ";
            elseif ($qtype == 'res_titulo')
                $where .= " and tab_respuesta.res_titulo LIKE '%$query%' ";
            elseif ($qtype == 'res_estado'){
                $estado;
                if ($query=='ABIERTA') {
                    $estado=1;
                }else{
                    $estado=2;
                }
                $where .= " and tab_respuesta.res_estado = '$estado' ";
            }elseif ($qtype == 'uni_descripcion')
                $where .= " and tab_unidad.uni_codigo LIKE '%$query%' ";
            elseif ($qtype == 'encargado') {
                $nomArray = explode(" ", $query);
                if ($nomArray[1]){
                    $where .= " and (tab_usuario.usu_nombres LIKE '%$nomArray[0]%' OR tab_usuario.usu_apellidos LIKE '%$nomArray[1]%') ";
                }else{
                    $where .= " and (tab_usuario.usu_nombres LIKE '%$nomArray[0]%') ";
                }    
                   
            } else
                $where .= " and $qtype LIKE '%$query%' ";
        }else {
            // Serie
            if (VAR3) {
                $_SESSION ["ENC_ID"] = VAR3;
            }
        }

        //if ($_SESSION ["ROL_COD"] == 'ADM' ) {
        if ($_SESSION ["ROL_COD"] == 'ENC') {
            $where .= " AND tab_usuario.usu_id ='" . $_SESSION['USU_ID'] . "' ";
        } 
        
        
        
        $sql = "SELECT
                tab_unidad.uni_codigo,
                tab_unidad.uni_descripcion,
                tab_respuesta.res_id,
                tab_encuesta.enc_id,
                tab_encuesta.enc_par,
                tab_encuesta.enc_codigo,
                tab_encuesta.enc_categoria,
                tab_encuesta.enc_fecpub,
                tab_encuesta.enc_feccie,
                tab_respuesta.res_codigo,
                tab_respuesta.res_titulo,
                CASE WHEN tab_respuesta.res_estado=1 THEN 'ABIERTA' ELSE 'CERRADA' END AS res_estado,
                tab_usuario.usu_id,
                tab_usuario.usu_nombres,
                tab_usuario.usu_apellidos,
                tab_usuario.usu_fono,
                tab_usuario.usu_email
                FROM
                tab_usuario
                INNER JOIN tab_encusuario ON tab_usuario.usu_id = tab_encusuario.usu_id
                INNER JOIN tab_respuesta ON tab_encusuario.res_id = tab_respuesta.res_id
                INNER JOIN tab_encuesta ON tab_respuesta.enc_id = tab_encuesta.enc_id
                INNER JOIN tab_unidad ON tab_unidad.uni_id = tab_usuario.uni_id
                WHERE
                tab_encuesta.enc_estado = 1 AND
                (tab_respuesta.res_estado = 1 OR
                tab_respuesta.res_estado = 2) AND
                tab_encusuario.eus_estado = 1
                $where
                $sort
                $limit ";

        $result = $this->tab_respuesta->dbSelectBySQL($sql);
        $total = $this->tab_respuesta->countBySQL("SELECT count (tab_respuesta.res_id)
                                                FROM
                                                tab_usuario
                                                INNER JOIN tab_encusuario ON tab_usuario.usu_id = tab_encusuario.usu_id
                                                INNER JOIN tab_respuesta ON tab_encusuario.res_id = tab_respuesta.res_id
                                                INNER JOIN tab_encuesta ON tab_respuesta.enc_id = tab_encuesta.enc_id
                                                INNER JOIN tab_unidad ON tab_unidad.uni_id = tab_usuario.uni_id
                                                WHERE
                                                tab_encuesta.enc_estado = 1 AND
                                                (tab_respuesta.res_estado = 1 OR
                                                tab_respuesta.res_estado = 2) AND
                                                tab_encusuario.eus_estado = 1
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
            // Count
            $contador = $this->estadoCuestionario($un->enc_id, $un->res_id);            
            
            if ($rc)
                $json .= ",";
            $json .= "\n{";
            $json .= "id:'" . $un->res_id . "',";
            
//            if ($contador == 0){
//                $json .= "cell:['" . '<font color=#B22222>' . $un->res_id . "'";
//                $json .= ",'<font color=#B22222>" . addslashes($un->uni_descripcion) . "'";
//            }else{
                $json .= "cell:['" . $un->res_id . "'";            
                $json .= ",'" . addslashes($un->uni_descripcion) . "'";
//            }           
            $json .= ",'" . addslashes($un->enc_categoria) . "'";  
            $json .= ",'" . addslashes($un->enc_fecpub) . "'";
            $json .= ",'" . addslashes($un->enc_feccie) . "'";
            // Dias
            $fechaactual = date("Y-m-d");
            $dias = (strtotime($un->enc_feccie)-strtotime($fechaactual))/86400;            
            $json .= ",'" . addslashes($un->res_estado) . "'";
//            $json .= ",'" . addslashes($dias) . " d." . "'";
            
//            if ($contador == 0){
//                $json .= ",'<font color=#B22222>" . addslashes($contador) . " %" . "'";
//            }else{
                $json .= ",'" . addslashes($contador) . " %" . "'";
//            }
            
            $json .= ",'" . addslashes($un->usu_nombres . ' ' . $un->usu_apellidos) . "'";
//            $json .= ",'" . addslashes($un->usu_fono) . "'";
//            $json .= ",'" . addslashes($un->usu_email) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {
        // Code
        $enc_id = $_SESSION['ENC_ID'];
        $encuesta = new encuesta();
        if ($_SESSION['ENC_ID']) {
            $this->registry->template->enc_codigo = $encuesta->obtenerCodigoSerie($_SESSION['ENC_ID']);
            $this->registry->template->uni_descripcion = $encuesta->obtenerSeccionSerie($_SESSION['ENC_ID']);
            $uni_id = $encuesta->obtenerSeccionIdSerie($_SESSION['ENC_ID']);
            $this->registry->template->encuesta = $encuesta->obtenerSelectSeccionDefault($_SESSION['USU_ID'], $uni_id, $_SESSION['ENC_ID']);
        } else {
            $this->registry->template->enc_codigo = "";
            $this->registry->template->uni_descripcion = "";
            $uni_id = 0;
            $this->registry->template->encuesta = $encuesta->obtenerSelectDefault($_SESSION['USU_ID'], $_SESSION['ENC_ID']);
        }

        $this->registry->template->res_id = "";
        $this->registry->template->res_codigo = "DGGE";
        $this->registry->template->res_titulo = "TITULO ENCUESTA";
        $this->registry->template->msm = "";

        
        // Dynamic fields
        $enccampo = new enccampo();
        $this->registry->template->enccampo = $enccampo->obtenerSelectCampos($enc_id);


        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;

        $this->registry->template->titulo = "AGREGAR ENCUESTA";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";

        $this->registry->template->show('headerG');
        $this->registry->template->show('respuesta/tab_respuesta.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        // Save respuesta
        $this->respuesta = new tab_respuesta();
        $this->respuesta->setRequest2Object($_REQUEST);
        $this->respuesta->setRes_id($_REQUEST['res_id']);
        $this->respuesta->setEnc_id($_REQUEST['enc_id']);
        $this->respuesta->setRes_codigo($_REQUEST['res_codigo']);        
        $this->respuesta->setRes_titulo($_REQUEST['res_titulo']);
        $this->respuesta->setRes_estado(1);
        $res_id = $this->respuesta->insert();


        // Save encusuario data
        $this->encusuario = new tab_encusuario();
        $this->encusuario->eus_id = '';        
        $this->encusuario->usu_id = $_SESSION['USU_ID'];
        $this->encusuario->res_id = $res_id;
        $this->encusuario->eus_estado = '1';
        $this->encusuario->insert();

        // Save data dynamic
        $enccampo = new enccampo();
        $row = $enccampo->obtenerCampos($_REQUEST['enc_id']);
        if (count($row) > 0) {
            foreach ($row as $val) {
                if ($val->ecp_tipdat == 'Lista') {
                    $ecp_id = $val->ecp_id;
                    $rcv_valor = $_REQUEST[$ecp_id];
                    $this->rescampovalor = new tab_rescampovalor();
                    $this->rescampovalor->setRes_id($res_id);
                    $this->rescampovalor->setEcp_id($ecp_id);
                    $this->rescampovalor->setEcl_id($rcv_valor);
                    $this->rescampovalor->setRcv_valor($rcv_valor);
                    $this->rescampovalor->setRcv_estado(1);
                    $this->rescampovalor->insert();
                // CheckBox
                }else if ($val->ecp_tipdat == 'CheckBox') {
                    $ecp_id = $val->ecp_id;                    
                    if (isset($_REQUEST['rcv_valorC'])) {
                        $valores = $_REQUEST['rcv_valorC'];
                        // Codificar
                        $rcv_valor = "";
                        foreach ($valores as $valor) {
                            $rcv_valor .= $valor . ",";
                        }
                    }                    
                    
                    $this->rescampovalor = new tab_rescampovalor();
                    $this->rescampovalor->setRes_id($res_id);
                    $this->rescampovalor->setEcp_id($ecp_id);
                    $this->rescampovalor->setEcl_id(1);
                    $this->rescampovalor->setRcv_valor($rcv_valor);
                    $this->rescampovalor->setRcv_estado(1);
                    $this->rescampovalor->insert();
                
                // RadioButton
                }else if ($val->ecp_tipdat == 'RadioButton') {
                    $ecp_id = $val->ecp_id;
                    $rcv_valor = $_REQUEST['rcv_valor'];
                    $this->rescampovalor = new tab_rescampovalor();
                    $this->rescampovalor->setRes_id($res_id);
                    $this->rescampovalor->setEcp_id($ecp_id);
                    $this->rescampovalor->setEcl_id($rcv_valor);
                    $this->rescampovalor->setRcv_valor($rcv_valor);
                    $this->rescampovalor->setRcv_estado(1);
                    $this->rescampovalor->insert();                    
                } else {
                    $ecp_id = (string) $val->ecp_id;
                    $rcv_valor = $_REQUEST[$ecp_id];
                    $this->rescampovalor = new tab_rescampovalor();
                    $this->rescampovalor->setRes_id($res_id);
                    $this->rescampovalor->setEcp_id($ecp_id);
                    $this->rescampovalor->setRcv_valor($rcv_valor);
                    $this->rescampovalor->setRcv_estado(1);
                    $this->rescampovalor->insert();
                }
            }
        }


        $msm = "SE GUARDO CORRECTAMENTE LA RESPUESTA!";
        $this->registry->template->msm = $msm;

        if ($_REQUEST ['accion'] == 'guardarsinsalir') {
            $msm_guardado_archivo = 1;
            Header("Location: " . PATH_DOMAIN . "/respuesta/view/" . $res_id . "/" . $msm_guardado_archivo . "/");
        } else if ($_REQUEST ['accion'] == 'guardarnuevo') {
            $_SESSION['ENC_ID'] = $_REQUEST['enc_id'];
            $this->add();
        } else if ($_REQUEST ['accion'] == 'guardar') {
            Header("Location: " . PATH_DOMAIN . "/respuesta/index/");
        } else {
            Header("Location: " . PATH_DOMAIN . "/respuesta/index/");
        }
    }

    function edit() {
        header("Location: " . PATH_DOMAIN . "/respuesta/view/" . $_REQUEST["res_id"] . "/");
    }

    function view() {
        // Valida parameter
        if (!VAR3) {
            die("Error del sistema 404");
        }
        // Validar usuario respuesta y estado
        if (!$this->validaRespuesta($_SESSION['USU_ID'], VAR3)){
            Header("Location: " . PATH_DOMAIN . "/respuesta/index/");
        }        
        
        
        
        $this->respuesta = new tab_respuesta();
        $rows = $this->respuesta->dbselectByField("res_id", VAR3);
        $row = $rows[0];
        $this->registry->template->res_id = $row->res_id;
        $this->registry->template->enc_id = $row->enc_id;
        
        $encuesta = new encuesta();
        $uni_id = $encuesta->obtenerSeccionIdSerie($row->enc_id);
        $this->registry->template->encuesta = $encuesta->obtenerSelectSeccionDefaultEdit($_SESSION['USU_ID'], $uni_id, $row->enc_id);
        $this->registry->template->enc_codigo = $encuesta->obtenerCodigoSerie($row->enc_id);
        $this->registry->template->uni_descripcion = $encuesta->obtenerSeccionSerie($row->enc_id);
        $this->registry->template->res_codigo = $row->res_codigo;
        $this->registry->template->res_titulo = $row->res_titulo;

        // Dynamic fields
        $enccampo = new enccampo();
        $this->registry->template->enccampo = $enccampo->obtenerSelectCamposEdit($row->enc_id, VAR3);

        $eus = new tab_encusuario();
        $row_eus = $eus->dbselectBy2Field("res_id", VAR3, "eus_estado", 1);
        $usu_id = $_SESSION['USU_ID'];
        if (!is_null($row_eus) && count($row_eus) > 0)
            $usu_id = $row_eus[0]->usu_id;


        if(VAR4){
            if (VAR4 == 0) {
                $msm = "HUBO ERROR AL REGISTRAR LA RESPUESTA!";
            } else if (VAR4 == 1) {
                $msm = "SE GUARDO CORRECTAMENTE LA RESPUESTA!";
            } else {
                $msm = "";
            }
        }else{
            $msm = "";
        }
        $this->registry->template->msm = $msm;
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";

        $this->registry->template->titulo = "EDITAR ENCUESTA";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('headerG');
        $this->registry->template->show('respuesta/tab_respuesta.tpl');
        $this->registry->template->show('footer');
    }

    function update() {
        $this->respuesta = new tab_respuesta();
        $this->respuesta->setRequest2Object($_REQUEST);
        $rows2 = $this->respuesta->dbselectByField("res_id", $_REQUEST['res_id']);
        $row2 = $rows2[0];
        $res_id = $row2->res_id;
        
        $this->respuesta->setRes_id($row2->res_id);
        $this->respuesta->setEnc_id($_REQUEST['enc_id']);
        $this->respuesta->setRes_codigo($_REQUEST['res_codigo']);
        $this->respuesta->setRes_titulo($_REQUEST['res_titulo']);
        $this->respuesta->setRes_estado(1);
        $this->respuesta->update2();

        // Update dynamic data
        $enccampo = new enccampo();
        $rows3 = $enccampo->obtenerCampos($_REQUEST['enc_id']);
        if (count($rows3) > 0) {
            foreach ($rows3 as $val) {
                if ($val->ecp_tipdat == 'Lista') {
                    $ecp_id = $val->ecp_id;
                    $rcv_valor = $_REQUEST[$ecp_id];
                    $rescampovalor = new rescampovalor();
                    $rcv_id = $rescampovalor->obtenerIdCampoValorporencuesta($ecp_id, $res_id);
                    if ($rcv_id == 0) {
                        $this->rescampovalor = new tab_rescampovalor();
                        $this->rescampovalor->setRes_id($res_id);
                        $this->rescampovalor->setEcp_id($ecp_id);
                        $this->rescampovalor->setEcl_id($rcv_valor);
                        $this->rescampovalor->setRcv_valor($rcv_valor);
                        $this->rescampovalor->setRcv_estado(1);
                        $this->rescampovalor->insert();
                    } else {
                        $this->rescampovalor = new tab_rescampovalor();
                        $this->rescampovalor->setRcv_id($rcv_id);
                        $this->rescampovalor->setRes_id($res_id);
                        $this->rescampovalor->setEcp_id($ecp_id);
                        $this->rescampovalor->setEcl_id($rcv_valor);
                        $this->rescampovalor->setRcv_valor($rcv_valor);
                        $this->rescampovalor->setRcv_estado(1);
                        $this->rescampovalor->update();
                    }

                } else if ($val->ecp_tipdat == 'CheckBox') {
                    $rcv_valor = "";
                    $ecp_id = $val->ecp_id;
                    
//                    $name = "'rcv_valor&" . $ecp_id . "'";
                    $name = "rcv_valorC&" . $ecp_id . "";
                    if (isset($_REQUEST[$name])) {
                        $valores = $_REQUEST[$name];
//                    if (isset($_REQUEST['rcv_valorC'])) {
//                        $valores = $_REQUEST['rcv_valorC'];
                        // Codificar
                        $rcv_valor = "";
                        $i = 0;

                        // New
                        for($i=0;$i<count($valores);$i++) {
                            if($enccampo->esOtro($valores[$i])){
                                $rcv_valor .= $valores[$i] . ",";
                                $rcv_valor .= $valores[$i+1] . ",";
                                $i++;
                            }else{                                
                                // Sino seguir iterando
                                $rcv_valor .= $valores[$i] . ",";
                            }                            
                        }
                                                
//                        foreach ($valores as $valor) {
//                            // Si valor es "Ninguno"
//                            // Solo almacenar el valor de Ninguno y break
//                            
//                            // Si $valor es "Otro"
//                            // Sacar el siguiente y break
//                            if($enccampo->esOtro($valor)){
//                                $rcv_valor = $valor . ",";
//                                $i++;
//                                if ($i==2) {
//                                    break;
//                                }
//                            }else{                            
//                                // Sino seguir iterando
//                                $rcv_valor .= $valor . ",";
//                            }                            
////                            $rcv_valor .= $valor . ",";
//                        }
                        
                        
                        
                    }
                    $rescampovalor = new rescampovalor();
                    $rcv_id = $rescampovalor->obtenerIdCampoValorporencuesta($ecp_id, $res_id);
                    
                    if ($rcv_id == 0) {
                        $this->rescampovalor = new tab_rescampovalor();
                        $this->rescampovalor->setRes_id($res_id);
                        $this->rescampovalor->setEcp_id($ecp_id);
                        $this->rescampovalor->setEcl_id(1);
                        $this->rescampovalor->setRcv_valor($rcv_valor);
                        $this->rescampovalor->setRcv_estado(1);
                        $this->rescampovalor->insert();
                    } else {
                        $this->rescampovalor = new tab_rescampovalor();
                        $this->rescampovalor->setRcv_id($rcv_id);
                        $this->rescampovalor->setRes_id($res_id);
                        $this->rescampovalor->setEcp_id($ecp_id);
                        $this->rescampovalor->setEcl_id(1);
                        $this->rescampovalor->setRcv_valor($rcv_valor);
                        $this->rescampovalor->setRcv_estado(1);
                        $this->rescampovalor->update();
                    }

                } else if ($val->ecp_tipdat == 'RadioButton') {
                    $rcv_valor = "";
                    $ecp_id = $val->ecp_id;
                    
//                    $name = "'rcv_valor&" . $ecp_id . "'";
                    $name = "rcv_valor&" . $ecp_id . "";
//                    if (isset($_REQUEST['rcv_valor'])) {
//                        $rcv_valor = $_REQUEST['rcv_valor'];
//                    }
                    if (isset($_REQUEST[$name])) {
                        $rcv_valor = $_REQUEST[$name];
                    }                    
                    
                    $rescampovalor = new rescampovalor();
                    $rcv_id = $rescampovalor->obtenerIdCampoValorporencuesta($ecp_id, $res_id);
                    if ($rcv_id == 0) {
                        $this->rescampovalor = new tab_rescampovalor();
                        $this->rescampovalor->setRes_id($res_id);
                        $this->rescampovalor->setEcp_id($ecp_id);
                        $this->rescampovalor->setEcl_id($rcv_valor);
                        $this->rescampovalor->setRcv_valor($rcv_valor);
                        $this->rescampovalor->setRcv_estado(1);
                        $this->rescampovalor->insert();
                    } else {
                        $this->rescampovalor = new tab_rescampovalor();
                        $this->rescampovalor->setRcv_id($rcv_id);
                        $this->rescampovalor->setRes_id($res_id);
                        $this->rescampovalor->setEcp_id($ecp_id);
                        $this->rescampovalor->setEcl_id($rcv_valor);
                        $this->rescampovalor->setRcv_valor($rcv_valor);
                        $this->rescampovalor->setRcv_estado(1);
                        $this->rescampovalor->update();
                    }

                } else {
                    $ecp_id = (string) $val->ecp_id;
                    $rcv_valor = $_REQUEST[$ecp_id];
                    $rescampovalor = new rescampovalor();
                    $rcv_id = $rescampovalor->obtenerIdCampoValorporencuesta($ecp_id, $res_id);
                    if ($rcv_id == 0) {
                        $this->rescampovalor = new tab_rescampovalor();
                        $this->rescampovalor->setRes_id($res_id);
                        $this->rescampovalor->setEcp_id($ecp_id);
                        $this->rescampovalor->setEcl_id(0);
                        $this->rescampovalor->setRcv_valor($rcv_valor);
                        $this->rescampovalor->setRcv_estado(1);
                        $this->rescampovalor->insert();
                    } else {
                        $this->rescampovalor = new tab_rescampovalor();
                        $this->rescampovalor->setRcv_id($rcv_id);
                        $this->rescampovalor->setRes_id($res_id);
                        $this->rescampovalor->setEcp_id($ecp_id);
                        $this->rescampovalor->setEcl_id(0);
                        $this->rescampovalor->setRcv_valor($rcv_valor);
                        $this->rescampovalor->setRcv_estado(1);
                        $this->rescampovalor->update2();
                    }
                }
            }
        }

        $encusuario = new tab_encusuario();
        $row4 = $encusuario->dbselectByField("res_id", $_REQUEST['res_id']);
        if (count($row4) == 0) {
            $this->encusuario = new tab_encusuario();
            $this->encusuario->eus_id = '';
            $this->encusuario->res_id = $_REQUEST['res_id'];
            $this->encusuario->usu_id = $_SESSION['USU_ID'];
            $this->encusuario->eus_fecha_crea = date("Y-m-d");
            $this->encusuario->eus_estado = '1';
            $this->encusuario->insert();
        }
             
        if ($_REQUEST ['accion'] == 'guardarsinsalir') {
            $msm_guardado_archivo = 1;
            Header("Location: " . PATH_DOMAIN . "/respuesta/view/" . $_REQUEST['res_id'] . "/" . $msm_guardado_archivo . "/");
        } else if ($_REQUEST ['accion'] == 'guardarnuevo') {
            $_SESSION['ENC_ID'] = $_REQUEST['enc_id'];
            $this->add();
        } else if ($_REQUEST ['accion'] == 'guardar') {
            Header("Location: " . PATH_DOMAIN . "/respuesta/index/");
        } else {
            Header("Location: " . PATH_DOMAIN . "/respuesta/index/");
        }
    }

    function delete() {
        $this->respuesta = new tab_respuesta();
        $this->respuesta->setRes_id($_REQUEST['res_id']);
        $this->respuesta->setRes_estado(5);
        $this->respuesta->update();
    }

    
    function printFichaEncuesta() {
        $res_id = VAR3;
        $where = "";
        $this->respuesta = new tab_respuesta();
        $sql = "SELECT
                tab_unidad.uni_id,
                tab_unidad.uni_descripcion,
                tab_encuesta.enc_categoria,
                tab_respuesta.res_id,
                tab_respuesta.enc_id,
                tab_respuesta.res_titulo,
                tab_respuesta.res_codigo,
                tab_respuesta.res_estado
                FROM
                tab_encuesta
                INNER JOIN tab_respuesta ON tab_encuesta.enc_id = tab_respuesta.enc_id
                INNER JOIN tab_encusuario ON tab_respuesta.res_id = tab_encusuario.res_id
                INNER JOIN tab_usuario ON tab_usuario.usu_id = tab_encusuario.usu_id
                INNER JOIN tab_unidad ON tab_unidad.uni_id = tab_usuario.uni_id
                WHERE
                tab_encuesta.enc_estado = 1 AND
                (tab_respuesta.res_estado = 1 OR
                tab_respuesta.res_estado = 2) AND
                tab_encusuario.eus_estado = 1
                AND tab_respuesta.res_id = '$res_id'
                $where ";
        
//        $sql = "SELECT
//                tab_unidad.uni_descripcion,
//                tab_encuesta.enc_categoria,
//                tab_respuesta.res_id,
//                tab_respuesta.enc_id,
//                tab_respuesta.res_titulo,                
//                tab_respuesta.res_codigo,
//                tab_respuesta.res_estado
//                FROM
//                tab_unidad
//                INNER JOIN tab_encuesta ON tab_unidad.uni_id = tab_encuesta.uni_id
//                INNER JOIN tab_respuesta ON tab_encuesta.enc_id = tab_respuesta.enc_id
//                INNER JOIN tab_encusuario ON tab_respuesta.res_id = tab_encusuario.res_id
//                WHERE tab_unidad.uni_estado = 1
//                AND tab_encuesta.enc_estado = 1
//                AND (tab_respuesta.res_estado = 1 OR tab_respuesta.res_estado = 2)
//                AND tab_encusuario.eus_estado = 1
//                AND tab_respuesta.res_id = '$res_id'
//                $where ";
        $result = $this->respuesta->dbSelectBySQL($sql); 
        $this->usuario = new usuario ();

        // PDF
        // Landscape
        require_once ('tcpdf/config/lang/eng.php');
        require_once ('tcpdf/tcpdf.php');
        $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->setFontSubsetting(FALSE);
        $pdf->SetAuthor($this->usuario->obtenerNombre($_SESSION['USU_ID']));
        $pdf->SetTitle('Reporte Ficha de Encuesta');
        $pdf->SetSubject('Reporte Ficha de Encuesta');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
//        aumentado
        $pdf->SetKeywords('DGGE, Sistema de Encuestas');
        // set default header data
        $pdf->SetHeaderData('logo.png', 20, 'MINISTERIO DE PLANIFICACI&Oacute;N DEL DESARROLLO', 'Dirección General de Gobierno Electrónico');
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
//
        $pdf->SetMargins(10, 30, 10);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 15);
//        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetFont('helvetica', '', 11);
        // add a page
        $pdf->AddPage();

        $cadena = "<br/>";
        $cadena .= '<table width="580" border="0" >';
        $cadena .= '<tr><td align="center">';
        $cadena .= '<span style="font-size: 30px;font-weight: bold;">';
        $cadena .= 'SISTEMA GENERAL DE ENCUESTAS';
        $cadena .= '</span>';
        $cadena .= '</td></tr>';
        foreach ($result as $fila) {
            $cadena .= '<tr><td align="left"><b>Encuesta:</b> ' . $fila->enc_categoria . '</td></tr>';
            $cadena .= '<tr><td align="left"><b>Nro. respuesta: </b>' . $fila->res_id . '</td></tr>';
            $cadena .= '<tr><td align="left"></td></tr>';
            $cadena .= '<tr><td align="left"><b>Datos de la instituci&oacute;n:</b> ' . "" . '</td></tr>';            
            $cadena .= '<tr><td align="left"><b>Id. Entidad:</b> ' . $fila->uni_id . '</td></tr>';
            $cadena .= '<tr><td align="left"><b>Entidad:</b> ' . $fila->uni_descripcion . '</td></tr>';
            
            $cadena .= '<tr><td align="left"></td></tr>';
            $cadena .= '<tr><td align="left"><b>Datos de la encuesta:</b> ' . "" . '</td></tr>';
            // Include dynamic fields
            $enccampo = new enccampo();
            $filcampo = $enccampo->obtenerSelectCamposShow($fila->enc_id, $fila->res_id);
                        
            if($filcampo){
                $cadena .= $filcampo;
            }


        }
        $cadena .= '</table>';
        //$cadena .= '</table>';
        $pdf->writeHTML($cadena, true, false, false, false, '');

        // Close and output PDF document
        $pdf->Output('ficha_expediente.pdf', 'I');
    }


    // Mysql
    // Mysql
    function printConteoEncuestaExcel() {
        $enc_id = VAR3;
        $where = "";
        
        $cadena .= '<table width="100%" border="0" >';
        $cadena .= '<tr><td colspan= "3" align="center">';
        $cadena .= '<span style="font-size: 30px;font-weight: bold;">';
        $cadena .= 'CONTEO ENCUESTA - GOBIERNO ELECTRONICO';
        $cadena .= '</span>';
        $cadena .= '</td></tr>';
        $cadena .= '<tr><td>Sobre un total de 27 preguntas en la encuesta</td></tr>';
        
        // Body - Header
        $cadena .= '<tr bgcolor="#CCCCCC">';
        $cadena .= '<td width="60%" align="center"><span style="font-family: helvetica; font-size: 11px;font-weight: bold;">Entidad/Usuario</span></td>';
        $cadena .= '<td width="20%" align="left"><span style="font-family: helvetica; font-size: 11px;font-weight: bold;">Nro. de respuestas</span></td>';
        $cadena .= '<td width="20%" align="left"><span style="font-family: helvetica; font-size: 11px;font-weight: bold;">% de avance</span></td>';
        $cadena .= '</tr>';        
        
        $sql = "SELECT
                usuario.uid,
                usuario.username
                FROM
                usuario
                ORDER BY  usuario.username ";        
        $answers = new answers();
        $rows = $answers->dbSelectBySQL($sql); //print $sql;       
        foreach ($rows as $row) {            
            $sql = "SELECT count(DISTINCT questioning.qid) as contador
                    FROM
                    groups
                    INNER JOIN questioning ON groups.gid = questioning.gid
                    INNER JOIN answers ON questioning.qid = answers.qid
                    INNER JOIN usuario ON usuario.uid = answers.uid
                    WHERE usuario.uid = '$row->uid'
                    AND questioning.estado = 1
                    ORDER BY  username, groups.gnum, 
                    questioning.qnum ";
            $result = $answers->dbSelectBySQL($sql); //print $sql;        
            $this->usuario = new usuario ();        

            $usernamea = "";
            $cont = 0;
            foreach ($result as $fila) {
                // Data
                $cadena .= '<tr bgcolor="FFFFFF">';
                $cadena .= '<td width="60%" align="center"><span style="font-family: helvetica; font-size: 11px;">' . $row->username . '</span></td>';
                $cadena .= '<td width="20%" align="left"><span style="font-family: helvetica; font-size: 11px;">' . $fila->contador . '</span></td>';
                $cadena .= '<td width="20%" align="left"><span style="font-family: helvetica; font-size: 11px;">' . ($fila->contador/27)*100 .  '</span></td>';
                $cadena .= '</tr>';
            }            
            
        }   
        $cadena .= '</table>';

        // Excel
        header("Content-type: application/vnd.ms-excel; name='excel'");
        header("Content-Disposition: filename=conteo_encuesta.xls");
        header("Pragma: no-cache");
        header("Expires: 0");        
        echo $cadena;
        
    }
    
    
    
    // Mysql
    function printEncuesta() {
        $enc_id = VAR3;
        $where = "";
        
        $sql = "SELECT
                usuario.username,
                groups.gnum,
                groups.gtext,
                questioning.qnum,
                questioning.qtext,
                answers.valor
                FROM
                groups
                INNER JOIN questioning ON groups.gid = questioning.gid
                INNER JOIN answers ON questioning.qid = answers.qid
                INNER JOIN usuario ON usuario.uid = answers.uid
                ORDER BY  username, groups.gnum, 
                questioning.qnum ";
        $answers = new answers();
        $result = $answers->dbSelectBySQL($sql); //print $sql;        
        $this->usuario = new usuario ();

        // PDF
        // Landscape
        require_once ('tcpdf/config/lang/eng.php');
        require_once ('tcpdf/tcpdf.php');
        $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->setFontSubsetting(FALSE);
        $pdf->SetAuthor($this->usuario->obtenerNombre($_SESSION['USU_ID']));
        $pdf->SetTitle('Reporte Ficha de Encuesta');
        $pdf->SetSubject('Reporte Ficha de Encuesta');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
//        aumentado
        $pdf->SetKeywords('DGGE, Sistema de Encuestas');
        // set default header data
        $pdf->SetHeaderData('logo.png', 20, 'MINISTERIO DE PLANIFICACI&Oacute;N DEL DESARROLLO', 'DGGE');
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
//
        $pdf->SetMargins(10, 30, 10);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 15);
//        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetFont('helvetica', '', 11);
        // add a page
        $pdf->AddPage();

        $cadena = "<br/>";
        $cadena .= '<table width="100%" border="0" >';
        $cadena .= '<tr><td colspan= "6" align="center">';
        $cadena .= '<span style="font-size: 30px;font-weight: bold;">';
        $cadena .= 'ENCUESTA - GOBIERNO ELECTRONICO';
        $cadena .= '</span>';
        $cadena .= '</td></tr>';
        
            
        // Body - Header
        $cadena .= '<tr bgcolor="#CCCCCC">';
        $cadena .= '<td width="20%" align="center"><span style="font-family: helvetica; font-size: 11px;font-weight: bold;">Usuario</span></td>';
        $cadena .= '<td width="5%" align="left"><span style="font-family: helvetica; font-size: 11px;font-weight: bold;">Grupo</span></td>';
        $cadena .= '<td width="20%" align="left"><span style="font-family: helvetica; font-size: 11px;font-weight: bold;">Nombre Grupo</span></td>';
        $cadena .= '<td width="5%" align="left"><span style="font-family: helvetica; font-size: 11px;font-weight: bold;">Nro. Pregunta</span></td>';
        $cadena .= '<td width="30%" align="left"><span style="font-family: helvetica; font-size: 11px;font-weight: bold;">Pregunta</span></td>';
        $cadena .= '<td width="20%" align="left"><span style="font-family: helvetica; font-size: 11px;font-weight: bold;">Respuesta</span></td>';       
        $cadena .= '</tr>';
        
        
        foreach ($result as $fila) {
            // Data
            $cadena .= '<tr bgcolor="#969696">';
            $cadena .= '<td width="20%" align="center"><span style="font-family: helvetica; font-size: 11px;">' . $fila->username . '</span></td>';
            $cadena .= '<td width="5%" align="left"><span style="font-family: helvetica; font-size: 11px;">' . $fila->gnum . '</span></td>';
            $cadena .= '<td width="20%" align="left"><span style="font-family: helvetica; font-size: 11px;">' . $fila->gtext . '</span></td>';
            $cadena .= '<td width="5%" align="left"><span style="font-family: helvetica; font-size: 11px;">' . $fila->qnum . '</span></td>';
            $cadena .= '<td width="30%" align="left"><span style="font-family: helvetica; font-size: 11px;">' . $fila->qtext . '</span></td>';
            $cadena .= '<td width="20%" align="left"><span style="font-family: helvetica; font-size: 11px;">' . $fila->valor . '</span></td>';       
            $cadena .= '</tr>';

        }
        $cadena .= '</table>';
        //$cadena .= '</table>';
        $pdf->writeHTML($cadena, true, false, false, false, '');

        // Close and output PDF document
        $pdf->Output('encuesta_ge.pdf', 'I');
    }

    
    
    // Mysql
    function printEncuestaExcel() {
        $enc_id = VAR3;
        $where = "";
        
        $sql = "SELECT
                usuario.username,
                groups.gnum,
                groups.gtext,
                questioning.qnum,
                questioning.qtext,
                answers.valor
                FROM
                groups
                INNER JOIN questioning ON groups.gid = questioning.gid
                INNER JOIN answers ON questioning.qid = answers.qid
                INNER JOIN usuario ON usuario.uid = answers.uid
                ORDER BY  username, groups.gnum, 
                questioning.qnum ";
        $answers = new answers();
        $result = $answers->dbSelectBySQL($sql); //print $sql;        
        $this->usuario = new usuario ();

        // Excel
        header("Content-type: application/vnd.ms-excel; name='excel'");
        header("Content-Disposition: filename=encuesta.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        $cadena .= '<table width="100%" border="0" >';
        $cadena .= '<tr><td colspan= "6" align="center">';
        $cadena .= '<span style="font-size: 30px;font-weight: bold;">';
        $cadena .= 'ENCUESTA - GOBIERNO ELECTRONICO';
        $cadena .= '</span>';
        $cadena .= '</td></tr>';
        
            
        // Body - Header
        $cadena .= '<tr bgcolor="#CCCCCC">';
        $cadena .= '<td width="20%" align="center"><span style="font-family: helvetica; font-size: 11px;font-weight: bold;">Usuario</span></td>';
        $cadena .= '<td width="5%" align="left"><span style="font-family: helvetica; font-size: 11px;font-weight: bold;">Grupo</span></td>';
        $cadena .= '<td width="20%" align="left"><span style="font-family: helvetica; font-size: 11px;font-weight: bold;">Area</span></td>';
        $cadena .= '<td width="5%" align="left"><span style="font-family: helvetica; font-size: 11px;font-weight: bold;">Nro.</span></td>';
        $cadena .= '<td width="30%" align="left"><span style="font-family: helvetica; font-size: 11px;font-weight: bold;">Pregunta</span></td>';
        $cadena .= '<td width="20%" align="left"><span style="font-family: helvetica; font-size: 11px;font-weight: bold;">Respuesta</span></td>';       
        $cadena .= '</tr>';
        
        
        foreach ($result as $fila) {
            // Data
            $cadena .= '<tr bgcolor="FFFFFF">';
            $cadena .= '<td width="20%" align="center"><span style="font-family: helvetica; font-size: 11px;">' . $fila->username . '</span></td>';
            $cadena .= '<td width="5%" align="left"><span style="font-family: helvetica; font-size: 11px;">' . $fila->gnum . '</span></td>';
            $cadena .= '<td width="20%" align="left"><span style="font-family: helvetica; font-size: 11px;">' . $fila->gtext . '</span></td>';
            $cadena .= '<td width="5%" align="left"><span style="font-family: helvetica; font-size: 11px;">' . $fila->qnum . '</span></td>';
            $cadena .= '<td width="30%" align="left"><span style="font-family: helvetica; font-size: 11px;">' . $fila->qtext . '</span></td>';
            $cadena .= '<td width="20%" align="left"><span style="font-family: helvetica; font-size: 11px;">' . $fila->valor . '</span></td>';       
            $cadena .= '</tr>';

        }
        $cadena .= '</table>';
        
        echo $cadena;
        
    }


//    function printFicha() {
//        $res_id = VAR3;
//        $where = "";
//        $this->respuesta = new tab_respuesta();
//        $sql = "SELECT
//                tab_unidad.uni_descripcion,
//                tab_encuesta.enc_categoria,
//                tab_respuesta.res_id,
//                tab_respuesta.enc_id,
//                tab_respuesta.res_titulo,                
//                tab_respuesta.res_codigo,
//                tab_respuesta.res_estado
//                FROM
//                tab_unidad
//                INNER JOIN tab_encuesta ON tab_unidad.uni_id = tab_encuesta.uni_id
//                INNER JOIN tab_respuesta ON tab_encuesta.enc_id = tab_respuesta.enc_id
//                INNER JOIN tab_encusuario ON tab_respuesta.res_id = tab_encusuario.res_id
//                WHERE
//                tab_unidad.uni_estado = 1 AND
//                tab_encuesta.enc_estado = 1 AND
//                tab_respuesta.res_estado = 1 AND
//                tab_encusuario.eus_estado = 1 AND
//                tab_respuesta.res_id = '$res_id'
//                $where ";
//        $result = $this->respuesta->dbSelectBySQL($sql); //print $sql;
//        $this->usuario = new usuario ();
//
//            
//            
//        $cadena = "<br/>";
//        $cadena .= '<table width="580" border="0" >';
//        $cadena .= '<tr><td align="center">';
//        $cadena .= '<span style="font-size: 30px;font-weight: bold;">';
//        $cadena .= 'ENCUESTA - SOFTWARE LIBRE';
//        $cadena .= '</span>';
//        $cadena .= '</td></tr>';
//        foreach ($result as $fila) {
//            $cadena .= '<tr><td align="left"><b>Datos de la instituci&oacute;n:</b> ' . "" . '</td></tr>';
//            $cadena .= '<tr><td align="left"><b>Id: </b>' . $fila->res_id . '</td></tr>';
//            $cadena .= '<tr><td align="left"><b>C&oacute;digo: </b>' . $fila->res_codigo . '</td></tr>';
//            $cadena .= '<tr><td align="left"><b>Unidad:</b> ' . $fila->uni_descripcion . '</td></tr>';
//            $cadena .= '<tr><td align="left"><b>Encuesta:</b> ' . $fila->enc_categoria . '</td></tr>';
//            $cadena .= '<tr><td align="left"><b>T&iacute;tulo:</b> <b>' . $fila->res_titulo . '</b></td></tr>';
//            
//            
//            // Include dynamic fields
//            $enccampo = new enccampo();
//            $filcampo = $enccampo->obtenerSelectCamposShow($fila->enc_id, $fila->res_id);
//            if($filcampo){
//                $cadena .= '<br/>';                
//                $cadena .= '<tr><td align="left"><b>Datos de la encuesta:</b> ' . "" . '</td></tr>';
//                $cadena .= '<tr><td align="left"><b>PARTE A</b></td></tr>';
//                $cadena .= $filcampo;
//            }
//
//
//        }
//        $cadena .= '</table>';
//        
//        echo $cadena;
//        
//    }
    

    
    function verifencuesta() {
        $usu_encuesta = new usu_encuesta ();
        echo $usu_encuesta->tieneencuesta($_SESSION['USU_ID']);
    }

    function verificaEstado() {
        $res_id = $_REQUEST['res_id'];
        $respuesta = new respuesta ();
        echo $respuesta->estadoEncuesta($res_id);
    }
    
    function cierre_exp() {
        $this->respuesta = new tab_respuesta();
        $this->respuesta->setRes_id($_REQUEST['res_id']);
        $this->respuesta->setExp_fecha_exf(date("Y-m-d"));
        $this->respuesta->update();
    }

    function verifFechaFin() {
        $respuesta = new tab_respuesta ();
        $res_id = $_POST["Res_id"];
        $sql = "SELECT exp_fecha_exf
                FROM tab_respuesta
                WHERE res_id='$res_id'";
        $row = $respuesta->dbselectBySQL($sql);
        if ($row[0]->exp_fecha_exf) {
            echo 'El respuesta fue cerrado';
        } else {
            echo '';
        }
    }

    function cargarSession() {
        $id_serie = $_REQUEST['id_serie'];
        $_SESSION ['ENC_ID'] = $id_serie;
        echo '<input name="enc_id" id="enc_id" type="text" value="' . $_SESSION ['ENC_ID'] . '" />';
    }

    function loadCodigoAjax() {
        $enc_id = $_POST["Enc_id"];
        $respuesta = new respuesta();
        $codigo = $respuesta->obtenerCodigoSerie($enc_id);
        $res = array();
        $res['enc_codigo'] = $codigo;
        echo json_encode($res);
    }

    function sendMail (){
        $res_id = $_REQUEST["res_id"];
        $respuesta = new respuesta();
        $encuesta = $respuesta->obtenerEncuestaNombre($res_id);
        $usuario = new usuario ();
        $nombre = $usuario->obtenerNombre($_SESSION ['USU_ID']);
        $unidad = $usuario->obtenerUnidad($_SESSION ['USU_ID']);
        $email = $usuario->obtenerEmail($_SESSION ['USU_ID']);
        
        // Test
//        $email = "arseniocastellon@gmail.com";
        
        try {
            // Update cuestioning
            $this->respuesta = new tab_respuesta();
            $this->respuesta->setRes_id($_REQUEST['res_id']);
            $this->respuesta->setRes_estado(2);
            $this->respuesta->update();

            // Include phpmail.php
            require_once ('includes/class.phpmailer.php'); 
            // Phpmailer instance
            $mail = new PHPMailer();
            $mail->SetLanguage("es", "includes/");
            // SMTP definition
            $mail->IsSMTP();
            //Esto es para activar el modo depuración. En entorno de pruebas lo mejor es 2, en producción siempre 0
            // 0 = off (producción)
            // 1 = client messages
            // 2 = client and server messages
            $mail->SMTPDebug  = 0;
            
            // Gmail SMTP
            $mail->Host       = 'smtp.gmail.com';
            // Port
            $mail->Port       = 587;
            // Encription
            $mail->SMTPSecure = 'tls';
            // Gmail authentication
            $mail->SMTPAuth   = true;
            // Gmail account
            $mail->Username   = "dggebolivia@gmail.com";
            // Password account
            $mail->Password   = "Pl4n1f1c4c10n";
            // Destinatary: (email, name optional)
            $mail->AddAddress($email, $nombre);  
            // CC
            $mail->AddCC("ariel.blanco@planificacion.gob.bo");
            // BCC
            $mail->AddBCC("arsenio.castellon@planificacion.gob.bo");
            // Reply to
            $mail->AddReplyTo('arsenio.castellon@planificacion.gob.bo','Arsenio Castellon');        
            // Remitente (email, name optional)
            $mail->SetFrom('arsenio.castellon@planificacion.gob.bo', 'Arsenio Castellon');
            // Subject email
            $mail->Subject = 'Confirmacion cierre: ' . $encuesta;
            // Format HTML to send with load file
//            $mail->MsgHTML(file_get_contents('correomaquetado.html'), dirname(ruta_al_archivo));
            $mail->MsgHTML("Confirmamos el cierre de la encuesta mencionada en la referencia.<br>"
                        . "<br><b>Usuario: "  . $nombre . "</b>"
                        . "<br><b>Entidad: "  . $unidad . "</b>");
            // Alternate for block
            $mail->AltBody = 'This is a plain-text message body';
            // Send mail
            if(!$mail->Send()) {
              echo "Error: " . $mail->ErrorInfo;
              Header("Location: " . PATH_DOMAIN . "/respuesta/index/");
            } else {
              echo "Enviado!";
              Header("Location: " . PATH_DOMAIN . "/respuesta/index/");
            }        
        } catch (phpmailerException $e) {
            // PhpMailer Error
            $result .= "<b class='red'>Error: PhpMailer.</b><br />".$e->errorMessage()."</b>";
            echo $result;            
        } catch (Exception $e) {
            // Other Error
            $result .= "<b class='red'>Error: </b><br />".$e->getMessage()."</b>";
            echo $result;
        }        
        
        
    }
    
    
    function estadoCuestionario($enc_id, $res_id){
        $contador = 0;
        // Contador 
        // total = 107; preguntas obligatorias
        $total = 110;
        $porcentaje = 0;
        $this->respuesta = new tab_respuesta();
        $sql = "SELECT
                tab_encuesta.enc_id,
                tab_respuesta.res_id,
                tab_respuesta.res_codigo,
                tab_enccampo.ecp_id,
                tab_enccampo.ecp_orden,
                tab_enccampo.ecp_nombre,
                tab_enccampo.ecp_eti,
                tab_rescampovalor.rcv_valor
                FROM
                tab_encuesta
                INNER JOIN tab_respuesta ON tab_encuesta.enc_id = tab_respuesta.enc_id
                INNER JOIN tab_enccampo ON tab_encuesta.enc_id = tab_enccampo.enc_id
                INNER JOIN tab_rescampovalor ON tab_respuesta.res_id = tab_rescampovalor.res_id AND tab_enccampo.ecp_id = tab_rescampovalor.ecp_id 
                WHERE tab_encuesta.enc_id = '$enc_id' 
                AND tab_respuesta.res_id = '$res_id' ";
        $rows = $this->respuesta->dbselectBySQL($sql);        
        foreach ($rows as $row) {
            if ($row->rcv_valor=="" || $row->rcv_valor==""){                
            }else{
                $contador++;
            }
        }
        
        $porcentaje = $contador/$total;
        $porcentaje = ($this->redondear2($porcentaje)) * 100;
        return $porcentaje;
    }
        
    function redondear2($valor) { 
       $float_redondeado=round($valor * 100) / 100; 
       return $float_redondeado; 
    }    
    
    
    function validaRespuesta($usu_id, $res_id){
        $flag = false;
        
        // Admin user
        $usuario = new usuario();
        if($usuario->esAdm()){
           $flag=true;
        }else{
            $this->respuesta = new tab_respuesta();
            $sql = "SELECT
                    tab_encusuario.usu_id,
                    tab_encusuario.res_id
                    FROM
                    tab_encusuario                
                    WHERE tab_encusuario.usu_id = '$usu_id' 
                    AND tab_encusuario.res_id = '$res_id' ";
            $rows = $this->respuesta->dbselectBySQL($sql);        
            if (count($rows) > 0) {
                // Status
                $sql = "SELECT
                        tab_respuesta.res_id
                        FROM
                        tab_respuesta
                        WHERE tab_respuesta.res_id = '$res_id' 
                        AND tab_respuesta.res_estado = '1' ";
                $rows = $this->respuesta->dbselectBySQL($sql);        
                if (count($rows) > 0) {
                    $flag=true;
                }else{
                    $flag=false;
                }                
            }                    
        }
        return $flag;
    }    
    
}

?>
