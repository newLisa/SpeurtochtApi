<?php 
namespace AppBundle\Controller;
 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Vraag;

class VraagController extends FOSRestController
{
	 /**
	 * @Rest\Get("/vraag")
	 */
	public function getAction()
	{
		$restresult = $this->getDoctrine()->getRepository('AppBundle:Vraag')->findAll();

		if ($restresult == null) 
		{
			return new View("There are no Questions to display", Response::HTTP_NOT_FOUND);
		}
		return $restresult;
	}

	/**
	* @Rest\Get("/vraag/{id}")
	*/
	public function idAction($id)
	{
		$singleresult = $this->getDoctrine()->getRepository('AppBundle:Vraag')->find($id);

		if ($singleresult == null) 
		{
			return new View("Question not found", Response::HTTP_NOT_FOUND);
		}
		return $singleresult;
	}

	/**
	* @Rest\Post("/vraag/")
	*/
	public function postAction(Request $request)
	{
		$data = new Vraag;
		$question = $request->get('vraag');
		$answer = $request->get('antwoord');
		$points = $request->get('punten');
		$completed = $request->get('voltooid');

		if (empty($question) || empty($answer) || empty($points)|| empty($completed)) 
		{
			return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
		}

		$data->setVraag($question);
		$data->setAntwoord($answer);
		$data->setPunten($points);
		$em = $this->getDoctrine()->getManager();
		$em->persist($data);
		$em->flush();

		return new View("Question added succesfully", Response::HTTP_OK);
	}
	
	/*
		//TODO Put does not work yet
	*/

	// /**
	// * @Rest\Put("/vraag/{id}")
	// */
	// public function updateAction($id,Request $request)
	// { 
	// 	$data = new Vraag;
	// 	$question = $request->get('vraag');
	// 	$answer = $request->get('antwoord');
	// 	$points = $request->get('punten');
	// 	$completed = $request->get('voltooid');

	// 	$sn = $this->getDoctrine()->getManager();
	// 	$question = $this->getDoctrine()->getRepository('AppBundle:Vraag')->find($id);
	// 	if (empty($question)) 
	// 	{
	// 		return new View("Question not found", Response::HTTP_NOT_FOUND);
	// 	}
	// 	else
	// 	{
	// 		if (empty($question) && empty($answer) && empty($points) && empty($completed)) 
	// 		{
	// 			return new View("all values cannot be empty", Response::HTTP_NOT_ACCEPTABLE); 
	// 		}

	// 		if (!empty($question)) 
	// 		{
	// 			$question->SetVraag($question);
	// 			$sn->flush();
	// 		}

	// 		if (!empty($answer)) 
	// 		{
	// 			$question->SetAntwoord($answer);
	// 			$sn->flush();
	// 		}

	// 		if (!empty($points)) 
	// 		{
	// 			$question->SetPunten($points);
	// 			$sn->flush();
	// 		}

	// 		if (!empty($completed)) 
	// 		{
	// 			$question->SetVoltooid($completed);
	// 			$sn->flush();
	// 		}

	// 		return new View('Question updated succesfully', Response::HTTP_OK);
	// 	} 
	// }

	/**
	* @Rest\Delete("/vraag/{id}")
	*/
	public function deleteAction($id)
	{
		$data = new Vraag;
		$sn = $this->getDoctrine()->getManager();
		$question = $this->getDoctrine()->getRepository('AppBundle:Vraag')->find($id);
		if (empty($question)) 
		{
			return new View("Question not found", Response::HTTP_NOT_FOUND);
		}
	else 
	{
		$sn->remove($question);
		$sn->flush();
	}
	
	return new View("Question deleted successfully", Response::HTTP_OK);
	}
}