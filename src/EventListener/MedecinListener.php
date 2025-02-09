<?php

namespace App\EventListener;

use App\Entity\Medecin;
use Doctrine\ORM\Event\PostLoadEventArgs;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;

#[AsEntityListener(event: 'postLoad', entity: Medecin::class)]
class MedecinListener
{
    public function postLoad(Medecin $medecin, PostLoadEventArgs $event): void
{
    $dateFinContrat = $medecin->getDateFinContrat();


    // Si la date est null (CDI), ne rien faire
    if ($dateFinContrat === null) {
        
        return; // CDI, donc on ne fait rien
    }

    $now = new \DateTime();
    
    if ($dateFinContrat < $now) {
        $entityManager = $event->getObjectManager();
        $user = $medecin->getUser();

        if ($user) {
            $medecin->setUser(null);
            $entityManager->remove($user);
            $entityManager->flush();
        }
    }
}
}
