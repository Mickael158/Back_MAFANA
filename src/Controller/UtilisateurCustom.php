<?php
namespace App\Controller;

use Symfony\Component\Security\Core\User\UserInterface;

class UtilisateurCustom implements UserInterface
{
    private $id;
    private $username;
    private $password;
    private $roles = [];

    // Implémentez les méthodes de l'interface UserInterfacepublic function getUserIdentifier(): str

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $Username)
    {
        $this->username = $Username;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }
    public function setPassword(string $password){
        $this->password = $password;
        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }
    public function setRoles( $roles){
        $this->roles = $roles;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->username; // Ou tout autre identifiant unique que vous utilisez
    }

    public function getSalt() // Si vous utilisez un algorithme de hachage qui nécessite un sel
    {
        return null; // Pas nécessaire si vous utilisez bcrypt ou argon2i
    }

    public function eraseCredentials():void
    {
        // Ne pas utiliser d'informations sensibles
    }
}
