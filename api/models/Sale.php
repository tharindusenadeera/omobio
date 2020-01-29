<?php
//'sales' object 

class Sale {

    // database connection and table name
    private $conn;
    private $table_name = "sales";

    // object properties
    public $id;
    public $pro_id;
    public $user_id;
    public $revenue;

    // constructor
    public function __construct($db){
        $this->conn = $db;
    }

    //create new product
    function create(){

        // insert query
        $query = "INSERT INTO " . $this->table_name . "
                SET
                pro_id = :pro_id,
                user_id = :user_id,
                revenue = :revenue";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->pro_id=htmlspecialchars(strip_tags($this->pro_id));
        $this->user_id=htmlspecialchars(strip_tags($this->user_id));
        $this->revenue=htmlspecialchars(strip_tags($this->revenue));
    
        // bind the values
        $stmt->bindParam(':name', $this->pro_id);
        $stmt->bindParam(':description', $this->user_id);
        $stmt->bindParam(':price', $this->revenue);

        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    function update(){

        $query = "UPDATE " . $this->table_name . "
        SET
        revenue = :revenue,
        WHERE id = :id";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->revenue=htmlspecialchars(strip_tags($this->revenue));

        // bind the values from the form
        $stmt->bindParam(':name', $this->revenue);

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

    function revenuesAccordingToAUser(){

        $query = "SELECT user.first_name, user.last_name, sales.revenue, products.name FROM users
                    LEFT JOIN sales
                    ON users.id == sales.user_id
                    LEFT JOIN producrs
                    ON sales.pro_id == products.id
                    where users.id = :id";

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