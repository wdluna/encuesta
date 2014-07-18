<?php

/**
 * tab_sistema.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright DGGE
 * @version $Id$ 2014.04.14
 * @access public
 */
class tab_sistema extends db {

    var $sis_id;
    var $sis_codigo;
    var $sis_nombre;
    var $sis_tipcarga;
    var $sis_tammax;
    var $sis_ruta;
    var $sis_estado;
    var $sis_palclave;
    var $sis_rutaexcel;

    function __construct() {
        parent::__construct();
    }

    function getSis_id() {
        return $this->sis_id;
    }

    function setSis_id($sis_id) {
        $this->sis_id = $sis_id;
    }

    function getSis_codigo() {
        return $this->sis_codigo;
    }

    function setSis_codigo($sis_codigo) {
        $this->sis_codigo = $sis_codigo;
    }

    function getSis_nombre() {
        return $this->sis_nombre;
    }

    function setSis_nombre($sis_nombre) {
        $this->sis_nombre = $sis_nombre;
    }

    function getSis_tipcarga() {
        return $this->sis_tipcarga;
    }

    function setSis_tipcarga($sis_tipcarga) {
        $this->sis_tipcarga = $sis_tipcarga;
    }

    function getSis_tammax() {
        return $this->sis_tammax;
    }

    function setSis_tammax($sis_tammax) {
        $this->sis_tammax = $sis_tammax;
    }

    function getSis_ruta() {
        return $this->sis_ruta;
    }

    function setSis_ruta($sis_ruta) {
        $this->sis_ruta = $sis_ruta;
    }

    function getSis_rutaexcel() {
        return $this->sis_rutaexcel;
    }

    function setSis_rutaexcel($sis_rutaexcel) {
        $this->sis_rutaexcel = $sis_rutaexcel;
    }
    
    function getSis_estado() {
        return $this->sis_estado;
    }

    function setSis_estado($sis_estado) {
        $this->sis_estado = $sis_estado;
    }
    
    function getSis_palclave() {
        return $this->sis_palclave;
    }

    function setSis_palclave($sis_palclave) {
        $this->sis_palclave = $sis_palclave;
    }
    
}

?>