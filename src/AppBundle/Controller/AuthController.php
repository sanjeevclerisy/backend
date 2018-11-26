<?php 
namespace AppBundle\Controller;
 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Users;

class AuthController extends FOSRestController
{	
	/**
   * @Rest\Get("/getUserData")
   */
	public function getUsers() {
      $data = $this->getDoctrine()->getRepository('AppBundle:Users')->findBy(array(),array('id' => 'DESC'));
      if (!empty($data)) {
          return new View(['success' => true,'data' => $data], Response::HTTP_OK);
      } else {
        return new View(['success' => false], Response::HTTP_OK);
      }
  }
  /**
   * @Rest\Post("/adduser")
   */
  public function addUser(Request $request,ValidatorInterface $validator){
      $users = new Users;
      $firstname = $request->get('firstname');
      $lastname = $request->get('lastname');
      $email = $request->get('email');
      $mobile = $request->get('mobile');

      $users->setFirstname($firstname);
      $users->setLastname($lastname);
      $users->setEmail($email);
      $users->setMobile($mobile);

      $errors = $validator->validate($users);
      if (count($errors) > 0) {
          return new View(['error' => 'validation_error','title' => 'There was a validation error'],Response::HTTP_BAD_REQUEST);
      }

      $em = $this->getDoctrine()->getManager();
      $em->persist($users);
      $em->flush();
      //Get all user records
      $data = $this->getDoctrine()->getRepository('AppBundle:Users')->findBy(array(),array('id' => 'DESC'));
      return new View(['success' => true,'data' => $data], Response::HTTP_OK);
  }
   /**
   * @Rest\Post("/editUser")
   */
  public function editUser(Request $request,ValidatorInterface $validator){
      $id = $request->get('userid');
      if(!empty($id) && (int)$id) {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:Users')
          ->find($id);
        if(!empty($users)) {
          $users->setFirstname($request->get('firstname'));
          $users->setLastname($request->get('lastname'));
          $users->setEmail($request->get('email'));
          $users->setMobile($request->get('mobile'));
          //Validate data 
          $errors = $validator->validate($users);
          if (count($errors) > 0) {
              return new View(['error' => 'validation_error','title' => 'There was a validation error'],Response::HTTP_BAD_REQUEST);
          } 
          $em->persist($users);
          $em->flush();
          //Get all user records
          $data = $this->getDoctrine()->getRepository('AppBundle:Users')->findBy(array(),array('id' => 'DESC'));
          return new View(['success' => true,'data' => $data], Response::HTTP_OK);
        } else {
          return new View(['error' => 'record_not_found'], Response::HTTP_NOT_FOUND);
        }   
      } else {
        return new View(['error' => 'validation_error'], Response::HTTP_BAD_REQUEST);
      }
      
  }
  /**
   * @Rest\get("/deleteUserData")
   */
  public function deleteUser(Request $request){
    $id = $request->get('id');
    if(!empty($id) && (int)$id) {
      $em = $this->getDoctrine()->getManager();
      $user = $em->getRepository('AppBundle:Users')->find($id);
      if(!empty($user)) {
        $em->remove($user);
        $em->flush();
        //Send updated records
        $data = $this->getDoctrine()->getRepository('AppBundle:Users')->findBy(array(),array('id' => 'DESC'));
         return new View(['success' => true,'data' => $data], Response::HTTP_OK);
      } else {
        return new View(['error' => 'record_not_found'], Response::HTTP_NOT_FOUND);
      }
    } else {
      return new View(['error' => 'validation_error'], Response::HTTP_BAD_REQUEST);
    }
  }
 
}
?>