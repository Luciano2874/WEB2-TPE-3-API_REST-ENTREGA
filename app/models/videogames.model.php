<?php

class videogamesModel {

    private $db;

    public function __construct() {
       $this->db = new PDO('mysql:host=localhost;dbname=tienda_videojuegos;charset=utf8', 'root', '');
    }

    public function getAllVideogames($id_plataforma, $orderBy = false, $order_dir = false, $pageSize = 5, $page) {
        $sql = 'SELECT * FROM videojuegos';
        // se verificó en el controller que $page y $pageSize sean números enteros.
        $offset = $pageSize * $page;

        if ($id_plataforma != 0) {
            $sql .= " WHERE id_plataforma = ?";
        }

        if ($orderBy && $order_dir) {
            switch ($orderBy) {
                case 'id_juego':   
                    $sql .= " ORDER BY id_juego";
                    break;
                case 'nombre':   
                    $sql .= " ORDER BY nombre";
                    break;
                case 'desarrollador':   
                    $sql .= " ORDER BY desarrollador";
                    break;
                case 'distribuidor':   
                    $sql .= " ORDER BY distribuidor";
                    break;
                case 'genero':   
                    $sql .= " ORDER BY genero";
                    break;
                case 'fecha_lanzamiento':
                    $sql .= " ORDER BY fecha_lanzamiento";
                    break;
                case 'id_plataforma':
                    $sql .= " ORDER BY id_plataforma";
                    break;
                case 'modos_de_juego':
                    $sql .= " ORDER BY modos_de_juego";
                    break;
                case 'precio':
                    $sql .= " ORDER BY precio";
                    break;
                default:
                    return NULL;
                    break;
            }

            switch ($order_dir) {
                case 'ASC':
                    $sql .= " ASC";
                    break;
                case 'DESC':
                    $sql .= " DESC";
                    break;
            }
        }

        $sql .= " LIMIT $pageSize OFFSET $offset";
        
        $queryVideogames = $this->db->prepare($sql);
        if ($id_plataforma != 0) {
            $queryVideogames->execute([$id_plataforma]);
        } else {
            $queryVideogames->execute();
        }
        

        $videogames = $queryVideogames->fetchAll(PDO::FETCH_OBJ);

        return $videogames;
    }


    public function getVideogameById($id) {
        $queryVideogames = $this->db->prepare('SELECT * FROM videojuegos WHERE id_juego = ?');
        $queryVideogames->execute([$id]);

        $videogame = $queryVideogames->fetch(PDO::FETCH_OBJ);

        return $videogame;
    }

 


    public function insertVideogames($nombre, $desarrollador, $distribuidor, $genero, $fecha_lanzamiento, $id_plataforma, $modos_de_juego, $precio) {
        $queryVideogames = $this->db->prepare('INSERT INTO videojuegos (nombre, desarrollador, distribuidor, genero, fecha_lanzamiento, id_plataforma, modos_de_juego, precio) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $queryVideogames->execute([$nombre, $desarrollador, $distribuidor, $genero, $fecha_lanzamiento, $id_plataforma, $modos_de_juego, $precio]);

        return $this->db->lastInsertId();
    }

    public function deleteVideogame($id) {
        $queryVideogames = $this->db->prepare('DELETE FROM videojuegos WHERE id_juego = ?');
        $queryVideogames->execute([$id]);
    }

    public function updateVideogame($nombre, $desarrollador, $distribuidor, $genero, $fecha_lanzamiento, $id_plataforma, $modos_de_juego, $precio, $id) {
        $queryVideogames = $this->db->prepare('UPDATE videojuegos SET nombre = ?,desarrollador = ?,distribuidor = ?,genero = ?,fecha_lanzamiento = ?,id_plataforma = ?,modos_de_juego = ?,precio = ? WHERE id_juego = ?');
        $queryVideogames->execute([$nombre, $desarrollador, $distribuidor, $genero, $fecha_lanzamiento, $id_plataforma, $modos_de_juego, $precio, $id]);
    }
} 