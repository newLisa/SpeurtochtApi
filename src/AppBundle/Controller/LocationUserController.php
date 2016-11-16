<?php 
namespace AppBundle\Controller;
 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\LocationUser;

class LocationUserController extends FOSRestController
{
	 /**
     * @Rest\Get("/locationuser")
     */
    public function getAction()
    {
      $restresult = $this->getDoctrine()->getRepository('AppBundle:LocationUser')->findAll();

      foreach ($restresult as $value) {
      	$locationId = $value->getLocationId();
      	$userId = $value->getUserId();
      	$locationResult = $this->getDoctrine()->getRepository('AppBundle:Marker')->findById($locationId);
      	$userResult = $this->getDoctrine()->getRepository('AppBundle:User')->findById($userId);
      	$value->setLocation($locationResult);
      	$value->setUser($userResult);
      }
        if ($restresult === null) {
          return new View("there are no highscores to display.", Response::HTTP_NOT_FOUND);
     }
        return $restresult;
    }

	/**
	* @Rest\Get("/locationuser/{id}")
	*/
	public function idAction($id)
	{
		$singleresult = $this->getDoctrine()->getRepository('AppBundle:LocationUser')->find($id);
	 	if ($singleresult === null) 
	 	{
			return new View("highscore not found", Response::HTTP_NOT_FOUND);
	    }
	 return $singleresult;
	}

	/**
	* @Rest\Post("/locationuser/")
	*/
	public function postAction(Request $request)
	{
		$data = new LocationUser;
		$location_id = $request->get('locatie_id');
		$user_id = $request->get('user_id');
		$correct = $request->get('answered_correct');
		if ($correct == 0) 
		{
			$correct = false;
		}

		if(!isset($location_id) && !isset($user_id) && !isset($correct))
		{
			return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE); 
		}

		$data->setLocationId($location_id);
		$data->setUserId($user_id);
		$data->setAnsweredCorrect($correct);

		$em = $this->getDoctrine()->getManager();
		$em->persist($data);
		$em->flush();

	 return new View("LocationUser Added Successfully", Response::HTTP_OK);
	}


	/**
	* @Rest\Put("/locationuser/{id}")
	*/
	public function updateAction($id,Request $request)
	{ 
		$data = new LocationUser;
		$score = $request->get('score');
		$user_id = $request->get('user_id');
		$sn = $this->getDoctrine()->getManager();
		$highscore = $this->getDoctrine()->getRepository('AppBundle:LocationUser')->find($id);
		if (empty($highscore)) 
		{
			return new View("LocationUser not found", Response::HTTP_NOT_FOUND);
		} 
		elseif(!empty($score) && !empty($user_id))
		{
			$highscore->setScore($score);
			$highscore->setUserId($user_id);
			$sn->flush();
			return new View("Highscore Updated Successfully", Response::HTTP_OK);
		}
		elseif(empty($score) && !empty($user_id))
		{
			$highscore->setUserId($user_id);
			$sn->flush();
			return new View("user_id Updated Successfully", Response::HTTP_OK);
		}
		elseif(!empty($score) && empty($user_id))
		{
			$highscore->setScore($score);
			$sn->flush();
			return new View("Score Updated Successfully", Response::HTTP_OK); 
		}
		else 
		{
			return new View("Score or user_id cannot be empty", Response::HTTP_NOT_ACCEPTABLE); 
		}
	}

	/**
	* @Rest\Delete("/locationuser/{id}")
	*/
	public function deleteAction($id)
	{
		$data = new LocationUser;
		$sn = $this->getDoctrine()->getManager();
		$highscore = $this->getDoctrine()->getRepository('AppBundle:LocationUser')->find($id);
		if (empty($highscore)) 
		{
			return new View("Highscore not found", Response::HTTP_NOT_FOUND);
		}
	else 
	{
		$sn->remove($highscore);
		$sn->flush();
	}
	
	return new View("Highscore deleted successfully", Response::HTTP_OK);
	}
}