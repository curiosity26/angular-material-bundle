<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 4/2/17
 * Time: 12:42 PM
 */

namespace Curiosity26\AngularMaterialBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class TestController
 * @package Curiosity26\AngularMaterialBundle\Tests\Controller
 */
class TestController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function textAction()
    {
        $builder = $this->createFormBuilder();

        $builder->add('test', TextType::class);

        $form = $builder->getForm();

        return $this->render('form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function radioAction()
    {
        $builder = $this->createFormBuilder();

        $builder->add('test', ChoiceType::class, [
            'choices' => [
                'Test 1' => 'test1',
                'Test 2' => 'test2',
            ],
            'choices_as_values' => true,
            'multiple' => false,
            'expanded' => true,
        ]);

        $form = $builder->getForm();

        return $this->render('form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function checkboxAction()
    {
        $builder = $this->createFormBuilder();

        $builder->add('test', ChoiceType::class, [
            'choices' => [
                'Test 1' => 'test1',
                'Test 2' => 'test2',
            ],
            'choices_as_values' => true,
            'multiple' => true,
            'expanded' => true,
        ]);

        $form = $builder->getForm();

        return $this->render('form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function selectAction()
    {
        $builder = $this->createFormBuilder();

        $builder->add('test', ChoiceType::class, [
            'choices' => [
                'Test 1' => 'test1',
                'Test 2' => 'test2',
            ],
            'choices_as_values' => true,
            'multiple' => false,
            'expanded' => false,
        ]);

        $form = $builder->getForm();

        return $this->render('form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}