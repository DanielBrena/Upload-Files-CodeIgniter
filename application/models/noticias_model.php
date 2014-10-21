<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Noticias_model extends CI_Model {

	public function __construct() {
        parent::__construct();
        $this->load->library(array('session'));
    }

    /**
    Metodo para insertar una noticia.
    @param $pdf Nombre del archivo pdf.
    @param $tipo Tipo que se va a insertar, puede ser pdf o url.
    @param $url Direccion url.
    @param $titulo Titulo a insertar.
    @param $previa Nombre de la imagen previa.
    @return $id Id de la insercion.
    */
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

    /**
    Metodo que elimina una noticia dentro de la base de datos.
    @param $not_id
    @return Boolean Retorna un booleano si elimino la noticia junto con sus respectivos archivos.
    */
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

    /**
    Metodo que obtiene un registro mediante su id.
    @param $not_id Id de la noticia a obtener.
    @return Array Array con el registro.
    */
    public function get_not($not_id){
        return $this->db->select()
            ->from("noticia")
            ->where("not_id",$not_id)
            ->get()
            ->row();
    }

    /**
    Metodo que nos obtiene el numero de noticias activas (not_estao = "1").
    @return Int Numero de registros.
    */
    public function num_activas(){
        $this->db->where('not_estado', '1');
        $this->db->from('noticia');
        return  $this->db->count_all_results();
    }

    /**
    Metodo que nos activa una noticiamediante su id.
    @param $id Id de la noticia a activar.
    @return Int Regresa si se realizo con exito la peticion. 
    */

    public function activar_not($id){
        $data = array(
               'not_estado' => "1"
            );

        $this->db->where('not_id', $id);
        $this->db->update('noticia', $data); 
        return $this->db->affected_rows();
    }

    /**
    Metodo que nos desactiva una noticia mediante su id.
    @param $id Id de la noticia a desactivar.
    @return Int Regresa si se realizo con exito la peticion. 
    */
    public function desactivar_not($id){
        $data = array(
               'not_estado' => "0"
            );

        $this->db->where('not_id', $id);
        $this->db->update('noticia', $data); 
        return $this->db->affected_rows();
    }

    /**
    Metodo que nos desactivar una noticia que esta como principal.
    @return Int Regresa si se realizo con exito la peticion. 
    */
    public function desactivar_principal(){
        $data = array(
               'not_estado' => "1"
            );

        $this->db->where('not_estado', "2");
        $this->db->update('noticia', $data); 
        return $this->db->affected_rows();
    }

    /**
    Metodo que activa una noticia como principal mediante su id.
    @param $id Id de la noticia a activar como principal.
    @return Int Regresa si se realizo con exito la peticion. 
    */
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

    /**
    Metodo que edita en la base de datos una direccion url mediante su id.
    @param $id Id de la noticia a editar.
    @param $url Url nueva.
    @return Int Regresa si se realizo con exito la peticion. 
    */
    public function editar_url($id,$url){
        $data = array(
               'not_url' => $url
            );

        $this->db->where('not_id', $id);
        $this->db->update('noticia', $data); 
        return $this->db->affected_rows();
    }

     /**
    Metodo que edita en la base de datos el titulo mediante su id.
    @param $id Id de la noticia a editar.
    @param $titulo Titulo nuevo.
    @return Int Regresa si se realizo con exito la peticion. 
    */
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