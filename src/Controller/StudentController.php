<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Entity\Student;
use App\Form\ClassroomType;
use App\Form\StudentType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/addstudent', name: 'add_student')]
    public function add(Request $request, ManagerRegistry $doctrine): Response
    { $s= new Student();
        $form = $this->createForm(StudentType::class, $s);
        $form->add('ajouter', SubmitType::class) ;
        $form->handleRequest($request);
        if ($form->isSubmitted())
        { $em = $doctrine->getManager();
            $em->persist($s);
            $em->flush();
            return $this->redirectToRoute('read_student');
        }
        return $this->renderForm("student/add.html.twig",
            ["f"=>$form]) ;

    }
}