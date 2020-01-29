<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/omobio/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// files needed to connect to database
include_once '../../config/Database.php';
include_once './../models/Product.php';
 
    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // instantiate product object
    $product = new Product($db);
    
    // get posted data
    $data = json_decode(file_get_contents("php://input"));

    // set product property values
    $product->name = $data->name;
    $product->description = $data->description;
    $product->price = $data->price;
 
    // create the product
    if(
        !empty($product->name) &&
        !empty($product->description) &&
        !empty($product->price) &&
        $product->create()
    ){
    
        // set response code
        http_response_code(200);
    
        // display message: product was created
        echo json_encode(array("message" => "Product was created."));
    }else{
    
        // set response code
        http_response_code(400);
    
        // display message: unable to create product
        echo json_encode(array("message" => "Unable to create product."));
    }

?>