<?php

require_once __DIR__ . '/../interfaces/EventListenerInterface.php';

abstract class User implements EventListenerInterface
{
    protected $id, $name, $role;

    abstract public function getTextsToEdit();

    //  implements EventListenerInterface.php
    public function attachEvent( string $methodName, callable $callback ) {

    }

    public function detouchEvent( string $methodName ) {

    }
}