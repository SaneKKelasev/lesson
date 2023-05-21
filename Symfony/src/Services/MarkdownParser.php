<?php

namespace App\Services;

use App\Homework\ArticleContentProvider;
use Psr\Cache\CacheItemPoolInterface;

class MarkdownParser
{
    /**
     * @var \ArticleContentProvider
     */
    private ArticleContentProvider $articleContent;

    /**
     * @var CacheItemPoolInterface
     */
    private CacheItemPoolInterface $cache;

    /**
     * @param \ArticleContentProvider $articleContent
     * @param CacheItemPoolInterface $cache
     */
    public function __construct(ArticleContentProvider $articleContent, CacheItemPoolInterface $cache)
    {
        $this->articleContent = $articleContent;
        $this->cache = $cache;
    }

    /**
     * @param string $text
     * @return string
     */
    public function parse(string $text): string
    {
        return $this->cache->get('markdown_' . md5($text), function () use ($text) {
            return $this->articleContent->get($text);
        });
    }
}