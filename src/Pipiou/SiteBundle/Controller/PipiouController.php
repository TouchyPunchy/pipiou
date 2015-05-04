<?php

namespace Pipiou\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException; 	
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Doctrine\ORM\Mapping as ORM;
use Pipiou\SiteBundle\Entity\PipiPlace;
use CrEOF\Spatial\PHP\Types\Geometry\Point;
use CrEOF\Spatial\PHP\Types\Geometry\Polygon;
use CrEOF\Spatial\PHP\Types\Geometry\LineString;

class PipiouController extends Controller
{
    public function indexAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('PipiouSiteBundle:PipiPlace');
    	
    	$place = new PipiPlace();
    	$places = $repository->findBy(array());
		$form = $this->createFormBuilder($place)
			->setMethod('POST')
            ->add('name', 'text')
            ->add('position', 'text', array('data_class' => 'CrEOF\Spatial\PHP\Types\Geometry\Point'))
            ->add('save', 'submit', array('label' => 'Add', 'attr' => array('class' => 'btn btn-default')))
            ->getForm();

        $form->handleRequest($request);
	    if ($form->isValid()) {
	    	$place = $form->getData();
	    	$coords = explode(" ", $place->getPosition());
	    	$place->setPosition(new Point($coords[0], $coords[1]));
            $place->setUserCreator($this->getUser());
	    	$em->persist($place);
    		$em->flush();
	    }

    	$places = $repository->findBy(array());///*,array('price' => 'ASC'));*/
		$encoders = array(new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
		$serializer = new Serializer($normalizers, $encoders);

        $places_dto = array();
        foreach ($places as $place)
            $places_dto[] = $place->getData();
		$places_json = $serializer->serialize($places_dto, 'json');

        $places_nearby = $repository->findBetween(0,0,100,100);

        return $this->render(
            'PipiouSiteBundle:Site:index.html.twig',
            array(
                'form_title' => "Add Place",
                'form' => $form->createView(),
                'places' => $places,
                'places_json' => $places_json,
                'places_nearby' => $places_nearby
            )
        );
    }

    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function editAction(Request $request, $id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('PipiouSiteBundle:PipiPlace');
    	
    	$place = $repository->find($id);
		$form = $this->createFormBuilder($place)
			->setMethod('POST')
            ->add('name', 'text')
            ->add('position', 'text', array('data_class' => 'CrEOF\Spatial\PHP\Types\Geometry\Point'))
            ->add('save', 'submit', array('label' => 'Save', 'attr' => array('class' => 'btn btn-default')))
            ->getForm();

        $form->handleRequest($request);
	    if ($form->isValid()) {
	    	$place = $form->getData();
	    	$coords = explode(" ", $place->getPosition());
	    	$place->setPosition(new Point($coords[0], $coords[1]));
	    	$em->persist($place);
    		$em->flush();
	    }

    	$places = $repository->findBy(array());
		$encoders = array(new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
		$places_dto = array();
        foreach ($places as $place)
            $places_dto[] = $place->getData();
        $places_json = $serializer->serialize($places_dto, 'json');

        $places_nearby = $repository->findBetween(0,0,100,100);

        return $this->render(
            'PipiouSiteBundle:Site:index.html.twig',
            array(
            	'form_title' => "Edit Place",
            	'form' => $form->createView(),
            	'places' => $places,
            	'places_json' => $places_json,
                'places_nearby' => $places_nearby
            )
        );
    }
}
