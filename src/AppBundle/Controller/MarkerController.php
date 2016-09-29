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

class MarkerController extends FOSRestController
{
	 /**
     * @Rest\Get("/marker")
     */
    public function getAction()
    {
      $restresult = $this->getDoctrine()->getRepository('AppBundle:Marker')->findAll();
        if ($restresult === null) {
          return new View("there are no markers exist", Response::HTTP_NOT_FOUND);
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
		$data = new Marker;
		$latitude = $request->get('latitude');
		$longitude = $request->get('longitude');
		if(empty($latitude) || empty($longitude))
		{
			return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE); 
		}

		$data->setLatitude($latitude);
		$data->setLongitude($longitude);
		$em = $this->getDoctrine()->getManager();
		$em->persist($data);
		$em->flush();

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
	* @Rest\Delete("/marker/{id}")
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