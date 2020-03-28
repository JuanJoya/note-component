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
     * Permite guardar autores en los registros de la aplicación.
     * @param array $attributes
     * @return void
     */
    public function create(array $attributes);

    /**
     * Permite eliminar un autor del sistema.
     * @param int $id
     * @return bool estado de la petición.
     */
    public function delete(int $id): bool;

    /**
     * Retorna los autores de un usuario especifico.
     * @param int $user_id
     * @return Collection
     */
    public function userAuthors(int $user_id): Collection;

    /**
     * Verifica la existencia de un autor y su correspondiente
     * usuario en los registros de la aplicación.
     * @param Author|int $author
     * @param int $user_id
     * @return Author
     */
    public function validate($author, int $user_id): Author;
}
