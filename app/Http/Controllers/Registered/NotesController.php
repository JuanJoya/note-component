<?php

namespace Note\Http\Controllers\Registered;

use Note\Src\Response\View;
use Illuminate\Http\Request;
use Sirius\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Redirector;
use Note\Http\Controllers\BaseController;
use Note\Domain\Services\Note\NoteService;
use Note\Domain\Services\Author\AuthorService;

class NotesController extends BaseController
{
    /**
     * @var NoteService
     */
    private $notes;

    /**
     * @var AuthorService
     */
    private $authors;

    /**
     * @var View
     */
    private $view;

    public function __construct(NoteService $note, AuthorService $author, View $view)
    {
        $this->notes = $note;
        $this->authors = $author;
        $this->view = $view;
    }

    public function create(array $errors = null, array $old = null)
    {
        $authors = $this->authors->byUser(currentId());
        return $this->view->make('notes.create', [
            'user'    => currentUser(),
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
            $this->authors->validate($request->author_id, currentId());
            $this->notes->create($request->all());
            simpleFlash('The note has been successfully saved.', 'success');
            return $redirect->route('home');
        }
        return $this->create($validator->getMessages(), $request->all());
    }

    public function find()
    {
        $authors = $this->authors->byUser(currentId(), true)->map(
            $this->mergeAuthorNotes()
        );
        return $this->view->make('notes.find', [
            'user' => currentUser(),
            'authors' => $authors
        ]);
    }

    public function show(int $author_id)
    {
        $author = $this->authors->validate($author_id, currentId());
        $notes = $this->paginate($this->notes->authorNotes($author_id), 4);
        return $this->view->make('notes.show', compact('notes', 'author'));
    }

    public function edit(int $id, array $errors = null)
    {
        $note = $this->notes->findOrFail($id);
        $this->authors->validate($note->getAuthor(), currentId());
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
            $author = $this->authors->validate($note->getAuthor(), currentId());
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
        $author = $this->authors->validate($note->getAuthor(), currentId());
        $this->notes->delete($id);
        simpleFlash('The note has been deleted.', 'warning');
        if ($request->ajax()) {
            return $response->setData([
                'route' => route('notes.show', ['author' => $author->getId()])
            ]);
        }
        return $redirect->route('home');
    }

    private function mergeAuthorNotes(): \Closure
    {
        return function ($author) {
            return array_merge($author, [
                'notes' => $this->notes->authorNotes($author['id'])->count()
            ]);
        };
    }
}
