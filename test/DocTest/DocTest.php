<?php

/**
 * CommonTest
 *
 * @author sghzal
 */
class DocTest extends PHPUnit_Framework_TestCase
{
    public function testDoc(){

        $treeBuilder = new  \UForm\Doc\ElementTreeBuilder([
            __DIR__ . '/../../lib/UForm/Forms' => 'UForm\Forms'
        ]);
        $tree = $treeBuilder->getTree();
        $it = new RecursiveIteratorIterator( new \UForm\Doc\ElementTreeRecursiveIterator($tree));

        $str = "";
        foreach($it as $nodeInfo){
            $str .=  str_repeat("·  ", $it->getDepth());
            if($nodeInfo->hasNext()){
                $str .=  "├─";
            }else{
                $str .=  "└─";
            }
            if($nodeInfo->node->hasChildren()){
                $str .=  "─┬";
            }else{
                $str .=  "─";
            }
            $str .=  $nodeInfo->node->getClassName();
            $str .=  PHP_EOL;
        }


        $treeRecursive = function(\UForm\Doc\ElementTreeNode $node, $depth = 0, $isLast = true) use (&$treeRecursive){
            $str = str_repeat("·  ", $depth);

            if($isLast){
                $str .= "└─";
            }else{
                $str .= "├─";
            }
            if($node->hasChildren()){
                $str .= "─┬";
            }else{
                $str .= "─";
            }
            $str .= $node->getClassName();
            $str .= PHP_EOL;

            $nodes = $node->getNodes();
            $countAll = count($nodes);
            $countCurrent = 0;
            foreach($nodes as $snode){
                $countCurrent++;
                $str .= $treeRecursive($snode, $depth + 1, $countCurrent >= $countAll);
            }

            return $str;
        };


        $strExpected = $treeRecursive($tree->getNode());

        $this->assertEquals($strExpected, $str);

    }
}
