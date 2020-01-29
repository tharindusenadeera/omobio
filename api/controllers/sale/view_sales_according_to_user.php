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
    
    // instantiate sale object
    $sale = new Sale($db);

    // get posted data
    $data = json_decode(file_get_contents("php://input"));

    // get jwt
    $jwt=isset($data->jwt) ? $data->jwt : "";

    if($jwt){

        try{
            // decode jwt
            $decoded = JWT::decode($jwt, $key, array('HS256'));
            if(
                $sale->revenuesAccordingToAUser()
            ){
                // set response code
                http_response_code(200);
            
                echo json_encode(array("message" => $sale->revenuesAccordingToAUser()));
            }else{
            
                // set response code
                http_response_code(400);
            
                // display message: unable to view product
                echo json_encode(array("message" => "Unable to view sales."));
            }

        }catch (Exception $e){
            // set response code
            http_response_code(401);

            // show error message
            echo json_encode(array(
                "message" => "Access denied.",
                "error" => $e->getMessage()
            ));
        }
    }
?>