<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 * (c) Paulo Ribeiro <paulo@duocriativa.com.br>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BFOS\BrasilBundle\Doctrine\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use BFOS\BrasilBundle\Doctrine\Form\DataTransformer\CidadeToIdTransformer;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\AbstractType;

class CidadeEntityType extends AbstractType
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->addViewTransformer(new CidadeToIdTransformer($this->container->get('doctrine')->getEntityManager()));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['empty_value'] = 'Primeiro selecione o estado';
        $view->vars['choices'] = array();
    }


    public function getParent()
    {
        return 'field';
    }

    public function getName()
    {
        return 'bfos_brasil_cidade_entity';
    }
}
