<?php
class Post
{
    // DB stuff 
    private $conn;
    private $table = 'posts';

    // Post proparities [name of columns]
    public $id;
    public $category_name;
    public $category_id;
    public $title;
    public $body;
    public $author;
    public $created_at;

    // the constructor to bind the conn 
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // CRUD to access this table 

    // Read all. Get all
    public function read()
    {
        // write the query 
        $query = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at
                FROM ' . $this->table . 'p 
                LEFT JOIN 
                 categories c ON p.category_id = c.id
                 ORDER BY 
                 p.created_at DESC';
        // prepare the query 
        $stmt = $this->conn->prepare($query);

        // execute the query 

        $stmt->execute();

        return $stmt;
    }

    // Get single post

    public function read_single()
    {

        $query = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.author. p.created_at 
              FROM ' . $this->table . 'p 
              LEFT JOIN 
              categories c ON p.category_id = c.id 
              WHERE p.id=?
              LIMIT 0,1';

        $stmt = $this->conn->prepare($query);
        // After praparing we want to bind the param 
        $stmt->bindParam(1, $this->id);
        // Execute it
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
    }

    // Create a post 
    public function create()
    {
     // Create query
     $query = 'INSERT INTO ' . $this->table . ' SET title = :title, body = :body, author = :author, category_id = :category_id';

     // Prepare statement
     $stmt = $this->conn->prepare($query);

     // Clean data
     $this->title = htmlspecialchars(strip_tags($this->title));
     $this->body = htmlspecialchars(strip_tags($this->body));
     $this->author = htmlspecialchars(strip_tags($this->author));
     $this->category_id = htmlspecialchars(strip_tags($this->category_id));

     // Bind data
     $stmt->bindParam(':title', $this->title);
     $stmt->bindParam(':body', $this->body);
     $stmt->bindParam(':author', $this->author);
     $stmt->bindParam(':category_id', $this->category_id);

     // Execute query
     if($stmt->execute()) {
       return true;
 }

 // Print error if something goes wrong
 printf("Error: %s.\n", $stmt->error);

 return false;
}


    public function update()
    {

        $query = 'UPDATE ' . $this->table .
            'SET title = :title, body = :body, author = :author, category_id = :category_id
             WHERE id= :id';

        $stmt = $this->conn->prepare($query);

        // Clean Data 
        $this->title = Tools::cleanData($this->title);
        $this->body = Tools::cleanData($this->body);
        $this->author = Tools::cleanData($this->author);
        $this->category_id = Tools::cleanData($this->category_id);
        $this->id = Tools::cleanData($this->id);


        // Bind param 
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->Error);
        return false;
    }

    public function delete(){
        $query = 'DELETE FROM ' . $this->table . 'WHERE id = :id';
        $stmt = $this->conn->prapare($query);
        // Clean data 
        $this->id = Tools::cleanData($this->id);
        // Bind data
        $stmt->bindParam(':id', $this->id);
        if($stmt->execute()){
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        return false;
    }


}
