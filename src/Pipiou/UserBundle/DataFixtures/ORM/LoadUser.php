<?php
// src/Pipiou/UserBundle/DataFixtures/ORM/LoadUser.php

namespace Pipiou\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Pipiou\UserBundle\Entity\User;

class LoadUser extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $manager){

		// USER
    	$listNames = array('moustachu', 'potiron', 'miche', 'vi');
    	foreach ($listNames as $name) {
			$user = new User;
			$user->setUsername($name);
			$user->setPlainPassword($name);
			$user->setEmail('test_'.$name.'@pipiou.com');            
			$user->setRoles(array('ROLE_USER'));
			$user->setEnabled(true);


			$manager->persist($user);
			
			if($name === "vi")
				$this->addReference('user-vi', $user);
		}

		// TODO ADMIN

		$manager->flush();

	}

	public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}