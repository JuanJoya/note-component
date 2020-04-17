<?php

declare(strict_types=1);

namespace Note\Domain\Services\User;

use Note\Domain\User;
use Illuminate\Support\Collection;

interface UserService
{
    /**
     * Retorna todos los usuarios de la aplicación.
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Retorna un usuario según el parámetro de búsqueda.
     * @param int|string $param parámetro de búsqueda.
     * @param string $type atributo del modelo.
     * @return User|null
     */
    public function find($param, string $type = 'id');

    /**
     * Retorna un usuario según el identificador ingresado.
     * @param int $id identificador de la entidad.
     * @return User
     */
    public function findOrFail(int $id);

    /**
     * Retorna la cantidad total de usuarios.
     * @return int
     */
    public function count(): int;

    /**
     * Permite paginar un conjunto de usuarios.
     * @param int $perPage numero de elementos por pagina.
     * @param array $appends agrega parámetros al QueryString.
     * @return Collection elementos de la pagina actual.
     */
    public function paginate(int $perPage = 10, array $appends = []): Collection;

    /**
     * Permite guardar usuarios en los registros de la aplicación.
     * @param array $attributes
     * @return User
     */
    public function create(array $attributes): User;

    /**
     * Permite eliminar un usuario del sistema.
     * @param int $id
     * @return bool estado de la petición.
     */
    public function delete(int $id): bool;
}
