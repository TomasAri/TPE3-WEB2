<?php
    require_once 'api/models/Model.php';

    class FabricasModel extends Model{


        public function getFabricas($Pais = false, $orderBy = false, $Direction = false){
            $sql = 'SELECT * FROM `fabrica`';

            //TP3-WEB2/api/fabrica?pais=Alemania
            if($Pais){
                $sql .= " WHERE `pais` = ?";
            }

            //TP3-WEB2/api/fabrica?orderBy=cantidad
            if($orderBy){
                switch($orderBy){
                    case 'id':
                        $sql .= ' ORDER BY `id`';
                        break;
                    case 'nombre':
                        $sql .= ' ORDER BY `nombre`';
                        break;
                    case 'importador':
                        $sql .= ' ORDER BY `importador`';
                        break;
                    case 'pais':
                        $sql .= ' ORDER BY `pais`';
                        break;
                    case 'cantidad':
                        $sql .= ' ORDER BY `cantidad`';
                        break;
                }
            }

            //TP3-WEB2/api/fabrica?orderBy=cantidad&Direction=DESC
            if($Direction == 'DESC'){
                $sql .= ' DESC';
            }

            //Ejecuto la consulta
            $query = $this->db->prepare($sql);

            if($Pais){
                $query->execute([$Pais]);
            }else{
                $query->execute();
            }

            //Obtengo los datos en un arreglo de objetos
            $fabricas = $query->fetchAll(PDO::FETCH_OBJ); 
    
            return $fabricas;
        }

        public function getFabrica($id){
            $sql = 'SELECT * FROM fabrica WHERE id = ?';

            $query = $this->db->prepare($sql);
            $query->execute([$id]);

            $fabrica = $query->fetch(PDO::FETCH_OBJ); 
            
            return $fabrica;
        }

        //TP3-WEB2/api/fabrica/:id
        public function deleteFabrica($id){
            $sql = 'DELETE FROM fabrica WHERE id=?';

            $query = $this->db->prepare($sql);
            $query->execute([$id]);
        }

        public function insertFabrica($nombre, $importador, $pais, $cantidad){
            $sql = 'INSERT INTO fabrica(nombre, importador, pais, cantidad) VALUES (?, ?, ?, ?)';

            $query = $this->db->prepare($sql);
            $query->execute([$nombre, $importador, $pais, $cantidad]);

            $id = $this->db->lastInsertId();

            return $id;
        }

        public function editar($id, $nombre, $importador, $pais, $cantidad){
            $sql = 'UPDATE fabrica SET nombre = ?, importador = ?, pais = ?, cantidad = ? WHERE id = ?';

            $query = $this->db->prepare($sql);
            $query->execute([$nombre, $importador, $pais, $cantidad, $id]);
        }
    }

?>