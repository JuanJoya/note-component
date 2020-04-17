<?php

namespace Note\Http\Controllers;

use Note\Src\Response\View;
use Note\Src\Template\TemplateEngine;
use Note\Domain\Services\Note\NoteService;
use Note\Domain\Services\Author\AuthorService;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    /**
     * @var NoteService
     */
    private $notes;

    public function __construct(NoteService $notes)
    {
        $this->notes = $notes;
    }

    public function index(View $view)
    {
        $notes = $this->notes->paginate(10);
        return $view->make('index.home', ['notes' => $notes]);
    }

    public function show(string $slug, View $view, AuthorService $authors)
    {
        $author = $authors->find($slug, 'slug', true);
        $notes = $this->notes->find($author->getId(), 'author_id');
        return $view->make('index.home', ['notes' => $this->paginate($notes, 10)]);
    }

    public function search(View $view)
    {
        return $view->make('index.search');
    }

    public function check(Request $request, TemplateEngine $template)
    {
        if ($request->ajax()) {
            $notes = $this->notes->search($request->q);
            return $template->render('index.searchResult', [
                'notes'  => $notes,
                'search' => preg_quote(trim($request->q), '/')
            ]);
        } else {
            abort();
        }
    }
}
