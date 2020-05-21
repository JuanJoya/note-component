<?php

declare(strict_types=1);

namespace Note\Src\Validation\Rule;

use Illuminate\Http\UploadedFile;
use Sirius\Validation\Rule\Upload\Image as UploadImage;

/**
 * Verifica si el "MIME Type" de un archivo subido corresponde al de una imagen valida.
 */
class Image extends UploadImage
{
    /**
     * Opciones por defecto.
     * @var array
     */
    protected $options = [
        self::OPTION_ALLOWED_IMAGES => ['jpeg', 'png', 'gif']
    ];

    /**
     * Opciones validas.
     * @var array
     */
    protected $imageTypesMap = ['jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'];

    public function validate($value, string $valueIdentifier = null): bool
    {
        $this->value = $value;
        if ($value instanceof UploadedFile && $value->isValid()) {
            $this->success = $this->validateMimes($value);
        } else {
            $this->success = false;
        }
        return $this->success;
    }

    /**
     * Valida el "MIME Type" de un archivo.
     * @param UploadedFile $file
     * @return boolean
     */
    private function validateMimes(UploadedFile $file): bool
    {
        if ($file->getPath() === '') {
            return false;
        }
        $extensions = array_intersect(
            $this->imageTypesMap,
            $this->options[self::OPTION_ALLOWED_IMAGES]
        );
        return in_array($file->guessExtension(), $extensions);
    }
}
