<?php
require_once("HARTestCase.php");

/**
 * Test HAR Viewer Search using JSON Path
 */ 
class HAR_TestSearchJsonPath extends HAR_TestCase
{
    public function testCase()
    {
        print "\ntestSearchJsonPath.php";

        $viewerURL = $GLOBALS["test_base"]."tests/testSearchJsonPath.html";
        $harFileURL = $GLOBALS["test_base"]."tests/hars/searchHAR.har";
        $this->open($viewerURL."?path=".$harFileURL);

        $this->assertCookie("regexp:searchJsonPath");

        // Select the DOM tab
        $this->click("css=.DOMTab");
        $this->assertElementExists("css=.DOMTab.selected");

        // Type JSON Path expression into the search field and press enter.
        $this->focus("css=.tabDOMBody .searchInput");
        $this->type("css=.tabDOMBody .searchInput", "$..request");
        $this->keyDown("css=.tabDOMBody .searchInput", "\\13");

        $this->assertElementExists("css=.tabDOMBody .domBox .results.visible");

        $document = "selenium.browserbot.getCurrentWindow().document.";
        $script = $document."querySelectorAll('.tabDOMBody .domBox .results .memberRow').length";
        $this->assertEquals("8", $this->getEval($script));
    }
}
?>
