<?php

namespace App\Controller\Admin\CustomFields;

use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\TextAlign;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Contracts\Translation\TranslatableInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;


final class CustomBooleanField implements FieldInterface
{
    use FieldTrait;

    public const OPTION_RENDER_AS_SWITCH = 'renderAsSwitch';
    /** @internal */
    public const OPTION_TOGGLE_URL = 'toggleUrl';
    /** @internal */
    public const CSRF_TOKEN_NAME = 'ea-toggle';

    /**
     * @param TranslatableInterface|string|false|null $label
     */
    public static function new(string $propertyName, $label = null): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setTextAlign(TextAlign::CENTER)
            ->setTemplateName('crud/field/boolean')
            ->setFormType(CheckboxType::class)
            ->addCssClass('field-boolean')
            ->addJsFiles(Asset::fromEasyAdminAssetPackage('field-boolean.js')->onlyOnIndex())
            ->setCustomOption(self::OPTION_RENDER_AS_SWITCH, true);
    }

    public function renderAsSwitch(bool $isASwitch = true): self
    {
        $this->setCustomOption(self::OPTION_RENDER_AS_SWITCH, $isASwitch);

        return $this;
    }
}
