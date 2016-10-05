<?php 
namespace AppBundle\Controller;
 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Koppel_tocht_vraag;

class Tocht_Vraag_Controller extends FOSRestController
{
	 /**
     * @Rest\Get("/koppeltochtvraag")
     */
    public function getAction()
    {
      $restresult = $this->getDoctrine()->getRepository('AppBundle:Koppel_tocht_vraag')->findAll();
        if ($restresult === null) 
        {
          return new View("there are no records to display.", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }

	/**
	* @Rest\Get("/koppeltochtvraag/{id}")
	*/
	public function idAction($id)
	{
		$singleresult = $this->getDoctrine()->getRepository('AppBundle:Koppel_tocht_vraag')->find($id);
	 	if ($singleresult === null) 
	 	{
			return new View("record not found", Response::HTTP_NOT_FOUND);
	    }
	 return $singleresult;
	}

	/**
	* @Rest\Post("/koppeltochtvraag/")
	*/
	public function postAction(Request $request)
	{
		$data = new Koppel_tocht_vraag;
		$tocht_id = $request->get('tocht_id');
		$vraag_id = $request->get('vraag_id');

		if(empty($tocht_id) || empty($vraag_id))
		{
			return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE); 
		}

		$data->setTochtId($tocht_id);
		$data->setVraagId($vraag_id);
		$em = $this->getDoctrine()->getManager();
		$em->persist($data);
		$em->flush();

	 return new View("Record Added Successfully", Response::HTTP_OK);
	}


	/**
	* @Rest\Put("/koppeltochtvraag/{id}")
	*/
	public function updateAction($id,Request $request)
	{ 
		$data = new Koppel_tocht_vraag;
		$tocht_id = $request->get('tocht_id');
		$vraag_id = $request->get('vraag_id');
		$sn = $this->getDoctrine()->getManager();
		$record = $this->getDoctrine()->getRepository('AppBundle:Koppel_tocht_vraag')->find($id);
		if (empty($record)) 
		{
			return new View("Record not found", Response::HTTP_NOT_FOUND);
		} 
		elseif(!empty($tocht_id) && !empty($vraag_id))
		{
			$record->setTochtId($tocht_id);
			$record->setVraagId($vraag_id);
			$sn->flush();
			return new View("Record Updated Successfully", Response::HTTP_OK);
		}
		elseif(empty($tocht_id) && !empty($vraag_id))
		{
			$record->setVraagId($vraag_id);
			$sn->flush();
			return new View("vraag_id Updated Successfully", Response::HTTP_OK);
		}
		elseif(!empty($tocht_id) && empty($vraag_id))
		{
			$record->setTochtId($tocht_id);
			$sn->flush();
			return new View("Tocht_id Updated Successfully", Response::HTTP_OK); 
		}
		else 
		{
			return new View("Score or vraag_id cannot be empty", Response::HTTP_NOT_ACCEPTABLE); 
		}
	}

	/**
	* @Rest\Delete("/koppeltochtvraag/{id}")
	*/
	public function deleteAction($id)
	{
		$data = new Koppel_tocht_vraag;
		$sn = $this->getDoctrine()->getManager();
		$record = $this->getDoctrine()->getRepository('AppBundle:Koppel_tocht_vraag')->find($id);
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