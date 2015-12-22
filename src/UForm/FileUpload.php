<?php
/**
 * @license see LICENSE
 */

namespace UForm;

/**
 * That's the abstraction of 1 file found in the global $_FILES
 */
class FileUpload
{

    public $name;
    public $path;
    public $uploadStatus;

    /**
     * The data as present in $_FILES
     *
     * @param array $data
     */
    public function __construct($name, $path, $uploadStatus)
    {
        $this->path = $path;
        $this->name = $name;
        $this->uploadStatus = $uploadStatus;
    }


    /**
     * Create files object from the $_FILES superglobal
     *
     * @param array|null $files
     * @return array list of the file in an array. It can contain sub arrays if the $_FILE did contain nested files
     */
    public static function fromGlobalFilesVariable(array $files = null, $checkIsUploaded = true)
    {
        if (null == $files) {
            $files = $_FILES;
        }

        $final = [];
        if ($files) {
            foreach ($files as $fieldName => $file) {
                if (is_array($file["name"])) {
                    $fileCount = count($file["name"]);
                    for ($i=0; $i<$fileCount; $i++) {
                        $fileData = [];
                        foreach ($file as $fileDataName => $data) {
                            $fileData[$fileDataName] = $data[$i];
                        }
                        $final[$fieldName][$i] = self::createFileFromData($fileData, $checkIsUploaded);
                    }
                } else {
                    $final[$fieldName] = self::createFileFromData($file, $checkIsUploaded);
                }
            }
        }
        return $final;
    }

    private static function createFileFromData($data, $checkIsUploaded)
    {
        if ($checkIsUploaded && !is_uploaded_file($data["tmp_name"])) {
            throw new Exception("File upload is not a valid uploaded file");
        }
        return new self($data["name"], $data["tmp_name"], $data["error"]);
    }

    /**
     * get the path of the file
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Move the uploaded file to the destination
     *
     * @link http://php.net/manual/fr/function.move-uploaded-file.php
     * @param string $destination new destination for the file
     */
    public function moveTo($destination)
    {
        if ($this->hasError()) {
            throw new Exception("Cannot move the uploaded file because the upload ended with an error.");
        }

        $file = $this->getPath();
        if (!file_exists($file)) {
            throw new Exception("Cannot move the uploaded file because the file is not valid. Did you move it away?");
        }
        if (!is_writable($file)) {
            throw new Exception("Cannot move the uploaded file because the file is not writable.");
        }
        $done = rename($file, $destination);

        if ($done) {
            $this->path = $destination;
        } else {
            throw new Exception("An error happened while moving the uploaded file");
        }
    }

    /**
     * get the status of the upload
     *
     * Reflects the value of $_FILES["theFile"]["error"]
     * @return int
     */
    public function getStatus()
    {
        return $this->uploadStatus;
    }

    /**
     * Check if the upload has an error
     * @return bool
     */
    public function hasError()
    {
        return $this->uploadStatus !== UPLOAD_ERR_OK;
    }

    /**
     * Name of the file uploaded.
     *
     * Reflects the value of $_FILES["theFile"]["name"]
     * @return string name of the file
     */
    public function getName()
    {
        return $this->name;
    }
}
