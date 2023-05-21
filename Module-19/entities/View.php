<?php

abstract class View
{
    public $storage;

    public function __construct( $store )
    {
        $this->storage = $store;
    }

    abstract public function displayTextById( $id );
    abstract public function displayTextByUrl( $url );
}