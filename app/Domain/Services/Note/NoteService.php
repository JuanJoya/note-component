<?php

declare(strict_types=1);

namespace Note\Domain\Services\Note;

use Note\Domain\Note;
use Illuminate\Support\Collection;

interface NoteService
{
    /**
     * Retorna todas las notas de la aplicación.
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Retorna una o varias notas según el parámetro de búsqueda.
     * @param int|string $param parámetro de búsqueda.
     * @param string $type atributo de la entidad.
     * @param bool $throwOnFail lanza una excepción al no encontrar resultados.
     * @return Collection|Note|null
     */
    public function find($param, string $type = 'id', bool $throwOnFail = false);

    /**
     * Retorna una nota según el identificador ingresado.
     * @param int $id identificador de la entidad.
     * @return Note
     */
    public function findOrFail(int $id);

    /**
     * Retorna la cantidad total de notas.
     * @return int
     */
    public function count(): int;

    /**
     * Permite paginar un conjunto de notas.
     * @param int $perPage numero de elementos por pagina.
     * @param array $appends agrega parámetros al QueryString.
     * @return Collection elementos de la pagina actual.
     */
    public function paginate(int $perPage = 10, array $appends = []): Collection;

    /**
     * Permite guardar notas en los registros de la aplicación.
     * @param array $attributes
     * @return void
     */
    public function create(array $attributes);

    /**
     * Permite actualizar una nota en los registros de la aplicación.
     * @param array $attributes
     * @return void
     */
    public function update(array $attributes): void;

    /**
     * Permite eliminar una nota del sistema.
     * @param int $id
     * @return bool estado de la petición.
     */
    public function delete(int $id): bool;

    /**
     * Retorna todas las notas que coincidan con el patron de
     * búsqueda ingresado, se filtra por [title|content].
     * @param string $pattern
     * @return Collection
     */
    public function search(string $pattern): Collection;

    /**
     * Retorna las notas de un autor especifico.
     * @param int $author_id
     * @return Collection
     */
    public function authorNotes(int $author_id): Collection;
}
