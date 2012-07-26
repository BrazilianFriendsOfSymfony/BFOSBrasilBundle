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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Exception\FormException;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceListInterface;
use Symfony\Component\Form\Extension\Core\EventListener\FixRadioInputListener;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\Extension\Core\DataTransformer\ChoiceToValueTransformer;
use Symfony\Component\Form\Extension\Core\DataTransformer\ChoiceToBooleanArrayTransformer;
use Symfony\Component\Form\Extension\Core\DataTransformer\ChoicesToValuesTransformer;
use Symfony\Component\Form\Extension\Core\DataTransformer\ChoicesToBooleanArrayTransformer;

class AjaxChoiceType extends \Symfony\Component\Form\Extension\Core\Type\ChoiceType
{


    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $choiceList = $form->getAttribute('choice_list');

        // We should not load anything right now when loading via ajax
        $view
            ->set('multiple', $form->getAttribute('multiple'))
            ->set('expanded', $form->getAttribute('expanded'))
            ->set('preferred_choices', array())
//            ->set('preferred_choices', $choiceList->getPreferredViews())
            ->set('choices', array())
//            ->set('choices', $choiceList->getRemainingViews())
            ->set('separator', '-------------------')
            ->set('empty_value', $form->getAttribute('empty_value'))
        ;

        if ($view->get('multiple') && !$view->get('expanded')) {
            // Add "[]" to the name in case a select tag with multiple options is
            // displayed. Otherwise only one of the selected options is sent in the
            // POST request.
            $view->set('full_name', $view->get('full_name').'[]');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'bfos_brasil_ajax_choice';
    }

}
