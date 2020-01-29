<?php
//'products' object 

class Product {

    // database connection and table name
    private $conn;
    private $table_name = "products";

    // object properties
    public $id;
    public $name;
    public $description;
    public $price;

    // constructor
    public function __construct($db){
        $this->conn = $db;
    }

    //create new product
    function create(){

        // insert query
        $query = "INSERT INTO " . $this->table_name . "
                SET
                name = :name,
                description = :description,
                price = :price";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->first_name));
        $this->description=htmlspecialchars(strip_tags($this->last_name));
        $this->price=htmlspecialchars(strip_tags($this->email));
    
        // bind the values
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':price', $this->price);

        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    function update(){

        $query = "UPDATE " . $this->table_name . "
        SET
        name = :name,
        description = :description,
        price = :price,
        WHERE id = :id";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->price=htmlspecialchars(strip_tags($this->price));

        // bind the values from the form
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':price', $this->price);

        // unique ID of record to be edited
        $stmt->bindParam(':id', $this->id);

        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    function view(){

        $query = "SELECT * FROM " . $this->table;

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // execute the query
        if($stmt->execute()){
            return $stmt->fetchAll();
        }
    
        return false;
    }

    function show(){

        $query = "SELECT * FROM " . $this->table . "WHERE id = :id";

        //prepare the query
        $stmt = $this->conn->prepare($query);

        // execute the query
        if($stmt->execute()){
            return $stmt->fetchAll();
        }
    
        return false;
    }
}
?>