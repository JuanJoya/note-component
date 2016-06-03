<?php
namespace Note\Http\Controllers;

use Illuminate\Http\Request;
use Note\Domain\AuthorService;
use Note\Domain\NoteService;
use Note\Domain\UserService;
use Note\Http\Views\View;

class HomeController
{
    /**
     * @var NoteService
     */
    private $noteService;
    /**
     * @var UserService
     */
    private $userService;

    private $authorService;

    /**
     * @param NoteService $noteService
     * @param UserService $userService
     * @param AuthorService $authorService
     */
    public function __construct(NoteService $noteService, UserService $userService, AuthorService $authorService)
    {
        $this->noteService = $noteService;
        $this->userService = $userService;
        $this->authorService = $authorService;
    }

    public function index()
    {
        $notes = $this->noteService->listNotes();

        $view = new View('home', [
            'notes' => $notes,
        ]);

        return $view->render();
    }

    public function create()
    {
        /**
         *  $defaultUser debería ser el user de la sesión.
         */
        $defaultUser = $this->userService->find('1');

        $authors = $this->authorService->listAuthors($defaultUser->getId());

        $view = new View('create', [
            'user' => $defaultUser,
            'authors' => $authors
        ]);

        return $view->render();
    }

    public function store()
    {
        /**
         * $_POST debería ser un objeto modelado como request
         */
        if($_POST)
        {
            $params['title'] = $_POST['note-title'];
            $params['content'] = $_POST['note-content'];
            $params['author_id'] = $_POST['note-author-id'];
            $this->noteService->saveNote($params);
        }

        return $this->index();
    }

}