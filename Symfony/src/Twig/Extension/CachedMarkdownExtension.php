<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\CachedMarkdownRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class CachedMarkdownExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('cached_markdown', [CachedMarkdownRuntime::class, 'cashedMarkdown'], ['is_safe' => ['html']]),
        ];
    }
}
