<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\AgoRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AgoExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('ago', [AgoRuntime::class, 'ago']),
        ];
    }
}
