<?php

namespace App\Controller;

use App\Entity\Expression;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Faker\Factory;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ExpressionController extends AbstractController
{
  protected $faker;
  /**
   * @Route("/", name="expression_list")
   * @METHOD({"GET", "POST"})
   */
  public function index(Request $request)
  {
    $this->faker = Factory::create();
    $generatedExpression = $this->faker->realText(20);

    $expression = new Expression();
    $form = $this->createFormBuilder($expression)
      ->add('text', HiddenType::class, array(
        'attr' => array('class' => 'form-control'),
        'data' => $generatedExpression
      ))
      ->add('userAddr', HiddenType::class, array(
        'required' => true,
        'data' => $request->getClientIp(),
        'attr' => array('class' => 'form-control')
      ))
      ->add('save', SubmitType::class, array(
        'label' => 'Išsaugoti išraišką',
        'attr' => array('class' => 'btn btn-primary mt-3')
      ))
      ->getForm();
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $expression = $form->getData();

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($expression);
      $entityManager->flush();
      $this->addFlash('success', 'Išraiška sėkmingai išsaugota!');

      return $this->redirectToRoute('expression_list');
    }
    $expression = '{{{{och|oi|ai}} tu {{aukštielnika|skraidanti|greita|plaukianti|siautėjanti|žavingoji|liežuvinga|šmaikščioji}}, {{išverstake||žavioji}} {{rupūže|kate|karve|kukūže|krupe|rupena}}
    |{{och tu}} {{aukštielnikas|beproti|svaiginantis|išbadėjas|šmaikštusis|liežuvingas|sąmojingas}}, {{iškleres|išvėpes|išverstakis||}} {{kurmi|šunie|buliau|raganiau|burtininke}}}}';
    $expressions = $this->getDoctrine()->getRepository(Expression::class)->findBy(['userAddr' => $request->getClientIp()]);
    return $this->render('expressions/index.html.twig', array(
      'expression' => $this->randomString($expression),
      'form' => $form->createView(),
      'expressions' => $expressions,
    ));
  }

  /**
   * @Route("/expression/{id}", name="show_expression")
   * Method({"GET})
   */
  public function show($id)
  {
    $expression = $this->getDoctrine()->getRepository(Expression::class)->find($id);
    return $this->render('expressions/show.html.twig', array('expression' => $expression));
  }

  public function randomString($string)
  {
    while (strpos($string, '{{') !== false) {
      $string = preg_replace_callback('({{([^{}]+)}})', function ($m) {
        $choice = array_rand($options = explode('|', $m[1]), 1);
        return $options[$choice];
      }, $string);
    }
    return $string;
  }
}
