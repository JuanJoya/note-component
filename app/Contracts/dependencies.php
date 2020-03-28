<?php

/**
 * En este archivo se puede resolver el contrato [interface -> implementación]
 * del contenedor de dependencias.
 * @var \Illuminate\Container\Container $container
 */

declare(strict_types=1);

use Note\Domain\Services\Note\{NoteService, NoteServiceBasic};
use Note\Domain\Services\User\{UserService, UserServiceBasic};
use Note\Domain\Services\Author\{AuthorService, AuthorServiceBasic};

$container->bind(NoteService::class, NoteServiceBasic::class);
$container->bind(AuthorService::class, AuthorServiceBasic::class);
$container->bind(UserService::class, UserServiceBasic::class);
