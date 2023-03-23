<?php

namespace App\Controller\User;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;


class GetCurrentController extends AbstractController
{

    public function __construct (

        private Security $security
    ) {

    }

    public function __invoke () {

        $this->security->getUser();


    }

}