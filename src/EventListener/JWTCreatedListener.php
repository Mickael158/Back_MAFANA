<?php
namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JWTCreatedListener
{
    /**
     * Ajoute des informations supplémentaires dans le token JWT
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        // Récupérer les données actuelles du token
        $data = $event->getData();
        $user = $event->getUser();

        // Ajoute des informations supplémentaires concernant l'utilisateur
        $data['id'] = $user->getId();
        $data['username'] = $user->getUsername();
        $data['roles'] = $user->getRoles();

        // Récupérer des informations depuis l'entité liée PersonneMembre
        $personne = $user->getIdPersonne();
        if ($personne) {
            $data['personne'] = [
                'id' => $personne->getId(),
                'nom' => $personne->getNom(),
                'prenom' => $personne->getPrenom(),
            ];
        }

        // Mettre à jour les données du token
        $event->setData($data);
    }
}
