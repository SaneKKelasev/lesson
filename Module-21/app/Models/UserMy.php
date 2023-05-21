<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMy extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role'
    ];

    public function getTextsToEdit()
    {

    }

    //  implements EventListenerInterface.php
    public function attachEvent(string $methodName, callable $callback)
    {

    }

    public function detouchEvent(string $methodName)
    {

    }
}
