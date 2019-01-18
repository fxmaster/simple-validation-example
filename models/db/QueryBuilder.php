 <?php

class QueryBuilder {

    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll($table) {
        $sql = "SELECT * FROM {$table}";
        $statement = $this->pdo->prepare($sql);
        // $statement->bindParam(':table',$table);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOne($table, $id){
        $sql = "SELECT * FROM {$table} WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        // $statement->bindValue(':id',$id);
        // $statement->bindParam(':id',$id);
        $statement->execute([
            'id' => $id
        ]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function create($table, $data) {
        $columns = implode(',', array_keys($data));
        $values = ":" . implode(', :', array_keys($data));

        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";
        $statement = $this->pdo->prepare($sql);

        return $statement->execute($data) ? true : false;
    }

    public function update($table, $id, $data){
        $keys = array_keys($data);

        foreach ($keys as $key) {
            $columns .= $key . '=:' .$key . ',';
        }
        $keys = rtrim($columns,',');
        unset($columns);
        $sql = "UPDATE {$table} set {$keys} WHERE id=:id";
        $statement = $this->pdo->prepare($sql);
        $data['id']=$id;
        
        return $statement->execute($data) ? true : false;
    }

    public function delete($table, $id){
        $sql = "DELETE FROM {$table} WHERE id=:id";
        $statement = $this->pdo->prepare($sql);
        return $statement->execute(['id'=>$id]) ? true : false;
    }

    public function exist($table, $column, $value) {
        $sql = "SELECT * FROM {$table} WHERE {$column}=:value";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['value'=>$value]);
        return  $statement->fetch(PDO::FETCH_ASSOC) ? true : false;
    }
}