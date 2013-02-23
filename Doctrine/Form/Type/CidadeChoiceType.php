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
use BFOS\BrasilBundle\Doctrine\Form\DataTransformer\CidadeUFToIdTransformer;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\FormBuilder;
use \BFOS\BrasilBundle\Doctrine\Form\DataTransformer\CidadeToIdTransformer;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
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

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $estados = self::getUFs();
        $estado_options = array('choices' => $estados);
        $cidade_options = array();
        if($options['required']){
            $cidade_options['required'] = true;
            $estado_options['required'] = true;
        }
        $builder
            ->add('estado', 'choice', $estado_options)
            ->add('cidade', 'bfos_brasil_cidade_entity', $cidade_options);

        /*$builder->addViewTransformer(new CidadeToIdTransformer(
            $this->registry->getEntityManager($options['em']),
            'BFOSBrasilBundle:Cidade',
            'nome'
        ));*/
        $subscriber = new AddCidadeFieldSubscriber($builder->getFormFactory());
        $builder->addEventSubscriber($subscriber);
        $builder->addViewTransformer(new CidadeUFToIdTransformer());
    }


    public function getParent()
    {
         /*if ($options['hidden']) {
            return 'hidden';
         }*/
         return 'form';
    }



    public function getName()
    {
        return 'bfos_cidade_choice';
    }
}