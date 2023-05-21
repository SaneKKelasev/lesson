<?php

interface LoggerInterface
{
    public function logMessage( string $textError );
    public function lastMessages( int $countMessage ) : array;
}