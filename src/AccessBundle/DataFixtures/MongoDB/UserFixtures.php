<?php

namespace AccessBundle\DataFixtures\MongoDB;

use AccessBundle\Document\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends AbstractFixture
{

    private $users = array(
        array('username' => 'user', 'password' => 'pass', 'roles' => array('ROLE_USER')),
        array('username' => 'admin', 'password' => 'pass', 'roles' => array('ROLE_ADMIN')),
        array('username' => 'api_user', 'password' => 'pass', 'roles' => array('ROLE_API')),
    );

    public function load(ObjectManager $manager) {
        foreach ($this->users as $user) {
            $userEntity = new User();
            $userEntity->setUsername($user['username'])
                    ->setPassword($user['password'])
                    ->setRoles($user['roles']);
            $manager->persist($userEntity);
        }
        for ($i = 1; $i < 100; $i++) {
            $userEntity = new User();
            $userEntity->setUsername("user$i")
                    ->setPassword('pass')
                    ->setRoles(array('ROLE_USER'));
            $manager->persist($userEntity);
        }
        $manager->flush();
    }

}
