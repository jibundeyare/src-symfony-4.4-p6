<?php

/**
 * [php - Symfony2 disable HTML5 form validation - Stack Overflow](https://stackoverflow.com/questions/10142509/symfony2-disable-html5-form-validation)
 * [Strangebuzz](https://www.strangebuzz.com/en/blog/disable-the-html5-validation-of-all-your-symfony-forms-with-a-feature-flag)
 */

namespace App\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class NoValidateExtension extends AbstractTypeExtension
{
    private bool $disableHtml5Validation;

    public function __construct(bool $disableHtml5Validation)
    {
        $this->disableHtml5Validation = $disableHtml5Validation;
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        if ($this->disableHtml5Validation) {
            $view->vars['attr']['novalidate'] = 'novalidate';
        }
    }

    public static function getExtendedTypes(): iterable
    {
        return [FormType::class];
    }
}