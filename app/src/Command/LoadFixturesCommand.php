<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Gossip;
use App\Entity\PaymentMethod;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadFixturesCommand extends Command
{
    protected static $defaultName = 'app:load-fixtures';

    private EntityManagerInterface $entityManager;

    /**
     * @param string|null $name
     */
    public function __construct(EntityManagerInterface $entityManager, string $name = null)
    {
        parent::__construct($name);

        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this->setDescription('Loads fixtures');
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
            $this->entityManager->persist(new Gossip('Kowalski kupił sobie nowy samochód.'));
            $this->entityManager->persist(new Gossip('Malinowska zdradza męża.'));
            $this->entityManager->persist(new Gossip('Nowak stracił pracę.'));

            $this->entityManager->persist(new Product(
                'Teletydzień',
                'https://secure.ce-tescoassets.com/assets/PL/105/9771230791105/ShotType1_540x540.jpg',
                3.40
            ));

            $this->entityManager->persist(new Product(
                'Papierosy',
                'https://www.kiep.pl/img47/2018/07/29/5b5d01b6c8a93.jpg',
                16.20
            ));

            $this->entityManager->persist(new Product(
                'Guma Turbo',
                'https://www.spodlady.com/zasoby/images/big/turbo.jpg',
                0.50
            ));

            $this->entityManager->persist(new PaymentMethod('Gotówka'));
            $this->entityManager->persist(new PaymentMethod('Przelew'));

            $this->entityManager->flush();

            $output->writeln('<info>Fixtures have been loaded successfully.</info>');
        } catch (Exception $e) {
            $output->writeln('<error>'.$e->getMessage().'</error>');
        }

        return 0;
    }
}