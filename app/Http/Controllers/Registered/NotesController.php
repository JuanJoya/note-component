<?php

namespace Note\Http\Controllers\Registered;

use Note\Src\Response\View;
use Illuminate\Http\Request;
use Sirius\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Redirector;
use Note\Http\Controllers\BaseController;
use Note\Domain\Services\Note\NoteService;
use Note\Domain\Services\User\UserService;
use Note\Domain\Services\Author\AuthorService;

class NotesController extends BaseController
{
    /**
     * @var NoteService
     */
    private $notes;

    /**
     * @var UserService
     */
    private $users;

    /**
     * @var AuthorService
     */
    private $authors;

    /**
     * @var View
     */
    private $view;

    public function __construct(NoteService $note, UserService $user, AuthorService $author, View $view)
    {
        $this->users   = $user;
        $this->authors = $author;
        $this->notes   = $note;
        $this->view    = $view;
    }

    public function create(array $errors = null, array $old = null)
    {
        $authors = $this->authors->userAuthors(
            $this->currentUser()->getId()
        );
        return $this->view->make('notes.create', [
            'user'    => $this->currentUser(),
            'authors' => $authors,
            'errors'  => $errors,
            'old'     => $old
        ]);
    }

    public function store(Request $request, Redirector $redirect, Validator $validator)
    {
        $validator->add([
            'title:Title' => 'required | AlphaNumHyphen | minlength(4) | maxlength(50)',
            'content:Content' => 'required | minlength(15) | maxlength(200)',
            'author_id:Author' => "required | integer | exists(authors)"
        ]);
        if ($validator->validate($request->all())) {
            $this->authors->validate($request->author_id, $this->currentUser()->getId());
            $this->notes->create($request->all());
            simpleFlash('The note has been successfully saved.', 'success');
            return $redirect->route('home');
        }
        return $this->create($validator->getMessages(), $request->all());
    }

    public function find()
    {
        $authors = $this->authors->userAuthors(
            $this->currentUser()->getId()
        );
        return $this->view->make('notes.find', [
            'user'    => $this->currentUser(),
            'authors' => $authors
        ]);
    }

    public function show(int $author_id)
    {
        $author = $this->authors->validate($author_id, $this->currentUser()->getId());
        $notes = $this->paginate($this->notes->authorNotes($author_id), 4);
        return $this->view->make('notes.show', compact('notes', 'author'));
    }

    public function edit(int $id, array $errors = null)
    {
        $note = $this->notes->findOrFail($id);
        $this->authors->validate($note->getAuthor(), $this->currentUser()->getId());
        return $this->view->make('notes.edit', compact('note', 'errors'));
    }

    public function update(int $id, Request $request, Redirector $redirect, Validator $validator)
    {
        $validator->add([
            'title:Title' => 'required | AlphaNumHyphen | minlength(4) | maxlength(50)',
            'content:Content' => 'required | minlength(15) | maxlength(200)'
        ]);
        if ($validator->validate($request->all())) {
            $note = $this->notes->findOrFail($id);
            $author = $this->authors->validate($note->getAuthor(), $this->currentUser()->getId());
            $request->merge(['id' => $note->getId()]);
            $this->notes->update($request->all());
            simpleFlash('The note has been successfully updated.', 'success');
            return $redirect->route('notes.show', ['author' => $author->getId()]);
        }
        return $this->edit($id, $validator->getMessages());
    }

    public function destroy(int $id, Request $request, Redirector $redirect, JsonResponse $response)
    {
        $note = $this->notes->findOrFail($id);
        $author = $this->authors->validate($note->getAuthor(), $this->currentUser()->getId());
        $this->notes->delete($id);
        simpleFlash('The note has been deleted.', 'warning');
        if ($request->ajax()) {
            return $response->setData([
                'route' => route('notes.show', ['author' => $author->getId()])
            ]);
        }
        return $redirect->route('home');
    }

    /**
     * @return \Note\Domain\User
     */
    private function currentUser()
    {
        return $this->users->findOrFail(2);
    }
}
