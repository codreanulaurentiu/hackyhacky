<?php

namespace AppBundle\Command;


use AppBundle\Entity\Item;
use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FixturesCommand extends ContainerAwareCommand
{
    private $users = [
        'alex.p@snuff.com',
        'laur@snuff.com',
        'alex.t@snuff.com',
        'ciprian@snuff.com',
        'mihaela@snuff.com',
        'gabriela@snuff.com'
    ];


    /** @var ObjectManager */
    private $manager;

    /** @var OutputInterface */
    private $outputInterface;

    protected function configure()
    {
        $this
            ->setName('fixtures:fake')
            ->setDescription('Dumps dummy data in the DB');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var RegistryInterface $doctrine */
        $doctrine      = $this->getContainer()->get('doctrine');
        $this->manager = $doctrine->getManager();
        $this->outputInterface = $output;

        $this->outputInterface->writeln('Preparing to create fake data!');
        $this->outputInterface->writeln('3...');
        $this->outputInterface->writeln('2...');
        $this->outputInterface->writeln('1...');

        $this->createGenericItems();
        $this->createUsers();

        $this->outputInterface->writeln('DONE!');

    }

    protected function createUsers(): void
    {
        $this->outputInterface->writeln('Creating fake users');

        foreach ($this->users as $user) {
            $dbUser = new User();
            $dbUser->setEmail($user);
            $dbUser->setIsActive(true);
            $dbUser->setUsername($user);
            $dbUser->setPassword(password_hash(1234, PASSWORD_DEFAULT));

            $this->manager->persist($dbUser);
        }

        $this->doIt();
    }

    private function createGenericItems()
    {
        $this->outputInterface->writeln('Creating fake users');


        $this->doIt();
    }

    protected function giveEveryoneAFridge(): void
    {
        $this->outputInterface->writeln('give Everyone A Fridge!');

        $dbUSers = $this->manager->getRepository(User::class)->findAll();

        foreach ($dbUSers as $user) {

        }

        $this->doIt();
    }

    protected function doIt(): void
    {
        $this->outputInterface->writeln('Flushing!');
        $this->manager->flush();
        $this->outputInterface->writeln('DONE!');
    }

}