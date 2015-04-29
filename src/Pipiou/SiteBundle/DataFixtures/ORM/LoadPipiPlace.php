<?php
// src/Pipiou/UserBundle/DataFixtures/ORM/LoadUser.php

namespace Pipiou\SiteBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Pipiou\SiteBundle\Entity\PipiPlace;
use CrEOF\Spatial\PHP\Types\Geometry\Point;

class LoadPipiPlaces implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		// FROIDEVAUX
		$place1 = new PipiPlace();
		$place1->setName("Froidevaux");
		$place1->setPosition(new Point("48.836531897379", "2.3255288600922"));
		$manager->persist($place1);

		// PARIS
		$place2 = new PipiPlace();
		$place2->setName("Paris!");
		$place2->setPosition(new Point("48.855", "2.35"));
		$manager->persist($place2);

		// SF
		$place3 = new PipiPlace();
		$place3->setName("San Francisco");//37.7, -122.4
		$place3->setPosition(new Point("37.7", "-122.4"));
		$manager->persist($place3);

		$manager->flush();
	}
}