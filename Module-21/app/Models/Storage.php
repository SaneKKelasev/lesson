<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TelegraphText;

class Storage extends Model
{
    use HasFactory;

    public function createStorage(TelegraphText $store)
    {

    }

    public function readStorage(string $identifierStore)
    {

    }

    public function updateStorage(string $identifierStore, TelegraphText $store)
    {

    }

    public function deleteStorage(string $identifierStore)
    {

    }

    public function list()
    {

    }

    // implements LoggerInterface
    public function logMessage(string $textError)
    {

    }

    public function lastMessages(int $countMessage) : array
    {
        return [];
    }

    //  implements EventListenerInterface.php

    public function attachEvent(string $methodName, callable $callback)
    {

    }

    public function detouchEvent(string $methodName)
    {

    }
}
