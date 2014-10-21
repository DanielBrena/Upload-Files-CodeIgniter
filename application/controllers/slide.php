<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Slide extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->library(array('session'));
        $this->load->database();
        $this->load->model('slide_model');
        $this->load->model('log_model');
    }

    /**
    Metodo que nos regresa la vista principal si tiene una sesion, sino nos regresa
    la vista del login.
    */
	public function index()
	{	

		if($this->session->userdata('id_usuario') == FALSE  ){
			$this->load->view('login');
		}
		else{
			$this->load->view('slide');
		}
		
	}

	/**
	Metodo que inserta una imagen a la base de datos
	*/
	public function upload_file(){
		$status = "";
		$msg = "";
		$file_element_name = "imagen-file";
		$url = "";
		$url_valida = array("http://","https://");


		if(empty($_POST["url"])  ){
			$status = "error";
			$msg = "Por favor rellene la URL.";

		}else{

			$url = $_POST["url"];
			$url_1 = substr($url,0, 7);
			$url_2 = substr($url,0, 8);

			if(in_array($url_1, $url_valida) || in_array($url_2, $url_valida)){
				
				$config["upload_path"] = "./imagenes/";
				$config["allowed_types"] = "png|jpg";
				$config["max_width"] = 980;
				$config["max_height"] =290;
				$config["overwrite"] = FALSE;

				$imagen = $_FILES["imagen-file"]["name"];

				$this->load->library('upload', $config);

				if(!file_exists($config["upload_path"].$imagen)){

					if(!$this->upload->do_upload($file_element_name)){
						$this->log_model->insert_log("Ocurrio un error al subir la imagen | Slide");
						$status = "error";
						$msg = $this->upload->display_errors("","");
					}else{
						$data = $this->upload->data();
						$img_id = $this->slide_model->insert_img($data["file_name"],$_POST["url"]);

						if($img_id){
							$this->log_model->insert_log("Se ha subido una imagen | Slide");
							$status = "success";
							$msg = "Imagen subida exitosamente.";
						}else{
							$this->log_model->insert_log("Ocurrio un eror al subir la imagen | Slide");
							unlink($data["full_path"]);
							$status = "error";
							$msg = "Algo salio mal, vuelve a intentar.";
						}
					}


				}else{
					$this->log_model->insert_log("Imagen existente | Slide");
					$status = "error";
					$msg = "La imagen ya existe.";
				}

			}else{
				$this->log_model->insert_log("Direccion URL invalida | Slide");
				$status ="error";
				$msg = "Por favor ingresa una URL valida.";
			}
		}

		echo json_encode(array("status" => $status, "msg" => $msg));

	}

	/**
	Metodo que nos regresa una vista con todas las imagenes.
	*/
	public function imagenes(){
		$imagenes = $this->slide_model->get_imgs();
		$this->load->view('imagenes_slide', array("imgs"  => $imagenes));
		
	}
	/**
	Metodo que nos elimina una imagen.
	*/
	public function delete_imagen($img_id){
		if($this->slide_model->delete_imagen($img_id)){
			$this->log_model->insert_log("Imagen eliminada | Slide");
			$status = "success";
			$msg = "Imagen eliminada.";
		}else{
			$this->log_model->insert_log("Ocurrio un error al eliminar la imagen | Slide");
			$status = "error";
			$msg = "Ocurrio un error mientras se eliminaba la imagen.";

		}
		echo json_encode(array("status" => $status,"msg" => $msg));
	}

	/**
	Metodo para activar una imagen.
	*/
	public function activar_img(){
		$maximo = 3;
		$id = $this->input->post("id");
		$opcion = $this->input->post("opcion");

		if($opcion == "activar"){

			if($this->slide_model->num_activas() < $maximo){
				$resultado = $this->slide_model->activar_img($id);

				if($resultado){
					$this->log_model->insert_log("Se activo la imagen | Slide");
					$msg = "Se a activado.";
					$status = "success";
				}else{
					$this->log_model->insert_log("Ocurrio un error al activar | Slide");
					$msg = "Ha ocurrido un error.";
					$status = "error";
				}
			}else{
				$this->log_model->insert_log("Ha superado el limite de numero de imagenes activas | Slide");
				$msg = "Ha superado el limite de numero de imagenes activas.";
				$status = "error";
			}

		}else if($opcion == "principal"){
			$resultado = $this->slide_model->activar_principal($id);

			if($resultado){
					$this->log_model->insert_log("Se activo como principal la imagen | Slide");
					$msg = "Se a activo como principal.";
					$status = "success";
				}else{
					$msg = "Ha ocurrido un error.";
					$status = "error";
				}


		}else{
			$resultado = $this->slide_model->desactivar_img($id);

			if($resultado){
				$this->log_model->insert_log("Se desactivo la imagen | Slide");
				$msg = "Se a desactivo.";
				$status = "success";
			}else{
				$this->log_model->insert_log("Ocurrio un error al desactivar | Slide");
				$msg = "Ha ocurrido un error.";
				$status = "error";
			}
		}
		echo json_encode(array("status" => $status,"msg" => $msg));

	}

	/**
	Metodo para editar una direccion URL
	*/
	public function editar_url(){
		$id = $this->input->post("id");
		$url = $this->input->post("url");

		$url_valida = array("http://","https://");


		if(empty($_POST["url"])  ){
			$this->log_model->insert_log("Direccion URL vacia | Slide");
			$status = "error";
			$msg = "Por favor rellene la URL.";

		}else{

			$url = $_POST["url"];
			$url_1 = substr($url,0, 7);
			$url_2 = substr($url,0, 8);

			if(in_array($url_1, $url_valida) || in_array($url_2, $url_valida)){
				$resultado = $this->slide_model->editar_url($id,$url);

				if($resultado){
					$this->log_model->insert_log("Se actualizo la Direccion URL | Slide");
					$msg = "Se gano actualizar la direccion url.";
					$status = "success";
				}else{
					$this->log_model->insert_log("Ocurrio un error al actualizar la Direccion URL | Slide");
					$msg = "Ha ocurrido un error.";
					$status = "error";
				}
			}else{
				$this->log_model->insert_log("Direccion URL invalida | Slide");
				$msg = "La direccion url es invalida.";
				$status = "error";
			}
		}

		echo json_encode(array("status" => $status,"msg" => $msg));
	}

}