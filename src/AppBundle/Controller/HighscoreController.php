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
		$repository = $this->getDoctrine()->getRepository('AppBundle:Highscore');
		$query = $repository->createQueryBuilder('h')->orderBy('h.score', 'DESC')->getQuery();
		$restresult = $query->getResult();
		if ($restresult === null) {
			return new View("there are no highscores to display.", Response::HTTP_NOT_FOUND);
		}

		foreach ($restresult as $value) {
	      	$userId = $value->getUserId();
	      	$userResult = $this->getDoctrine()->getRepository('AppBundle:User')->findById($userId);
	      	$value->setUser($userResult);
	    }

        return $restresult;
    }

    /**
     * @Rest\Get("/highscores/{quest_id}")
     */
    public function getQuestAction($quest_id)
    {
    	$repository = $this->getDoctrine()->getRepository('AppBundle:Highscore');
    	$query = $repository->createQueryBuilder('h')
    	->where('h.questId = :questId')
    	->setParameter('questId',$quest_id)
    	->orderBy('h.score', 'DESC')
    	->getQuery();

        $restresult = $query->getResult();
        if ($restresult === null) 
        {
        	return new View("there are no highscores to display.", Response::HTTP_NOT_FOUND);
     	}

     	foreach ($restresult as $value) 
     	{
	      	$userId = $value->getUserId();
	      	$userResult = $this->getDoctrine()->getRepository('AppBundle:User')->findById($userId);
	      	$value->setUser($userResult);
	    }

        return $restresult;
    }

	/**
	* @Rest\Get("/highscores/{quest_id}/{user_id}")
	*/
	public function getQuestUserAction($quest_id, $user_id)
	{
		$restresult = $this->getDoctrine()->getRepository('AppBundle:Highscore')->findBy(array('questId' => $quest_id, 'userId' => $user_id));
	 	if ($restresult === null) 
	 	{
			return new View("highscore not found", Response::HTTP_NOT_FOUND);
	    }
	    foreach ($restresult as $value) 
     	{
	      	$userId = $value->getUserId();
	      	$userResult = $this->getDoctrine()->getRepository('AppBundle:User')->findById($userId);
	      	$value->setUser($userResult);
	    }
		return $restresult;
	}

	/**
	* @Rest\Post("/highscores/")
	*/
	public function postAction(Request $request)
	{
		$data = new Highscore;
		$em = $this->getDoctrine()->getManager();
		$score = $request->get('score');
		$user_id = $request->get('user_id');
		$markersCompleted = $request->get('markers_completed');
		$quest_id = $request->get('quest_id');

		if(empty($score) || empty($user_id) || empty($quest_id) || empty($markersCompleted))
		{
			return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE); 
		}
		$restResult = $this->getDoctrine()->getRepository('AppBundle:Highscore')->findOneBy(array('questId' => $quest_id, 'userId' => $user_id));
		if ($restResult === null) {
			$data->setScore($score);
			$data->setUserId($user_id);
			$data->setQuestId($quest_id);
			$data->setMarkersCompleted($markersCompleted);
			
			$em->persist($data);
			$em->flush();
			return new View("Highscore Added Successfully", Response::HTTP_OK);
		}
		else
		{
			$restResult->setScore($score);
			$restResult->setMarkersCompleted($markersCompleted);

			$em->flush();
			return new View("Highscore Updated Successfully", Response::HTTP_OK);
		}
		return new View("Highscore Fucked Up Successfully", Response::HTTP_NOT_ACCEPTABLE);
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