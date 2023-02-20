<?php

namespace App\Security;

use App\Entity\Participants;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof Participants) {
            return;
        }
        if (!$user->IsActif()) {
            throw new CustomUserMessageAuthenticationException(
                'Compte inactif veuillez contacter un administrateur.'
            );
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
        $this->checkPreAuth($user);
    }
}