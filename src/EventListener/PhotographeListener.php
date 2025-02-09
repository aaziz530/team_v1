<?php

namespace App\EventListener;


use App\Entity\Photographe;
use Doctrine\ORM\Event\PostLoadEventArgs;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;

#[AsEntityListener(event: 'postLoad', entity: Photographe::class)]
class PhotographeListener
{
    public function postLoad(Photographe $photographe, PostLoadEventArgs $event): void
{
    $dateFinContrat = $photographe->getDateFinContrat();


    // Si la date est null (CDI), ne rien faire
    if ($dateFinContrat === null) {
        
        return; // CDI, donc on ne fait rien
    }

    $now = new \DateTime();
    
    if ($dateFinContrat < $now) {
        $entityManager = $event->getObjectManager();
        $user = $photographe->getUser();

        if ($user) {
            $photographe->setUser(null);
            $entityManager->remove($user);
            $entityManager->flush();
        }
    }
}
}
