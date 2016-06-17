<?php
namespace Note\Http\Controllers;

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
    /**
     * @var AuthorService
     */
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
        $notes = $this->noteService->all();

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

        $authors = $this->authorService->authors($defaultUser->getId());

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
            $this->noteService->save($params);
        }

        return $this->index();
    }

    public function find()
    {
        $defaultUser = $this->userService->find('1');
        $authors = $this->authorService->authors($defaultUser->getId());
        $view = new View('find', [
            'user' => $defaultUser,
            'authors' => $authors
        ]);
        return $view->render();
    }

    public function show()
    {
        if($_POST)
        {
            $authorId = $_POST['note-author-id'];
            $notes = $this->noteService->notes($authorId);

            $view = new View('show', [
                'notes' => $notes
            ]);

            return $view->render();
        }
    }

    public function update($id)
    {
        $note = $this->noteService->find($id);

        $view = new View('update', [
            'note' => $note
        ]);

        return $view->render();
    }

    public function save()
    {
        if($_POST)
        {
            $params['title'] = $_POST['note-title'];
            $params['content'] = $_POST['note-content'];
            $params['id'] = $_POST['note-id'];
            $this->noteService->update($params);
        }
        return $this->index();
    }

    public function delete($id)
    {
        /**
         * Validar credenciales de User
         */
        $this->noteService->delete($id);

        return $this->index();
    }
}