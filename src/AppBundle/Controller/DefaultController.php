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

        try {
            $logger->info(json_encode($_FILES) .  ' files');
            $base64 = $_REQUEST['image'];
            $data = [
                'requests' => [
                    [
                        'image' => [
                            'content' => $base64
                        ],
                        'features' => [
                            [
                                'type' => 'LABEL_DETECTION',
                                'maxResults' => 1
                            ]
                        ]
                    ]
                ]
            ];
//            $logger->info(json_encode($_REQUEST['image']) .  ' files');
            $url = 'https://vision.googleapis.com/v1/images:annotate?key=AIzaSyBRAHd61n8DJppN5RWuMxH5zpLkuiv29uI';
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json')
            );
            $response = curl_exec($ch);
            $logger->info(json_encode($response));
            return new  JsonResponse($response);

            // Undefined | Multiple Files | $_FILES Corruption Attack
            // If this request falls under any of them, treat it invalid.
            if (
                !isset($_FILES['upfile']['error']) ||
                is_array($_FILES['upfile']['error'])
            ) {
                throw new \RuntimeException('Invalid parameters.');
            }

            // Check $_FILES['upfile']['error'] value.
            switch ($_FILES['upfile']['error']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    throw new \RuntimeException('No file sent.');
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    throw new \RuntimeException('Exceeded filesize limit.');
                default:
                    throw new \RuntimeException('Unknown errors.');
            }

            // You should also check filesize here.
            if ($_FILES['upfile']['size'] > 1000000) {
                throw new \RuntimeException('Exceeded filesize limit.');
            }

            // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
            // Check MIME Type by yourself.
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            if (false === $ext = array_search(
                    $finfo->file($_FILES['upfile']['tmp_name']),
                    array(
                        'jpg' => 'image/jpeg',
                        'png' => 'image/png',
                        'gif' => 'image/gif',
                    ),
                    true
                )) {
                throw new \RuntimeException('Invalid file format.');
            }

            // You should name it uniquely.
            // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
            // On this example, obtain safe unique name from its binary data.
            if (!move_uploaded_file(
                $_FILES['upfile']['tmp_name'],
                sprintf('./uploads/%s.%s',
                    sha1_file($_FILES['upfile']['tmp_name']),
                    $ext
                )
            )) {
                throw new \RuntimeException('Failed to move uploaded file.');
            }
            $logger->info('asd');

            echo 'File is uploaded successfully.';
            return new JsonResponse(['huhuhu']);
        } catch (\RuntimeException $e) {
            $logger->info($e->getMessage());

            echo $e->getMessage();
            return new JsonResponse(['huhuhu']);
        }
        $logger->info('asd');
        $logger->info($request->files->get('filename'));
        $logger->info($_FILES['uploaded_file']['name']);

        $file_path = "../uploads/";
//        $this->visionApi();

        $file_path = $file_path . basename($_FILES['uploaded_file']['name']);
        if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $file_path)) {
            return new JsonResponse(['gud'], 200);
        } else {
            $logger->info('error');
            return new JsonResponse(['assda'], 500);
        }
        return new JsonResponse(['huhuhu']);
    }

    /**
     * @Route("/vision-image", name="vision-image")
     */
    public function visionApiAction(Request $request)
    {
        $image = base64_encode(file_get_contents('../uploads/test5.jpg'));
        $data = [
            'requests' => [
                [
                    'image' => [
                        'content' => $image
                    ],
                    'features' => [
                        [
                            'type' => 'DOCUMENT_TEXT_DETECTION'
                        ]
                    ]
                ]
            ]
        ];
        $url = 'https://vision.googleapis.com/v1p3beta1/images:annotate?key=AIzaSyBRAHd61n8DJppN5RWuMxH5zpLkuiv29uI';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json')
        );
        $response = curl_exec($ch);
        echo '<pre>';
        var_dump($response);die;
        curl_close($ch);
    }
}
