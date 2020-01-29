<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/omobio/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// files needed to connect to database
include_once '../../config/Database.php';
include_once './../models/User.php';
 
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
    
    // instantiate sale object
    $sale = new Sale($db);

    //view sales
    if(
        $sale->view()
    ){
        // set response code
        http_response_code(200);
    
        echo json_encode(array("message" => $sale->view()));
    }else{
    
        // set response code
        http_response_code(400);
    
        // display message: unable to view product
        echo json_encode(array("message" => "Unable to view sales."));
    }

?>