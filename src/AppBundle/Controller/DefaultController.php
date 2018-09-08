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

        $logger->info(json_encode($_FILES) .  ' files');
        $base64 = $_REQUEST['image'];
        $response = $this->visionApiRequest($base64);
        $responseArr = json_decode($response, true);
        $responseArr =  $responseArr['responses'][0]['localizedObjectAnnotations'];
        $formattedResponse = [];
        foreach ($responseArr as $value) {
            if (!in_array($value['name'],  ['Food', 'Fruit'])) {
                $formattedResponse[] = $value['name'];
            }
        }
        $translationReponse = $this->translationApiRequest($formattedResponse);
        $logger->info(json_encode($response));
        return new  JsonResponse($response);
    }

    /**
     * @Route("/vision-image", name="vision-image")
     */
    public function visionApiAction(Request $request)
    {
        $image = base64_encode(file_get_contents('../uploads/test7.jpg'));
        $data = [
            'requests' => [
                [
                    'image' => [
                        'content' => $image
                    ],
                    'features' => [
                        [
                            'type' => 'OBJECT_LOCALIZATION'
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
        curl_close($ch);
        echo '<pre>';
        $responseArr = json_decode($response, true);
        $responseArr =  $responseArr['responses'][0]['localizedObjectAnnotations'];
        $formattedResponse = [];
        foreach ($responseArr as $value) {
            if (!in_array($value['name'],  ['Food', 'Fruit'])) {
                $formattedResponse[] = $value['name'];
            }
        }
        var_dump($formattedResponse);
        $translationUrl = 'https://translation.googleapis.com/language/translate/v2?key=AIzaSyBRAHd61n8DJppN5RWuMxH5zpLkuiv29uI';
        $ch2 = curl_init($translationUrl);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "POST");
        $products = [];
        foreach ($formattedResponse as $text) {
            $translationData = [
                'q' => $text,
                'source' => 'en',
                'target' => 'ro',
                'format' => 'text'
            ];
            curl_setopt($ch2, CURLOPT_POSTFIELDS, json_encode($translationData));
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json')
            );
            $response = curl_exec($ch2);
            $product = json_decode($response, true);
            $products[] = $product['data']['translations']['0'];
        }
        var_dump($products);die;

        die;
        curl_close($ch2);
    }

    private function visionApiRequest($base64)
    {
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
        $url = 'https://vision.googleapis.com/v1/images:annotate?key=AIzaSyBRAHd61n8DJppN5RWuMxH5zpLkuiv29uI';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json')
        );
        $response = curl_exec($ch);
        return $response;
    }

    private function translationApiRequest($formattedResponse)
    {
        $translationUrl = 'https://translation.googleapis.com/language/translate/v2?key=AIzaSyBRAHd61n8DJppN5RWuMxH5zpLkuiv29uI';
        $ch2 = curl_init($translationUrl);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "POST");
        $products = [];
        foreach ($formattedResponse as $text) {
            $translationData = [
                'q' => $text,
                'source' => 'en',
                'target' => 'ro',
                'format' => 'text'
            ];
            curl_setopt($ch2, CURLOPT_POSTFIELDS, json_encode($translationData));
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json')
            );
            $response = curl_exec($ch2);
            $product = json_decode($response, true);
            $products[] = $product['data']['translations']['0'];
        }
        return $products;
    }
}
