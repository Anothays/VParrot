<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Vich\UploaderBundle\Form\Type\VichImageType;

final class VichImageField implements FieldInterface
{
    use FieldTrait;

    public const OPTION_BASE_PATH = 'basePath';
    public const OPTION_UPLOAD_DIR = 'uploadDir';
    public const OPTION_UPLOADED_FILE_NAME_PATTERN = 'uploadedFileNamePattern';

    public static function new(string $propertyName, ?string $label = null): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)

//            ->setTemplatePath('../../../templates/services/test.html.twig')
            ->setFormType(VichImageType::class);

    }

    public function setBasePath(string $path): self
    {
        $this->setCustomOption(self::OPTION_BASE_PATH, $path);

        return $this;
    }

}