<?php

namespace Bywulf\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Index extends Controller
{

    /**
     * @Route("/terms", name="bywulf_user_terms")
     *
     * @return Response
     */
    public function terms()
    {
        return $this->render('@BywulfUser/terms.html.twig');
    }
}
