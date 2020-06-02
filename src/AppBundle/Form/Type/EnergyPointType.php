<?php
/**
 * Created by PhpStorm.
 * User: martz
 * Date: 1/6/16
 * Time: 8:58 PM
 */

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EnergyPointType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code')
            ->add('description',  'textarea', array(
                'attr' => array('class' => 'form-control')
            ))
            ->add('currentStat','choice', array('choices' => array('ACTIVO' => 'Activo', 'INACTIVO' => 'Inactivo')))
            ->add('location', 'entity', array(
                'class' => 'AppBundle:Location',
                'property'=> 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.status = true')
                        ->orderBy('u.name', 'ASC');
                }))
            ->add('save', 'submit');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\EnergyPoint',
            'csrf_protection'   => false,
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'energy_point';
    }
}