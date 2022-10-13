<?php

namespace App\Controller;

use App\Entity\Student;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    #[Route('student', name : 'app_student' )]
public function index() : Response
{
    return new Response("Bonjour mes étudiants") ;
}

    #[Route('/readstudent', name: 'read_student')]
    public function read(ManagerRegistry $doctrine): Response
    {
        $students = $doctrine
            ->getRepository(Student::class)
            ->findAll();
        return $this->render('student/read.html.twig',
            ["students"=>$students]);
    }
}