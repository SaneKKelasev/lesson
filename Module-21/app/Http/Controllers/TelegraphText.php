<?php

namespace App\Http\Controllers;

use App\Models\FileStorage;

class TelegraphText extends Controller
{
    protected $telegraphText;

    public function __construct( string $author, string $slug, FileStorage $storage = null )
    {
        $this->telegraphText = new \App\Models\TelegraphText();

        $this->telegraphText->storage = $storage;
        $this->telegraphText->author = $author;
        $this->telegraphText->slug = $slug;
        $this->telegraphText->published = date("d.m.Y H:i:s");

        $this->telegraphText->save();
    }

    private function storeText()
    {
        $this->telegraphText->storage->create($this);
    }

    private function loadText()
    {
        $this->telegraphText->storage->read($this->telegraphText->slug);
    }

    public function editText( string $title, string $text )
    {
        $this->telegraphText->title = $title;
        $this->telegraphText->text = $text;

        $this->telegraphText->save();
    }

    public function deleteText(int $id)
    {
        $this->telegraphText->delete();
    }
}
