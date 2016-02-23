<?php
/**
 * Created by PhpStorm.
 * User: Lars_Soendergaard
 * Date: 23.02.2016
 * Time: 10:26
 */

namespace LFM\Twigify\TokenParser;

use LFM\Twigify\Nodes\WithNode;
use Twig_Parser;
use Twig_Token;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class WithTokenParser extends \Twig_TokenParser
{
    public function parse(Twig_Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $name = $this->parser->getExpressionParser()->parseExpression();
        $stream->expect(Twig_Token::NAME_TYPE, 'as');
        $targets = $this->parser->getExpressionParser()->parseAssignmentExpression();

        $stream->expect(Twig_Token::BLOCK_END_TYPE);
        $body = $this->parser->subparse(array($this, 'decideBlockEnd'), true);
        $stream->expect(Twig_Token::BLOCK_END_TYPE);

        return new WithNode($name, $targets, $body, $lineno, $this->getTag());
    }

    public function getTag()
    {
        return 'with';
    }

    public function decideBlockEnd(\Twig_Token $token) {
        return $token->test('endwith');
    }
}