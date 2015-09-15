<?php

namespace UForm\Doc;


use RecursiveIterator;
use Traversable;

class ElementTreeNode implements NodeContainer{

    protected $className;
    /**
     * @var ElementTreeNode[]
     */
    protected $nodes = [];

    /**
     * @var SemanticTypeInformation[]
     */
    protected $semTypes = null;

    function __construct($className)
    {
        $this->className = $className;
    }

    public function getClassName(){
        return $this->className;
    }

    public function add($list){
        $parent = array_shift($list);

        if($parent != $this->getClassName()){
            $className = end($list);
            if(!$className){
                $className = $parent;
            }
            throw new \Exception("Invalid class $className. Not a subclass of " . $this->getClassName());
        }

        if(count($list) > 0){
            $element = reset($list);
            if(!isset($this->nodes[$element])){
                $this->nodes[$element] = new ElementTreeNode($element);
            }
            $this->nodes[$element]->add($list);
        }
    }


    /**
     * @return ElementTreeNode[]
     */
    public function getNodes()
    {
        return $this->nodes;
    }

    public function hasChildren(){
        return count($this->nodes) > 0;
    }

    public function getSemanticTypes(){

        if(null === $this->semTypes){
            $reader = AnnotationReaderFactory::getDefault();
            $semTypes = [];

            // DEFAULT CLASS
            $annotations = $reader->getClassAnnotations($this->className);
            $foundTypes = $annotations->getAsArray("semanticType");

            foreach($foundTypes as $type){
                $semTypes[] = new SemanticTypeInformation($type, false, $this->className, $this->className);
            }

            // PARENT CLASSES
            foreach(class_parents($this->getClassName()) as $parentClass){
                $annotations = $reader->getClassAnnotations($parentClass);
                $foundTypes = $annotations->getAsArray("semanticType");
                foreach($foundTypes as $type){
                    $semTypes[] = new SemanticTypeInformation($type, true, $this->className, $parentClass);
                }
            }
            $this->semTypes = $semTypes;
        }

        return $this->semTypes;
    }

    public function getSelfSemanticTypes(){
        $found = [];
        foreach($this->getSemanticTypes() as $type){
            if(!$type->isDefinedInParent()){
                $found[] = $type;
            }
        }
        return $found;
    }

}