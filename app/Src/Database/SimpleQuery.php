<?php

declare(strict_types=1);

namespace Note\Src\Database;

class SimpleQuery
{
    /**
     * @var string
     */
    private static $dbDriver = 'mysql';
    
    /**
     * @var string
     */
    private static $dbHost = 'localhost';

    /**
     * @var string
     */
    private static $dbUser = 'root';

    /**
     * @var string
     */
    private static $dbPass = '';

    /**
     * @var string
     */
    private static $dbName = 'note_component';

    /**
     * @var \PDO objeto que permite trabajar con la DB.
     */
    private static $conn;

    /**
     * @var array parámetros para el binding del query.
     */
    public $bindParams = array();

    /**
     * Permite ejecutar sentencias INSERT, UPDATE, DELETE.
     * @param string $query sentencia sql.
     * @return int número de registros afectados.
     */
    public function executeSingleQuery(string $query): int
    {
        $this->openConnection();
        $stm = $this->execute($query);
        $affectedRows = $stm->rowCount();
        $stm = null;
        
        return $affectedRows;
    }

    /**
     * Permite ejecutar SELECT, modela el resultado (PDOStatement) en un array $rows.
     * @param string $query sentencia sql.
     * @return array
     */
    public function getResultsFromQuery(string $query): array
    {
        $this->openConnection();
        $stm = $this->execute($query);
        $result = $stm->fetchAll();
        $stm = null;
        
        return $result;
    }

    /**
     * Realiza el binding del query (sentencia preparada), ejecuta el query y retorna el Statement.
     * @param string $query
     * @return \PDOStatement $result objeto con los resultados asociados al execute del query.
     */
    private function execute(string $query): \PDOStatement
    {
        $stm = self::$conn->prepare($query);
        foreach ($this->bindParams as $key => &$param) {
            $stm->bindParam($key, $param, pdoType($param));
        }
        $stm->execute();

        return $stm;
    }

    /**
     * Crea el objeto PDO, si este existe, utiliza la misma instancia para no crear multiples conexiones a la DB.
     * @throws \PDOException
     * @return void
     */
    private function openConnection(): void
    {
        if (!self::$conn) {
            $opt = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_STRINGIFY_FETCHES => false,
                \PDO::ATTR_EMULATE_PREPARES => false //for mysqlnd driver
            ];
            self::$conn = new \PDO(
                self::$dbDriver . ':host=' . self::$dbHost . ';dbname=' . self::$dbName . ';charset=utf8;',
                self::$dbUser,
                self::$dbPass,
                $opt
            );
        }
    }

    /**
     * @param string $name
     * @return void
     */
    public static function setDatabaseName(string $name): void
    {
        self::$dbName = $name;
    }
}
