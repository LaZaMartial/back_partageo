<?php

namespace App\Events;

use App\Entity\Utilisateur;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class CreationJWT{
    public function onJWTCreated(JWTCreatedEvent $event){
        $user = $event->getUser();

        if($user instanceof Utilisateur){
            $data = $event->getData();
            $data['Id'] = $user->getId();
            $data['Nom'] = $user->getNom();

            $event->setData($data);
        }
    }
}