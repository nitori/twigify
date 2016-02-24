<?php
/**
 * Created by PhpStorm.
 * User: Lars_Soendergaard
 * Date: 23.02.2016
 * Time: 10:31
 */

namespace LFM\Twigify\Nodes;

use Traversable;
use Twig_Compiler;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class WithNode extends \Twig_Node
{
    public function __construct(
        \Twig_Node $value,
        \Twig_Node $target,
        \Twig_Node $body,
        $lineno,
        $tag = null)
    {
        parent::__construct(['value' => $value, 'name' => $target, 'body' => $body], ['safe' => true], $lineno, $tag);
    }

    public function compile(Twig_Compiler $compiler)
    {
        $compiler->addDebugInfo($this);

        $name = $this->getNode('name');
        $value = $this->getNode('value');

        $key = $name->nodes[0]->getAttribute('name');

        $compiler->write("call_user_func(function(\$context){\n")->indent();

        // run body in closure
        $compiler->subcompile($this->getNode('body'));

        $compiler->outdent()->write(sprintf("}, array_merge(\$context, [\n", $key));
        $compiler->indent();
        $compiler->write(sprintf("'%s' => ", $key));
        $compiler->subcompile($value, true);
        $compiler->raw(",\n");
        $compiler->outdent();
        $compiler->write("]));\n");
    }
}