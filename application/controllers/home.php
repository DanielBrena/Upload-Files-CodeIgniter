<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('login_model');
		$this->load->model('log_model');
		$this->load->library(array('session','form_validation'));
		$this->load->database('default');
	}

	public function index()
	{

		if($this->session->userdata('id_usuario') == FALSE  ){
			$this->load->view('login');
		}
		else{
			$this->load->view('index');
		}
		

	}

	public function login(){
		$this->load->view('login');
	}

	public function validar(){
		$this->form_validation->set_rules('usuario', 'Nombre de Usuario', 'required');
		$this->form_validation->set_rules('contrasena', 'Contrasena', 'required');
	
		if($this->form_validation->run() == FALSE){
			$this->index();
		}else{
			$usuario = $this->input->post('usuario');
			$contrasena = $this->input->post('contrasena');
			$valido = $this->login_model->login_admin($usuario,md5($contrasena));

			if($valido == TRUE){

				$datos = array(
					'isLogin' => TRUE,
					'id_usuario' => $valido->adm_id,
					'usuario' => $valido->adm_usuario
				);
				$this->session->set_userdata($datos);
				$this->log_model->insert_log("Ha iniciado sesión.");
				redirect(base_url());

			}


		}

	}

	public function logout(){
		$this->log_model->insert_log("Cerro sesión | Noticia");
		$this->session->sess_destroy();
		redirect(base_url());
		//$this->index();
	}

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */