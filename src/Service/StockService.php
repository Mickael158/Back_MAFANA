<?php

namespace App\Service;

use App\Entity\Materiel;

class StockService{
    public Materiel $materiel;
    public int $nombre;

    public function getMateriel(){
        return $this->materiel;
    }

    public function setMateriel(Materiel $materiel){
        $this->materiel = $materiel;
        return $this;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function setNombre(int $nombre){
        $this->nombre = $nombre;
        return $this;
    }
}