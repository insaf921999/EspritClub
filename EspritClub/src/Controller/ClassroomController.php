<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Classroom;
use App\Form\FormulaireType;
use Symfony\Component\HttpFoundation\Request;
class ClassroomController extends AbstractController
{
    /**
     * @Route("/classroom", name="classroom")
     */
    public function index(Request $request)
    {
     #   {{# return $this->render('classroom/index.html.twig', ['controller_name' => 'ClassroomController',]);  #}}
        $em=$this->getDoctrine()->getManager();
        $classroom= new classroom();
        $form = $this->createForm(FormulaireType::class,$classroom);
         if($request->isMethod('POST') && $form->handleRequest($request)->isValid())
{
  $em->persist($classroom);
  $em->flush();
}
return $this-> render('classroom/index.html.twig',[
'form' => $form ->createView(),
        ]);
    }
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/Listclass")
     */
   /* function Liste(){
        $classrooms =[
            array('id' =>'1', 'name'=>'3a31'),
            array('id' =>'2', 'name'=>'3a20'),
            array ('id' =>'3', 'name'=>'3a12')
        ];
        return  $this ->render("classroom/List.html.twig",
            ['classroom'=>$classrooms]);}*/

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/listclassroom", name="listeclassroom")
     */
            public function ListClass(){
        $classrooms= $this->getDoctrine()->getRepository(classroom::class)->findAll();
        return $this->render("classroom/List.html.twig",array("classrooms"=>$classrooms));
            }
    /**
     * @Route("/removeclassroom/{id}", name="removeclassroom")
     */
            public function remove($id){
                $classrooms=$this->getDoctrine()->getRepository(classroom::class)->find($id);
                $em= $this->getDoctrine()->getManager();
                $em->remove($classrooms);
                $em->flush();
                return $this->redirectToRoute('listeclassroom');
// remove supprimer w persist ajouter  flush confimer suppression wmis ajour de bd
            }
    /**
     * @Route("/addclassroom", name="addclassroom")
     */
public function add(Request $request){
                $classroom = new Classroom();
                $form = $this->createForm(FormulaireType::class,$classroom);
                //handle request mas2oula 3la traitement de la requete
                $form->handleRequest($request);
                if($form->isSubmitted()){
                    $em=$this->getDoctrine()->getManager();
                    $em->persist($classroom); // ajout
                    $em->flush(); //flush
                    return $this->redirectToRoute("listeclassroom"); //redirection
                }
                return $this->render("classroom/add.html.twig",array('formulaire'=>$form->createView()));}
    /**
     * @Route("/updateclassroom/{id}", name="updateclassroom")
     */
    public function update(Request $request,$id){
        $classroom = $this->getDoctrine()->getRepository(classroom::class)->find($id);
        $form = $this->createForm(FormulaireType::class,$classroom);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em=$this->getDoctrine()->getManager();
            $em->flush(); //flush
            return $this->redirectToRoute("listeclassroom"); //redirection
        }
        return $this->render("classroom/update.html.twig",array('formulaire'=>$form->createView()));
    }
}