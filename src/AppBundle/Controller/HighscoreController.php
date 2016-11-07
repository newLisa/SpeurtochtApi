<?php 
namespace AppBundle\Controller;
 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Highscore;

class HighscoreController extends FOSRestController
{
	 /**
     * @Rest\Get("/highscores")
     */
    public function getAction()
    {
      $restresult = $this->getDoctrine()->getRepository('AppBundle:Highscore')->findAll();
        if ($restresult === null) {
          return new View("there are no highscores to display.", Response::HTTP_NOT_FOUND);
     }
        return $restresult;
    }

	/**
	* @Rest\Get("/highscores/{id}")
	*/
	public function idAction($id)
	{
		$singleresult = $this->getDoctrine()->getRepository('AppBundle:Highscore')->find($id);
	 	if ($singleresult === null) 
	 	{
			return new View("highscore not found", Response::HTTP_NOT_FOUND);
	    }
	 return $singleresult;
	}

	/**
	* @Rest\Post("/highscores/")
	*/
	public function postAction(Request $request)
	{
		$data = new Highscore;
		$score = $request->get('score');
		$user_id = $request->get('user_id');

		if(empty($score) || empty($user_id))
		{
			return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE); 
		}

		$data->setScore($score);
		$data->setUserId($user_id);
		$em = $this->getDoctrine()->getManager();
		$em->persist($data);
		$em->flush();

	 return new View("Highscore Added Successfully", Response::HTTP_OK);
	}


	/**
	* @Rest\Put("/highscores/{id}")
	*/
	public function updateAction($id,Request $request)
	{ 
		$data = new Highscore;
		$score = $request->get('score');
		$user_id = $request->get('user_id');
		$sn = $this->getDoctrine()->getManager();
		$highscore = $this->getDoctrine()->getRepository('AppBundle:Highscore')->find($id);
		if (empty($highscore)) 
		{
			return new View("Highscore not found", Response::HTTP_NOT_FOUND);
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
	* @Rest\Delete("/highscores/{id}")
	*/
	public function deleteAction($id)
	{
		$data = new Highscore;
		$sn = $this->getDoctrine()->getManager();
		$highscore = $this->getDoctrine()->getRepository('AppBundle:Highscore')->find($id);
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