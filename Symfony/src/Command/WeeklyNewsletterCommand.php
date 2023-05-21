<?php

namespace App\Command;

use App\Entity\Article;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use App\Services\Mailer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:weekly-newsletter',
    description: 'Еженедельная рассылка статей',
)]
class WeeklyNewsletterCommand extends Command
{
    public function __construct(
        protected UserRepository $userRepository,
        protected ArticleRepository $articleRepository,
        protected Mailer $mailer
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var User[]|null $users */
        $users = $this->userRepository->findAllSubscribedUsers();

        /** @var Article[] $articles */
        $articles = $this->articleRepository->findAllPublishedLastWeek();

        $io = new SymfonyStyle($input, $output);

        if ($articles && count($articles) === 0) {
            $io->warning('За последнюю неделю нету статей');
            return Command::SUCCESS;
        }

        $io->progressStart(count($users));

        foreach ($users as $user) {
            $this->mailer->sendWeekNewsletter($user, $articles);

            $io->progressAdvance();

            break;
        }

        $io->progressFinish();

        return Command::SUCCESS;
    }
}
