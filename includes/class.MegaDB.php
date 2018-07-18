<?

include("class.DB.php");

/**
 * A barebones wrapper for the PDO class.
 */
class MegaDB {
    /**
     * This is the PDO object that maintains a connection to the database.
     */
    static $pdo;
    /**
     * Connects to the database, instantiating the PDO if necessary.
     */
    static function connect(){
        if(empty(MegaDB::$pdo)) {
            try {
                MegaDB::$pdo = new PDO(DB::HOST, DB::USER, DB::PASS);
            } catch (Exception $e){
                die("uh oh! it looks like our database is down...");
            }
        }
        return MegaDB::$pdo ? true : false;
    }
    static function query(string $query, array $params){
        
        if(DB::DEBUG){
            echo "\n $query -- PARAMS: (";
            foreach($params as $p) echo "$p, ";
            echo ") \n";
        }
        
        MegaDB::connect();
        
        $stmt = MegaDB::$pdo->prepare($query); // returns a PDOStatement object
        $stmt->execute($params);
        return (array) $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}


?>