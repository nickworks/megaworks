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
     * This array stores multiple SQL objects (see below) that will be merged together to form the final query.
     */
    private $parts = array();
    
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
        $this->parts = array();
    }
    /**
     * Sets the table. This will cause the parts array to be flushed.
     */
    function table($table){
        $this->clear();
        $this->table = SQL::escapeField($table);
        return $this;
    }
    /**
     * Begins a DELETE query.
     */
    function delete() {
        
        $this->parts []= new SQL("DELETE FROM {$this->table}");
        
        return $this;
    }
    /**
     * Begins a SELECT query.
     */
    function select($fields = "*", bool $filterFields = true) {
        
        if($filterFields === true){
            if (is_string($fields)) $fields = SQL::escapeField($fields);
            if (empty($fields)) $fields = "*";
            if (is_array($fields)){
                $temp = "";
                foreach($fields as $field){
                    if(!empty($temp)) $temp .= ", ";
                    $temp .= SQL::escapeField($field);
                }
                $fields = $temp;
            }
        }
                
        $this->parts []= new SQL("SELECT {$fields} FROM {$this->table}");
        
        return $this;
    }
    /**
     * Begins an INSERT query.
     */
    function insert($kvp){
        
        $cols = array();
        $vals = array();
        $params = array();
        foreach($kvp as $key => $val){
            
            $cols []= SQL::escapeField($key);
            
            if      ($val === null ) $vals []= " NULL";
            elseif  ($val === true ) $vals []= " TRUE";
            elseif  ($val === false) $vals []= " FALSE";
            
            else { // anything else uses a parameter:
                $vals []= " ?";
                $params []= $val;
            }
        }
        
        $cols = implode(",", $cols);
        $vals = implode(",", $vals);
        
        $this->parts []= new SQL("INSERT INTO {$this->table} ({$cols}) VALUES ({$vals})", $params);
        return $this;
    }
    /**
     * Begins an UPDATE query.
     * @param kvp stands for KeyValuePair. You should pass in an associative where "key"=>"value" corresponds to "field"=>"value".
     */
    function update($kvp){
                
        $temp = "";
        $params = array();
        foreach($kvp as $key => $val){
            
            if(!empty($temp)) $temp .= ", ";
            $field = SQL::escapeField($key);
            if      ($val === null ) $temp .= " {$field} = NULL ";
            elseif  ($val === true ) $temp .= " {$field} = TRUE ";
            elseif  ($val === false) $temp .= " {$field} = FALSE ";
            
            else { // anything else uses a parameter:
                $temp .= " {$field} = ? ";
                $params []= $val;
            }
        }
        
        $this->parts []= new SQL("UPDATE {$this->table} SET {$temp}", $params);
        
        return $this;
    }
    function where($conditions, $and = true){
        
        if(!empty($conditions)) {
            $this->parts []= new SQL(" WHERE ");
            $this->parts []= SQL::fromConditions($conditions, $and);
        }
        return $this;
    }
    function limit($limit){
        $limit = intval($limit);
        if($limit > 0) $this->parts []= new SQL(" LIMIT {$limit}");
        return $this;
    }
    function execute(){
        
        $sql = new SQL("");
        foreach($this->parts as $part){
            $sql->merge($part);
        }
        
        if(DB::DEBUG) echo $sql->toString()."\n\n";
        
        return $this->query($sql->query, $sql->params);
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
}

class SQL {
    
    public $query;
    public $params;
    
    function __construct(string $query, array $params = []){
        
        if(empty($query)) $query = "";
        if(empty($params)) $params = [];
        
        $this->query = $query;
        $this->params = $params;
    }
    function toString($verbose = false):string {       
        
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
    function merge(SQL $other){
        $this->query .= $other->query;
        $this->params = array_merge($this->params, $other->params);
        return $this;
    }
    static function fromConditions($conditions, $and = true):SQL{
        if (empty($conditions)) return ['', []];
        $params = [];
        $fields = [];
        foreach ($conditions as $field => $val) {
            
            $field = SQL::escapeField($field);
            
            if      ($val === null ) $fields []= " {$field} IS NULL ";
            elseif  ($val === true ) $fields []= " {$field} = TRUE ";
            elseif  ($val === false) $fields []= " {$field} = FALSE ";
            
            else { // anything else uses a parameter:
                $fields []= " {$field} = ? ";
                $params []= $val;
            }
        }
        
        $glu = ($and == true) ? 'AND' : 'OR';
        
        $fields = implode($glu, $fields);
        
        return new SQL("({$fields})", $params);
    }
    static function escapeField(string $string): string {
        
        if(empty($string)) return "";
        
        if(strpos($string, '.') !== false){ // if multi-part (e.g.: "table.field"):
            $parts = explode('.', $string); // break apart
            foreach($parts as $index => $part){
                $parts[$index] = SQL::escapeField($part); // escape each part
            }
            return implode('.', $parts); // put back together
        }
        $string = trim($string);
        if(preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $string) === 0) return "";
        
        return "`{$string}`";
    }
}

?>