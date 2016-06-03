<?php

namespace Note\Infrastructure;

abstract class Database
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
    private static $dbPass = 'root';
	/**
	 * @var \PDO objeto que permite trabajar con la DB
	 */
    private static $conn;
	/**
	 * @var string
	 */
    protected $dbName = 'note_component';
	/**
	 * @var string con sentencia SQL
	 */
    protected $query;
	/**
	 * @var array resultado al traer datos de la DB
	 */
    protected $rows = array();
	/**
	 * @var int registros afectados por un query
	 */
    protected $affectedRows;
	/**
	 * @var array con los parámetros para el binding del query
	 */
    protected $bindParams = array();

	/**
	 * Crea el objeto PDO, si este existe, utiliza la misma instancia
	 * para no crear multiples conexiones a la DB
	 */
	private function openConnection()
	{
		if(!self::$conn)
		{
			self::$conn = new \PDO(
				self::$dbDriver.':host='.self::$dbHost.';dbname='.$this->dbName.';charset=utf8;',
				self::$dbUser,
				self::$dbPass,
				array(\PDO::MYSQL_ATTR_FOUND_ROWS => true)
			);
		}
	}

	/**
	 * @return \PDOStatement $result objeto con los resultados asociados al execute del query
	 * realiza el binding del query (sentencia preparada), ejecuta el query y retorna el Statement
	 */
	private function dbQuery()
	{
		$result = self::$conn->prepare($this->query);
		foreach ($this->bindParams as $key => &$param)
		{
			$result->bindParam($key, $param);
		}
		$result->execute();

		return $result;
	}

	/**
	 * permite ejecutar las sentencias UPDATE, INSERT, DELETE
	 */
	protected function executeSingleQuery()
	{
		$this->openConnection();
		$result = $this->dbQuery();
		$this->affectedRows = $result->rowCount();
		$result = null;
	}

	/**
	 * permite ejecutar SELECT, modela el resultado (PDOStatement) en un array $rows
	 */
	protected function getResultsFromQuery()
	{
		$this->openConnection();
		$result = $this->dbQuery();
		while ($this->rows[] = $result->fetch(\PDO::FETCH_ASSOC));
		$result= null;
		array_pop($this->rows);
	}
}
