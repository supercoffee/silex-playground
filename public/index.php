<?php
/**
 * Created by PhpStorm.
 * User: ben
 * Date: 7/28/15
 * Time: 18:26
 */

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/../src/Cakes.php";

$app = new Silex\Application();
$app['debug'] = true;
//list all cakes
$app->get("/cakes", function(){
    $cakes = new Cakes();
    return new JsonResponse($cakes->getAllCakes());
});

$app->post("/cakes/create", function(Request $request){
    $cakes = new Cakes();
    $data = json_decode($request->getContent(), true);
    $cake = $cakes->createCake($data);
    $cakes->save();
    return new JsonResponse($cake);
});

//show a cake
$app->get("/cakes/{id}", function($id){
    $cakes = new Cakes;

    return new JsonResponse($cakes->getCake($id));
});

$app->patch("/cakes/{id}/update", function(Request $request, $id){
    $cakes = new Cakes();

    $oldCake = $cakes->getCake($id);
    if(! $oldCake){
        return new Response("No cake by id {$id}", 404);
    }
    $newCake = json_decode($request->getContent(), true);
//    var_dump($newCake, $oldCake);die;
    $cake = array_merge($oldCake, $newCake);
    $cakes->updateCake($id, $cake);
    $cakes->save();
    return new JsonResponse($cake);
});

$app->delete("/cakes/{id}/delete", function($id){
   $cakes = new Cakes();

    if(! $cakes->getCake($id)){
        return new Response("No cake by id {$id}");
    }

    $cakes->deleteCake($id);
    $cakes->save();
    return new Response();
});

$app->run();
