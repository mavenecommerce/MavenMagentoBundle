<?php

namespace Maven\Bundle\MagentoBundle\Twig;

use Symfony\Bundle\FrameworkBundle\Translation\Translator;

/**
 * @package Maven\Bundle\MagentoBundle\Twig
 */
class LabelExtension extends \Twig_Extension
{
    /**
     * @var null|Translator
     */
    protected $translator;

    /**
     * @param Translator|null $translator
     */
    public function __construct(Translator $translator = null)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('booleanLabel', [$this, 'filterBoolean'])
        ];
    }

    /**
     * Returned "Yes" or "No" dependence on value.
     *
     * @param $value
     *
     * @return string
     */
    public function filterBoolean($value)
    {
        if ($value) {
            return $this->translator->trans('maven_magento.labels.yes');
        }

        return $this->translator->trans('maven_magento.labels.no');
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'label_extension';
    }
}
