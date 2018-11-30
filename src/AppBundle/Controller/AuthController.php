<?php 
namespace AppBundle\Controller;
 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Users;
use AppBundle\Form\Type\UserType;
use AppBundle\Service\Userservice;

class AuthController extends FOSRestController
{	

	/**
   * @Rest\Get("/getUserData")
   */
	public function getUsers(Userservice $userservice)
  {
      $data = $userservice->getAllUsers();
      return new View(['success' => true,'data' => $data], Response::HTTP_OK);
  }

  /**
   * @Rest\Get("/getUserDetail")
   */
  public function getUserDetail(Request $request,Userservice $userservice) 
  {
      $id = $request->get('id');
      $data = $userservice->getUserById($id);
      return new View(['success' => true,'data' => $data], Response::HTTP_OK);
  }

  /**
   * @Rest\Post("/adduser")
   */
  public function addUser(Request $request,Userservice $userservice)
  {
      $form = $this->createForm(UserType::class,null);
      $form->submit($request->request->all());
      if($form->isValid()) {
        $data = $form->getData();  
        $userservice->addUser($data);
        return new View(['successss' => true], Response::HTTP_OK);
      } else {
          return new View(['success' => false,'data' => $form], Response::HTTP_BAD_REQUEST);  
      }
  }

   /**
   * @Rest\Post("/editUser")
   */
  public function editUser(Request $request,Userservice $userservice)
  {
      $id = $request->get('userid');
      $form = $this->createForm(UserType::class,null);
      $userInfo =  $request->request->all();
      unset($userInfo['userid']);
      $form->submit($userInfo);
      if($form->isValid()) {
        $data = $form->getData();  
        $userservice->editUser($userInfo,$id);
        return new View(['successss' => true], Response::HTTP_OK);
      } else {
          return new View(['success' => false,'data' => $form], Response::HTTP_BAD_REQUEST);  
      }    
  }

  /**
   * @Rest\get("/deleteUserData")
   */
  public function deleteUser(Request $request,Userservice $userservice){
      $id = $request->get('id');
      $status = $userservice->deleteUser($id);
      if($status) {
        return new View(['success' => true], Response::HTTP_OK);
      } else {
        return new View(['error' => 'record_not_found'], Response::HTTP_NOT_FOUND);
      }
  }
}
?>