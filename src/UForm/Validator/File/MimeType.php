<?php
/**
 * @license see LICENSE
 */

namespace UForm\Validator\File;

use UForm\FileUpload;
use UForm\Validation\Message;
use UForm\Validation\ValidationItem;
use UForm\Validator;

class MimeType extends Validator
{

    const INVALID_FILE_TYPE = 'MimeType::INVALID_FILE_TYPE';
    const NOT_A_FILE = 'MimeType::NOT_A_FILE';

    /**
     * @var array
     */
    protected $allowedMimeTypes;

    /**
     * MimType constructor.
     * @param array $allowedMimeTypes
     */
    public function __construct(array $allowedMimeTypes)
    {
        $this->allowedMimeTypes = $allowedMimeTypes;
        parent::__construct();
    }

    /**
     * @return array
     */
    public function getAllowedMimeTypes()
    {
        return $this->allowedMimeTypes;
    }
    
    public function validate(ValidationItem $validationItem)
    {
        $item = $validationItem->getValue();

        if (!$item instanceof FileUpload) {
            $validationItem->setInvalid();
            $message = new Message('Invalid file', [], self::NOT_A_FILE);
            $validationItem->appendMessage($message);
        } else {
            $itemMimeType = $item->getMimeType();
            $hasMatch = false;
            foreach ($this->allowedMimeTypes as $mimeType) {
                if ($itemMimeType === $mimeType) {
                    $hasMatch = true;
                    break;
                } elseif (fnmatch($mimeType, $itemMimeType)) {
                    $hasMatch = true;
                    break;
                }
            }

            if (!$hasMatch) {
                $validationItem->setInvalid();
                $message = new Message('Invalide file type', [], self::INVALID_FILE_TYPE);
                $validationItem->appendMessage($message);
                return false;
            }
        }
    }
}
