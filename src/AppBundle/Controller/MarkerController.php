<?php 
namespace AppBundle\Controller;
 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Marker;
use AppBundle\Entity\Vraag;
use AppBundle\Entity\Koppel_tocht_locatie;


class MarkerController extends FOSRestController
{
	 /**
     * @Rest\Get("/marker")
     */
    public function getAction()
    {
      $restresult = $this->getDoctrine()->getRepository('AppBundle:Marker')->findAll();
        if ($restresult === null) 
        {
          return new View("no markers found", Response::HTTP_NOT_FOUND);
        
    	}
        return $restresult;
    }

	/**
	* @Rest\Get("/marker/{id}")
	*/
	public function idAction($id)
	{
		$singleresult = $this->getDoctrine()->getRepository('AppBundle:Marker')->find($id);
	 	if ($singleresult === null) 
	 	{
			return new View("marker not found", Response::HTTP_NOT_FOUND);
	    }
	 return $singleresult;
	}

	/**
	* @Rest\Post("/marker/")
	*/
	public function postAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$requestJson = json_decode($request->getContent(), true);
		foreach ($requestJson['markers'] as $jsonMarker) {
			$marker = new Marker;
			$question = new Vraag;
			$tochtLocatie = new Koppel_tocht_locatie;


			$question->setVraag($jsonMarker['questions']['question']);
			$question->setCorrect_Answer($jsonMarker['questions']['correctAnswer']);
			$question->setPoints($jsonMarker['questions']['points']);
			$question->setAnswer_1($jsonMarker['questions']['answer1']);
			$question->setAnswer_2($jsonMarker['questions']['answer2']);
			$question->setAnswer_3($jsonMarker['questions']['answer3']);
			$question->setAnswer_4($jsonMarker['questions']['answer4']);
			$em->persist($question);
			$em->flush();

			$marker->setName($jsonMarker['name']);
			$marker->setLatitude($jsonMarker['location']['lat']);
			$marker->setLongitude($jsonMarker['location']['lng']);
			$marker->setInfo($jsonMarker['markerInfo']);
			$marker->setQuestionId($question->getId());
			$marker->setIsQr($jsonMarker['isQr'] === true? 1: 0);
			$marker->setIsVisible($jsonMarker['isVisible'] === true? 1: 0);
			$em->persist($marker);
			$em->flush();

			$tochtLocatie->setTochtId($requestJson['questId']);
			$tochtLocatie->setLocatieId($marker->getId());
			$em->persist($tochtLocatie);
			$em->flush();
		}

		return new View("Marker Added Successfully", Response::HTTP_OK);
	}

	/**
	* @Rest\Put("/marker/{id}")
	*/
	public function updateAction($id,Request $request)
	{ 
		$data = new Marker;
		$latitude = $request->get('latitude');
		$longitude = $request->get('longitude');
		$sn = $this->getDoctrine()->getManager();
		$marker = $this->getDoctrine()->getRepository('AppBundle:Marker')->find($id);
		if (empty($marker)) 
		{
			return new View("marker not found", Response::HTTP_NOT_FOUND);
		} 
		elseif(!empty($latitude) && !empty($longitude))
		{
			$marker->setLatitude($latitude);
			$marker->setLongitude($longitude);
			$sn->flush();
			return new View("Marker Updated Successfully", Response::HTTP_OK);
		}
		elseif(empty($latitude) && !empty($longitude))
		{
			$marker->setLongitude($longitude);
			$sn->flush();
			return new View("longitude Updated Successfully", Response::HTTP_OK);
		}
		elseif(!empty($latitude) && empty($longitude))
		{
			$marker->setLatitude($latitude);
			$sn->flush();
			return new View("Marker Name Updated Successfully", Response::HTTP_OK); 
		}
		else 
		{
			return new View("Marker latitude or longitude cannot be empty", Response::HTTP_NOT_ACCEPTABLE); 
		}
	}

	/**
	* @Rest\Post("/marker/delete{id}")
	*/
	public function deleteAction($id)
	{
		$data = new Marker;
		$sn = $this->getDoctrine()->getManager();
		$marker = $this->getDoctrine()->getRepository('AppBundle:Marker')->find($id);
		if (empty($marker)) 
		{
			return new View("marker not found", Response::HTTP_NOT_FOUND);
		}
	else 
	{
		$sn->remove($marker);
		$sn->flush();
	}
	
	return new View("deleted successfully", Response::HTTP_OK);
	}
}