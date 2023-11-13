<?php

require_once 'app/models/ProductsModel.php';
require_once 'app/views/ApiView.php';

class ApiProductsController
{
    private $model;
    private $view;

    private $data;

    public function __construct()
    {
        $this->model = new ProductsModel();
        $this->view = new ApiView();

        // lee el body del request
        $this->data = file_get_contents("php://input");
    }

    private function getData()
    {
        return json_decode($this->data);
    }

    function getProducts($params = [])
    {

        $sort = $_GET['sort'] ?? "clase"; //Orden por Clase
        $order = $_GET['order'] ?? "asc"; //Orden Ascendente
        $page = (int)($_GET['page'] ?? 1); //Paginado
        $limit = (int)($_GET['limit'] ?? 10); //Paginado
        $filterBy = $_GET['filterBy'] ?? null; //Filtrado por clase
        $filterValue = $_GET['filterValue'] ?? null; //Elección de la clase para filtrar

        $columns = $this->getColumns(); //Traigo los nombres de las columnas

        // in_array — Checks if a value exists in an array
        // strtolower - Devuelve el string en minúsculas
        if (($sort == 'clase' || in_array(strtolower($sort), $columns)) && (strtolower($order == "asc") || strtolower($order == "desc"))) {

            //Asigna un valor $sort para pasar al modelo en funcion del campo por el que se quiere ordenar
            if ($sort == 'clase') {
                $sort = 'productos_clases.clase';
            } else {
                $sort = 'productos.' . $sort;
            }

            if ((is_numeric($page) && $page > 0) && (is_numeric($limit) && $limit > 0)) { //validacion de paginado

                $offset = ($page * $limit) - $limit;  //Las cláusulas "limit" y "offset" se usan para restringir los registros que se retornan en una consulta "select". La cláusula limit recibe un argumento numérico positivo que indica el número máximo de registros a retornar; la cláusula offset indica el número del primer registro a retornar.

                if ($filterBy != null && $filterValue != null) { // Verifica si existen los parámetros de filtrado


                    if ($filterBy == 'clase' || in_array(strtolower($filterBy), $columns)) {

                        $filter = 'productos_clases';

                        $result = $this->model->getProductsFilter($sort, $order, $limit, $offset, $filter, $filterValue);

                        // Verifica si la consulta se realizó correctamente y si esta vacia
                        if (isset($result)) {

                            if (empty($result)) {
                                $this->view->response("The search performed returned no results", 204);
                            } else {
                                $this->view->response($result, 200);
                            }
                        } else {
                            $result = $this->view->response("The query couldn't be performed", 500);
                        }
                    } else {
                        $result = $this->view->response("Bad Request - Invalid filter parameter", 400);
                    }
                } else {
                    //Obtiene todos los productos del modelo y pasa los parametros de ordenamiento y paginado.
                    $result = $this->model->getProducts($sort, $order, $limit, $offset);
                    $this->view->response($result, 200);
                }
            } else {
                $result = $this->view->response("Bad Request - Invalid filter parameter", 400);
            }
        } else {
            $result = $this->view->response("Bad Request - Invalid filter parameter", 400);
        }
    }


    function getColumns($params = null)
    {
        $columns = []; //arreglo vacío para almacenar los nombres de las columnas
        $resultcolumns = $this->model->getColumns();

        foreach ($resultcolumns as $column) {
            array_push($resultcolumns, $column->Field); //Recorre el arreglo y trae el nombre del campo de la columna.
        }
        return $columns; //devuelve un arreglo con los nombres de las columnas
    }


    function getProduct($params = [])
    {
        $idProduct = $params[":ID"];
        if (is_numeric($idProduct) && ($idProduct) > 0) {
            $product = $this->model->getProduct($idProduct);
            if ($product) {
                return $this->view->response($product, 200);
            } else {
                return $this->view->response("El producto con el ID $idProduct no existe", 404);
            }
        } else {
            return $this->view->response("El producto con  ID $idProduct  no tiene un parametro valido", 400);
        }
    }

    function deleteProduct($params = [])
    {
        $idProduct = $params[":ID"];
        $product = $this->model->getProduct($idProduct);

        if ($product) {
            $this->model->deleteProduct($idProduct);
            return $this->view->response("El producto con el ID $idProduct ha sido borrado", 200);
        } else {
            return $this->view->response("El producto con el ID $idProduct no existe", 404);
        }
    }

    function createProduct($params = null)
    { //no es necesario poner params pq lo voy a crear
        // obtengo el body del request (json)
        $body = $this->getData();

        //VALIDACIONES -> 400 (BAD REQUEST) valida si falta alguno o no cumple requisitos
        if (
            !empty($body->producto) &&
            !empty($body->clase) && is_numeric($body->clase) &&
            !empty($body->cantidad) && is_numeric($body->cantidad) &&
            !empty($body->descuento) && is_numeric($body->descuento) &&
            !empty($body->precio_u) && is_numeric($body->precio_u)
        ) {
            $id = $this->model->insertProduct($body->producto, $body->clase, $body->cantidad, $body->descuento, $body->precio_u);

            if ($id != 0) {
                $this->view->response("El producto fue insertado correctamente con el ID  $id", 201);
                // muestro el último ID creado para corroborarlo
                $product = $this->model->getProduct($id);
                return $this->view->response($product, 201);
            } else {
                $this->view->response("El producto no pudo ser insertado", 500);
            }
        } else {
            $this->view->response("BAD REQUEST - Por favor, complete todos los campos", 400);
        }
    }



    function updateProduct($params = null)
    {
        $idProduct = $params[':ID'];
        $body = $this->getData();
        //VALIDACIONES -> 400 (BAD REQUEST) valida si falta alguno 
        if (
            empty($body->producto) &&
            empty($body->clase) &&
            empty($body->cantidad) &&
            empty($body->descuento) &&
            empty($body->precio_u)
        ) {
            $this->view->response("BAD REQUEST - Por favor, chequee todos los campooooos", 400);
        } else {
            $product = $this->model->getProduct($idProduct);

            if ($product) { 
                if (
                    !empty($body->producto) &&
                    !empty($body->clase) && is_numeric($body->clase) &&
                    !empty($body->cantidad) && is_numeric($body->cantidad) &&
                    !empty($body->descuento) && is_numeric($body->descuento) &&
                    !empty($body->precio_u) && is_numeric($body->precio_u)
                    
                ) {
                    $this->model->updateProduct($idProduct, $body->producto, $body->clase, $body->cantidad, $body->descuento, $body->precio_u);
                    return $this->view->response("El producto con el ID $idProduct ha sido actualizado correctamente", 200);
                } else {
                    return $this->view->response("BAD REQUEST - Por favor, chequee todos los campos del producto ocn ID $idProduct", 400);
                }
            } else {
                return $this->view->response("El producto con el ID $idProduct no existe", 404);
            }
        }
    }
}
