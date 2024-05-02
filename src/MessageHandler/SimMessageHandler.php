<?php

namespace App\MessageHandler;

use App\Message\SimMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class SimMessageHandler
{
    public function __invoke(SimMessage $message)
    {
        // do something with your message
    }
}
