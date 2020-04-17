<?php

declare(strict_types=1);

namespace Note\Src\Database;

class SimpleQuery
{
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
        $this->openConnection();
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
                'mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME') . ';charset=utf8;',
                getenv('DB_USER'),
                getenv('DB_PASS'),
                $opt
            );
        }
    }
}
