<?php 
namespace AppBundle\Service;

use AppBundle\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;

class Userservice 
{
    private $entityManager;
    public function __construct(EntityManagerInterface $em) 
    {
		$this->entityManager = $em;
    }

    /*
     * Get all users data
     */
    public function getAllUsers() 
    { 
        $data = $this->entityManager->getRepository(Users::class)->findBy(array(),array('id' => 'DESC'));
        return $data;
    }

    /*
     * Add new user
     */
    public function addUser($userInfo)
    {
		$this->entityManager->persist($userInfo);
        $this->entityManager->flush();
        return true; 
    }

    /*
     * Edit user by @id
     */
    public function editUser($userInfo,$id) 
    {
        $users = $this->entityManager->getRepository(Users::class)->find($id);
        if($users) {
          $users->setFirstname($userInfo['firstname']);
          $users->setLastname($userInfo['lastname']);
          $users->setEmail($userInfo['email']);
          $users->setMobile($userInfo['mobile']);
          $this->entityManager->flush();
          return true; 
        } else {
          return false;
        }
    }

    /*
     * Delete user by @id
     */
    public function deleteUser($id) 
    {
        $users = $this->entityManager->getRepository(Users::class)->find($id);
        $this->entityManager->remove($users);
        $this->entityManager->flush();
        return true;
    }

    /*
     * Get user data by @id
     */
    public function getUserById($id) 
    {
        $users = $this->entityManager->getRepository(Users::class)->find($id);
        return $users;
    }
}
?>
