<?php

namespace UForm;

/**
 * Tag
 *
 * @author sghzal
 */
class Tag {
    
    protected $name;
    protected $baseProperties;
    protected $closed;
            
    function __construct($name, $baseProperties = array(), $closed = false) {
        $this->name = $name;
        $this->baseProperties = $baseProperties ;
        $this->closed = $closed;
    }

        
    public function parseProperties($p){
        
        $class = isset($this->baseProperties["class"]) ? $this->baseProperties["class"] : null;
        
        if(isset($p["class"])){
            if($class){
                $class .= " " . $p["class"];
            }  else {
                $class = $p["class"];
            }
        }
        
        if(is_array($p))
            $properties = array_merge($this->baseProperties, $p);
        else
            $properties = $this->baseProperties;
        
        if($class)
            $properties["class"] = $class;
        
        $d = "";
        
        foreach ($properties as $k=>$v){
            
            $vs = htmlentities($v);
            $ks = htmlentities($k);

            if(is_bool($v) && true == $v){
                $d .= " $ks";
            }else{
                $d .= " $ks='$vs'";
            }
        }
        
        return $d;
        
    }
    
    public function draw($p,$content = ""){
        $d = "<" . $this->name;
        $d .= $this->parseProperties($p);
        
        if($this->closed){
            $d .= "/>";
        }else{
            $d .= ">$content</$this->name>";
        }
        
        return $d;
    }

    
}
