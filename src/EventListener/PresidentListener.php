<?php

namespace App\EventListener;


use App\Entity\President;
use Doctrine\ORM\Event\PostLoadEventArgs;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;

#[AsEntityListener(event: 'postLoad', entity: President::class)]
class PresidentListener
{
    public function postLoad(President $president, PostLoadEventArgs $event): void
{
    $dateFinContrat = $president->getDateFinContrat();


    // Si la date est null (CDI), ne rien faire
    if ($dateFinContrat === null) {
        
        return; // CDI, donc on ne fait rien
    }

    $now = new \DateTime();
    
    if ($dateFinContrat < $now) {
        $entityManager = $event->getObjectManager();
        $user = $president->getUser();

        if ($user) {
            $president->setUser(null);
            $entityManager->remove($user);
            $entityManager->flush();
        }
    }
}
}
