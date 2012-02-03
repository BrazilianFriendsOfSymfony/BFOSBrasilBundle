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
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\FormBuilder;
use \BFOS\BrasilBundle\Doctrine\Form\DataTransformer\CidadeToIdTransformer;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use \Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
use \BFOS\BrasilBundle\Doctrine\Form\EventListener\AddCidadeFieldSubscriber;

class CidadeChoiceType extends AbstractType
{
    public function __construct(RegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    static function getUFs()
      {
      	return array(
          "0"=>"Selecione o estado",
          "AC"=>"Acre",
          "AL"=>"Alagoas",
          "AP"=>"Amapá",
          "AM"=>"Amazonas",
          "BA"=>"Bahia",
          "CE"=>"Ceará",
          "DF"=>"Distrito Federal",
          "ES"=>"Espírito Santo",
          "GO"=>"Goiás",
          "MA"=>"Maranhão",
          "MG"=>"Minas Gerais",
          "MS"=>"Mato Grosso do Sul",
          "MT"=>"Mato Grosso",
          "PA"=>"Pará",
          "PB"=>"Paraíba",
          "PR"=>"Paraná",
          "PE"=>"Pernambuco",
          "PI"=>"Piauí",
          "RJ"=>"Rio de Janeiro",
          "RN"=>"Rio Grande do Norte",
          "RS"=>"Rio Grande do Sul",
          "RO"=>"Rondônia",
          "RR"=>"Roraima",
          "SP"=>"São Paulo",
          "SC"=>"Santa Catarina",
          "SE"=>"Sergipe",
          "TO"=>"Tocantins",
          );
      }

    public function buildForm(FormBuilder $builder, array $options)
    {
        $estados = self::getUFs();
        $builder
            ->add('estado', 'choice', array('choices'=> $estados, 'index_strategy' => ChoiceList::COPY_CHOICE, 'value_strategy' => ChoiceList::COPY_CHOICE ))
            ->add('cidade', 'bfos_brasil_ajax_entity', array('class'=>'BFOSBrasilBundle:Cidade', 'property'=>'nome', 'empty_value'=>'Escolha o estado primeiro'));

        $builder->prependClientTransformer(new CidadeToIdTransformer(
            $this->registry->getEntityManager($options['em']),
            'BFOSBrasilBundle:Cidade',
            'nome'
        ));
        $subscriber = new AddCidadeFieldSubscriber($builder->getFormFactory());
        $builder->addEventSubscriber($subscriber);
        /*$builder
//                    ->setAttribute('virtual', isset($options['virtual'])?$options['virtual']:false)
                    ->setDataMapper(new \Symfony\Component\Form\Extension\Core\DataMapper\PropertyPathMapper($options['data_class']))
                ;*/
    }

    public function getDefaultOptions(array $options)
    {
        $defaultOptions = array(
            'em'                => null,
            'class'             => null,
            'property'          => null,
            'hidden'            => false,
            'choices'           => array()
        );

        $options = array_replace($defaultOptions, $options);

        return $options;
    }

    public function getParent(array $options)
    {
         if ($options['hidden']) {
            return 'hidden';
         }
         return 'form';
    }

    public function buildView(FormView $view, FormInterface $form)
    {
        parent::buildView($view, $form);
    }


    public function getName()
    {
        return 'bfos_cidade_choice';
    }
}