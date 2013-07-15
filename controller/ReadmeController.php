<?php
/**
 * @uri /
 */
class ReadmeController extends Tonic\Resource
{
    /**
     * @method GET
     * Shows the README.md
     */
    public function getIndex()
    {
        $result = new Tonic\Response(200, file_get_contents('../README.md'), array('ContentType' => 'text/plain'));
        $result->contentType = 'text/plain';
        return $result;
    }
}
