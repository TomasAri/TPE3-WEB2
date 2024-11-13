<?php
    require_once 'api/models/Model.php';

    class ModelosModel extends Model{

        public function getModelos($Nombre = false, $orderBy = false, $Direction = false){
            $sql = 'SELECT * FROM `modelo`';

            //TPE3-WEB2/api/modelo?nombre=Air Jordan
            if($Nombre){
                $sql .= " WHERE `nombre` = ?";
            }

            //TPE3-WEB2/api/modelo?orderBy=stock
            if($orderBy){
                switch($orderBy){
                    case 'id_zapatilla':
                        $sql .= ' ORDER BY `id_zapatilla`';
                        break;
                    case 'nombre':
                        $sql .= ' ORDER BY `nombre`';
                        break;
                    case 'id_fabrica':
                        $sql .= ' ORDER BY `id_fabrica`';
                        break;
                    case 'precio':
                        $sql .= ' ORDER BY `precio`';
                        break;
                    case 'stock':
                        $sql .= ' ORDER BY `stock`';
                        break;
                }
            }

            //TPE3-WEB2/api/modelo?orderBy=stock&Direction=DESC
            if($Direction == 'DESC'){
                $sql .= ' DESC';
            }

            // Ejecuto la consulta
            $query = $this->db->prepare($sql);

            if($Nombre){
                $query->execute([$Nombre]);
            }else{
                $query->execute();
            }

            // Obtengo los datos en un arreglo de objetos
            $modelos = $query->fetchAll(PDO::FETCH_OBJ); 
    
            return $modelos;
        }

        public function getModelo($id_zapatilla){
            $sql = 'SELECT * FROM modelo WHERE id_zapatilla = ?';

            $query = $this->db->prepare($sql);
            $query->execute([$id_zapatilla]);

            $modelo = $query->fetch(PDO::FETCH_OBJ); 
            
            return $modelo;
        }

        //TPE3-WEB2/api/modelo/:id
        public function deleteModelo($id_zapatilla){
            $sql = 'DELETE FROM modelo WHERE id_zapatilla=?';

            $query = $this->db->prepare($sql);
            $query->execute([$id_zapatilla]);
        }

        public function insertModelo($nombre, $id_fabrica, $precio, $stock){
            $sql = 'INSERT INTO modelo(nombre, id_fabrica, precio, stock) VALUES (?, ?, ?, ?)';

            $query = $this->db->prepare($sql);
            $query->execute([$nombre, $id_fabrica, $precio, $stock]);

            $id_zapatilla = $this->db->lastInsertId();

            return $id_zapatilla;
        }

        public function editar($id_zapatilla, $nombre, $id_fabrica, $precio, $stock){
            $sql = 'UPDATE modelo SET nombre = ?, id_fabrica = ?, precio = ?, stock = ? WHERE id_zapatilla = ?';

            $query = $this->db->prepare($sql);
            $query->execute([$nombre, $id_fabrica, $precio, $stock, $id_zapatilla]);
        }
    }
?>