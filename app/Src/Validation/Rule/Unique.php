<?php

declare(strict_types=1);

namespace Note\Src\Validation\Rule;

use Note\Src\Database\SimpleQuery;
use Sirius\Validation\Rule\AbstractRule;

/**
 * Permite validar que un registro sea único en la base de datos.
 */
class Unique extends AbstractRule
{
    public const MESSAGE = 'The {column} has already been taken';
    public const LABELED_MESSAGE = 'The {label} has already been taken';

    public const OPTION_TABLE = 'table';
    public const OPTION_COLUMN = 'column';
    public const OPTION_EXCEPT = 'except';
    public const OPTION_ID_COLUMN = 'idColumn';

    /**
     * Opciones por defecto.
     * @var array
     */
    protected $options = [
        self::OPTION_TABLE => 'users',
        self::OPTION_COLUMN => 'email',
        self::OPTION_EXCEPT => null,
        self::OPTION_ID_COLUMN => 'id'
    ];

    /**
     * Orden de las opciones.
     * @var array
     */
    protected $optionsIndexMap = [
        0 => self::OPTION_TABLE,
        1 => self::OPTION_COLUMN,
        2 => self::OPTION_EXCEPT,
        3 => self::OPTION_ID_COLUMN
    ];

    public function validate($value, string $valueIdentifier = null): bool
    {
        $this->value = $value;
        $id = $this->getIdFromTable();
        if ($id) {
            $this->success = ($id == $this->options[self::OPTION_EXCEPT]) ? true : false;
        } else {
            $this->success = true;
        }
        return $this->success;
    }

    /**
     * Retorna el id de la tabla ingresada.
     * @return int|null
     */
    private function getIdFromTable(): ?int
    {
        $db = new SimpleQuery();
        $db->bindParams([':value' => $this->value]);
        $result = $db->getResultsFromQuery(
            "SELECT {$this->options[self::OPTION_ID_COLUMN]} FROM {$this->options[self::OPTION_TABLE]}
             WHERE {$this->options[self::OPTION_COLUMN]} = :value"
        );
        return empty($result) ? null : array_shift($result)[$this->options[self::OPTION_ID_COLUMN]];
    }
}
