<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Noticia extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->library(array('session'));
        $this->load->database();
        $this->load->model('noticias_model');
        $this->load->model('log_model');
    }

	public function index()
	{
		if($this->session->userdata('id_usuario') == FALSE  ){
			$this->load->view('login');
		}
		else{
			$this->load->view('noticias');
		}
	}

	/**
	Metodo que inserta una noticia a la base de datos
	*/
	public function upload_file(){

		$status = "";
		$msg = "";

		
		$file_element_name_1 = "imagen-file";
		$file_element_name_2 = "pdf-file";

		$titulo 	=  	$this->input->post("titulo");
		$url 		= 	$this->input->post("url") != "" ? $this->input->post("url") : "" ;
		$opcion 	= 	$this->input->post("opcion");

		if($opcion == "pdf"){

			if(empty($titulo) || empty($_FILES["pdf-file"]) || empty($_FILES["imagen-file"])){
				$status = "error";
				$msg 	= "Algun campo no se relleno.";
				$this->log_model->insert_log("Campos vacios | Noticia");
			}else{

				$this->load->library('upload');

				$pdf 	= $_FILES["pdf-file"]["name"];
				$imagen = $_FILES["imagen-file"]["name"];
				$config1["upload_path"] 	= 	"./previsualizacion/";
				$config1["allowed_types"] 	= 	"png|jpg";
				$config1["max_width"] 		= 	174;
				$config1["max_height"] 		=	86;

				$this->upload->initialize($config1);

				if(!file_exists($config1["upload_path"].$imagen)){

					if(!$this->upload->do_upload($file_element_name_1)){
						$this->log_model->insert_log("Error al subir la imagen de previsualización | Noticia");
						$status = "error";
						$msg 	= $this->upload->display_errors("","");

					}else{

						$data1 	= $this->upload->data();
						$config2["upload_path"] 	= "./pdf/";
						$config2["allowed_types"] 	= "pdf";
						$this->upload->initialize($config2);

						if(!file_exists($config2["upload_path"].$pdf)){
							if(!$this->upload->do_upload($file_element_name_2)){
								$this->log_model->insert_log("Error al subir el PDF | Noticia");
								unlink($data1["full_path"]);
								$status = "error";
								$msg 	= $this->upload->display_errors("","");
							}else{
								$data2 	= $this->upload->data();

								$not_id = $this->noticias_model->insert_not($data2["file_name"],"pdf",$url,$titulo,$data1["file_name"]);
								

								if($not_id){
									$this->log_model->insert_log("Ha subido una noticia | Noticia");
									$status = "success";
									$msg = "Noticia subida exitosamente.";
								}else{
									$this->log_model->insert_log("Error al subir una noticia | Noticia");

									unlink($data1["full_path"]);
									unlink($data2["full_path"]);
									$status = "error";
									$msg = "Algo salio mal, vuelve a intentar.";
								}
							}
						}else{
							$this->log_model->insert_log("PDF eixistente | Noticia");
							unlink($data1["full_path"]);
							$status = "error";
							$msg = "Existe el PDF.";
						}
					}

				}else{
					$this->log_model->insert_log("Imagen existente | Noticia");
					$status = "error";
					$msg = "Existe la imagen.";
				}
			}

		}else{
			//imagen
			if(empty($titulo) || empty($_FILES["imagen-file"]) || empty($url)){
				$status = "error";
				$msg = "Algun campo no se relleno.";
				$this->log_model->insert_log("Campos vacios | Noticia");
			}else{
				if($this->validar_url($url)){
					$this->load->library('upload');

					$imagen = $_FILES["imagen-file"]["name"];

					$config1["upload_path"] = "./previsualizacion/";
					$config1["allowed_types"] = "png|jpg";
					$config1["max_width"] = 174;
					$config1["max_height"] =86;

					$this->upload->initialize($config1);

					if(!file_exists($config1["upload_path"].$imagen)){

						if(!$this->upload->do_upload($file_element_name_1)){
							$status = "error";
							$msg = $this->upload->display_errors("","");
							$this->log_model->insert_log("Error al subir la imagen de previsualización | Noticia");
						}else{
							$data1 = $this->upload->data();
							$not_id = $this->noticias_model->insert_not("","url",$url,$titulo,$data1["file_name"]);
									
							if($not_id){
								$this->log_model->insert_log("Ha subido una noticia | Noticia");
								$status = "success";
								$msg = "Noticia subida exitosamente.";
							}else{
								$this->log_model->insert_log("Error al subir la noticia | Noticia");
								unlink($data1["full_path"]);
								$status = "error";
								$msg = "Algo salio mal, vuelve a intentar.";
							}
						}

					}else{
						$this->log_model->insert_log("La imagen existe | Noticia");
						$status = "error";
						$msg = "La imagen ya existe.";
					}
				}else{
					$this->log_model->insert_log("Direccion URL invalida | Noticia");
					$status = "error";
					$msg = "La direccion URL es invalida.";
				}

				

			}
		}

		echo json_encode(array("status" => $status, "msg" => $msg));


	}

	/**
	Metodo que valida una direccion url
	@return True Validacion
	*/
	private function validar_url($url){
		$url_valida = array("http://","https://");
		$url_1 = substr($url,0, 7);
		$url_2 = substr($url,0, 8);

		if(in_array($url_1, $url_valida) || in_array($url_2, $url_valida)){
			return TRUE;
		}else{
			return FALSE;
		}

	}

	/**
	Metodo que nos regresa una vista con todas las noticias.
	*/
	public function noticias(){
		$noticias = $this->noticias_model->get_noticias();
		$this->load->view('noticias_slide', array("not"  => $noticias));
	}

	/**
	Metodo que nos elimina una noticia.
	*/
	public function delete_noticia($not_id){
		if($this->noticias_model->delete_noticia($not_id)){
			$this->log_model->insert_log("Noticia eliminada | Noticia");
			$status = "success";
			$msg = "Noticica eliminada.";
		}else{
			$this->log_model->insert_log("Error al eliminar la noticia | Noticia");
			$status = "error";
			$msg = "Ocurrio un error mientras se eliminaba la noticia.";

		}
		echo json_encode(array("status" => $status,"msg" => $msg));
	}

	/**
	Metodo para activar una noticia.
	*/
	public function activar_not(){
		$maximo = 1;
		$id = $this->input->post("id");
		$opcion = $this->input->post("opcion");

		if($opcion == "activar"){

			if($this->noticias_model->num_activas() < $maximo){
				$resultado = $this->noticias_model->activar_not($id);

				if($resultado){
					$this->log_model->insert_log("Se ha activado una noticia | Noticia");
					$msg = "Se a activado.";
					$status = "success";
				}else{
					$this->log_model->insert_log("Error al activar una noticia | Noticia");
					$msg = "Ha ocurrido un error.";
					$status = "error";
				}
			}else{
				$this->log_model->insert_log("Ha superado el limite de numero de noticias activas | Noticia");
				$msg = "Ha superado el limite de numero de noticias activas.";
				$status = "error";
			}

		}else if($opcion == "principal"){
			$resultado = $this->noticias_model->activar_principal($id);

			if($resultado){
				$this->log_model->insert_log("Activado la noticia principal | Noticia");
				$msg = "Se a activo como principal.";
				$status = "success";
			}else{
				$this->log_model->insert_log("Ocurrio un error al activar como principal | Noticia");
				$msg = "Ha ocurrido un error.";
				$status = "error";
			}


		}else{
			$resultado = $this->noticias_model->desactivar_not($id);

			if($resultado){
				$this->log_model->insert_log("Se desactivo la noticia | Noticia");
				$msg = "Se a desactivo.";
				$status = "success";
			}else{
				$this->log_model->insert_log("Error al desactivar una noticia | Noticia");
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


		if(empty($_POST["url"])  ){
			$this->log_model->insert_log("Direccion URL vacia | Noticia");
			$status = "error";
			$msg = "Por favor rellene la URL.";

		}else{

			
			if($this->validar_url($url)){
				$resultado = $this->noticias_model->editar_url($id,$url);

				if($resultado){
					$this->log_model->insert_log("Direccion URL actualizada | Noticia");
					$msg = "Se gano actualizar la direccion url.";
					$status = "success";
				}else{
					$this->log_model->insert_log("Ocurrio un error al actualizar la Direccion URL | Noticia");
					$msg = "Ha ocurrido un error.";
					$status = "error";
				}
			}else{
				$this->log_model->insert_log("Direccion URL invalida | Noticia");
				$msg = "La direccion url es invalida.";
				$status = "error";
			}
		}

		echo json_encode(array("status" => $status,"msg" => $msg));
	}


	/**
	Metodo para editar un titulo.
	*/
	public function editar_titulo(){
		$id = $this->input->post("id");
		$titulo = $this->input->post("titulo");


		if(empty($titulo)  ){
			$this->log_model->insert_log("Titulo vacio | Noticia");
			$status = "error";
			$msg = "Por favor rellene el titulo.";

		}else{

			$resultado = $this->noticias_model->editar_titulo($id,$titulo);

			if($resultado){
				$this->log_model->insert_log("Se actualizo el titulo | Noticia");
				$msg = "Se gano actualizar el titulo.";
				$status = "success";
			}else{
				$this->log_model->insert_log("Ocurrio un error al actualizar el titulo | Noticia");
				$msg = "Ha ocurrido un error.";
				$status = "error";
			}
			
		}

		echo json_encode(array("status" => $status,"msg" => $msg));
	}


}

/* End of file noticias.php */
/* Location: ./application/controllers/noticias.php */