<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TextController extends Controller
{
    public function getText(Request $request)
    {
        $author = $request->get('author');
        $slug = $request->get('slug');

        (new TelegraphText($author, $slug))->loadText();
    }

    public function postText(Request $request)
    {
        $author = $request->get('author');
        $slug = $request->get('slug');

        (new TelegraphText($author, $slug))->storeText();
    }

    public function putText(Request $request)
    {
        $author = $request->get('author');
        $slug = $request->get('slug');
        $title = $request->get('title');
        $text = $request->get('text');

        (new TelegraphText($author, $slug))->editText($title, $text);
    }

    public function deleteText(Request $request)
    {
        $author = $request->get('author');
        $slug = $request->get('slug');
        $id = $request->get('id');

        (new TelegraphText($author, $slug))->deleteText($id);
    }
}
