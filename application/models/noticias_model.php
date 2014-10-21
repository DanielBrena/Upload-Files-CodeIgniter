<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Noticias_model extends CI_Model {

	public function __construct() {
        parent::__construct();
        $this->load->library(array('session'));
    }

    public function insert_not($pdf,$tipo,$url,$titulo,$previa){
    	$data = array(
    		"not_archivo_nombre" => $pdf,
    		"not_tipo" => $tipo,
    		"not_url" => $url,
    		"not_titulo" => $titulo,
    		"not_fecha_creacion" => date('Y-m-d H:i:s'),
    		"not_estado" => "0",
    		"not_img_nombre_vp" => $previa,
    		"admin_adm_id" =>  $this->session->userdata("id_usuario")
    	);
    	$this->db->insert("noticia",$data);
		return $this->db->insert_id();
    	
    }

    /**
    Metodo que nos regresa un arreglo con todas las noticias.
    @return Array() Noticias
    */
    public function get_noticias(){
        return $this->db->select()->from("noticia")->get()->result();
    }

    public function delete_noticia($not_id){
        $not  = $this->get_not($not_id);

        if(!$this->db->where("not_id",$not_id)->delete("noticia") ){
            return FALSE;
        }

        if($not->not_tipo == "pdf"){
            unlink("./pdf/".$not->not_archivo_nombre);
            unlink("./previsualizacion/".$not->not_img_nombre_vp);
        }else{
            unlink("./previsualizacion/".$not->not_img_nombre_vp);
        }
        
        return TRUE;
    }

    public function get_not($not_id){
        return $this->db->select()
            ->from("noticia")
            ->where("not_id",$not_id)
            ->get()
            ->row();
    }

    public function num_activas(){
        $this->db->where('not_estado', '1');
        $this->db->from('noticia');
        return  $this->db->count_all_results();
    }

    public function activar_not($id){
        $data = array(
               'not_estado' => "1"
            );

        $this->db->where('not_id', $id);
        $this->db->update('noticia', $data); 
        return $this->db->affected_rows();
    }

    public function desactivar_not($id){
        $data = array(
               'not_estado' => "0"
            );

        $this->db->where('not_id', $id);
        $this->db->update('noticia', $data); 
        return $this->db->affected_rows();
    }

    public function desactivar_principal(){
        $data = array(
               'not_estado' => "1"
            );

        $this->db->where('not_estado', "2");
        $this->db->update('noticia', $data); 
        return $this->db->affected_rows();
    }


    public function activar_principal($id){
        $not  = $this->get_not($id);

        if($not->not_estado == "0"){
            return 0;
        }else{
            $this->desactivar_principal();

            $data = array(
                   'not_estado' => "2"
                );

            $this->db->where('not_id', $id);
            $this->db->update('noticia', $data); 
            return $this->db->affected_rows();
        }
        
    }

    public function editar_url($id,$url){
        $data = array(
               'not_url' => $url
            );

        $this->db->where('not_id', $id);
        $this->db->update('noticia', $data); 
        return $this->db->affected_rows();
    }

    public function editar_titulo($id,$titulo){
        $data = array(
               'not_titulo' => $titulo
            );

        $this->db->where('not_id', $id);
        $this->db->update('noticia', $data); 
        return $this->db->affected_rows();
    }


}

/* End of file noticias_model.php */
/* Location: ./application/models/noticias_model.php */