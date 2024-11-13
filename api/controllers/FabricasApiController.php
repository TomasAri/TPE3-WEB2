<?php
    require_once 'api/views/json.view.php';
    require_once 'api/models/FabricasModel.php';

    class FabricasApiController{
        private $model;
        private $view;

        public function __construct(){
            $this->model = new FabricasModel();
            $this->view = new JSONView();
        }

        public function getAllFabricas($req, $res){
            //Filtrado por pais
            $Pais = false;
            if(isset($req->query->pais)){
                $Pais = $req->query->pais;
            }
            
            $orderBy = false;
            if(isset($req->query->orderBy)){
                $orderBy = $req->query->orderBy;
            }

            $Direction = false;
            if(isset($req->query->Direction)){
                $Direction = $req->query->Direction;
            }

            //pido las fabricas a la db
            $fabricas = $this->model->getFabricas($Pais, $orderBy, $Direction);

            if(!$fabricas){
                return $this->view->response("No hay fabricas para mostrar", 404);
            }
            //envio las fabricas a la vista
            return $this->view->response($fabricas);
        }

        public function getFabrica($req, $res){
            //obtengo id de las fabricas desde la ruta
            $id = $req->params->id;
            
            $fabrica = $this->model->getFabrica($id);
            
            if(!$fabrica) {
                return $this->view->response("La fabrica con el id=$id no existe", 404);
            }

            return $this->view->response($fabrica);
        }

        public function delete($req, $res){
            if($res->user == null) {
                return $this->view->response("No autorizado", 401);
            }

            $id = $req->params->id;

            $fabrica = $this->model->getFabrica($id);
            if(!$fabrica) {
                return $this->view->response("La fabrica con el id=$id no existe", 404);
            }

            $this->model->deleteFabrica($id);
            $this->view->response("La fabrica con el id= $id se elimino con exito");
        }

        public function create($req, $res){
            if($res->user == null) {
                return $this->view->response("No autorizado", 401);
            }

            if(empty($req->body->nombre) || empty($req->body->importador) || empty($req->body->pais) || empty($req->body->cantidad)){
                return $this->view->response('Falta completar campos', 400);
            }

            $nombre = $req->body->nombre;
            $importador = $req->body->importador;
            $pais= $req->body->pais;
            $cantidad = $req->body->cantidad;

            $id = $this->model->insertFabrica($nombre,$importador,$pais,$cantidad);

            if(!$id){
                return $this->view->response('Error al agregar fabrica', 500);
            }

            $fabrica = $this->model->getFabrica($id);
            return $this->view->response($fabrica, 201);
        }

        public function edit($req, $res){
            if($res->user == null) {
                return $this->view->response("No autorizado", 401);
            }

            $id = $req->params->id;

            $fabrica = $this->model->getFabrica($id);
            if(!$fabrica){
                return $this->view->response("La fabrica con el id=$id no existe", 404);
            }

            if(empty($req->body->nombre) || empty($req->body->importador) || empty($req->body->pais) || empty($req->body->cantidad)){
                return $this->view->response('Falta completar campos', 400);
            }

            $nombre = $req->body->nombre;
            $importador= $req->body->importador;
            $pais = $req->body->pais;
            $cantidad = $req->body->cantidad;

            $this->model->editar($id, $nombre, $importador, $pais, $cantidad);

            $fabrica = $this->model->getFabrica($id);
            $this->view->response($fabrica, 200); 

        }
    }
?>