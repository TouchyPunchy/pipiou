<?php

namespace Pipiou\SiteBundle\Entity;

use Doctrine\ORM\EntityRepository;
use CrEOF\Spatial\PHP\Types\Geometry\Point;
use CrEOF\Spatial\PHP\Types\Geometry\Polygon;
use CrEOF\Spatial\PHP\Types\Geometry\LineString;

/**
 * PipiPlaceRepository
 */
class PipiPlaceRepository extends EntityRepository
{
	public function findBetween($point1_lat,$point1_lon, $point2_lat,$point2_lon)
	{
		$em = $this->getEntityManager();
		$lineString = new LineString(array(
			new Point($point1_lat, $point1_lon),
            new Point($point2_lat, $point1_lon),
            new Point($point2_lat, $point2_lon),
            new Point($point1_lat, $point2_lon),
            new Point($point1_lat, $point1_lon)
        ));
        $polygon = new Polygon(array($lineString));
        $query = $em->createQuery("SELECT p FROM PipiouSiteBundle:PipiPlace p WHERE MBRContains(GeomFromText(:p1), p.position)=1");
        $query->setParameter('p1', $polygon, 'polygon');
        return $query->getResult();
	}
}
