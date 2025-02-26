<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Entity\UserData;
use App\Repository\TransactionRepository;
use App\Repository\UserDataRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
final class TransactionsController extends AbstractController
{
    #[Route('/transactions', name: 'app_transactions')]
    public function transactionsShow(TransactionRepository $transactionRepository): Response
    {
        $user=$this->getUser();

        $transactions=$transactionRepository->findBy(['user'=>$user]);
        
        return $this->render('transactions/index.html.twig', [
            'controller_name' => 'TransactionsController',
            'transactions' =>$transactions,
            'user' =>$user
        ]);
    
    }
    #[Route('/transaction_income_add', name: 'app_transaction_income_route')]
    public function transactionsrouteincome(): Response
    {
        $user=$this->getUser();

        return $this->render('transactions/income_add.html.twig', [
            'controller_name' => 'TransactionsController',
            'user' =>$user
        ]);
    
    }

    #[Route('/transaction_add_income', name: 'app_transaction_add_income')]
    public function transactionsAddIncome(Request $request, EntityManagerInterface $entityManager,TransactionRepository $transactionRepository,UserDataRepository $userDataRepository): Response
    {
        $user=$this->getUser();

        // $transactions=$transactionRepository->findBy(['user'=>$user]);
        
       
        $type="income";
        $specialtype=$request->request->get('source');
        $value=$request->request->get('value');
        //$rental->setActuelreturndate(new DateTime());
        $date=new DateTime();
    
        if (!$type || !$specialtype || !$value || !$date || !$user) {
            $this->addFlash('error', 'All fields are required!');
            return $this->redirectToRoute('app_transaction_add_income'); // Redirection vers le formulaire
        }


    $transaction= new Transaction();
    $transaction->setType($type);
    $transaction->setSpecialtype($specialtype);
    $transaction->setValue($value);
    $transaction->setDate($date);
    $transaction->setUser($user);
        $entityManager->persist($transaction);
        $entityManager->flush();
    
        $this->calculBudget($entityManager,$transactionRepository, $userDataRepository);
        $this->addFlash('success', 'transaction (income) successfully created!');
        return $this->redirectToRoute('app_transactions'); // Redirection vers la liste des transactions
    }
    #[Route('/transaction_add_spending', name: 'app_transaction_add_spending')]
    public function transactionsAddSpending(Request $request, EntityManagerInterface $entityManager,TransactionRepository $transactionRepository,UserDataRepository $userDataRepository): Response
    {
        $user=$this->getUser();

        // $transactions=$transactionRepository->findBy(['user'=>$user]);
        
       
        $type="spending";
        $specialtype=$request->request->get('source');
        $value=$request->request->get('value');
        //$rental->setActuelreturndate(new DateTime());
        $date=new DateTime();
    
        if (!$type || !$specialtype || !$value || !$date || !$user) {
            $this->addFlash('error', 'All fields are required!');
            return $this->redirectToRoute('app_transaction_add_spending'); // Redirection vers le formulaire
        }


    $transaction= new Transaction();
    $transaction->setType($type);
    $transaction->setSpecialtype($specialtype);
    $transaction->setValue($value);
    $transaction->setDate($date);
    $transaction->setUser($user);
        $entityManager->persist($transaction);
        $entityManager->flush();
        
        $this->calculBudget($entityManager, $transactionRepository, $userDataRepository);
        
        $this->addFlash('success', 'transaction (spending) successfully created!');
        return $this->redirectToRoute('app_transactions'); // Redirection vers la liste des transactions
    }
    
    #[Route('/transaction_spending_add', name: 'app_transaction_spending_route')]
    public function transactionsroutespending(): Response
    {
        $user=$this->getUser();

        return $this->render('transactions/spending_add.html.twig', [
            'controller_name' => 'TransactionsController',
            'user' =>$user
        ]);
    
    }
    #[Route('/home', name: 'app_calcul_budget')]
    public function calculBudget(EntityManagerInterface $entityManager,TransactionRepository $transactionRepository,UserDataRepository $userDataRepository)://
    void
    {
        $user=$this->getUser();
        $userdata = $userDataRepository->findOneByUser($user);
        $transactions=$transactionRepository->findBy(['user'=>$user]);
        $incomes=$transactionRepository->findBy(['user' =>$user,'type' => 'income']);
        $spendings=$transactionRepository->findBy(['user' =>$user,'type' => 'spending']);

        $sommeincomes=0;
        $sommespendings=0;
       // $userdata=$userDataRepository->findOneBy(['user'=>$user]);
        foreach($incomes as $income){
            $sommeincomes+=$income->getValue();
        }
        foreach($spendings as $spending){
            $sommespendings+=$spending->getValue();
        }
        $budget=$sommeincomes-$sommespendings;
        $userdata->setBudget($budget);
        $entityManager->persist($userdata);
        $entityManager->flush();
        
        // return $this->render('transactions/ok.html.twig', [
        //     'controller_name' => 'TransactionsController',
        //     'user' =>$user
        // ]);
    
    }

    



   
}
