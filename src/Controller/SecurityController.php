<?php

namespace App\Controller;

use App\Entity\UserData;
use App\Repository\UserDataRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
    #[Route(path: '/ok', name: 'app_ok')]
    public function ok(): Response
    {
        $user = $this->getUser(); // Récupère l'utilisateur connecté
    if (!$user) {
        return $this->redirectToRoute('app_login'); // Redirige si aucun utilisateur connecté
    }

    return $this->render('ok.html.twig', [
        'username' => $user->getUserIdentifier(),// Envoie le username au template
        'user' =>$user
    ]);
    }
    #[Route(path: '/userdatashow', name: 'app_userdata_show')]
    public function datausershow(): Response
    {
        $user = $this->getUser(); // Récupère l'utilisateur connecté
      
    if (!$user) {
        return $this->redirectToRoute('app_login'); // Redirige si aucun utilisateur connecté
    }

    return $this->render('userdata/userdata_show.html.twig', [
        'username' => $user->getUserIdentifier(),// Envoie le username au template
        'user' =>$user
    ]);
    }

    // #[Route(path: '/userdataedit/{id}', name: 'app_userdata_edit')]
    // public function datauseredit( int $id,Request $request, UserDataRepository $userDataRepository, EntityManagerInterface $entityManager): Response
   

    // {
    //     $user = $this->getUser(); // Récupère l'utilisateur connecté
        
    //     //$userdata=$user->getUserD
    //     $userdata = $userDataRepository->find($id);
    //     $userdata->setUser($user);
    // if (!$user) {
    //     return $this->redirectToRoute('app_login'); // Redirige si aucun utilisateur connecté
    // }
    // if ($request->isMethod('POST')) {
    //     $userdata->setFirstname($request->request->get('firstname'));
    //     $userdata->setLastname($request->request->get('lastname'));
    //     $userdata->setPhone($request->request->get('phone'));
    //     $userdata->setAdress($request->request->get('adress'));
    //     $userdata->setAge($request->request->get('age'));
    //         $entityManager->flush();

    //     $this->addFlash('success', 'Customer updated successfully!');
        
    //     return $this->redirectToRoute('app_userdata_show'); // Retourner à la liste des clients
    //     // }
    // }
        

    // //     $entityManager->flush();

    // //     $this->addFlash('success', 'Customer updated successfully!');
    // //     return $this->redirectToRoute('app_customers'); // Retourner à la liste des clients
    // // }
    // return $this->render('userdata/userdata_edit.html.twig', [
    //     'username' => $user->getUserIdentifier(),// Envoie le username au template
    //     'user' =>$user

    // ]);
    // }
    #[Route(path: '/userdataedit/{id}', name: 'app_userdata_edit')]
    public function datauseredit(int $id, Request $request, UserDataRepository $userDataRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser(); // Récupère l'utilisateur connecté

        if (!$user) {
            return $this->redirectToRoute('app_login'); // Redirige si aucun utilisateur connecté
        }

        $userdata = $userDataRepository->find($id); // Récupère l'entité UserData existante

        if (!$userdata) {
            throw $this->createNotFoundException('No user data found for id ' . $id);
        }

        if ($request->isMethod('POST')) {
            $userdata->setFirstname($request->request->get('firstname'));
            $userdata->setLastname($request->request->get('lastname'));
            $userdata->setPhone($request->request->get('phone'));
            $userdata->setAdress($request->request->get('adress'));
            $userdata->setAge($request->request->get('age'));
           

            $entityManager->flush();

            $this->addFlash('success', 'User data updated successfully!');
            return $this->redirectToRoute('app_userdata_show'); // Retourner à la liste des utilisateurs
        }

        return $this->render('userdata/userdata_edit.html.twig', [
            'username' => $user->getUserIdentifier(), // Envoie le username au template
            'user' => $user
        ]);
    }
//     #[Route('/customer/edit/{id}', name: 'app_customer_edit')]
//     public function editCar(int $id, Request $request, CustomerRepository $customerRepository, EntityManagerInterface $entityManager): Response
//     {
//     $customer = $customerRepository->find($id);

//     if (!$customer) {
//         throw $this->createNotFoundException('Customer not found');
//     }

//     if ($request->isMethod('POST')) {
//         $customer->setName($request->request->get('name'));
//         $customer->setEmail($request->request->get('email'));
//         $customer->setPhone($request->request->get('phone'));
//         $customer->setAddress($request->request->get('address'));
//         $customer->setLicencenumber($request->request->get('liscencenumber'));


        

//         $entityManager->flush();

//         $this->addFlash('success', 'Customer updated successfully!');
//         return $this->redirectToRoute('app_customers'); // Retourner à la liste des clients
//     }

   

//     return $this->render('customeredit.html.twig', [
//         'customer' => $customer,
//     ]);
// }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
