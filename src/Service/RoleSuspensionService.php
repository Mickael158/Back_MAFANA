<?php
namespace App\Service;

use App\Entity\Users;
use App\Repository\RoleSuspenduRepository;

class RoleSuspensionService
{
    private RoleSuspenduRepository $roleSuspenduRepository;

    public function __construct(RoleSuspenduRepository $roleSuspenduRepository)
    {
        $this->roleSuspenduRepository = $roleSuspenduRepository;
    }

    public function filterRoles($roles): array
    {
        $suspendedRoles = array_column($this->roleSuspenduRepository->getRolesSuspendues(), 'role');

        $newRoles = $roles;
        foreach ($roles as $role) {
            foreach ($suspendedRoles as $susRole) {
                if ($susRole == $role) {
                    $index = array_search($role, $newRoles);
                    if ($index !== false) {
                        unset($newRoles[$index]);
                    }
                }    
            }
        }
        return $newRoles = array_values($newRoles); 
    }
}
