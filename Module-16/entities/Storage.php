<?php

require_once __DIR__ . '/../interfaces/LoggerInterface.php';
require_once __DIR__ . '/../interfaces/EventListenerInterface.php';

abstract class Storage implements LoggerInterface, EventListenerInterface
{
    abstract public function create( TelegraphText $store );
    abstract public function read( string $identifierStore );
    abstract public function update( string $identifierStore, TelegraphText $store );
    abstract public function delete( string $identifierStore );
    abstract public function list();

    // implements LoggerInterface
    public function logMessage( string $textError ) {

    }

    public function lastMessages( int $countMessage ) : array {
        return [];
    }

    //  implements EventListenerInterface.php

    public function attachEvent( string $methodName, callable $callback ) {

    }

    public function detouchEvent( string $methodName ) {

    }
}