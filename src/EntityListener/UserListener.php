<?php
namespace App\EntityListener;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
class UserListener
{
    private UserPasswordHasherInterface $hasher;
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher=$hasher;
    }
    public function prepersist(User $user)
    {
        $this->encodepassword($user);
    }

    public function preupdate(User $user)
    {
        $this->encodepassword($user);
    }

    /**
     * Encode password
     *
     * @param User $user
     * @return void
     */
    public function encodepassword(User $user)
    {
        if($user->getPlainpassword()===null)
        {
            return;
        }
        $user->setPassword($this->hasher->hashPassword($user,$user->getPlainpassword()));
        $user->setPlainpassword(null);
    }
}