<?php
/**
 * Created by PhpStorm.
 * User: ben
 * Date: 7/28/15
 * Time: 18:33
 */

class Cakes {

    private $cakeFile;

    private $cakes = array();

    private $schema = array(
        "id" => 0,
        "name" => "",
        "flavor" => "",
        "frosting" => "",
        "options" => array(),
    );

    function __construct() {
        $this->cakeFile = __DIR__."/../config/cakes.json";

        $this->prepare();
        $this->loadCakes();
    }

    private function prepare() {
        $dir = dirname($this->cakeFile);
        if(! is_dir($dir)){
            mkdir($dir);
        }
    }

    private function loadCakes() {
        if(file_exists($this->cakeFile)){
            $contents = file_get_contents($this->cakeFile);
            $this->cakes = json_decode($contents, true);
        }
    }

    public function getAllCakes(){
        return $this->cakes;
    }

    public function getCake($id){
        foreach($this->cakes as $cake){
            if($cake && $cake['id'] == $id){
                return $cake;
            }
        }
        return null;
    }

    public function createCake($cake){
        $cake['id'] = sizeof($this->cakes);
        array_push($this->cakes, $cake);
        return $cake;
    }

    public function updateCake($id, $cake){

        $this->cakes[$id] = $cake;
        return $cake;
    }

    public function deleteCake($id){
        if(array_key_exists($id, $this->cakes)){
            unset($this->cakes[$id]);
        }
    }

    public function save() {

        file_put_contents($this->cakeFile, json_encode($this->cakes));

    }

}