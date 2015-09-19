<?php
/**
 * @license see LICENSE
 */

namespace UForm\Builder;


use UForm\Form\Element;
use UForm\Form\Element\Container\Group;
use UForm\Form\Element\Container\Group\Column;
use UForm\Form\Element\Container\Group\ColumnGroup;
use UForm\Form\Element\Container\Group\Row;
use UForm\Form\Element\Container\Group\Tab;
use UForm\Form\Element\Container\Group\TabGroup;

trait GroupBuilder {

    use FluentElement;


    /**
     * @param null $name
     * @param int $width
     * @return $this
     * @throws \Exception
     */
    public function column($width, $name = null, $hname = null)
    {

        if(!$this->currentGroup instanceof ColumnGroup){
            throw new BuilderException("Cant call builder::tab() outside of a tabgroup Element");
        }
        $element = new Column($name);

        $this->add($element);
        $this->open($element);

        $element->setOption("col-width", $width);

        return $this;

    }


    public function panel($name){
        $element = new Panel($name);
        $this->add($element);
        $this->open($element);

        return $this;
    }
    /**
     * @param $name
     * @return $this
     */
    
    
    public function row($name = null){
        $element = new Row($name);

        $this->add($element);
        $this->open($element);

        return  $this;
    }

    public function tabGroup($name = null){
        $element = new TabGroup($name);

        $this->add($element);
        $this->open($element);

        return  $this;
    }

    public function tab($name = null){
        if(!$this->currentGroup instanceof TabGroup){
            throw new BuilderException("Cant call builder::tab() outside of a tabgroup Element");
        }

        $element = new Tab($name);

        $this->add($element);
        $this->open($element);

        return  $this;
    }
    


}