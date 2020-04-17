<?php

declare(strict_types=1);

namespace Note\Src\Database;

use Closure;
use voku\helper\Paginator;

trait CanPaginate
{
    /**
     * Retorna el objeto de paginación.
     * @param int $perPage
     * @param int $total
     * @param string $identifier
     * @return Paginator
     */
    private function getPaginator(int $perPage, int $total, string $identifier = 'page'): Paginator
    {
        return (new Paginator($perPage, $identifier))->set_total($total);
    }

    /**
     * Retorna el Callback que construye los enlaces de paginación.
     * @param Paginator $pages
     * @param array $appends
     * @return Closure
     */
    private function getLinksMethod(Paginator $pages, array $appends): Closure
    {
        return function (array $appendsFromTemplate = []) use ($pages, $appends) {
            $query = http_build_query(array_merge($appends, $appendsFromTemplate));
            return $pages->page_links($query ? '?' . $query . '&' : '?');
        };
    }
}
