<?php

namespace App\Controller;

use App\Form\EditProfileType;
use App\Service\CallApiService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserController extends AbstractController
{
    private $CallApiService;
    private $url;

    public function __construct(CallApiService $CallApiService)
    {
        $this->CallApiService = $CallApiService;
        $this->url =  'http://localhost:8001';
    }
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/user/edit', name: 'app_user_edit')]
public function editProfile(
    Request $request,
    UserPasswordHasherInterface $userPasswordHasher,
    EntityManagerInterface $entityManager
): Response {
    $user = $this->getUser();
    $form = $this->createForm(EditProfileType::class, $user);
    $form->handleRequest($request);
   
    if ($form->isSubmitted() ) {
        // Hash the new password if it's set
        if ($form->get('plainPassword')->getData()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
        }//dd($user);

     $entityManager->flush();

        $this->addFlash('message', 'Profile mis à jour ✅');
        return $this->redirectToRoute('app_user_edit');
    }

    return $this->render('user/editprofile.html.twig', [
        'form' => $form->createView(),
    ]);
}


    
    #[Route('/user/ListPayment', name: 'app_user_list')]
    public function listPayement(): Response
    {
        $payments = $this->CallApiService->getData('/api/orders' );
dd($payments);
        return $this->render('user/listpayment.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
