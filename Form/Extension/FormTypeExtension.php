<?php

namespace Ekyna\BackendBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Forms (all) Types Extension
 */
class FormTypeExtension extends AbstractTypeExtension
{
    /**
     * Ajoute l'option label_nb_col et nb_col
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(array(
            'label_nb_col', 
            'nb_col',
            'sizing'
        ));
        $resolver->setDefaults(array(
            'sizing'         => null
        ));
    }

    /**
     * Ajoute les variables à la vue
     *
     * @param \Symfony\Component\Form\FormView $view
     * @param \Symfony\Component\Form\FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $label_nb_col = array_key_exists('label_nb_col', $options) ? intval($options['label_nb_col']) : 2;
        $nb_col = array_key_exists('nb_col', $options) ? intval($options['nb_col']) : (array_key_exists('label', $options) && strlen($options['label']) > 0 ? 10 : 12 );
        if($label_nb_col + $nb_col != 12) $label_nb_col = 12 - $nb_col;
        
        $view->vars['label_nb_col'] = $label_nb_col;
        $view->vars['nb_col'] = $nb_col;
        $view->vars['sizing'] = in_array($options['sizing'], array('sm', 'lg')) ? $options['sizing'] : false;
    }

    /**
     * @return string Le nom du type qui est étendu
     */
    public function getExtendedType()
    {
        return 'form';
    }
}
