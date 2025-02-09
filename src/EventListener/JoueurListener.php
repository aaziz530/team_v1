<?php

namespace App\EventListener;

use App\Entity\Joueur;

use Doctrine\ORM\Event\PostLoadEventArgs;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;

#[AsEntityListener(event: 'postLoad', entity: Joueur::class)]
class JoueurListener
{
    public function postLoad(Joueur $joueur, PostLoadEventArgs $event): void
{
    $dateFinContrat = $joueur->getDateFinContrat();


    // Si la date est null (CDI), ne rien faire
    if ($dateFinContrat === null) {
        
        return; // CDI, donc on ne fait rien
    }

    $now = new \DateTime();
    
    if ($dateFinContrat < $now) {
        $entityManager = $event->getObjectManager();
        $user = $joueur->getUser();

        if ($user) {
            $joueur->setUser(null);
            $entityManager->remove($user);
            $entityManager->flush();
        }
    }
}
}
