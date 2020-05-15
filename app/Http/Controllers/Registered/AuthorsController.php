<?php

namespace Note\Http\Controllers\Registered;

use Illuminate\Support\Str;
use Note\Src\Response\View;
use Illuminate\Http\Request;
use Sirius\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Redirector;
use Note\Http\Controllers\BaseController;
use Note\Domain\Services\Author\AuthorService;

class AuthorsController extends BaseController
{
    /**
     * @var AuthorService
     */
    private $authors;

    /**
     * @var View
     */
    private $view;

    public function __construct(AuthorService $author, View $view)
    {
        $this->authors = $author;
        $this->view = $view;
    }

    public function index()
    {
        $authors = $this->authors->userAuthors(currentId());
        return $this->view->make('authors.index', [
            'user' => currentUser(),
            'authors' => $authors
        ]);
    }

    public function create(array $errors = null, array $old = null)
    {
        return $this->view->make('authors.create', [
            'user' => currentUser(),
            'errors' => $errors,
            'old' => $old
        ]);
    }

    public function store(Request $request, Redirector $redirect, Validator $validator)
    {
        $validator->add([
            'username:Username' => 'required | AlphaNumHyphen | minlength(5) | maxlength(20)',
            'slug:Username' => 'required | unique(authors,slug)'
        ]);
        $data = [
            'username' => $request->username,
            'slug' => Str::slug($request->username),
            'user_id' => currentId()
        ];
        if ($validator->validate($data)) {
            $this->authors->create($data);
            simpleFlash('The author has been successfully saved.', 'success');
            return $redirect->route('authors.index');
        }
        return $this->create($validator->getMessages(), $request->all());
    }

    public function edit(int $id, array $errors = null)
    {
        $author = $this->authors->validate($id, currentId());
        return $this->view->make('authors.edit', compact('author', 'errors'));
    }

    public function update(int $id, Request $request, Redirector $redirect, Validator $validator)
    {
        $validator->add([
            'username:Username' => 'required | AlphaNumHyphen | minlength(5) | maxlength(20)',
            'slug:Username' => "required | unique(authors,slug,{$id})"
        ]);
        $data = [
            'id' => $id,
            'username' => $request->username,
            'slug' => Str::slug($request->username)
        ];
        if ($validator->validate($data)) {
            $this->authors->validate($id, currentId());
            $this->authors->update($data);
            simpleFlash('The author has been successfully updated.', 'success');
            return $redirect->route('authors.index');
        }
        return $this->edit($id, $validator->getMessages());
    }

    public function destroy(int $id, Request $request, Redirector $redirect, JsonResponse $response)
    {
        $this->authors->validate($id, currentId());
        $this->authors->delete($id);
        simpleFlash('The author has been deleted.', 'warning');
        if ($request->ajax()) {
            return $response->setData([
                'route' => route('authors.index')
            ]);
        }
        return $redirect->route('authors.index');
    }
}
