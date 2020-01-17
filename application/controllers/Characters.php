<?php
   
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;
     
class Characters extends REST_Controller {
    
	/**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->database();
    }
       
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    //Endpoint para consultar uno o todos los personajes
	public function index_get($id = 0){
        //Validamos si el dato que llega es numerico
        if(!is_numeric($id))
        {
            $data = array("status" => 400,
                            "msg" => 'Bad request');
            $this->response($data, REST_Controller::HTTP_BAD_REQUEST);
        }

        //Si nos llega un id devolvemos ese personaje, de lo contrario devolvemos todos
        if(!empty($id)){
            $response = $this->db->get_where("CatCharacters", ['id' => $id])->row_array();
        }else{
            $response = $this->db->get("CatCharacters")->result();
        }

        $data = array("status" => 200,
                    "msg" => 'success',
                    "character" => $response);
        $http = REST_Controller::HTTP_OK;

        //Si el id no existe se notifica.
        if (!$response) {
            $data = array("status" => 400,
                    "msg" => 'Character not found.');
            $http = REST_Controller::HTTP_BAD_REQUEST;
        }
        $this->response($data, $http);

	}
      
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
     //Endpoint para insertar un nuevo personaje
    public function index_post(){
        $input = $this->input->post();
        if ($input) {
            $this->db->insert('CatCharacters',$input);
            $data = array("status" => 200,
                            "msg" => 'Character created successfully.');
            $http = REST_Controller::HTTP_OK;
        }else{
            $data = array("status" => 400,
                            "msg" => 'Bad request');
            $http = REST_Controller::HTTP_BAD_REQUEST;
        }

        $this->response($data,$http);
    } 
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
     //Endpoint para actualizar datos de algun personaje
    public function index_put($id){   
        $input = $this->put();
        if ($input) {
            $this->db->update('CatCharacters', $input, array('id'=>$id));
            $data = array("status" => 200,
                        "msg" => 'Character updated successfully.');
            $this->response($data, REST_Controller::HTTP_OK);
        }else{
            $data = array("status" => 400,
                        "msg" => 'Bad request');
            $this->response($data, REST_Controller::HTTP_BAD_REQUEST);
        }

    }
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    //Endpoint para eliminar algun personaje
    public function index_delete($id){

        //Verificamos si losd datos que nos llegan son correctos
        if (!$id || !is_numeric($id)) {
            $data = array("status" => 400,
                        "msg" => 'Bad request.');
            $this->response($data, REST_Controller::HTTP_BAD_REQUEST);
        }

        //Validamos si el id existe en la base
        $getCharacter = $this->db->get_where("CatCharacters", ['id' => $id])->row_array();
        
        //Si el personaje existe, lo eliminamos
         if ($getCharacter) {
            $response = $this->db->delete('CatCharacters', array('id'=>$id));
            $data = array("status" => 200,
                        "msg" => 'Character deleted successfully.');
            $http = REST_Controller::HTTP_BAD_REQUEST;
         }else{ //De lo contrario mandamos repsuesta de que no existe el personaje
            $data = array("status" => 400,
                        "msg" => 'Character not found.');
            $http = REST_Controller::HTTP_BAD_REQUEST;
         }

        $this->response($data,$http);
    }
    	
}