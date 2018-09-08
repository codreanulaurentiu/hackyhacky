<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/add-image", name="add-image")
     */
    public function addImageAction(Request $request)
    {
        $logger = $this->get('logger');
        $logger->info('asd');
        $logger->info($request->files->get('filename'));
        $logger->info($_FILES['uploaded_file']['name']);

        $file_path = "../uploads/";

        $file_path = $file_path . basename($_FILES['uploaded_file']['name']);
        if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $file_path)) {
            return new JsonResponse(['gud'], 200);
        } else {
            $logger->info('error');
            return new JsonResponse(['assda'], 500);
        }
        return new JsonResponse(['huhuhu']);
    }
}
