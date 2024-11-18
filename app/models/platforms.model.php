<?php

class platformsModel {
    private $db;

    public function __construct() {
       $this->db = new PDO('mysql:host=localhost;dbname=tienda_videojuegos;charset=utf8', 'root', '');
    }

    public function getPlatforms() {
        $queryPlataformas = $this->db->prepare('SELECT * FROM plataformas');
        $queryPlataformas->execute();

        $platforms = $queryPlataformas->fetchAll(PDO::FETCH_OBJ);

        return $platforms;
    }

    public function getPlatformById($id) {
        $query = $this->db->prepare('SELECT * FROM plataformas WHERE id_plataforma = ?');
        $query->execute([$id]);
        $platform = $query->fetch(PDO::FETCH_OBJ);
        return $platform;

    }
    public function addPlatform($plataforma, $fabricante, $tipo) {
        $query = $this->db->prepare('INSERT INTO plataformas(plataforma, fabricante, tipo) VALUES (?,?,?)');
        $query->execute([$plataforma, $fabricante, $tipo]);
        return $this->db->lastInsertId();
    }

    public function deletePlataform($id) {
        $queryPlataformas = $this->db->prepare('DELETE FROM plataformas WHERE id_plataforma = ?');
        $queryPlataformas->execute([$id]);
    }

    public function updatePlatform($plataforma, $fabricante, $tipo, $id) {
        $queryPlataformas = $this->db->prepare('UPDATE plataformas SET plataforma = ?, fabricante = ?, tipo = ? WHERE id_plataforma = ?');
        $queryPlataformas->execute([$plataforma, $fabricante, $tipo, $id]);
    }
}