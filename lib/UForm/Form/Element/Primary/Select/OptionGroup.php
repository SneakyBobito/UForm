<?php
/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Primary\Select;


class OptionGroup {

    /**
     * @var Option[]
     */
    protected $options = [];
    protected $label;

    function __construct($label, array $options = null)
    {
        if(null !== $options){
            $this->addOptions($options);
        }

        $this->label = $label;
    }

    public function addOption(Option $option){
        $this->options[] = $option;
    }

    public function addOptions(array $options){
        foreach($options as $key => $option){

            if(!is_object($options) || !$option instanceof Option) {
                if (is_int($key)) {
                    $option = new Option($option);
                } else {
                    $option = new Option($option, $key);
                }
            }

            $this->addOption($option);
        }
    }

    /**
     * @return Option[]
     */
    public function getOptions(){
        return $this->options;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

}