<?php
    if(!defined('KB_SITE')) die ("Go Away!");

    require_once("common/admin/admin_menu.php");
    $module = "TQ Server Status";
    $page = new Page("$module (EDK4, by Khi3l)");
    $version = "1.3";
    $versiondb = config::get('serverstatus_ver');
    $display = config::get('serverstatus_display');
    if ($version != $versiondb)
    {
            config::set('serverstatus_ver', $version);
            $html .= "<div><strong>Version Updated!</strong></div>";
    }
    if (empty($display))
    {
            config::set('serverstatus_display', "menu");
            config::set('serverstatus_displayclock', "yes");
            $html .= "<div><strong><em>First run</em>. Loaded default values!</strong></div>";
    }
    if ($_SERVER['REQUEST_METHOD'] == "POST")
    {
            $display = trim($_POST["update_display"]);
            $displayclock = (string) $_POST["displayclock"];
            config::set('serverstatus_display', $display);
            config::set('serverstatus_displayclock', $displayclock);
            $html .= "<div><strong>Settings Updated. Enjoy!</strong></div>";
    }
    $version = config::get('serverstatus_ver');
    $display = config::get('serverstatus_display');
    $displayclock = config::get('serverstatus_displayclock');
    $html .= "<div class=\"block-header\">Settings</div>\n";
    $html .= "<form name=\"update\" id=\"update\" method=\"post\">\n";
    $html .= "<table class=\"kb-table\">\n";
    $html .= "<tr class=\"kb-table-row-odd\"><td class=\"kb-table-cell\">Position</td><td class=\"kb-table-cell\"><select name=\"update_display\">\n";
    
    if ($display == "menuSetup")
    {
        $html .= "<option value=\"menuSetup\" selected>On Top</option>\n";
    } else
    {
        $html .= "<option value=\"menuSetup\">On Top</option>\n";
    }
    
    if ($display == "menu")
    {
        $html .= "<option value=\"menu\" selected>After Menu</option>\n";
    } else
    {
        $html .= "<option value=\"menu\">After Menu</option>\n";
    }
    
    if ($display == "clock")
    {
        $html .= "<option value=\"clock\" selected>After Clock</option>\n";
    } else
    {
        $html .= "<option value=\"clock\">After Clock</option>\n";
    }
    
    if ($display == "topLists")
    {
        $html .= "<option value=\"topLists\" selected>After Top Lists</option>\n";
    } else
    {
        $html .= "<option value=\"topLists\">After Top Lists</option>\n";
    }

    $html .= "</select>&nbsp;&nbsp;<em>The position of the module in the context of the killboard.<br />Default is <strong>After Menu</strong></em></td></tr>\n";

    $html .= "<tr class=\"kb-table-row-odd\"><td class=\"kb-table-cell\">Display Clock ?</td><td class=\"kb-table-cell\"><input type=\"checkbox\" name=\"displayclock\" value=\"yes\"";
    $html .= ($displayclock == "yes") ? " checked>" : ">";
    $html .="</td></tr>\n";

    $html .= "<tr class=\"kb-table-row-even\"><td colspan=\"2\"><input type=\"submit\" name=\"submit\" value=\"Save\"></td></tr>\n";
    $html .= "</table>\n";
    $html .= "</form>\n";
    $html .= "<div style=\"padding: 5px; margin: 20px 10px 10px; text-align: right; border-top: 1px solid #ccc\">$module $version by <a href=\"http://vavylonknights.com\">Khi3l</a>.</div>";
    $page->setContent($html);
    $page->addContext($menubox->generate());
    $page->generate();
?>
