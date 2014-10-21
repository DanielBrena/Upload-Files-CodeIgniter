<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Slide_model extends CI_Model {

	public function __construct() {
        parent::__construct();
        $this->load->library(array('session'));
    }

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

	public function get_imgs(){
		return $this->db->select()->from("slide")->get()->result();
	}

	public function delete_imagen($img_id){
		$img  = $this->get_img($img_id);

		if(!$this->db->where("sli_id",$img_id)->delete("slide") ){
			return FALSE;
		}
		unlink("./imagenes/".$img->sli_img_nombre);
		return TRUE;
	}

	public function get_img($img_id){
		return $this->db->select()
			->from("slide")
			->where("sli_id",$img_id)
			->get()
			->row();
	}

	public function num_activas(){
		$this->db->where('sli_estado', '1');
		$this->db->from('slide');
		return  $this->db->count_all_results();
	}

	public function activar_img($id){
		$data = array(
               'sli_estado' => "1"
            );

		$this->db->where('sli_id', $id);
		$this->db->update('slide', $data); 
		return $this->db->affected_rows();
	}

	public function desactivar_img($id){
		$data = array(
               'sli_estado' => "0"
            );

		$this->db->where('sli_id', $id);
		$this->db->update('slide', $data); 
		return $this->db->affected_rows();
	}

	public function desactivar_principal(){
		$data = array(
               'sli_estado' => "1"
            );

		$this->db->where('sli_estado', "2");
		$this->db->update('slide', $data); 
		return $this->db->affected_rows();
	}


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