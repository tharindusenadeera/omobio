<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/omobio/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// files needed to connect to database
include_once '../../config/Database.php';
include_once './../models/Sale.php';

    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // instantiate product object
    $sale = new Sale($db);
    
    // get posted data
    $data = json_decode(file_get_contents("php://input"));

    // set product property values
    $sale->pro_id  = $data->pro_id;
    $sale->user_id = $data->user_id;
    $sale->revenue = $data->revenue;

    // create the product
    if(
        !empty($sale->pro_id) &&
        !empty($sale->user_id) &&
        !empty($sale->revenue) &&
        $sale->create()
    ){
    
        // set response code
        http_response_code(200);
    
        // display message: sale was created
        echo json_encode(array("message" => "sale was created."));
    }else{
    
        // set response code
        http_response_code(400);
    
        // display message: unable to create product
        echo json_encode(array("message" => "Unable to create sale."));
    }

?>