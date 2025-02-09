<?php

namespace App\Controller;

use App\Entity\Entraineur;
use App\Entity\Joueur;
use App\Entity\User;
use App\Entity\Medecin;
use App\Entity\Photographe;
use App\Entity\President;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/api/admin', name: 'admin_')]
class AdminController extends AbstractController
{
    #[Route('/create-medecin', name: 'create_medecin', methods: ['POST'])]
    public function createMedecin(Request $request, UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine): JsonResponse
    {
        $em = $doctrine->getManager();
        $data = json_decode($request->getContent(), true);

        $email = $data['email'];
        $password = $data['password'];
        $firstname = $data['firstname'];
        $lastname = $data['lastname'];
        $birthdate = new \DateTime($data['birthdate']);
        $specialite = $data['specialite'];
        $phone_number = $data['phone_number'];
        $dateAffectation = new \DateTime($data['date_affectation']);

        $dateFinContrat = isset($data['date_fin_contrat']) && !empty($data['date_fin_contrat'])
            ? new \DateTime($data['date_fin_contrat'])  
            : null;

        // Créer l'utilisateur
        $user = new User();
        $user->setEmail($email);
        $user->setUsername($email);
        $hashedPassword = $passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_MEDECIN']);

        // Créer le médecin
        $medecin = new Medecin();
        $medecin->setFirstname($firstname);
        $medecin->setLastname($lastname);
        $medecin->setBirthdate($birthdate);
        $medecin->setSpecialite($specialite);
        $medecin->setPhoneNumber($phone_number);
        $medecin->setDateAffectation($dateAffectation);
        $medecin->setDateFinContrat($dateFinContrat);
        $medecin->setUser($user);  // Lier le médecin à l'utilisateur

        // Lier l'utilisateur au médecin dans l'entité User
        $user->setMedecin($medecin);

        // Sauvegarder l'utilisateur et le médecin
        $em->persist($user);
        $em->persist($medecin);
        $em->flush();

        return $this->json(['message' => 'Médecin créé avec succès']);
    }

    #[Route('/listmedecins', name: 'listmedecins', methods: ['GET'])]
    public function listMedecins(ManagerRegistry $doctrine): JsonResponse
    {
        $medecins = $doctrine->getRepository(Medecin::class)->findAll();
        
        $medecinData = [];
        foreach ($medecins as $medecin) {
            $medecinData[] = [
                'id' => $medecin->getId(),
                'firstname' => $medecin->getFirstname(),
                'lastname' => $medecin->getLastname(),
                'birthdate' => $medecin->getBirthdate()->format('Y-m-d'),
                'specialite' => $medecin->getSpecialite(),
                'phone_number' => $medecin->getPhoneNumber(),
                'date_affectation' => $medecin->getDateAffectation() ? $medecin->getDateAffectation()->format('Y-m-d') : null,
                'date_fin_contrat' => $medecin->getDateFinContrat() ? $medecin->getDateFinContrat()->format('Y-m-d') : null,
            ];
        }
        
        return $this->json($medecinData);
    }

    //-------------------------------------------------------------------------------


    #[Route('/create-president', name: 'create_president', methods: ['POST'])]
    public function createPresident(Request $request, UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine): JsonResponse
    {
        $em = $doctrine->getManager();
        $data = json_decode($request->getContent(), true);

        $email = $data['email'];
        $password = $data['password'];
        $firstname = $data['firstname'];
        $lastname = $data['lastname'];
        $birthdate = new \DateTime($data['birthdate']);
        $phone_number = $data['phone_number'];
        $dateAffectation = new \DateTime($data['date_affectation']);

        $dateFinContrat = isset($data['date_fin_contrat']) && !empty($data['date_fin_contrat'])
            ? new \DateTime($data['date_fin_contrat'])  
            : null;

        // Créer l'utilisateur
        $user = new User();
        $user->setEmail($email);
        $user->setUsername($email);
        $hashedPassword = $passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_PRESIDENT']);

        // Créer le president
        $president = new President();
        $president->setFirstname($firstname);
        $president->setLastname($lastname);
        $president->setBirthdate($birthdate);
        $president->setPhoneNumber($phone_number);
        $president->setDateAffectation($dateAffectation);
        $president->setDateFinContrat($dateFinContrat);
        $president->setUser($user);  // Lier le president à l'utilisateur

        // Lier l'utilisateur au president dans l'entité User
        $user->setPresident($president);

        // Sauvegarder l'utilisateur et le president
        $em->persist($user);
        $em->persist($president);
        $em->flush();

        return $this->json(['message' => 'Président créé avec succès']);
    }


    #[Route('/listpresidents', name: 'listpresidents', methods: ['GET'])]
    public function listPresidents(ManagerRegistry $doctrine): JsonResponse
    {
        $presidents = $doctrine->getRepository(President::class)->findAll();
        
        $presidentData = [];
        foreach ($presidents as $president) {
            $presidentData[] = [
                'id' => $president->getId(),
                'firstname' => $president->getFirstname(),
                'lastname' => $president->getLastname(),
                'birthdate' => $president->getBirthdate()->format('Y-m-d'),
                'phone_number' => $president->getPhoneNumber(),
                'date_affectation' => $president->getDateAffectation() ? $president->getDateAffectation()->format('Y-m-d') : null,
                'date_fin_contrat' => $president->getDateFinContrat() ? $president->getDateFinContrat()->format('Y-m-d') : null,
            ];
        }
        
        return $this->json($presidentData);
    }

    //-------------------------------------------------------------------------------


    #[Route('/create-entraineur', name: 'create_entraineur', methods: ['POST'])]
    public function createEntraineur(Request $request, UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine): JsonResponse
    {
        $em = $doctrine->getManager();
        $data = json_decode($request->getContent(), true);

        $email = $data['email'];
        $password = $data['password'];
        $firstname = $data['firstname'];
        $lastname = $data['lastname'];
        $birthdate = new \DateTime($data['birthdate']);
        $specialite = $data['specialite'];
        $phone_number = $data['phone_number'];
        $dateAffectation = new \DateTime($data['date_affectation']);

        $dateFinContrat = isset($data['date_fin_contrat']) && !empty($data['date_fin_contrat'])
            ? new \DateTime($data['date_fin_contrat'])  
            : null;

        // Créer l'utilisateur
        $user = new User();
        $user->setEmail($email);
        $user->setUsername($email);
        $hashedPassword = $passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_ENTRAINEUR']);

        // Créer l'entraineur
        $entraineur = new Entraineur();
        $entraineur->setFirstname($firstname);
        $entraineur->setLastname($lastname);
        $entraineur->setBirthdate($birthdate);
        $entraineur->setSpecialite($specialite);
        $entraineur->setPhoneNumber($phone_number);
        $entraineur->setDateAffectation($dateAffectation);
        $entraineur->setDateFinContrat($dateFinContrat);
        $entraineur->setUser($user);  // Lier l'entraineur à l'utilisateur

        // Lier l'utilisateur au entraineur dans l'entité User
        $user->setEntraineur($entraineur);

        // Sauvegarder l'utilisateur et le entraineur
        $em->persist($user);
        $em->persist($entraineur);
        $em->flush();

        return $this->json(['message' => 'Entraineur créé avec succès']);
    }

    #[Route('/listentraineurs', name: 'listentraineurs', methods: ['GET'])]
    public function listEntraineurs(ManagerRegistry $doctrine): JsonResponse
    {
        $entraineurs = $doctrine->getRepository(Entraineur::class)->findAll();
        
        $entraineurData = [];
        foreach ($entraineurs as $entraineur) {
            $entraineurData[] = [
                'id' => $entraineur->getId(),
                'firstname' => $entraineur->getFirstname(),
                'lastname' => $entraineur->getLastname(),
                'birthdate' => $entraineur->getBirthdate()->format('Y-m-d'),
                'specialite' => $entraineur->getSpecialite(),
                'phone_number' => $entraineur->getPhoneNumber(),
                'date_affectation' => $entraineur->getDateAffectation() ? $entraineur->getDateAffectation()->format('Y-m-d') : null,
                'date_fin_contrat' => $entraineur->getDateFinContrat() ? $entraineur->getDateFinContrat()->format('Y-m-d') : null,
            ];
        }
        
        return $this->json($entraineurData);
    }


    //-------------------------------------------------------------------------------


    #[Route('/create-joueur', name: 'create_joueur', methods: ['POST'])]
    public function createJoueur(Request $request, UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine): JsonResponse
    {
        $em = $doctrine->getManager();
        $data = json_decode($request->getContent(), true);

        $email = $data['email'];
        $password = $data['password'];
        $firstname = $data['firstname'];
        $lastname = $data['lastname'];
        $birthdate = new \DateTime($data['birthdate']);
        $position = $data['position'];
        $phone_number = $data['phone_number'];
        $numero_maillot = $data['numero_maillot'];
        $salaire = $data['salaire'];
        $nb_carton_rouge = $data['nb_carton_rouge'];
        $nb_carton_jaune = $data['nb_carton_jaune'];
        $dateAffectation = new \DateTime($data['date_affectation']);

        $dateFinContrat = isset($data['date_fin_contrat']) && !empty($data['date_fin_contrat'])
            ? new \DateTime($data['date_fin_contrat'])  
            : null;

        // Créer l'utilisateur
        $user = new User();
        $user->setEmail($email);
        $user->setUsername($email);
        $hashedPassword = $passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_JOUEUR']);

        // Créer le joueur
        $joueur = new Joueur();
        $joueur->setFirstname($firstname);
        $joueur->setLastname($lastname);
        $joueur->setBirthdate($birthdate);
        $joueur->setPosition($position);
        $joueur->setPhoneNumber($phone_number);
        $joueur->setNumeroMaillot($numero_maillot);
        $joueur->setSalaire($salaire);
        $joueur->setNbCartonRouge($nb_carton_rouge);
        $joueur->setNbCartonJaune($nb_carton_jaune);
        $joueur->setDateAffectation($dateAffectation);
        $joueur->setDateFinContrat($dateFinContrat);
        $joueur->setUser($user);  // Lier le joueur à l'utilisateur

        // Lier l'utilisateur au joueur dans l'entité User
        $user->setJoueur($joueur);

        // Sauvegarder l'utilisateur et le joueur
        $em->persist($user);
        $em->persist($joueur);
        $em->flush();

        return $this->json(['message' => 'Joueur créé avec succès']);
    }

    #[Route('/listjoueurs', name: 'listjoueurs', methods: ['GET'])]
    public function listJoueurs(ManagerRegistry $doctrine): JsonResponse
    {
        $joueurs = $doctrine->getRepository(Joueur::class)->findAll();
        
        $joueurData = [];
        foreach ($joueurs as $joueur) {
            $joueurData[] = [
                'id' => $joueur->getId(),
                'firstname' => $joueur->getFirstname(),
                'lastname' => $joueur->getLastname(),
                'birthdate' => $joueur->getBirthdate()->format('Y-m-d'),
                'position' => $joueur->getPosition(),
                'phone_number' => $joueur->getPhoneNumber(),
                'numero_maillot' => $joueur->getNumeroMaillot(),
                'salaire' => $joueur->getSalaire(),
                'nb_carton_rouge' => $joueur->getNbCartonRouge(),
                'nb_carton_jaune' => $joueur->getNbCartonJaune(),
                'date_affectation' => $joueur->getDateAffectation() ? $joueur->getDateAffectation()->format('Y-m-d') : null,
                'date_fin_contrat' => $joueur->getDateFinContrat() ? $joueur->getDateFinContrat()->format('Y-m-d') : null,
            ];
        }
        
        return $this->json($joueurData);
    }

    //-------------------------------------------------------------------------------


    #[Route('/create-photographe', name: 'create_photographe', methods: ['POST'])]
    public function createPhotographe(Request $request, UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine): JsonResponse
    {
        $em = $doctrine->getManager();
        $data = json_decode($request->getContent(), true);

        $email = $data['email'];
        $password = $data['password'];
        $firstname = $data['firstname'];
        $lastname = $data['lastname'];
        $birthdate = new \DateTime($data['birthdate']);
        $phone_number = $data['phone_number'];
        $dateAffectation = new \DateTime($data['date_affectation']);

        $dateFinContrat = isset($data['date_fin_contrat']) && !empty($data['date_fin_contrat'])
            ? new \DateTime($data['date_fin_contrat'])  
            : null;

        // Créer l'utilisateur
        $user = new User();
        $user->setEmail($email);
        $user->setUsername($email);
        $hashedPassword = $passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_PHOTOGRAPHE']);

        // Créer le joueur
        $photographe = new Photographe();
        $photographe->setFirstname($firstname);
        $photographe->setLastname($lastname);
        $photographe->setBirthdate($birthdate);
        $photographe->setPhoneNumber($phone_number);
        $photographe->setDateAffectation($dateAffectation);
        $photographe->setDateFinContrat($dateFinContrat);
        $photographe->setUser($user);  // Lier le joueur à l'utilisateur

        // Lier l'utilisateur au joueur dans l'entité User
        $user->setPhotographe($photographe);

        // Sauvegarder l'utilisateur et le joueur
        $em->persist($user);
        $em->persist($photographe);
        $em->flush();

        return $this->json(['message' => 'Photographe créé avec succès']);
    }

    #[Route('/listphotographes', name: 'listphotographes', methods: ['GET'])]
    public function listPhotographes(ManagerRegistry $doctrine): JsonResponse
    {
        $photographes = $doctrine->getRepository(Photographe::class)->findAll();
        
        $photographeData = [];
        foreach ($photographes as $photographe) {
            $photographeData[] = [
                'id' => $photographe->getId(),
                'firstname' => $photographe->getFirstname(),
                'lastname' => $photographe->getLastname(),
                'birthdate' => $photographe->getBirthdate()->format('Y-m-d'),
                'phone_number' => $photographe->getPhoneNumber(),
                'date_affectation' => $photographe->getDateAffectation() ? $photographe->getDateAffectation()->format('Y-m-d') : null,
                'date_fin_contrat' => $photographe->getDateFinContrat() ? $photographe->getDateFinContrat()->format('Y-m-d') : null,
            ];
        }
        
        return $this->json($photographeData);
    }
}