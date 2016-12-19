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

class SpeurtochtController extends FOSRestController
{
	 /**
	 * @Rest\Get("/speurtocht")
	 */
	public function getAction()
	{
		$restresult = $this->getDoctrine()->getRepository('AppBundle:Speurtocht')->findAll();

		if ($restresult == null) 
		{
			return new View("There are no Quests to display", Response::HTTP_NOT_FOUND);
		}
		return $restresult;
	}

	/**
	* @Rest\Get("/speurtocht/{id}")
	*/
	public function idAction($id)
	{
		$singleresult = $this->getDoctrine()->getRepository('AppBundle:Speurtocht')->find($id);

		if ($singleresult == null) 
		{
			return new View("Quest not found", Response::HTTP_NOT_FOUND);
		}
		return $singleresult;
	}

	/**
	* @Rest\Post("/speurtocht/")
	*/
	public function postAction(Request $request)
	{
		$data = new Speurtocht;
		$name = $request->get('naam');
		$course = $request->get('opleiding');
		$info = $request->get('informatie');

		if (empty($name) || empty($course) || empty($info)) 
		{
			return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
		}

		$data->setNaam($name);
		$data->setOpleiding($course);
		$data->setInformatie($info);
		$data->setIsDeleted(0);
		$em = $this->getDoctrine()->getManager();
		$em->persist($data);
		$em->flush();

		return new View("Quest added succesfully", Response::HTTP_OK);
	}

	/**
	* @Rest\Post("/speurtocht/put/{id}")
	*/
	public function updateAction($id,Request $request)
	{ 
		$data = new Speurtocht;
		$name = $request->get('naam');
		$course = $request->get('opleiding');
		$info = $request->get('informatie');
		$isDeleted = $request->get('isDeleted');

		$sn = $this->getDoctrine()->getManager();
		$quest = $this->getDoctrine()->getRepository('AppBundle:Speurtocht')->find($id);
		if (empty($quest)) 
		{
			return new View("Speurtocht not found", Response::HTTP_NOT_FOUND);
		}
		else
		{
			if (empty($name) && empty($info) && empty($course) && empty($isDeleted)) 
			{
				return new View("all values cannot be empty", Response::HTTP_NOT_ACCEPTABLE); 
			}

			if (!empty($name)) 
			{
				$quest->setNaam($name);
				$sn->flush();
			}

			if (!empty($course)) 
			{
				$quest->setOpleiding($course);
				$sn->flush();
			}

			if (!empty($info)) 
			{
				$quest->setInformatie($info);
				$sn->flush();
			}

			if (!empty($isDeleted)) 
			{
				$quest->setIsDeleted($isDeleted);
				$sn->flush();
			}

			return new View('Speurtocht updated succesfully', Response::HTTP_OK);
		} 
	}

	/**
	* @Rest\Post("/speurtocht/delete/{id}")
	*/
	public function deleteAction($id)
	{
		$data = new Speurtocht;
		$sn = $this->getDoctrine()->getManager();
		$quest = $this->getDoctrine()->getRepository('AppBundle:Speurtocht')->find($id);
		if (empty($quest)) 
		{
			return new View("Speurtocht not found", Response::HTTP_NOT_FOUND);
		}
		else 
		{
			$quest->setIsDeleted(1);
			$sn->flush();
		}
	
	return new View("Speurtocht deleted successfully", Response::HTTP_OK);
	}

	/**
	* @Rest\Post("/speurtocht/restore/{id}")
	*/
	public function restoreAction($id)
	{
		$data = new Speurtocht;
		$sn = $this->getDoctrine()->getManager();
		$quest = $this->getDoctrine()->getRepository('AppBundle:Speurtocht')->find($id);
		if (empty($quest)) 
		{
			return new View("Speurtocht not found", Response::HTTP_NOT_FOUND);
		}
		else 
		{
			$quest->setIsDeleted(0);
			$sn->flush();
		}
	
	return new View("Speurtocht deleted successfully", Response::HTTP_OK);
	}
}