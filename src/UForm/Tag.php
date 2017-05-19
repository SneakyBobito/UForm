<?php

namespace UForm;

/**
 * Tag class allows to generate html tags. It's used for elements base rendering
 */
class Tag
{

    protected $name;
    protected $baseProperties;
    protected $closed;

    public function __construct($name, array $baseProperties = [], $closed = false)
    {
        $this->name = $name;
        $this->baseProperties = $baseProperties ;
        $this->closed = $closed;
    }


    /**
     * Process the properties to an html tag attributes valid string
     * @param array|null $p
     * @return string
     */
    private function __parseProperties(array $p = null)
    {

        if (null === $p) {
            $p = [];
        }

        $class = isset($this->baseProperties['class']) ? $this->baseProperties['class'] : null;

        if (isset($p['class'])) {
            if ($class) {
                $class .= ' ' . $p['class'];
            } else {
                $class = $p['class'];
            }
        }

        $properties = array_merge($this->baseProperties, $p);


        if ($class) {
            $properties['class'] = $class;
        }

        $d = '';

        foreach ($properties as $k => $v) {
            $vs = htmlspecialchars($v);
            $ks = htmlspecialchars($k);

            if (is_bool($v) && true == $v) {
                $d .= ' ' . $ks;
            } else {
                $d .= ' ' . $ks . '="' . $vs . '"';
            }
        }

        return $d;
    }

    public function draw($p = null, $content = '')
    {
        $d = '<' . $this->name;
        $d .= $this->__parseProperties($p);

        if ($this->closed) {
            $d .= '/>';
        } else {
            $d .= ">$content</$this->name>";
        }

        return $d;
    }
}
