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
use Pipiou\SiteBundle\Entity\PipiPlaceEvaluation;
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
            'PipiouSiteBundle:Site:section.index.html.twig',
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

    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function evaluateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $place_repository = $em->getRepository('PipiouSiteBundle:PipiPlace');
        $evaluation_repository = $em->getRepository('PipiouSiteBundle:PipiPlaceEvaluation');
        
        $place = $place_repository->find($id);
        $current_user = $this->getUser();
        $place_evaluation = $evaluation_repository->findOneBy(array('user_evaluator' => $current_user, 'place' => $place));
        
        if(!$place_evaluation)
            $place_evaluation = new PipiPlaceEvaluation();

        $place_evaluation->setPlace($place);
        $place_evaluation->setUserEvaluator($this->getUser());
        $place_evaluation->setRating(5);

        $form = $this->createFormBuilder($place_evaluation)
            ->setMethod('POST')
            ->add('gender','choice', array(
                'attr' => array('class' => ''),
                'choices' => array(1 => "Homme", 2 => "Femme", 3 => "Mixte"),
                'data' => $place_evaluation->getGender(),
                'expanded' => false, // select
                'multiple' => false  
            ))
            ->add('rating', 'choice', array(
                'attr' => array('class' => 'rating'),
                'choices' => array(5 => 5, 4 => 4, 3 => 3, 2 => 2, 1 => 1),
                'data' => $place_evaluation->getRating(),
                'expanded' => true,  // radio or checkbox...
                'multiple' => false  // but no checkbox...
            ))
            ->add('cleanliness', 'choice', array(
                'attr' => array('class' => 'rating'),
                'choices' => array(5 => 5, 4 => 4, 3 => 3, 2 => 2, 1 => 1),
                'data' => $place_evaluation->getCleanliness(),
                'expanded' => true,  // radio or checkbox...
                'multiple' => false  // but no checkbox...
            ))
            ->add('door', 'checkbox', array(
                'label'     => '',
                'required'  => false,
            ))
            ->add('paper', 'checkbox', array(
                'label'     => '',
                'required'  => false,
            ))
            ->add('music', 'checkbox', array(
                'label'     => '',
                'required'  => false,
            ))
            ->add('price', 'text')
            ->add('save', 'submit', array('label' => 'Save', 'attr' => array('class' => 'btn btn-default')))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            $place_evaluation = $form->getData();
            $em->persist($place_evaluation);
            $em->flush();
        }

        $places = $place_repository->findBy(array());
        $encoders = array(new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $places_dto = array();
        foreach ($places as $place)
            $places_dto[] = $place->getData();
        $places_json = $serializer->serialize($places_dto, 'json');

        $places_nearby = $place_repository->findBetween(0,0,100,100);
        $place = $place_repository->find($id);
        $evaluations = $place->getEvaluations();

        return $this->render(
            'PipiouSiteBundle:Site:section.evaluate_place.html.twig',
            array(
                'form_title' => "Evaluate Place",
                'form' => $form->createView(),
                'place' => $place,
                'places_json' => $places_json,
                'places_nearby' => $places_nearby,
                'evaluations' => $evaluations
            )
        );
    }
}
