<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function login_admin($usuario,$contrasena){
		$this->db->where('adm_usuario',$usuario);
		$this->db->where('adm_contrasena', $contrasena);
		$query = $this->db->get('admin');

		if($query->num_rows() == 1){
			return $query->row();
		}else{
			$this->session->set_flashdata('Usuario incorrecto','Los datos son incorrectos');
			redirect(base_url(),'refresh');
		}
	}
	
}

/* End of file login_model.php */
/* Location: ./application/models/login_model.php */