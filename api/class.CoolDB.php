<?

include("class.DB.php");

/**
 * This is my attempt at a high-level, convenient abstraction for MySQL.
 * Use with caution, as I'm sure it has some flaws.
 *
 * The CoolDB interface uses method-chaining for convenience.
 */
class CoolDB {
    /**
     * This is the PDO object that maintains a connection to the database.
     * I only want one of these, so I'm using the Singleton design pattern here.
     */
    private static $pdo;
    /**
     * This holds the query that will sent when calling execute().
     * The various methods in this class build up the query string.
     */
    private $query = "";
    /**
     * This array stores multiple parameters that will be fed to the PDO object.
     */
    private $params = array();
    
    /**
     * The current table we're working in. This isn't cleared after a call to execute(),
     * so it isn't necessary to call table() for each consecutive query in the same table.
     */
    private $table;
        
    function __construct(){
        $this->connect();
    }
    /**
     * Connects to the database, instantiating the PDO singleton if necessary.
     */
    function connect(){
        if(empty(CoolDB::$pdo)) CoolDB::$pdo = new PDO(DB::HOST, DB::USER, DB::PASS);
        
        return CoolDB::$pdo ? true : false;
    }
    /**
     * This flushes the array of SQL parts.
     */
    function clear(){
        $this->query = "";
        $this->params = array();
    }
    /**
     * Sets the table. This will cause the parts array to be flushed.
     */
    function table($table){
        $this->clear();
        $this->table = CoolDB::escapeField($table);
        return $this;
    }
    /**
     * Begins a DELETE query.
     */
    function delete() {
        
        $this->query = "DELETE FROM {$this->table}";
        
        return $this;
    }
    /**
     * Begins a SELECT query.
     */
    function select($fields = "*", bool $filterFields = true) {
        
        if($filterFields === true){
            if (is_string($fields)) $fields = CoolDB::escapeField($fields);
            if (empty($fields)) $fields = "*";
            if (is_array($fields)){
                $temp = "";
                foreach($fields as $field){
                    if(!empty($temp)) $temp .= ", ";
                    $temp .= CoolDB::escapeField($field);
                }
                $fields = $temp;
            }
        }
                
        $this->query = "SELECT {$fields} FROM {$this->table}";
        
        return $this;
    }
    /**
     * Begins an INSERT query.
     */
    function insert($kvp){
        
        $cols = array();
        $vals = array();
        foreach($kvp as $key => $val){
            
            $cols []= CoolDB::escapeField($key);
            
            if      ($val === null ) $vals []= " NULL";
            elseif  ($val === true ) $vals []= " TRUE";
            elseif  ($val === false) $vals []= " FALSE";
            
            else { // anything else uses a parameter:
                $vals []= " ?";
                $this->params []= $val;
            }
        }
        
        $cols = implode(",", $cols);
        $vals = implode(",", $vals);
        
        $this->query = "INSERT INTO {$this->table} ({$cols}) VALUES ({$vals})";

        return $this;
    }
    /**
     * Begins an UPDATE query.
     * @param kvp stands for KeyValuePair. You should pass in an associative where "key"=>"value" corresponds to "field"=>"value".
     */
    function update($kvp){
                
        $temp = "";
        foreach($kvp as $key => $val){
            
            if(!empty($temp)) $temp .= ", ";
            $field = CoolDB::escapeField($key);
            if      ($val === null ) $temp .= " {$field} = NULL ";
            elseif  ($val === true ) $temp .= " {$field} = TRUE ";
            elseif  ($val === false) $temp .= " {$field} = FALSE ";
            
            else { // anything else uses a parameter:
                $temp .= " {$field} = ? ";
                $this->params []= $val;
            }
        }
        
        $this->query = "UPDATE {$this->table} SET {$temp}";
        
        return $this;
    }
    function where($conditions, $and = true){
        
        if(!empty($conditions)) {
            $this->query .= " WHERE ";
            $this->fromConditions($conditions, $and);
        }
        return $this;
    }
    private function fromConditions($conditions, $and = true) {
        if (empty($conditions)) return ['', []];
        $params = [];
        $fields = [];
        foreach ($conditions as $field => $val) {
            
            $field = CoolDB::escapeField($field);
            
            if      ($val === null ) $fields []= " {$field} IS NULL ";
            elseif  ($val === true ) $fields []= " {$field} = TRUE ";
            elseif  ($val === false) $fields []= " {$field} = FALSE ";
            
            else { // anything else uses a parameter:
                $fields []= " {$field} = ? ";
                $this->params []= $val;
            }
        }
        
        $glu = ($and == true) ? 'AND' : 'OR';
        
        $fields = implode($glu, $fields);
        
        $this->query .= "({$fields})";
    }
    function limit($limit){
        $limit = intval($limit);
        if($limit > 0) $this->query .= " LIMIT {$limit}";
        return $this;
    }
    function execute(){
        
        if(DB::DEBUG) echo $this->dump()."\n\n";
        
        return $this->query($this->query, $this->params);
    }
    function query(string $query, array $params){
        
        // TODO: verify/sanitize values...
        
        // $stmt is a PDOStatement object
        $stmt = CoolDB::$pdo->prepare($query);
        $stmt->execute($params);
        
        $this->clear();
        
        $res = (array) $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $res;
    }
    function dump(bool $verbose = false){

        $dump = "";
        if($verbose){
            foreach($this->params as $key => $val){
                $dump .= "\n\t";
                $dump .= is_string($key) ? "\"{$key}\"" : $key;
                $dump .= " => ";
                $dump .= is_string($val) ? "\"{$val}\"" : $val;
            }
            return $this->query."\nArray({$dump}\n)\n";
        }
        
        foreach($this->params as $val){
            if(!empty($dump)) $dump .= ", ";
            $dump .= is_string($val) ? "\"{$val}\"" : $val;
        }
        return $this->query." \t\t ### PARAMS: ({$dump}) ###";
    }
    static function escapeField(string $string): string {
        
        if(empty($string)) return "";
        
        if(strpos($string, '.') !== false){ // if multi-part (e.g.: "table.field"):
            $parts = explode('.', $string); // break apart
            foreach($parts as $index => $part){
                $parts[$index] = CoolDB::escapeField($part); // escape each part
            }
            return implode('.', $parts); // put back together
        }
        $string = trim($string);
        if(preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $string) === 0) return "";
        
        return "`{$string}`";
    }
}


?>