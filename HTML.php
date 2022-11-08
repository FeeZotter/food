<?php
class HTML
{
    private $htmlstart   = "<!DOCTYPE html><html>";
    private $headstart   = "<head>";
    private $style       = "";
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
        $this->addStyle("/food/style/style.css");
      /*  $this->addStyleAdvanced('<link rel="stylesheet" 
                                  href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
                                  integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
                                  crossorigin="anonymous">'); //*/
        $this->addStyle("/food/style/bootstrap-5.2.2-dist/css/bootstrap.min.css");
        $this->addScript('/food/js/index.js');
    }

    public function getHTML()
    {
        return $this->htmlstart.
               $this->headstart.
               $this->style.
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
    public function resetScript() { $this->script      = ""; }
    public function resetStyle()  { $this->style       = ""; }

    public function addToBody($addToBody)
    {
        $this->bodycontent .= $addToBody;
    }

    public function addStyle($styleLink)
    {
        $this->style .="<link rel='stylesheet' href='$styleLink'>";
    }

    public function addStyleAdvanced($style)
    {
        $this->style .= $style;
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