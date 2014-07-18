<?php

/**
 * departamento.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright DGGE
 * @version $Id$ 2014.04.14
 * @access public
 */
class departamento extends tab_departamento {

    function __construct() {
        $this->departamento = new tab_departamento();
    }

    function obtenerSelect($default = null) {
        $sql = "SELECT *
                FROM tab_departamento
                WHERE tab_departamento.dep_estado = 1
                ORDER BY dep_id ASC ";
        $row = $this->departamento->dbselectBySQL($sql);
        $option = "";
        foreach ($row as $val) {
            if ($default == $val->dep_id)
                $option .="<option value='" . $val->dep_id . "' selected>" . $val->dep_nombre . "</option>";
            else
                $option .="<option value='" . $val->dep_id . "'>" . $val->dep_nombre . "</option>";
        }
        return $option;
    }

    function validaDependencia($dep_id) {
        $sql = "SELECT COUNT (ubi.ubi_id)
                        FROM tab_departamento dep INNER JOIN
                        tab_provincia pro ON dep.dep_id = pro.dep_id INNER JOIN
                        tab_localidad loc ON pro.pro_id = loc.pro_id INNER JOIN
                        tab_ubicacion ubi ON loc.loc_id = ubi.loc_id
                        WHERE ubi.ubi_estado = 1 AND dep.dep_id = $dep_id ";
        $option = 0;
        $algo = $this->departamento->countBySQL($sql);
        if ($algo != 0) {
            $option = 1;
        }
        return $option;
    }

    function obtenerDatosDepartamento($username = null, $pass = null) {
        $row = "";
        $root = "";
        if ($username == 'root')
            $root = "OR tab_usuario.usu_estado='0' ";
        if ($username != null || $pass != null) {
            $sql = "SELECT
                    tab_departamento.dep_codigo,
                    tab_departamento.dep_nombre
                    FROM
                    tab_departamento
                    INNER JOIN tab_unidad ON tab_departamento.dep_id = tab_unidad.dep_id
                    INNER JOIN tab_usuario ON tab_unidad.uni_id = tab_usuario.uni_id
                    WHERE tab_usuario.usu_login ='" . $username . "' 
                    AND tab_usuario.usu_pass ='" . $pass . "' 
                    AND usu_estado=1 $root ";
            $row = $this->departamento->dbselectBySQL($sql);
            $row = $row [0];
            if (is_object($row))
                return $row;
            else
                return 0;
        }
        else
            0;
    }

    function existeCodigo($dep_codigo, $dep_id=null) {
        $row = array();
        if ($dep_id == null) {
            $sql = "SELECT * 
                    FROM tab_departamento 
                    WHERE tab_departamento.dep_codigo = '$dep_codigo' 
                    AND dep_estado='1'";
        } else {
            $sql = "SELECT * 
                    FROM tab_departamento 
                    WHERE tab_departamento.dep_codigo = '$dep_codigo' 
                    AND dep_id<>'$dep_id' 
                    AND dep_estado='1' ";
        }
        $row = $this->departamento->dbselectBySQL($sql);
        if (count($row) > 0) {
            return true;
        }
        return false;
    }

    function obtenerIdDeptoCodigoSerie($ser_codigo) {
        $delimiter = DELIMITER;
        $codigo = explode($delimiter, $ser_codigo);
        $dep_codigo = $codigo[0];
        $dep_id = 0;
        $rows = "";
        $sql = "SELECT 
                dep_id
		FROM tab_departamento
		WHERE 
                dep_estado = '1' 
                AND dep_codigo = '$dep_codigo' ";
        $rows = $this->departamento->dbselectBySQL($sql);
        foreach ($rows as $val) {
            $dep_id = $val->dep_id;
        }
        return $dep_id;
    }

}

?>