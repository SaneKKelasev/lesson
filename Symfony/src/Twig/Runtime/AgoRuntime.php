<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;
use Carbon\Carbon;

class AgoRuntime implements RuntimeExtensionInterface
{
    public function __construct()
    {
        // Inject dependencies if needed
    }

    public function ago($value)
    {
        return Carbon::make($value)->locale('ru')->diffForHumans();
    }
}
