<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log_model extends CI_Model {

	public function __construct() {
        parent::__construct();
        $this->load->library(array('session'));
    }

    /**
    Metodo que inserta un log con una descripcion.
    @param $descripcion Descripcion del Log.
    @retrun Int Regresa el id que se inserto.
    */
    public function insert_log($descripcion){

    	$data = array(
			"log_descripcion"	=>	$descripcion,
			"log_fecha_creacion"	=>	date('Y-m-d H:i:s'),
			"admin_adm_id" => $this->session->userdata("id_usuario")
		);

		$this->db->insert("log",$data);
		return $this->db->insert_id();
    }
	

}

/* End of file log_model.php */
/* Location: ./application/models/log_model.php */