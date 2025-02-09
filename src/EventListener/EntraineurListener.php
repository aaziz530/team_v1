<?php

namespace App\EventListener;

use App\Entity\Entraineur;
use Doctrine\ORM\Event\PostLoadEventArgs;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;

#[AsEntityListener(event: 'postLoad', entity: Entraineur::class)]
class EntraineurListener
{
    public function postLoad(Entraineur $entraineur, PostLoadEventArgs $event): void
{
    $dateFinContrat = $entraineur->getDateFinContrat();


    // Si la date est null (CDI), ne rien faire
    if ($dateFinContrat === null) {
        
        return; // CDI, donc on ne fait rien
    }

    $now = new \DateTime();
    
    if ($dateFinContrat < $now) {
        $entityManager = $event->getObjectManager();
        $user = $entraineur->getUser();

        if ($user) {
            $entraineur->setUser(null);
            $entityManager->remove($user);
            $entityManager->flush();
        }
    }
}
}
