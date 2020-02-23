<?php

declare(strict_types=1);

namespace App\Command;

use App\Messenger\Enum\PayloadEnum;
use App\Proxy\MessengerProxy;
use Exception;
use Kerox\Messenger\Messenger;
use Kerox\Messenger\Model\ProfileSettings;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SetGetStartedButtonCommand extends Command
{
    protected static $defaultName = 'app:set-get-started-button';

    private Messenger $messenger;

    /**
     * @param MessengerProxy $messengerProxy
     * @param string|null    $name
     */
    public function __construct(MessengerProxy $messengerProxy, string $name = null)
    {
        parent::__construct($name);

        $this->messenger = $messengerProxy->messenger();
    }

    protected function configure()
    {
        $this->setDescription(
            'Sets facebook messenger\'s get started button.'
        );
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $profileSettings = ProfileSettings::create()->addStartButton(PayloadEnum::GREETING);
            $this->messenger->profile()->add($profileSettings);

            $output->writeln('<info>Get started button has been set correctly.</info>');
        } catch (Exception $e) {
            $output->writeln('<error>'.$e->getMessage().'</error>');
        }

        return 0;
    }
}
