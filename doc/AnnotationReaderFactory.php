<?php
/**
 * Created by PhpStorm.
 * User: sghzal
 * Date: 9/15/15
 * Time: 2:07 PM
 */

namespace UForm\Doc;


use Minime\Annotations\Cache\ArrayCache;
use Minime\Annotations\Parser;
use Minime\Annotations\Reader;

class AnnotationReaderFactory {

    /**
     * @var Reader
     */
    private static $reader;

    public static function getDefault(){

        if(!self::$reader) {
            self::$reader = new Reader(new Parser(), new ArrayCache());
        }

        return self::$reader;
    }

}