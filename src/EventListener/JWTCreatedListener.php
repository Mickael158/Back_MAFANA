<?php
namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use App\Service\RoleSuspensionService;
use Psr\Log\LoggerInterface;

class JWTCreatedListener
{
    private RoleSuspensionService $roleSuspensionService;

    public function __construct(RoleSuspensionService $roleSuspensionService)
    {
        $this->roleSuspensionService = $roleSuspensionService;
    }

    public function onJWTCreateda(JWTCreatedEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        $filteredRoles = $this->roleSuspensionService->filterRoles($user);
        $data['roles'] = [];
        $data['userId'] = $user->getId();
        dump($data);
        $event->setData($data);
    }
}
