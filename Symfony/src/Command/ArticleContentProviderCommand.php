<?php

namespace App\Command;

use App\Homework\ArticleContentProvider;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use function Twig\Extra\Markdown\twig_html_to_markdown;

#[AsCommand(
    name: 'app:article:content_provider',
    description: 'returns json object',
)]
class ArticleContentProviderCommand extends Command
{
    /**
     * @var ArticleContentProvider
     */
    private ArticleContentProvider $content;


    /**
     * @param ArticleContentProvider $content
     * @param string|null $name
     */
    public function __construct(ArticleContentProvider $content, string $name = null)
    {
        parent::__construct($name);
        $this->content = $content;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('paragraphs', InputArgument::REQUIRED, 'count paragraphs')
            ->addArgument('word', InputArgument::OPTIONAL, 'repeat word', null)
            ->addArgument('wordsCount', InputArgument::OPTIONAL, 'count repeat word', 0)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $paragraphs = $input->getArgument('paragraphs');
        $word = $input->getArgument('word');
        $wordsCount = $input->getArgument('wordsCount');

        if (! is_null($word) && $wordsCount > 0) {
            $text = $this->content->get($paragraphs, $word, $wordsCount);
        } else {
            $text = $this->content->get($paragraphs);
        }

        $io->text(json_encode(($text)));

        return Command::SUCCESS;
    }
}
