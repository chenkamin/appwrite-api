<?php

use Utopia\App;
use Utopia\Exception;
use Utopia\Response;
use Utopia\Swoole\Request;
use Utopia\CLI\Console;
use Utopia\Validator\Text;
use Utopia\Validator\Integer;
use Utopia\Validator\Range;



App::get(BASE_URL .'/vehicles')
    ->desc('Get all vehicles')
    ->action(function ($request ,$response) {
				$id = $request->getParam("id");	
				$vehicles =	getVehicleById($id);
				$response
					->setStatusCode(Response::STATUS_CODE_OK)
					->json([
						"data" => ["vehicles" =>$vehicles]]);       
    }, ['request', 'response']);

  

App::post(BASE_URL . '/vehicles')
    ->desc('Create a new vehicle')
    ->action(function ($request,$response) {
        //mock insert and validation
        $vehicle = $request->getPayload('vehicle');
        $model = $request->getPayload('model');
        if(!isset($vehicle) || !isset($model)){
					$response
            ->setStatusCode(Response::STATUS_CODE_BAD_REQUEST)
            ->json([	
							"status" => "fail",
							"msg" => "vehicle and model are required"
						]);
        }
        $id = "nkjdwq87wqdhwqd6";
        $newVehicles = ["vehicle"=>$vehicle , "model" =>$model , "id" =>$id];
        $response
        	->setStatusCode(Response::STATUS_CODE_CREATED)
        	->json([
						"status" => "success",
						"data" => ["vehicle" =>$newCar]
          ]);
    }, ['request','response']);

App::put(BASE_URL . '/vehicles')
    ->desc('Update a new vehicle')
    ->action(function ($request, $response) {
			$id = $request->getQuery("id");	
			$vehicles =	getVehicleById($id);
			$updatedVehicle = $vehicles;
			$response
			->setStatusCode(Response::STATUS_CODE_OK)
			->json([
				"status" => "success",
				"data" => ["vehicles" =>$updatedVehicle]]);       
		}, ['request', 'response']);

App::delete(BASE_URL . '/vehicles')
    ->desc('Delete a vehicle')
    ->action(function ($request, $response) {
			$response  	
				->setStatusCode(Response::STATUS_CODE_NOCONTENT)
				->json([
					"status" => "success",
					"data" => null
				]);
		}, ['request', 'response']);
		

		function getVehicleById($id){
			$vehicles = json_decode(file_get_contents(MOCK_DATA . '/vehicles.json'), true);
			if($id){
				foreach ($vehicles as $key => $v) {
					if($v['id'] == $id){
					return	$vehicles = $v;
					}
				}
			}
			return $vehicles;
		}