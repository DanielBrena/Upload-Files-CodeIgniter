<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Slide_model extends CI_Model {

	public function __construct() {
        parent::__construct();
        $this->load->library(array('session'));
    }

    /**
    Metodo que insertar una imagen en la base de datos.
    @param $imagen Nombre de la imagen.
    @param $url Direccion URL.
    @return Int Retorna el id de la insercion.
    */
	public function insert_img($imagen,$url){
		
		$data = array(
			"sli_url"	=>	$url,
			"sli_img_nombre"	=>	$imagen,
			"sli_estado"	=>	"0",
			"sli_fecha_creacion" =>	date('Y-m-d H:i:s'),
			"admin_adm_id" => $this->session->userdata("id_usuario")
		);

		$this->db->insert("slide",$data);
		return $this->db->insert_id();
	}

	/**
    Metodo que nos regresa un arreglo con todas las imagenes.
    @return Array() Imagenes
    */
	public function get_imgs(){
		return $this->db->select()->from("slide")->get()->result();
	}

	/**
    Metodo que elimina una imagen dentro de la base de datos.
    @param $img_id
    @return Boolean Retorna un booleano si elimino la noticia junto con sus respectivos archivos.
    */
	public function delete_imagen($img_id){
		$img  = $this->get_img($img_id);

		if(!$this->db->where("sli_id",$img_id)->delete("slide") ){
			return FALSE;
		}
		unlink("./imagenes/".$img->sli_img_nombre);
		return TRUE;
	}

	/**
    Metodo que obtiene un registro mediante su id.
    @param $img_id Id de la imagen a obtener.
    @return Array Array con el registro.
    */
	public function get_img($img_id){
		return $this->db->select()
			->from("slide")
			->where("sli_id",$img_id)
			->get()
			->row();
	}

	/**
    Metodo que nos obtiene el numero de imagenes activas (sli_estao = "1").
    @return Int Numero de registros.
    */
	public function num_activas(){
		$this->db->where('sli_estado', '1');
		$this->db->from('slide');
		return  $this->db->count_all_results();
	}

	 /**
    Metodo que nos activa una imagen mediante su id.
    @param $id Id de la imagen a activar.
    @return Int Regresa si se realizo con exito la peticion. 
    */
	public function activar_img($id){
		$data = array(
               'sli_estado' => "1"
            );

		$this->db->where('sli_id', $id);
		$this->db->update('slide', $data); 
		return $this->db->affected_rows();
	}

	/**
    Metodo que nos desactiva una imagen mediante su id.
    @param $id Id de la imagen a desactivar.
    @return Int Regresa si se realizo con exito la peticion. 
    */
	public function desactivar_img($id){
		$data = array(
               'sli_estado' => "0"
            );

		$this->db->where('sli_id', $id);
		$this->db->update('slide', $data); 
		return $this->db->affected_rows();
	}

	/**
    Metodo que nos va desactivar una imagen que esta como principal.
    @return Int Regresa si se realizo con exito la peticion. 
    */
	public function desactivar_principal(){
		$data = array(
               'sli_estado' => "1"
            );

		$this->db->where('sli_estado', "2");
		$this->db->update('slide', $data); 
		return $this->db->affected_rows();
	}

	/**
    Metodo que activa una imagen como principal mediante su id.
    @param $id Id de la imagen a activar como principal.
    @return Int Regresa si se realizo con exito la peticion. 
    */
	public function activar_principal($id){

		$img  = $this->get_img($id);

		if($img->sli_estado == "0"){
			return 0;
		}else{
			$this->desactivar_principal();
			$data = array(
	               'sli_estado' => "2"
	            );

			$this->db->where('sli_id', $id);
			$this->db->update('slide', $data); 
			return $this->db->affected_rows();
		}
		
	}

	/**
    Metodo que edita en la base de datos una direccion url mediante su id.
    @param $id Id de la noticia a editar.
    @param $url Url nueva.
    @return Int Regresa si se realizo con exito la peticion. 
    */
	public function editar_url($id,$url){
		$data = array(
               'sli_url' => $url
            );

		$this->db->where('sli_id', $id);
		$this->db->update('slide', $data); 
		return $this->db->affected_rows();
	}

	
}

/* End of file slide_model.php */
/* Location: ./application/models/slide_model.php */