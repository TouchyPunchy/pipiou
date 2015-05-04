<?php
// src/Pipiou/UserBundle/DataFixtures/ORM/LoadUser.php

namespace Pipiou\SiteBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Pipiou\SiteBundle\Entity\PipiPlace;
use CrEOF\Spatial\PHP\Types\Geometry\Point;

class LoadPipiPlaces extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $manager)
	{
		// get user referenced in LoadUser fixture
		$user_vi = $this->getReference('user-vi');

		// FROIDEVAUX
		$place1 = new PipiPlace();
		$place1->setName("Froidevaux");
		$place1->setPosition(new Point("48.836531897379", "2.3255288600922"));
		$place1->setUserCreator($user_vi);
		$manager->persist($place1);

		// PARIS
		$place2 = new PipiPlace();
		$place2->setName("Paris!");
		$place2->setPosition(new Point("48.855", "2.35"));
		$place2->setUserCreator($user_vi);
		$manager->persist($place2);

		// SF
		$place3 = new PipiPlace();
		$place3->setName("San Francisco");//37.7, -122.4
		$place3->setPosition(new Point("37.7", "-122.4"));
		$place3->setUserCreator($user_vi);
		$manager->persist($place3);

		$manager->flush();
	}

	public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }
}