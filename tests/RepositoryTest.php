<?php
/**
 * Para evitar inconsistencias en la aplicación (y en los tests), se recomienda utilizar una
 * base de datos de prueba o bien modificar la clase Database para admitir transacciones y poder
 * implementar un rollback en caso de error.
 */

use Illuminate\Support\Collection;
use Note\Domain\Author;
use Note\Domain\Note;
use Note\Domain\User;
use Note\Infrastructure\AuthorRepository;
use Note\Infrastructure\Database;
use Note\Infrastructure\NoteRepository;
use Note\Infrastructure\UserRepository;

class RepositoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var User
     */
    private static $user;
    /**
     * @var Author
     */
    private static $author;
    /**
     * @var Collection Note
     */
    private static $notes;
    /**
     * @var NoteRepository
     */
    private $noteRepo;
    /**
     * @var UserRepository
     */
    private $userRepo;
    /**
     * @var AuthorRepository
     */
    private $authorRepo;

    function __construct()
    {
        Database::setDatabaseName("note_component_tests");
        $this->userRepo   = new UserRepository();
        $this->authorRepo = new AuthorRepository($this->userRepo);
        $this->noteRepo   = new NoteRepository($this->authorRepo);
        $this->noteRepo->truncate();
    }

    function test_create_user_in_db()
    {
        $this->userRepo->save(new User('test@email.com', 'pa$$w0rd'));
    }

    /**
     * @depends test_create_user_in_db
     */
    function test_fail_to_create_duplicate_user()
    {
        $this->setExpectedException(RuntimeException::class);
        $this->userRepo->save(new User('test@email.com', 'pa$$w0rd'));
    }

    /**
     * @depends test_create_user_in_db
     */
    function test_find_user_in_db()
    {
        self::$user = $this->userRepo->find('test@email.com', 'email');
        $this->assertInstanceOf(User::class, self::$user);
        $this->assertEquals('test@email.com', self::$user->getEmail());
    }

    /**
     * @depends test_find_user_in_db
     */
    function test_create_author_in_db()
    {
        $author = Author::create(self::$user, '@tempUser');
        $this->authorRepo->save($author);
    }

    /**
     * @depends test_create_author_in_db
     */
    function test_fail_to_create_duplicate_author()
    {
        $this->setExpectedException(RuntimeException::class);
        $this->authorRepo->save(Author::create(self::$user, '@tempUser'));
    }

    function test_fail_to_create_author_without_user()
    {
        $this->setExpectedException(LogicException::class);
        $randomUser = new User('t@e.com', '12345');
        $this->authorRepo->save(Author::create($randomUser, '@tempUser'));
    }

    /**
     * @depends test_create_author_in_db
     */
    function test_find_author_in_db()
    {
        self::$author = $this->authorRepo->find('@tempUser', 'username');
        $this->assertInstanceOf(Author::class, self::$author);
        $this->assertEquals('@tempUser', self::$author->getUsername());
    }

    /**
     * @depends test_find_author_in_db
     */
    function test_create_notes_in_db()
    {
        $firstNote = new Note(self::$author, 'note 1 title', 'note 1 content');
        $secondNote = new Note(self::$author, 'note 2 title', 'note 2 content');
        $this->noteRepo->save($firstNote);
        $this->noteRepo->save($secondNote);
    }

    function test_fail_to_create_note_without_author()
    {
        $this->setExpectedException(LogicException::class);
        $randomAuthor = new Author('t@m.co', '123', '@temp');
        $note = new Note($randomAuthor, 'note title', 'note content');
        $this->noteRepo->save($note);
    }

    /**
     * @depends test_create_notes_in_db
     */
    function test_find_notes_in_db()
    {
        self::$notes = $this->noteRepo->notesByAuthor(self::$author->getAuthorId());

        foreach (self::$notes as $note) {
            $this->assertInstanceOf(Note::class, $note);
        }
    }

    /**
     * @depends test_find_notes_in_db
     */
    function test_update_note()
    {
        $note = self::$notes->first();
        $note->setTitle('Note #1');
        $this->noteRepo->update($note);
        $note = $this->noteRepo->find('Note #1', 'title');
        $this->assertEquals('Note #1', $note->getTitle());
    }

    /**
     * @depends  test_create_notes_in_db
     */
    function test_searching_notes()
    {
        $results = $this->noteRepo->search('note');
        $this->assertInstanceOf(Collection::class, $results);
        $this->assertInstanceOf(Note::class, $results->first());
    }

    /**
     * @depends test_find_user_in_db
     * @depends test_find_author_in_db
     * @depends test_find_notes_in_db
     */
    function test_delete_entities()
    {
        $this->userRepo->delete(self::$user->getId());
        $this->authorRepo->delete(self::$author->getAuthorId());

        foreach (self::$notes as $note) {
            $this->noteRepo->delete($note->getId());
        }
    }
}
