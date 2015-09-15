<?php

namespace UForm\Doc;


class SemanticTypeInformation {

    protected $name;
    protected $definedInParent;

    protected $classTested;
    protected $classDefined;

    function __construct($name, $definedInParent, $classTested, $classDefined)
    {
        $this->name = $name;
        $this->definedInParent = $definedInParent;
        $this->classTested = $classTested;
        $this->classDefined = $classDefined;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function isDefinedInParent()
    {
        return $this->definedInParent;
    }

    /**
     * @return mixed
     */
    public function getClassTested()
    {
        return $this->classTested;
    }

    /**
     * @return mixed
     */
    public function getClassDefined()
    {
        return $this->classDefined;
    }




}