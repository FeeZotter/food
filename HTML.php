<?php
class HTML
{
    private $htmlstart   = "<!DOCTYPE html><html>";
    private $headstart   = "<head>";
    private $headcontent = "";
    private $headend     = "</head>";
    private $bodystart   = "<body>";
    private $bodycontent = "";
    private $bodyend     = "</body>";
    private $htmlend     = "</head>";
    private $script      = "";
    function __construct(string $title)
    {
        $this->headcontent .= "<title>$title</title>";
        $this->addScript('/food/js/index.js');
    }

    public function getHTML()
    {
        return $this->htmlstart.
               $this->headstart.
               $this->headcontent.
               $this->headend.
               $this->bodystart.
               $this->bodycontent.
               $this->bodyend.
               $this->htmlend.
               $this->script;
    }

    public function resetHead()   { $this->headcontent = ""; }
    public function resetBody()   { $this->bodycontent = ""; }
    public function resetScript() { $this->script = ""; }

    public function addToBody($addToBody)
    {
        $this->bodycontent .= $addToBody;
    }

    public function addToHead($addToHead)
    {
        $this->headcontent .= $addToHead;
    }

    public function addScript($script)
    {
        $this->script .= "<script src='$script'></script>";
    }

    public function addScriptWithSource($script)
    {
        $this->script .= $script;
    }
}
?>