<?php 
namespace AppBundle\Controller;
 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Koppel_tocht_user as Koppel_tocht_user;

class Tocht_User_Controller extends FOSRestController
{
	 /**
     * @Rest\Get("/koppeltochtuser")
     */
    public function getAction()
    {
      $restresult = $this->getDoctrine()->getRepository('AppBundle:Koppel_tocht_user')->findAll();
      $restObj = json_decode($json);
      var_dump($restObj);
        // if ($restresult === null) 
        // {
        //   return new View("there are no records to display.", Response::HTTP_NOT_FOUND);
        // }
        // return $restresult;
    }

	/**
	* @Rest\Get("/koppeltochtuser/{id}")
	*/
	public function idAction($id)
	{
		$singleresult = $this->getDoctrine()->getRepository('AppBundle:Koppel_tocht_user')->find($id);
	 	if ($singleresult === null) 
	 	{
			return new View("record not found", Response::HTTP_NOT_FOUND);
	    }
	 return $singleresult;
	}

	/**
	* @Rest\Post("/koppeltochtuser/")
	*/
	public function postAction(Request $request)
	{
		$data = new Koppel_tocht_user;
		$tocht_id = $request->get('tocht_id');
		$user_id = $request->get('user_id');
		$started_bool = $request->get('started_bool');
		$finished_bool = $request->get('finished_bool');

		if(empty($tocht_id) || empty($user_id) || empty($started_bool) || empty($finished_bool))
		{
			return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE); 
		}

		$data->setTochtId($tocht_id);
		$data->setUserId($user_id);
		$data->setStartedBool($started_bool);
		$data->setFinishedBool($finished_bool);
		$em = $this->getDoctrine()->getManager();
		$em->persist($data);
		$em->flush();

	 return new View("Record Added Successfully", Response::HTTP_OK);
	}

	/**
	* @Rest\Put("/koppeltochtuser/{id}")
	*/
	public function updateAction($id,Request $request)
	{ 
		$data = new Koppel_tocht_user;
		$tocht_id = $request->get('tocht_id');
		$user_id = $request->get('user_id');
		$finished_bool = $request->get('finished_bool');
		$sn = $this->getDoctrine()->getManager();
		$record = $this->getDoctrine()->getRepository('AppBundle:Koppel_tocht_user')->find($id);
		if (empty($record)) 
		{
			return new View("Record not found", Response::HTTP_NOT_FOUND);
		} 

		if(!empty($tocht_id))
		{
			$record->setTochtId($tocht_id);
		}

		if(!empty($user_id))
		{
			$record->setUserId($user_id);
		}

		if(!empty($finished_bool))
		{
			$record->setTochtId($finished_bool);
		}

		if (empty($tocht_id) && empty($user_id) && empty($finished_bool)) 
		{
			return new View("All values cannot be empty", Response::HTTP_NOT_ACCEPTABLE);
		}

		$sn->flush();
		return new View("Record Updated Successfully", Response::HTTP_OK);
	}

	/**
	* @Rest\Delete("/koppeltochtuser/{id}")
	*/
	public function deleteAction($id)
	{
		$data = new Koppel_tocht_user;
		$sn = $this->getDoctrine()->getManager();
		$record = $this->getDoctrine()->getRepository('AppBundle:Koppel_tocht_user')->find($id);
		if (empty($record)) 
		{
			return new View("Record not found", Response::HTTP_NOT_FOUND);
		}
	else 
	{
		$sn->remove($record);
		$sn->flush();
	}
	
	return new View("Record deleted successfully", Response::HTTP_OK);
	}
}