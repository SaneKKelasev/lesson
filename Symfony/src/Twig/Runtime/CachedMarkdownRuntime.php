<?php

namespace App\Twig\Runtime;

use App\Services\MarkdownParser;
use Twig\Extension\RuntimeExtensionInterface;

class CachedMarkdownRuntime implements RuntimeExtensionInterface
{
    /**
     * @var MarkdownParser
     */
    private MarkdownParser $markdownParser;

    /**
     * @param MarkdownParser $markdownParser
     */
    public function __construct(MarkdownParser $markdownParser)
    {
        $this->markdownParser = $markdownParser;
    }

    public function cashedMarkdown($value)
    {
        $this->markdownParser->parse($value);
    }
}
