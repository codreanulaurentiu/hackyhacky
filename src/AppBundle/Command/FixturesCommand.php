<?php
/**
 * Created by PhpStorm.
 * User: alexandru.pop
 * Date: 9/8/2018
 * Time: 10:47 PM
 */

namespace AppBundle\Command;


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

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var RegistryInterface $doctrine */
        $doctrine = $this->getContainer()->get('doctrine');
        $this->manager = $doctrine->getManager();

        $this->createUsers();

    }

    protected function createUsers(): void
    {
        foreach ($this->users as $user) {
            $dbUser = new User();
            $dbUser->setEmail($user);
            $dbUser->setIsActive(true);
            $dbUser->setUsername($user);
            $dbUser->setPassword(password_hash(1234, PASSWORD_DEFAULT));

            $this->manager->persist($dbUser);
        }

        $this->manager->flush();
    }

}