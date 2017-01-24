<?php 
namespace AppBundle\Controller;
 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Polygon;

class PolygonController extends FOSRestController
{
	 /**
	 * @Rest\Get("/polygon")
	 */
	public function getAction()
	{
		$restresult = $this->getDoctrine()->getRepository('AppBundle:Polygon')->findAll();

		if ($restresult == null) 
		{
			return new View("There are no Polygons to display", Response::HTTP_NOT_FOUND);
		}
		return $restresult;
	}

	/**
	* @Rest\Get("/polygon/{questId}")
	*/
	public function questIdAction($questId)
	{
		$polygon = $this->getDoctrine()->getRepository('AppBundle:Polygon')->findBy(array('questId' => $questId));

		if ($polygon == null) 
		{
			return new View("Polygon not found", Response::HTTP_NOT_FOUND);
		}
		return $polygon;
	}

	/**
	* @Rest\Post("/polygon/")
	*/
	public function postAction(Request $request)
	{
		$requestJson = json_decode($request->getContent(), true);
		$em = $this->getDoctrine()->getManager();
		if ($this->getDoctrine()->getRepository('AppBundle:Polygon')->findBy(array('questId' => $requestJson['polygonMarkers'][0]['questId'])) != null) {
			$polygon = $this->getDoctrine()->getRepository('AppBundle:Polygon')->findBy(array('questId' => $requestJson['polygonMarkers'][0]['questId']));
			foreach ($polygon as $removePoly) {
			    $em->remove($removePoly);
			    $em->flush();
			}
		}

		foreach ($requestJson['polygonMarkers'] as $polygonMarker) {
			$polygon = new Polygon;
			$polygon->setQuestId($polygonMarker['questId']);
			$polygon->setLat($polygonMarker['lat']);
			$polygon->setLng($polygonMarker['lng']);
			$polygon->setOrderNumber($polygonMarker['orderNumber']);
			$em->persist($polygon);
			$em->flush();
		}
		return new View("Polygon added succesfully", Response::HTTP_OK);
	}
}