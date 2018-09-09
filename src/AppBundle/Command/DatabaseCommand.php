<?php

namespace AppBundle\Command;

use AppBundle\Entity\Item;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DatabaseCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('db:create')
            ->setDescription('Dumps dummy data in the DB');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var ObjectManager $em */
        $em = $this->getContainer()->get('doctrine')->getManager();
        $string = file_get_contents('uploads/test.json');
        $entities = json_decode($string, true);
        $entities = $entities['rows'];
        $i = 0;
        foreach ($entities as $entity) {$output->writeln(json_encode($entity));
            $item = new Item();
            try {

                $item->setName($entity['0']);
                $item->setExternalRef($entity['1']);
                $item->setType(Item::ITEM_TYPE_STANDARD);
                $item->setRecommendedExpireDate(5);
                $em->persist($item);
                $output->writeln($i);
                $em->flush();

                $em->clear();
            } catch (\Exception $e) {
                $output->writeln($e->getMessage());
            } catch (\Throwable $e) {
                $output->writeln($e->getMessage());
            }
        }
        $em->flush();
    }
}