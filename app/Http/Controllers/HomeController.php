<?php

namespace Note\Http\Controllers;

use Note\Domain\AuthorService;
use Note\Domain\NoteService;
use Note\Domain\UserService;
use Note\Helpers\DataHelper;
use Note\Http\Views\View;

class HomeController
{
    /**
     * @var NoteService permite interactuar con el repositorio de Note
     */
    private $noteService;
    /**
     * @var UserService permite interactuar con el repositorio User
     */
    private $userService;
    /**
     * @var AuthorService permite interactuar con el repositorio Author
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
         * En vez de $_POST se debería utilizar un objeto modelado como request
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
        /**
         *  $defaultUser debería ser el user de la sesión.
         */
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
        /**
         * En vez de $_POST se debería utilizar un objeto modelado como request
         */
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

    /**
     * @param string $id id de Note por URL
     * @return \Illuminate\Http\Response
     */
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
        /**
         * En vez de $_POST se debería utilizar un objeto modelado como request
         */
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
         * Validar credenciales de User por url
         */
        $this->noteService->delete($id);

        return $this->index();
    }

    public function check()
    {
        /**
         * En vez de $_POST se debería utilizar un objeto modelado como request
         */
        if(isset($_POST['note-word'])) {
            $query = trim($_POST['note-word']);

            if(!empty($query)) {
                $result = $this->noteService->search($query);
                $notes = $this->searchReplace($query,$result);
            } else {
                $notes = null;
            }
        } else {
            $notes = null;
        }

        $view = new View('searchResult', [
            'notes' => $notes,
        ]);

        return $view->render();
    }

    public function search()
    {
        $view = new View('search');

        return $view->render();
    }

    /**
     * @param string $pattern
     * @param \Illuminate\Support\Collection $notes
     * @return null|\Illuminate\Support\Collection
     */
    protected function searchReplace($pattern, $notes)
    {
        if(!$notes->isEmpty()) {
            foreach($notes as $note) {
                $note->setTitile(
                    DataHelper::strong($pattern,$note->getTitle())
                );
                $note->setContent(
                    DataHelper::strong($pattern,$note->getContent())
                );
            }
            return $notes;
        } else {
            return null;
        }
    }
}
