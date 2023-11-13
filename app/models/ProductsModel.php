<?php

require_once 'app/models/Model.php';

class ProductsModel extends model {

  
    public function getProducts($sort, $order, $limit, $offset)
    { 
        $query = $this->db->prepare("SELECT productos.*, productos_clases.clase  
                                    FROM productos INNER JOIN productos_clases 
                                    ON productos.clase = productos_clases.id_clases
                                    ORDER BY $sort $order
                                    LIMIT $limit 
                                    OFFSET $offset");
        $query->execute(); 
        $products = $query->fetchAll(PDO::FETCH_OBJ); 
        return $products;  
    }

    function getProductsFilter($sort, $order, $limit, $offset, $filterBy, $filterValue){
        $query = $this->db->prepare("SELECT productos.*, productos_clases.clase
                                     FROM productos
                                     JOIN productos_clases
                                     ON productos.clase = productos_clases.id_clases
                                     WHERE productos_clases.clase = ?
                                     ORDER BY $sort $order
                                     LIMIT $limit OFFSET $offset");
        $query->execute([$filterValue]);
        $products = $query->fetchAll(PDO::FETCH_OBJ);
        return $products;
    }

    function getColumns(){
        $query = $this->db->prepare('DESCRIBE productos'); //proporciona información sobre las columnas de una tabla
        $query->execute();
        $resultcolumns = $query->fetchAll(PDO::FETCH_OBJ);
        return $resultcolumns;
    }

    public function getProduct($id)
    {
        $query = $this->db->prepare("SELECT productos.*, productos_clases.clase  FROM productos INNER JOIN productos_clases ON productos.clase = productos_clases.id_clases WHERE id_producto=?");
        $query->execute(array($id));
        $product = $query->fetch(PDO::FETCH_OBJ);
        return $product;
    }

    function deleteProduct($id)
    {
        $query = $this->db->prepare("DELETE FROM productos WHERE id_producto=?");
        $query->execute(array($id));
    }

    public function insertProduct($producto, $clase, $cantidad, $descuento, $precio_u)
    {
        $query = $this->db->prepare("INSERT INTO productos(producto, clase , cantidad, descuento, precio_u) VALUES(?, ?, ?, ?, ?)");
        $query->execute(array($producto, $clase, $cantidad, $descuento, $precio_u));
        return $this->db->lastInsertId();
    }

    function updateProduct($id_producto, $producto, $clase, $cantidad, $descuento, $precio_u)
    {
        $query = $this->db->prepare("UPDATE productos SET producto=?, clase=?, cantidad=?, descuento=?, precio_u=? WHERE id_producto=?");
        $query->execute(array($producto, $clase, $cantidad, $descuento, $precio_u, $id_producto)); //los parametros van en el mismo orden de la preparacion
        return $query->fetch(PDO::FETCH_OBJ);
        
    }

}
