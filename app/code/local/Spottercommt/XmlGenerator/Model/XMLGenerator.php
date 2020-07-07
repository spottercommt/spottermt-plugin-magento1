<?php
/**
 * Class XMLGenerator
 * @author    Dimitrios Bantanis-Kapirnas
 * @copyright None
 * @license   Take it and do what you want, no warranty
 */
namespace Spottercommt\XMLGenerator\Model;
class XMLGenerator extends \SimpleXMLElement
{
    public function addCData($cdata_text)
    {
        $node = dom_import_simplexml($this);
        $no = $node->ownerDocument;
        $node->appendChild($no->createCDATASection($cdata_text));
    }
}
