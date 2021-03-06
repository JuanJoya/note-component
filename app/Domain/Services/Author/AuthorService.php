<?php

declare(strict_types=1);

namespace Note\Domain\Services\Author;

use Illuminate\Support\Collection;
use Note\Domain\Author;

interface AuthorService
{
    /**
     * Retorna todos los autores de la aplicación.
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Retorna uno o varios autores según el parámetro de búsqueda.
     * @param int|string $param parámetro de búsqueda.
     * @param string $type atributo del modelo.
     * @param bool $throwOnFail lanza una excepción al no encontrar resultados.
     * @return Collection|Author|null
     */
    public function find($param, string $type = 'id', bool $throwOnFail = false);

    /**
     * Retorna un autor según el identificador ingresado.
     * @param int $id identificador de la entidad.
     * @return Author
     */
    public function findOrFail(int $id);

    /**
     * Retorna la cantidad total de autores.
     * @return int
     */
    public function count(): int;

    /**
     * Permite paginar un conjunto de autores.
     * @param int $perPage numero de elementos por pagina.
     * @param array $appends agrega parámetros al QueryString.
     * @return Collection elementos de la pagina actual.
     */
    public function paginate(int $perPage = 10, array $appends = []): Collection;

    /**
     * Permite guardar autores en los registros de la aplicación.
     * @param array $attributes
     * @return void
     */
    public function create(array $attributes);

    /**
     * Permite actualizar una author en los registros de la aplicación.
     * @param array $attributes
     * @return void
     */
    public function update(array $attributes): void;

    /**
     * Permite eliminar un autor del sistema.
     * @param int $id
     * @return bool estado de la petición.
     */
    public function delete(int $id): bool;

    /**
     * Retorna los autores de un usuario especifico.
     * @param int $user_id
     * @param bool plain modela los autores como un array.
     * @return Collection
     */
    public function byUser(int $user_id, bool $plain = false): Collection;

    /**
     * Verifica la existencia de un autor y su correspondiente
     * usuario en los registros de la aplicación.
     * @param Author|int $author
     * @param int $user_id
     * @return Author
     */
    public function validate($author, int $user_id): Author;
}
