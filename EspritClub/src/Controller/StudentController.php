<?php

namespace App\Controller;
use App\Entity\Student;
use App\Form\StudentformType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
class StudentController extends AbstractController
{
    /**
     * @Route("/student", name="student")
     */
    public function index()
    {
       /* return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
        $em = $this->getDoctrine()->getManager();
        $student = new student();*/
        //  $form = $this->createForm(FormulaireType::class,$classroom);
        //  if($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        /*  {
              $em->persist($classroom);
              $em->flush();
          }
          return $this-> render('classroom/index.html.twig',[
              'form' => $form ->createView(),
          ]);*/
        $em=$this->getDoctrine()->getManager();
        $student= new student();
        $form = $this->createForm(StudentformType::class,$student);
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em->persist($student);
            $em->flush();
        }
        return $this-> render('student/index.html.twig',[
            'form' => $form ->createView(),
        ]);
    }
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/liststudent", name="listestudent")
     */
    public function ListStudent()
    {
        $students = $this->getDoctrine()->getRepository(student::class)->findAll();
        return $this->render("student/List.html.twig", array("students" => $students));
    }
    /**
     * @Route("/addstudent", name="addstudent")
     */
    public function add(Request $request)
    {
        $student = new Student();
        $form = $this->createForm(StudentformType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($student); // ajout
            $em->flush(); //flush
            return $this->redirectToRoute("listestudent"); //redirection
        }
        return $this->render("student/add.html.twig", array('formulaire' => $form->createView()));
    }
    /**
     * @Route("/removestudent/{id}", name="removestudent")
     */
    public function remove($id)
    {
        $students = $this->getDoctrine()->getRepository(student::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($students);
        $em->flush();
        return $this->redirectToRoute('listestudent');
    }
    /**
     * @Route("/updatestudent/{id}", name="updatestudent")
     */
    public function update(Request $request, $id)
    {
        $student = $this->getDoctrine()->getRepository(student::class)->find($id);
        $form = $this->createForm(StudentformType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush(); //flush
            return $this->redirectToRoute("listestudent"); //redirection}
        }
        return $this->render("student/update.html.twig", array('formulaire' => $form->createView()));

    }
}