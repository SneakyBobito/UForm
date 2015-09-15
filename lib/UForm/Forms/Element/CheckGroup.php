<?php

namespace UForm\Forms\Element;

/**
 * Class CheckGroup
 * @semanticType checkGroup
 */
class CheckGroup extends Group{
    
    protected $values;

    /**
     * 
     * @param string $name name of the checkbox. Just type "name" and it will generate some "name[]"
     * @param string $elementsDefinition list of checkboxes to create
     * @throws \UForm\Forms\Exception
     */
    public function __construct($name, $elementsDefinition){
        
        $elements = array();
        
        $i = 0;
        
        foreach ($elementsDefinition as $k=>$v){
            
            if(is_string($v)){
                $elements[] = new Check($i, $v);
            }else if(is_array($v)){
                $elements[] = new Check($i,$v["value"],
                    isset($v["attributes"]) ? $v["attributes"] : null ,
                    isset($v["validators"]) ? $v["validators"] : null,
                    isset($v["filters"])    ? $v["filters"]    : null
                );
            }else{
                throw new \UForm\Forms\Exception("Unvalid type for checkgroup creation");
            }
            $i++;
        }

        parent::__construct($name, $elements);
        $this->addSemanticType("checkGroup");
    }

    
  



}