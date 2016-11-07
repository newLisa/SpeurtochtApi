<?php 
namespace AppBundle\Controller;
 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\User;

class UserController extends FOSRestController
{
	 /**
     * @Rest\Get("/user")
     */
    public function getAction()
    {
      $restresult = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
        if ($restresult === null) {
          return new View("there are no users exist", Response::HTTP_NOT_FOUND);
     }
        return $restresult;
    }

	/**
	* @Rest\Get("/user/{id}")
	*/
	public function idAction($id)
	{
		$singleresult = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
	 	if ($singleresult === null) 
	 	{
			return new View("user not found", Response::HTTP_NOT_FOUND);
	    }
	 return $singleresult;
	}

	/**
	* @Rest\Post("/user/")
	*/
	public function postAction(Request $request)
	{
		$data = new User;
		$name = $request->get('name');
		$pin = $request->get('pin');

		if(empty($name) || empty($pin))
		{
			return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE); 
		}

		$data->setName($name);
		$data->setPin($pin);
		$em = $this->getDoctrine()->getManager();
		$em->persist($data);
		$em->flush();

		$id = $data->getId();

		return new View($id, Response::HTTP_OK);
	}


	/**
	* @Rest\Put("/user/{id}")
	*/
	public function updateAction($id,Request $request)
	{ 
		$data = new User;
		$name = $request->get('name');
		$pin = $request->get('pin');
		$sn = $this->getDoctrine()->getManager();
		$user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
		if (empty($user)) 
		{
			return new View("User not found", Response::HTTP_NOT_FOUND);
		} 
		elseif(!empty($name) && !empty($pin))
		{
			$user->setName($name);
			$user->setPin($pin);
			$sn->flush();
			return new View("User Updated Successfully", Response::HTTP_OK);
		}
		elseif(empty($name) && !empty($pin))
		{
			$user->setPin($pin);
			$sn->flush();
			return new View("PIN Updated Successfully", Response::HTTP_OK);
		}
		elseif(!empty($name) && empty($pin))
		{
			$user->setName($name);
			$sn->flush();
			return new View("User-Name Updated Successfully", Response::HTTP_OK); 
		}
		else 
		{
			return new View("User-name or PIN cannot be empty", Response::HTTP_NOT_ACCEPTABLE); 
		}
	}

	/**
	* @Rest\Delete("/user/{id}")
	*/
	public function deleteAction($id)
	{
		$data = new User;
		$sn = $this->getDoctrine()->getManager();
		$user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
		if (empty($user)) 
		{
			return new View("User not found", Response::HTTP_NOT_FOUND);
		}
	else 
	{
		$sn->remove($user);
		$sn->flush();
	}
	
	return new View("Deleted successfully", Response::HTTP_OK);
	}

	public function generatePIN()
	{
		$repository = $this->getDoctrine()->getRepository('AppBundle:Product');

		$pin = rand(1000,9999);

		$dbPin = $repository->FindOneByPin($pin);

		 while($dbPin != null)
		{
			$pin = rand(1000,9999);
			$dbPin = $repository->FindOneByPin($pin);
		}

		return $pin;
	}
}