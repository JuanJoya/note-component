<?php

declare(strict_types=1);

namespace Note\Src\Validation\Rule;

use Illuminate\Http\UploadedFile;
use Sirius\Validation\Util\RuleHelper;
use Sirius\Validation\Rule\Upload\Size as UploadSize;

/**
 * Permite validar el tamaño de un archivo.
 */
class Size extends UploadSize
{
    /**
     * Opciones por defecto.
     * @var array
     */
    protected $options = [
        self::OPTION_SIZE => '1M'
    ];

    /**
     * Orden de las opciones.
     * @var array
     */
    protected $optionsIndexMap = [
        0 => self::OPTION_SIZE
    ];

    public function validate($value, string $valueIdentifier = null): bool
    {
        $this->value = $value;
        if ($value instanceof UploadedFile && $value->isValid()) {
            $this->success = $this->validateSize($value);
        } else {
            $this->success = false;
        }
        return $this->success;
    }

    /**
     * Valida el tamaño de un archivo.
     * @param UploadedFile $file
     * @return boolean
     */
    private function validateSize(UploadedFile $file): bool
    {
        if ($file->getPath() === '') {
            return false;
        }
        return $file->getSize() <= RuleHelper::normalizeFileSize($this->options[self::OPTION_SIZE]);
    }
}
