<?php
/**
 * Created by PhpStorm.
 * User: martz
 * Date: 1/3/16
 * Time: 12:44 PM
 */

namespace AppBundle\Services;


class UserService
{

    protected  $userRepository;

    public function __construct(\AppBundle\Entity\UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    public function findById($id){
        $user = $this->userRepository->findById($id);
        return $user;
    }

}