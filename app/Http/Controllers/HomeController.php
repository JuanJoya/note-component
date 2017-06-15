<?php

namespace Note\Http\Controllers;

use Note\Domain\AuthorService;
use Note\Domain\Note;
use Note\Domain\NoteService;
use Note\Domain\User;
use Note\Domain\UserService;
use Note\Http\Responses\View;

class HomeController extends BaseController
{
    /**
     * @var NoteService permite interactuar con el repositorio de Note
     */
    private $notes;
    /**
     * @var UserService permite interactuar con el repositorio User
     */
    private $users;
    /**
     * @var AuthorService permite interactuar con el repositorio Author
     */
    private $authors;

    public function __construct(NoteService $note, UserService $user, AuthorService $author)
    {
        $this->notes   = $note;
        $this->users   = $user;
        $this->authors = $author;
    }

    public function index()
    {
        $view = new View('home', [
            'notes' => $this->notes->all(),
        ]);

        return $view->render();
    }

    public function create()
    {
        $authors = $this->authors->authors($this->currentUser());
        $view = new View('create', [
            'user' => $this->currentUser(),
            'authors' => $authors
        ]);

        return $view->render();
    }

    public function store()
    {
        if(self::$request->has('title', 'content', 'author_id')) {
            $author = $this->authors->findOrFail(self::$request->get('author_id'));
            $this->authors->validateAuthor($author, $this->currentUser());
            $note   = new Note(
                $author,
                self::$request->get('title'),
                self::$request->get('content')
            );
            $this->notes->save($note);
        }

        return $this->index();
    }

    public function find()
    {
        $authors = $this->authors->authors($this->currentUser());
        $view = new View('find', [
            'user' => $this->currentUser(),
            'authors' => $authors
        ]);

        return $view->render();
    }

    public function show()
    {
        if(self::$request->has('author_id')) {
            $author = $this->authors->findOrFail(self::$request->get('author_id'));
            $this->authors->validateAuthor($author, $this->currentUser());
            $notes  = $this->notes->notesByAuthor($author);
            $view = new View('show', [
                'notes' => $notes
            ]);

            return $view->render();
        }

        return $this->index();
    }

    public function update($id)
    {
        $note = $this->notes->findOrFail($id);
        $this->authors->validateAuthor($note->getAuthor(), $this->currentUser());
        $view = new View('update', [
            'note' => $note
        ]);

        return $view->render();
    }

    public function save()
    {
        if(self::$request->has('title', 'content', 'id')) {
            $note = $this->notes->findOrFail(self::$request->get('id'));
            $this->authors->validateAuthor($note->getAuthor(), $this->currentUser());
            $note->setTitle(self::$request->get('title'));
            $note->setContent(self::$request->get('content'));

            $this->notes->update($note);
        }

        return $this->index();
    }

    public function delete($id)
    {
        $note = $this->notes->findOrFail($id);
        $this->authors->validateAuthor($note->getAuthor(), $this->currentUser());
        $this->notes->delete($id);

        return $this->index();
    }

    public function check()
    {
        if(self::$request->has('query')) {
            $query = self::$request->get('query');
            $notes = $this->notes->search($query);
            $view  = new View('searchResult', [
                'notes' => $notes,
                'query' => trim($query)
            ], false);

            return $view->render();
        }
    }

    public function search()
    {
        $view = new View('search');
        return $view->render();
    }

    /**
     * @return User|null
     */
    private function currentUser()
    {
        return $this->users->findOrFail(1);
    }
}
