<?php

class TelegraphText
{
    private $text, $title, $author, $published, $slug, $storage;

    public function __construct( string $author, string $slug, FileStorage $storage = null )
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
            function exceptionTextHandler($exception) {
                echo "<div style='background-color: pink; width: 600px; height: 100px; margin: 0 auto; text-align: center'><b>{$exception->getMessage()}</b></div>";
            }

            set_exception_handler('exceptionTextHandler');

            if (strlen($value) < 1) {
                throw new Exception('Вы не ввели текст');
            } elseif (strlen($value) > 500) {
                throw new Exception('Длина текста больше превышает 500 символов');
            }

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