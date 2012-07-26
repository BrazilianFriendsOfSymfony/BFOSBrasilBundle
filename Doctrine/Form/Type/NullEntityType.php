<?php
/**
 * This file is part of the Duo Criativa software.
 *
 * (c) Paulo Ribeiro <paulo@duocriativa.com.br>
 *
 * Date: 1/31/12
 * Time: 12:01 PM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace BFOS\BrasilBundle\Doctrine\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\FormBuilder;
use BFOS\BrasilBundle\Doctrine\Form\DataTransformer\TextToIdTransformer;
use Symfony\Bridge\Doctrine\Form\ChoiceList\EntityChoiceList;


class NullEntityType extends AbstractType
{
    public function __construct(RegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*$builder->prependClientTransformer(new TextToIdTransformer(
            $this->registry->getEntityManager($options['em']),
            $options['class'],
            $options['property']
        ));*/
    }

    /*public function getDefaultOptions(array $options)
    {
        $defaultOptions = array(
            'em'                => null,
            'class'             => null,
            'property'          => null,
            'query_builder'     => null,
            'loader'            => null,
            'choices'           => null,
            'group_by'          => null,
            'hidden'          => null,
        );

        $options = array_replace($defaultOptions, $options);

        if (!isset($options['choice_list'])) {
            $manager = $this->registry->getManager($options['em']);

            if (isset($options['query_builder'])) {
                $options['loader'] = $this->getLoader($manager, $options);
            }

            $defaultOptions['choice_list'] = new EntityChoiceList(
                $manager,
                $options['class'],
                $options['property'],
                $options['loader'],
                $options['choices'],
                $options['group_by']
            );
        }

        return $defaultOptions;
    }*/

    /*public function getDefaultOptions(array $options)
    {
        $defaultOptions = array(
            'em'                => null,
            'class'             => null,
            'property'          => null,
            'hidden'            => false,
            'choices'           => array(),
        );

        $options = array_replace($defaultOptions, $options);

        return $options;
    }*/

    public function getParent()
    {
         /*if (isset($options['hidden']) && $options['hidden']) {
            return 'hidden';
         }*/
         return 'entity';
    }

    public function getName()
    {
        return 'bfos_brasil_ajax_loaded_entity';
    }
}