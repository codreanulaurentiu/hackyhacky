<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FoodWasteHistory;
use AppBundle\Entity\Fridge;
use AppBundle\Entity\FridgeInventory;
use AppBundle\Entity\Item;
use AppBundle\Entity\PurchaseHistory;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
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
        $base64 = $_REQUEST['image'];
        $response = $this->visionApiRequest($base64);
        $responseArr = json_decode($response, true);
        $logger->info($response);

        $responseArr =  $responseArr['responses'][0]['localizedObjectAnnotations'];
        $formattedResponse = [];
        foreach ($responseArr as $value) {
            if (!in_array($value['name'],  ['Food', 'Fruit'])) {
                $formattedResponse[] = $value['name'];
            }
        }
        $translationResponse = $this->translationApiRequest($formattedResponse);
//        $logger->info(json_encode($translationResponse));
        $items = [];

        /** @var User $user */
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['id' => 9]);
        /** @var Fridge $fridge */
        $fridge = $this->getDoctrine()->getManager()->getRepository(Fridge::class)->findOneBy(['id' => 1]);
        foreach ($translationResponse as $product) {
            if (is_array($product)) {
                $product = $product['0'];
            }
            $logger->info('hey');

            $itemsFromDb = $this->getDoctrine()->getManager()->getRepository(Item::class)->getItemsByName($product);
            $logger->info($itemsFromDb);die;
            /** @var Item $item */
            foreach ($itemsFromDb as $item) {
                $fridgeItem = new FridgeInventory();
                $fridgeItem->setItemId($item);
                $fridgeItem->setFridgeId($fridge);
                $fridgeItem->setBoughtAt(new \DateTime());
                $fridgeItem->setInitialQuantity(1);
                $fridgeItem->setStatus(FridgeInventory::IN_FRIDGE);
                $fridgeItem->setQuantity(1);
                $this->getDoctrine()->getManager()->persist($fridgeItem);

                $items[$item->getId()] = $fridgeItem;
            }
            $this->getDoctrine()->getManager()->flush();
            //$this->snapshotDiff($items);
        }
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
            $products[] = $product['data']['translations']['0']['translatedText'];
        }
        $items = [];
        /** @var User $user */
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['id' => 9]);
        /** @var Fridge $fridge */
        $fridge = $this->getDoctrine()->getManager()->getRepository(Fridge::class)->findOneBy(['id' => 1]);
        foreach ($products as $product) {
            $itemsFromDb = $this->getDoctrine()->getManager()->getRepository(Item::class)->getItemsByName($product);
            /** @var Item $item */
            foreach ($itemsFromDb as $item) {
                $fridgeItem = new FridgeInventory();
                $fridgeItem->setItemId($item);
                $fridgeItem->setFridgeId($fridge);
                $fridgeItem->setBoughtAt(new \DateTime());
                $fridgeItem->setInitialQuantity(1);
                $fridgeItem->setStatus(FridgeInventory::IN_FRIDGE);
                $fridgeItem->setQuantity(1);

                $items[] = $item;
            }
        }

        var_dump($items);die;

        die;
        curl_close($ch2);
    }

    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request)
    {
        // Create a new blank user and process the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the new users password
            $encoder = $this->get('security.password_encoder');
            $password = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            // Set their role
            $user->setRole('ROLE_USER');
            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Inregistrare cu succes.');

            return $this->redirectToRoute('login');
        }
        return $this->render('default/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $helper = $this->get('security.authentication_utils');
        return $this->render(
            'default/login.html.twig',
            array(
                'last_username' => $helper->getLastUsername(),
                'error'         => $helper->getLastAuthenticationError(),
            )
        );
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
                            'type' => 'OBJECT_LOCALIZATION',
                            'maxResults' => 1
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
            $products[] = $product['data']['translations']['0']['translatedText'];
        }
        return $products;
    }
    /**
     * @Route("/login_check", name="security_login_check")
     */
    public function loginCheckAction()
    {
    }

    /**
     * @param $newSnapshot
     *
     *  $snapshotDiff = [
     *                  $itemId => $FridgeItem,
     *                  $itemId => $FridgeItem,
     *                  $itemId => $FridgeItem,
     *                    ]
     */
    private function snapshotDiff($newSnapshot)
    {
        /** @var Fridge $fridge */
        $fridge = $this->getDoctrine()->getRepository(Fridge::class)->findBy(['id' => 1]);

        $client = $this->getDoctrine()->getRepository(Fridge::class)->findBy(['id' => 9]);
        $currentSnapshot = $this->getDoctrine()->getRepository(FridgeInventory::class)->findBy(['fridgeId' => $fridge]);

        $orderedSnapshot = [];
        /** @var FridgeInventory $item */
        foreach ($currentSnapshot as $item) {
            $orderedSnapshot[$item->getItemId()->getId()] = $item;
        }
        $em = $this->getDoctrine()->getManager();

        /** @var FridgeInventory $newItem */
        foreach ($newSnapshot as $key => $newItem) {
            if (!isset($currentSnapshot[$key])) {
                $em->persist($newItem);

                $purchaseHistory = new PurchaseHistory();
                $purchaseHistory
                    ->setItemId($newItem->getItemId())
                    ->setBoughtAt(new \DateTime())
                    ->setQuantity(1);

                $em->persist($purchaseHistory);

            } else {
                /** @var FridgeInventory $currentItem */
                $currentItem = $currentSnapshot[$key];

                if ($currentItem->getStatus() == FridgeInventory::OUT_OF_FRIDGE) {
                    $currentItem->setStatus(FridgeInventory::IN_FRIDGE);
                    $em->persist($currentItem);
                }

                unset($currentSnapshot[$key]);
            }
        }

        /** @var FridgeInventory $oldItem */
        foreach ($currentSnapshot as $oldItem) {
            if ($oldItem->getStatus() != FridgeInventory::OUT_OF_FRIDGE) {
                $oldItem->setRemovedAt(new \DateTime());
                $oldItem->setStatus(FridgeInventory::OUT_OF_FRIDGE);
                $em->persist($oldItem);
            } else {
                //@TODO: Make this conditional work for I cannot think
//                if ($oldItem->getRemovedAt() - new \DateTime() >= $oldItem->getItemId()->getRecommendedExpireDate()) {
//                    $foodWasteHistory = new FoodWasteHistory();
//                    $foodWasteHistory->setClientId(9);
//                    $foodWasteHistory->setItemId($oldItem->getItemId());
//                    $em->persist($foodWasteHistory);
//                    $em->remove($oldItem);
//                }
            }
        }

        $em->flush();
    }
}
