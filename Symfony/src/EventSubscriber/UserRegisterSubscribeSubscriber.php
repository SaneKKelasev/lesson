<?php

namespace App\EventSubscriber;

use App\Events\UserRegisteredEvent;
use App\Services\Mailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserRegisterSubscribeSubscriber implements EventSubscriberInterface
{
    public function __construct(
        protected Mailer $mailer
    ) {
    }

    public function onUserRegistered(UserRegisteredEvent $event)
    {
        $this->mailer->sendWelcomeMail($event->getUser());
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UserRegisteredEvent::class => 'onUserRegistered',
        ];
    }
}
