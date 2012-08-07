<?php
/**
 * This file is part of the Duo Criativa software.
 *
 * (c) Paulo Ribeiro <paulo@duocriativa.com.br>
 *
 * Date: 2/1/12
 * Time: 5:42 PM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BFOS\BrasilBundle\Doctrine\Form\EventListener;


use Symfony\Component\Form\Event\DataEvent;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityRepository;

class AddCidadeFieldSubscriber implements EventSubscriberInterface
{
    private $factory;

    public function __construct(FormFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that we want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return array(FormEvents::PRE_SET_DATA => 'preSetData', FormEvents::PRE_BIND => 'preBind');
    }

    public function preSetData(DataEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        // During form creation setData() is called with null as an argument
        // by the FormBuilder constructor. We're only concerned with when
        // setData is called with an actual Entity object in it (whether new,
        // or fetched with Doctrine). This if statement let's us skip right
        // over the null condition.
        if (null === $data) {
            return;
        }

        // check if the product object is "new"
        if ($data->getId()) {
            $form->remove('cidade');
            $form->add($this->factory->createNamed('cidade', 'entity', null, array('class'=>'BFOSBrasilBundle:Cidade', 'property'=>'nome'/*, 'empty_value'=>'Escolha o estado primeiro'*/, 'query_builder' => function(EntityRepository $er) use ($data) {
                    return $er->createQueryBuilder('c')->where('c.uf = :uf')
                        ->orderBy('c.nome', 'ASC')->setParameter('uf', $data->getUf());
                },)));
        }
    }

    public function preBind(DataEvent $event){
        $form = $event->getForm();
        $data = $event->getData();
        if (null === $data) {
            return;
        }

        if (isset($data['estado'])) {
            $form->remove('cidade');
            $form->add($this->factory->createNamed('cidade', 'entity', null, array('class'=>'BFOSBrasilBundle:Cidade', 'property'=>'nome'/*, 'empty_value'=>'Escolha o estado primeiro'*/, 'query_builder' => function(EntityRepository $er) use ($data) {
                return $er->createQueryBuilder('c')->where('c.uf = :uf')
                    ->orderBy('c.nome', 'ASC')->setParameter('uf', $data['estado']);
            },)));
        }
    }

}