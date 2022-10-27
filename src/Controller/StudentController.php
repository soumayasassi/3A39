<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Entity\Student;
use App\Form\ClassroomType;
use App\Form\RechercheType;
use App\Form\StudentType;
use App\Repository\StudentRepository;
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
       // var_dump($s); die;
        if ($form->isSubmitted())
        { $em = $doctrine->getManager();
            $em->persist($s);
            $em->flush();
            return $this->redirectToRoute('read_student');
        }
        return $this->renderForm("student/add.html.twig",
            ["f"=>$form]) ;

    }


    #[Route('/recherche', name: 'recherche_student')]
    public function find2(StudentRepository  $repo, Request $request ): Response
    {
        $students= $repo->findAll();
        if($request->isMethod("post"))
        {
            $nsc=$request->get('nsc');
            $student = $repo->findOneBynNsc($nsc);
            return $this->render("student/search2.html.twig",
                ["student"=>$student]);
        }
        return $this->render("student/read.html.twig",
            ["students"=>$students]);
    }
    #[Route('/findstudent', name: 'find_student')]
    public function find(StudentRepository  $repo): Response
    {
        //$student = $repo->findOneBynNsc("zzz");
        $students= $repo->TriByEmail();
        return $this->render("student/find.html.twig",["student"=>$students]);
    }

    #[Route('/finds', name: 'find2_student')]
    public function search(StudentRepository  $repo, Request $request): Response
    {$student = New Student() ;
        $form = $this->createForm(RechercheType::class,$student);
        $form->handleRequest($request);
        $students=$repo->findAll() ;
        if($form->isSubmitted())
        {
            $nsc = $form['nsc']->getData();
           // $nsc1 = $request->get('')
            $student = $repo->findOneBynNsc($nsc);
            return $this->renderForm("student/search.html.twig",
                ["student"=>$student,"form"=>$form]);
        }
        return $this->renderForm("student/read.html.twig",
            ["students"=>$students,"form"=>$form]);
    }
}