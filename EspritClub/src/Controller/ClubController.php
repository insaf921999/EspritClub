<?php
namespace App\Controller;
use App\Entity\Club;
use App\Form\ClubformType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
class ClubController extends AbstractController
{
    /**
     * @Route("/club", name="club")
     */
    public function index()
    {
        /*return $this->render('club/index.html.twig', [
            'controller_name' => 'ClubController',
        ]);*/
        $em=$this->getDoctrine()->getManager();
        $club= new club();
        $form = $this->createForm(ClubformType::class,$club);
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em->persist($club);
            $em->flush();
        }
        return $this-> render('club/index.html.twig',[
            'form' => $form ->createView(),
        ]);
    }
    /**
     * @param $nom
     * @Route("/Affiche/{nom}")
     */
   /* function getName($nom)
    {
        return $this->render('club/AfficheNom.html.twig',
            ['n' =>$nom]);
    }*/

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/Liste")
     */
  /*  function Liste(){
       $formations =[
            array('ref'=>'form1', 'Titre'=>'Formation Symfony 3.4','Description'=>'formation
pratique','date_debut'=>'12/06/2020', 'date_fin'=>'19/06/2020',
                'nb_participants'=>'19'),
            array('ref'=>'form2', 'Titre'=>'Formation Angular7','Description'=>'formation
theorique','date_debut'=>'01/11/2020', 'date_fin'=>'05/11/2020',
                'nb_participants'=>'0'),
            array ('ref'=>'form3', 'Titre'=>'Formation NodeJs','Description'=>'formation
pratique','date_debut'=>'12/12/2020', 'date_fin'=>'15/12/2020',
                'nb_participants'=>'10')
        ];
           return  $this ->render("club/Liste.html.twig",
               ['formation'=>$formations]);
    }*/

    /**
     * @Route("/d/{id}", name="detail")
     */
   /* function Detail($id){
        return $this->render("club/Detail.html.twig",
            ['ref'=>$id]);

    }*/
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/listclub", name="listeclub")
     */
    public function ListClub()
    {
        $clubs = $this->getDoctrine()->getRepository(club::class)->findAll();
        return $this->render("club/Listclub.html.twig", array("clubs" => $clubs));
    }
    /**
     * @Route("/removeclub/{id}", name="removeclub")
     */
    public function remove($id)
    {
        $clubs = $this->getDoctrine()->getRepository(club::class)->find($id);
        $em = $this->getDoctrine()->getManager();

        $em->remove($clubs);
        $em->flush();
        return $this->redirectToRoute('listeclub');
    }
    /**
     * @Route("/addclub", name="addclub")
     */
    public function add(Request $request)
    {
        $club = new Club();
        $form = $this->createForm(ClubformType::class, $club);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($club); // ajout
            $em->flush(); //flush
            return $this->redirectToRoute("listeclub"); //redirection
            }
        return $this->render("club/add.html.twig", array('formulaire' => $form->createView()));
    }

    /**
     * @Route("/updateclub/{id}", name="updateclub")
     */
    public function update(Request $request, $id)
    {
        $club = $this->getDoctrine()->getRepository(club::class)->find($id);
        $form = $this->createForm(ClubformType::class, $club);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("listeclub"); //redirection}
        }
        return $this->render("club/update.html.twig", array('formulaire' => $form->createView()));
    }
}