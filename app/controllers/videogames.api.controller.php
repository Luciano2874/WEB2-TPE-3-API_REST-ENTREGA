<?php

require_once './app/models/videogames.model.php';
require_once './app/models/platforms.model.php';
require_once './app/views/json.view.php';

class VideogamesApiController {

    private $videogamesModel;
    private $JSONView;
    private $platformsModel;

    public function __construct(){
        $this->videogamesModel = new videogamesModel();
        $this->JSONView = new JSONView();
        $this->platformsModel = new platformsModel;
    }

    public function getAll($req, $res) {
        $id_plataforma = 0;

        $page = 1;
        $pageSize = 5;

        $orderBy = false;
        $order_dir = false;
        
        if (isset($req->query->id_plataforma)) {
            $id_plataforma = $req->query->id_plataforma;
            $platform = $this->platformsModel->getPlatformById($id_plataforma);
            if (empty($platform)) {
                return $this->JSONView->response("La plataforma con el id: $id_plataforma no existe", 404);
            }
        }

        // se verifica que $pageSize sea un entero y mayor o igual a uno
        if (isset($req->query->pageSize) &&  ctype_digit($req->query->pageSize) && $req->query->pageSize >= 1)  {
            $pageSize = $req->query->pageSize;
        } else if (isset($req->query->pageSize)) {
            return $this->JSONView->response("El límite establecido de la cantidad de items por página no es válida. El valor debe de ser entero mayor o igual a 1.", 400);
        }

        // se verifica que $page sea un entero y mayor o igual a uno
        if (isset($req->query->page) &&  ctype_digit($req->query->page) && $req->query->page >= 1)  {
            $page = $req->query->page;
        } else if (isset($req->query->page)) {
            return $this->JSONView->response("La página que buscas no existe.", 404);
        }
        
        if (isset($req->query->orderBy)) {
            $orderBy = $req->query->orderBy;
            if (isset($req->query->order_dir)) {
                $order_dir = $req->query->order_dir;
            }
        }
        $videogames = $this->videogamesModel->getAllVideogames($id_plataforma, $orderBy, $order_dir, $pageSize, $page - 1);
    

        if (!$videogames) {
            return $this->JSONView->response("No se han encontrado items.");
        }

        return $this->JSONView->response($videogames);
    }


    public function get($req, $res) {
        $id_juego = $req->params->id_juego;
       
        $videogame = $this->videogamesModel->getVideogameById($id_juego);

        if (!$videogame) {
            return $this->JSONView->response("El juego con el id: $id_juego no existe", 404);
        }

        return $this->JSONView->response($videogame);
    }


    public function create($req, $res) {
        $newVideogame = $req->body;

        if (empty($newVideogame->nombre) || empty($newVideogame->desarrollador) || empty($newVideogame->distribuidor) || empty($newVideogame->genero) || empty($newVideogame->fecha_lanzamiento) || empty($newVideogame->id_plataforma) || empty($newVideogame->modos_de_juego) || empty($newVideogame->precio)) {
            return $this->JSONView->response("Faltan completar datos o los datos son inválidos.", 400);
        }

        $nombre = $newVideogame->nombre;
        $desarrollador = $newVideogame->desarrollador;
        $distribuidor = $newVideogame->distribuidor;
        $genero = $newVideogame->genero;
        $fecha_lanzamiento = $newVideogame->fecha_lanzamiento;
        $id_plataforma = $newVideogame->id_plataforma;
        $modos_de_juego = $newVideogame->modos_de_juego;
        $precio = $newVideogame->precio;

        $platform = $this->platformsModel->getPlatformById($id_plataforma);
        if (empty($platform)) {
            return $this->JSONView->response("La plataforma con el id: $id_plataforma no existe", 404);
        }

        if ($precio <= 0) {
            return $this->JSONView->response("El precio : $precio no es válido", 400);
        }


        $id_juego = $this->videogamesModel->insertVideogames($nombre, $desarrollador, $distribuidor, $genero, $fecha_lanzamiento, $id_plataforma, $modos_de_juego, $precio);
        

        if(!$id_juego) {
            return $this->JSONView->response("Error al insertar tarea.", 500);
        }

        $videogame = $this->videogamesModel->getVideogameById($id_juego);
        return $this->JSONView->response($videogame, 201);
    }



    public function delete($req, $res) {
        $id_juego = $req->params->id_juego;
       
        $videogame = $this->videogamesModel->getVideogameById($id_juego);

        if (!$videogame) {
            return $this->JSONView->response("El videojuego con el id: $id_juego no existe", 404);
        }

        $this->videogamesModel->deleteVideogame($id_juego);
        return $this->JSONView->response("Se ha eliminado con el éxito el videojuego con el ID: $id_juego");
    }



    public function update($req, $res) {
        $id_juego = $req->params->id_juego;

        $videogame = $this->videogamesModel->getVideogameById($id_juego);

        if (!$videogame) {
            return $this->JSONView->response("El videojuego con el id: $id_juego no existe", 404);
        }

        $updateVideogame = $req->body;

        if (empty($updateVideogame->nombre) || empty($updateVideogame->desarrollador) || empty($updateVideogame->distribuidor) || empty($updateVideogame->genero) || empty($updateVideogame->fecha_lanzamiento) || empty($updateVideogame->id_plataforma) || empty($updateVideogame->modos_de_juego) || empty($updateVideogame->precio)) {
            return $this->JSONView->response("Faltan completar datos o los datos son inválidos.", 400);
        }

        $nombre = $updateVideogame->nombre;
        $desarrollador = $updateVideogame->desarrollador;
        $distribuidor = $updateVideogame->distribuidor;
        $genero = $updateVideogame->genero;
        $fecha_lanzamiento = $updateVideogame->fecha_lanzamiento;
        $id_plataforma = $updateVideogame->id_plataforma;
        $modos_de_juego = $updateVideogame->modos_de_juego;
        $precio = $updateVideogame->precio;



        $platform = $this->platformsModel->getPlatformById($id_plataforma);
        if (empty($platform)) {
            return $this->JSONView->response("La plataforma con el id: $id_plataforma no existe", 404);
        }
        
        if ($precio <= 0) {
            return $this->JSONView->response("El precio : $precio no es válido", 400);
        }


        $this->videogamesModel->updateVideogame($nombre, $desarrollador, $distribuidor, $genero, $fecha_lanzamiento, $id_plataforma, $modos_de_juego, $precio, $id_juego);

        $videogame = $this->videogamesModel->getVideogameById($id_juego);
        return $this->JSONView->response($videogame, 200);
    }


}