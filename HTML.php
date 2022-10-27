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
    private $sripts      = "";
    function __construct(string $title)
    {
        $this->headcontent .= "<title>$title</title>";
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
               $this->htmlend;
    }

    public function resetHead()   { $this->headcontent = ""; }
    public function resetBody()   { $this->bodycontent = ""; }
    public function resetScript() { $this->sripts = ""; }

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
        $this->sripts .= $script;
    }
}
?>