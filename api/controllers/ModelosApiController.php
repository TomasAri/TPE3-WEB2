<?php
    require_once 'api/views/json.view.php';
    require_once 'api/models/ModelosModel.php';

    class ModelosApiController{
        private $model;
        private $view;

        public function __construct(){
            $this->model = new ModelosModel();
            $this->view = new JSONView();
        }

        public function getAllModelos($req, $res){
            $Nombre = false;
            if(isset($req->query->nombre)){
                $Nombre = $req->query->nombre;
            }
    
            $orderBy = false;
            if(isset($req->query->orderBy)){
                $orderBy = $req->query->orderBy;
            }

            $Direction = false;
            if(isset($req->query->Direction)){
                $Direction = $req->query->Direction;
            }

            $modelos = $this->model->getModelos($Nombre, $orderBy, $Direction);

            if(!$modelos){
                return $this->view->response("No hay modelos para mostrar", 404);
            }
            return $this->view->response($modelos);
        }

        public function getModelo($req, $res) {
            $id_zapatilla = $req->params->id;
            
            $modelo = $this->model->getModelo($id_zapatilla);
            
            if (!$modelo) {
                return $this->view->response("Modelo no encontrado con id=$id_zapatilla", 404);
            }
            
            return $this->view->response($modelo);
        }

        public function delete($req, $res){
            if($res->user == null) {
                return $this->view->response("No autorizado", 401);
            }

            $id_zapatilla = $req->params->id;

            $modelo = $this->model->getModelo($id_zapatilla);
            if(!$modelo) {
                return $this->view->response("El modelo con el id=$id_zapatilla no existe", 404);
            }

            $this->model->deleteModelo($id_zapatilla);
            $this->view->response("El modelo con el id= $id_zapatilla se elimino con exito");
        }

        public function create($req, $res){
            if($res->user == null) {
                return $this->view->response("No autorizado", 401);
            }

            if(empty($req->body->id_fabrica) || empty($req->body->precio) || empty($req->body->nombre) || empty($req->body->stock)){
                return $this->view->response('Falta completar campos', 400);
            }

            $nombre = $req->body->nombre;
            $id_fabrica = $req->body->id_fabrica;
            $precio= $req->body->precio;
            $stock = $req->body->stock;

            $id_zapatilla = $this->model->insertModelo($nombre,$id_fabrica,$precio,$stock);

            if(!$id_zapatilla){
                return $this->view->response('Error al agregar modelo', 500);
            }

            $modelo = $this->model->getModelo($id_zapatilla);
            return $this->view->response($modelo, 201);
        }

        public function edit($req, $res){
            if($res->user == null) {
                return $this->view->response("No autorizado", 401);
            }

            $id_zapatilla = $req->params->id; 
        
            $modelo = $this->model->getModelo($id_zapatilla);
            if(!$modelo || !isset($modelo->id_zapatilla)){
                return $this->view->response("El modelo con el id=$id_zapatilla no existe", 404);
            }
        
            if(empty($req->body->id_fabrica) || empty($req->body->precio) || empty($req->body->nombre) || empty($req->body->stock)){
                return $this->view->response('Falta completar campos', 400);
            }
        
            $nombre = $req->body->nombre;
            $id_fabrica = $req->body->id_fabrica;
            $precio= $req->body->precio;
            $stock = $req->body->stock;
        
            $this->model->editar($id_zapatilla, $nombre, $id_fabrica, $precio, $stock);
        
            $modelo = $this->model->getModelo($id_zapatilla);
            $this->view->response($modelo, 200); 
        }
    }
?>