<?php

/**
 * @deprecated
 */

require_once "vendor/autoload.php";

$dbName = 'note_component';
$dbUser = 'root';
$dbPass = '';

try {
    $faker = Faker\Factory::create();
    $pdo = new PDO("mysql:host=localhost;dbname={$dbName};charset=utf8;", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    dropTables($pdo);
    createTables($pdo);
    createUsers($pdo, $faker);
    createAuthors($pdo, $faker);
    createNotes($pdo, $faker);

} catch (PDOException $e) {
    die($e->getMessage());
}

function dropTables(PDO $pdo)
{
    $pdo->exec("DROP TABLE IF EXISTS notes, authors, users");
}

function createUsers(PDO $pdo, Faker\Generator $faker):void
{
    $stm = $pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :pass)");
    for ($i = 0; $i < 5; $i++) {
        $stm->execute([
            'email'  => $faker->email,
            'pass'   => password_hash('123456', PASSWORD_DEFAULT)
        ]);
    }
}

function createAuthors(PDO $pdo, Faker\Generator $faker):void
{
    $stm = $pdo->prepare("INSERT INTO authors (username, slug, user_id) VALUES (:username, :slug, :user_id)");

    for ($i = 0; $i < 10; $i++) {
        $stm->execute([
            'username' => $username = $faker->userName,
            'slug'     => str_slug($username),
            'user_id'  => randomTableId($pdo, "users")
        ]);
    }
}

function createNotes(PDO $pdo, Faker\Generator $faker):void
{
    $stm = $pdo->prepare("INSERT INTO notes (title, content, author_id, created_at, updated_at) VALUES (:title, :content, :author_id, :cr_at, :up_at)");

    for ($i = 0; $i < 50; $i++) {
        $stm->execute([
            'title'      => $faker->sentence(4),
            'content'    => $faker->text(),
            'author_id'  => randomTableId($pdo, "authors"),
            'cr_at' => $date = $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
            'up_at' => $date
        ]);
    }
}

function randomTableId(PDO $pdo, string $table):int
{
    $result = $pdo->query("SELECT id FROM {$table} ORDER BY RAND() LIMIT 1");
    return (int)$result->fetchColumn();
}

function createTables(PDO $pdo):void
{
    $pdo->query("CREATE TABLE users (
                    id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    email VARCHAR(50) NOT NULL UNIQUE,
                    password VARCHAR(255) NOT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
    ");

    $pdo->query("CREATE TABLE authors (
                    id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(20) NOT NULL,
                    slug VARCHAR(40) NOT NULL UNIQUE,
                    user_id INTEGER UNSIGNED NOT NULL,
                    FOREIGN KEY (user_id) REFERENCES users(id)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
    ");

    $pdo->query("CREATE TABLE `notes` (
                    id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    title VARCHAR(50) NOT NULL,
                    content VARCHAR(200) NOT NULL,
                    author_id INTEGER UNSIGNED NOT NULL,
                    created_at datetime DEFAULT NOW(),
                    updated_at datetime DEFAULT NOW(),
                    FOREIGN KEY (author_id) REFERENCES authors(id)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
    ");
}
