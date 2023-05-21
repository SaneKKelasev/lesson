<?php

class TelegraphText
{
    private $text, $title, $author, $published, $slug;

    public function __construct( string $author, string $slug, FileStorage $storage )
    {
        $this->storage = $storage;
        $this->author = $author;
        $this->slug = $slug;
        $this->published = date("d.m.Y H:i:s");
    }

    public function __set( $nameField, $value )
    {
        if ($nameField === 'author') {
            if (strlen($value) <= 120) {
                $this->author = $value;
            }
        } elseif ($nameField === 'slug') {
            $regex = "/^[a-zA-Z]{4,10}_[0-9]{2}\\.[0-9]{2}\\.[0-9]{4}_?[0-9]*$/u"; // собрал регулярку под примерное название файлов - test_01.12.2022 либо - teststests_01.12.2022_1
            if (preg_match($regex, $value) === 1) {
                $this->slug = $value;
            }
        } elseif ($nameField === 'published') {
            if ( strtotime($value) >= time() ) {
                $this->published = $value;
            }
        } elseif ($nameField === 'text') {
            $this->text = $value;
            $this->storeText();
        }
    }

    public function __get( $nameField )
    {
        if ($nameField === 'author') {
            return $this->author;
        } elseif ($nameField === 'slug') {
            return $this->slug;
        } elseif ($nameField === 'published') {
            return $this->published;
        } elseif ($nameField === 'text') {
            $this->loadText();
            return $this->text;
        }
    }

    private function storeText()
    {
        $this->storage->create($this);
    }

    private function loadText()
    {
        $this->storage->read($this->slug);
    }

    public function editText( string $title, string $text )
    {
        $this->title = $title;
        $this->text = $text;
    }
}