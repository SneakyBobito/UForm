<?php

namespace UForm\Doc;

/**
 * Allows to create a tree of elements inheritance.
 * The goal is to provide a tool to build documentation schema
 *
 * Class ElementTreeView
 * @package UForm\Doc
 */
class ElementTreeBuilder {

    const BASE_CLASS = 'UForm\Forms\Element';

    /**
     * an array of directory with as key the directory name and the namespace as a value
     *
     * <pre>
     * new ElementTreeView([
     *  "/path/to/lib/UForm/Forms" => "UForm\Forms"
     * ]);
     * </pre>
     * @var array|\string[]
     */
    protected $classPaths = [];

    /**
     * @param string[] $classPaths
     */
    function __construct($classPaths)
    {
        $this->classPaths = $classPaths;
    }

    /**
     * @return ElementTree
     */
    public function getTree(){

        $classList = $this->_getClassList();


        $tree = new ElementTree(self::BASE_CLASS);
        foreach($classList as $class => $file){
            $tree->addElement($class);
        }

        return $tree;

    }

    private function _getClassList(){

        $classList = [];

        foreach($this->classPaths as $parentPath => $parentNamespace){

            $parentNamespace = trim($parentNamespace, "\\ ");

            $dirIterator = new \RecursiveDirectoryIterator($parentPath);
            $iterator = new \RecursiveIteratorIterator($dirIterator);

            foreach($iterator as $fileInfo){
                /* @var $fileInfo \SplFileInfo */

                if($fileInfo->getExtension() == "php"){
                    $subDirectory = substr($fileInfo->getPath(), strlen($parentPath));
                    $namespace = $parentNamespace;
                    if($subDirectory){
                        $namespace .= str_replace("/", "\\", $subDirectory);
                    }

                    $className = $namespace . '\\' . $fileInfo->getBasename(".php");

                    if(class_exists($className)){
                        if(is_subclass_of($className, self::BASE_CLASS) || $className == self::BASE_CLASS){
                            $classList[$className] = $fileInfo->getRealPath();
                        }
                    }
                }
            }
        }

        return $classList;

    }

}