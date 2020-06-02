<?php
/**
 * Created by PhpStorm.
 * User: martz
 * Date: 2/15/16
 * Time: 8:11 PM
 */

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CollectorType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code')
            ->add('description', 'textarea', array(
                'attr' => array('class' => 'form-control')
            ))
            ->add('currentStat','choice', array('choices' => array('ACTIVO' => 'Activo', 'INACTIVO' => 'Inactivo')))
            ->add('save', 'submit');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Collector',
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
        return 'collector';
    }

}