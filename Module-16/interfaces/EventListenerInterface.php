<?php


interface EventListenerInterface
{
    public function attachEvent( string $methodName, callable $callback );
    public function detouchEvent( string $methodName );
}