<?php

namespace UForm;

/**
 * A semantic item bundles a pool of string that allow to identify it.
 * It's in some ways similar with the inheritance system because  when an object extend another it also inherits
 * from the parent's semantic types but semantic types can be added to any instance no matter about the class.
 *
 * The main goal of semantic types is to serve as render helper form the form elements, for instance twig has no builtin access
 * to instanceOf but it can check for semantic type.
 *
 * It was placed in a trait to keep clarity of things.
 *
 * @package UForm
 */
trait SemanticItem {

    protected $semanticTypes = [];

    /**
     * add a semantic type to the stack that can check with isType()
     * order (LIFO) of semantic type is very important because it's primarily used for form rendering
     * @param $type string the semantic type to add
     * @return $this
     */
    public function addSemanticType($type){
        array_unshift($this->semanticTypes, $type);
        return $this;
    }

    /**
     * check if the element has the specified type.
     * types are set with addSemanticType()
     * @param $type string the semantic type to check for existence
     * @return bool
     */
    public function hasSemanticType($type){
        return in_array($type, $this->semanticTypes);
    }

    /**
     * @return array semantic types ordered in LIFO order
     */
    public function getSemanticTypes(){
        return $this->semanticTypes;
    }

}