<?php

declare(strict_types=1);

namespace App\Messenger\MessageHandler;

use App\Messenger\Enum\PayloadEnum;
use App\Messenger\Message\Gossips;
use App\Proxy\MessengerProxy;
use App\Repository\GossipRepository;
use Kerox\Messenger\Api\Send;
use Kerox\Messenger\Model\Message;
use Kerox\Messenger\Model\Message\QuickReply;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GossipsHandler extends AbstractFacebookEventHandler implements MessageHandlerInterface
{
    private GossipRepository $gossipRepository;

    public function __construct(MessengerProxy $messengerProxy, GossipRepository $gossipRepository)
    {
        parent::__construct($messengerProxy);

        $this->gossipRepository = $gossipRepository;
    }

    public function __invoke(Gossips $message)
    {
        $this->messenger->send()->action($message->sender(), Send::SENDER_ACTION_TYPING_ON);
        $this->messenger->send()->message($message->sender(), 'Nie uwierzysz, ale... 😱');

        foreach ($this->gossipRepository->findAll() as $gossip) {
            $this->messenger->send()->action($message->sender(), Send::SENDER_ACTION_TYPING_ON);
            $this->messenger->send()->message($message->sender(), $gossip->text());
        }

        $this->messenger->send()->action($message->sender(), Send::SENDER_ACTION_TYPING_ON);
        $this->messenger->send()->message(
            $message->sender(),
            (new Message('Czy masz może jakieś plotki do sprzedania?'))
                ->setQuickReplies([
                    QuickReply::create(QuickReply::CONTENT_TYPE_TEXT)
                        ->setTitle('Tak')
                        ->setPayload(PayloadEnum::GOSSIP_WANT_TO_ADD),
                    QuickReply::create(QuickReply::CONTENT_TYPE_TEXT)
                        ->setTitle('Nie')
                        ->setPayload(PayloadEnum::GOSSIP_DONT_WANT_TO_ADD),
                ])
        );
    }
}
