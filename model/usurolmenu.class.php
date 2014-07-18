<?php

/**
 * usurolmenu.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright DGGE
 * @version $Id$ 2014.04.14
 * @access public
 */
class usurolmenu extends db {


    function __construct() {
        $this->usurolmenu = new Tab_usurolmenu();
    }

    function obtenerPrivilegiosUsuario($rol_id) {
        $row = $this->usurolmenu->dbSelectBySQL("SELECT * FROM tab_usurolmenu WHERE rol_id='" . $rol_id . "'");
        //$r = substr($row[0],0,1);		$w = substr($row[0],1,2);
        //$d = substr($row[0],2,3);		$x = substr($row[0],3,4);
        //return array($r,$w,$d,$x);
        
        return $row; 
    }

    function obtenerPermisosArchivosUsuarios($men_id, $usu_id) {
        //$usrolmenu = new usurolmenu();
        //echo ("SELECT urm_privilegios FROM tab_usurolmenu WHERE usu_id='".$usu_id."'	AND men_id='".$men_id."' ");
        $sql = "SELECT 
                tab_usurolmenu.urm_id, 
                tab_usurolmenu.rol_id, 
                tab_usurolmenu.men_id, 
                tab_usurolmenu.urm_privilegios, 
                tab_usurolmenu.urm_estado
                FROM tab_usurolmenu
                WHERE tab_usurolmenu.men_id='" . $men_id . "' AND tab_usurolmenu.rol_id IN  (SELECT U.rol_id FROM tab_usuario U WHERE U.usu_id='" . $usu_id . "')";
        $row = $this->usurolmenu->dbselectBySQL($sql);
        /* $r = substr($row[0]->urm_privilegios,0,1);
          $w = substr($row[0]->urm_privilegios,1,1);
          $d = substr($row[0]->urm_privilegios,2,1);
          $x = substr($row[0]->urm_privilegios,3,1);
         */
        if (count($row))
            return $row[0]->urm_privilegios; //return array($r,$w,$d,$x);
        else
            return "";
    }

}

?>