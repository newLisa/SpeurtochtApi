<?php 
namespace AppBundle\Controller;
 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Koppel_tocht_locatie;

class Tocht_Locatie_Controller extends FOSRestController
{
	 /**
     * @Rest\Get("/koppeltochtlocatie")
     */
    public function getAction()
    {
      $restresult = $this->getDoctrine()->getRepository('AppBundle:Koppel_tocht_locatie')->findAll();
        if ($restresult === null) 
        {
          return new View("there are no records to display.", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }

	/**
	* @Rest\Get("/koppeltochtlocatie/{id}")
	*/
	public function idAction($id)
	{
		//haal de koppeltabel op
		$repository = $this->getDoctrine()->getRepository('AppBundle:Koppel_tocht_locatie');

		//zoek alleen de resultaten op met tocht_id $id
		$query = $repository->createQueryBuilder('q')
   		 ->where('q.tochtId = :id')
   		 ->setParameter('id', $id)
    	 ->getQuery();

    	 $results = $query->getResult();

	 	if ($results === null) 
	 	{
			return new View("Speurtocht not found", Response::HTTP_NOT_FOUND);
	    }

	    //sla alle locatie ids op in een array
	    $locatieids = array();
	    foreach ($results as $result) 
	    {
	    	$locatieids[] = $result->getLocatieId();
	    }

	    //haal de lacaties op met gebruik van de locatie array
    	$markerRepository = $this->getDoctrine()->getRepository('AppBundle:Marker');

    	$markerQuery = $markerRepository->createQueryBuilder('m');
    	$markerQuery->where($markerQuery->expr()->in("m.id", $locatieids));

    	$markerResults = $markerQuery->getQuery()->getResult();

    	 if ($markerResults === null) 
	 	{
			return new View("no markers found", Response::HTTP_NOT_FOUND);
	    }

	return $markerResults;
	}

	/**
	* @Rest\Post("/koppeltochtlocatie/")
	*/
	public function postAction(Request $request)
	{
		$data = new Koppel_tocht_locatie;
		$tocht_id = $request->get('tocht_id');
		$locatie_id = $request->get('locatie_id');

		if(empty($tocht_id) || empty($locatie_id))
		{
			return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE); 
		}

		$data->setTochtId($tocht_id);
		$data->setLocatieId($locatie_id);
		$em = $this->getDoctrine()->getManager();
		$em->persist($data);
		$em->flush();

	 return new View("Record Added Successfully", Response::HTTP_OK);
	}


	/**
	* @Rest\Put("/koppeltochtlocatie/{id}")
	*/
	public function updateAction($id,Request $request)
	{ 
		$data = new Koppel_tocht_locatie;
		$tocht_id = $request->get('tocht_id');
		$locatie_id = $request->get('locatie_id');
		$sn = $this->getDoctrine()->getManager();
		$record = $this->getDoctrine()->getRepository('AppBundle:Koppel_tocht_locatie')->find($id);
		if (empty($record)) 
		{
			return new View("Record not found", Response::HTTP_NOT_FOUND);
		} 
		elseif(!empty($tocht_id) && !empty($locatie_id))
		{
			$record->setTochtId($tocht_id);
			$record->setLocatieId($locatie_id);
			$sn->flush();
			return new View("Record Updated Successfully", Response::HTTP_OK);
		}
		elseif(empty($tocht_id) && !empty($locatie_id))
		{
			$record->setLocatieId($locatie_id);
			$sn->flush();
			return new View("Locatie_id Updated Successfully", Response::HTTP_OK);
		}
		elseif(!empty($tocht_id) && empty($locatie_id))
		{
			$record->setTochtId($tocht_id);
			$sn->flush();
			return new View("Tocht_id Updated Successfully", Response::HTTP_OK); 
		}
		else 
		{
			return new View("Score or locatie_id cannot be empty", Response::HTTP_NOT_ACCEPTABLE); 
		}
	}

	/**
	* @Rest\Delete("/koppeltochtlocatie/{id}")
	*/
	public function deleteAction($id)
	{
		$data = new Koppel_tocht_locatie;
		$sn = $this->getDoctrine()->getManager();
		$record = $this->getDoctrine()->getRepository('AppBundle:Koppel_tocht_locatie')->find($id);
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