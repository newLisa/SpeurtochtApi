<?php 
namespace AppBundle\Controller;
 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Speurtocht;
use AppBundle\Entity\Marker;
use AppBundle\Entity\Vraag;
use AppBundle\Entity\Koppel_tocht_locatie;



class PostController extends FOSRestController
{
	/**
	* @Rest\Post("/postQuest/")
	*/
	public function postAction(Request $request)
	{

		$requestJson = json_decode($request->getContent(), true);
		file_put_contents("testrequest.txt", $requestJson);
		//dd($requestJson);
		$quest = new Speurtocht;
		$marker = new Marker;
		$question = new Vraag;
		$tochtLocatie = new Koppel_tocht_locatie;

		if (empty($requestJson['quest']['name']) || empty($requestJson['quest']['course']) || empty($requestJson['quest']['info'])) 
		{
			return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
		}
		$quest->setNaam($requestJson['quest']['name']);
		$quest->setOpleiding($requestJson['quest']['course']);
		$quest->setInformatie($requestJson['quest']['info']);
		$quest->setIsDeleted(0);
		$em = $this->getDoctrine()->getManager();
		$em->persist($quest);
		$em->flush();
		foreach ($requestJson['marker'] as $jsonMarker) {

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

			$tochtLocatie->setTochtId($quest->getId());
			$tochtLocatie->setLocatieId($marker->getId());
			$em->persist($tochtLocatie);
			$em->flush();
		}
		



		/*$questData = new Speurtocht;
		$questName = $request->get('name');
		$questCourse = $request->get('course');
		$questInfo = $request->get('info');*/

/*		if (empty($name) || empty($course) || empty($info)) 
		{
			return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
		}*/

		/*$data->setNaam($name);
		$data->setOpleiding($course);
		$data->setInformatie($info);
		$em = $this->getDoctrine()->getManager();
		$em->persist($data);
		$em->flush();

		$id = $data->getId();

		return new View($id, Response::HTTP_OK);*/

		return new View(Response::HTTP_OK);
	}
}