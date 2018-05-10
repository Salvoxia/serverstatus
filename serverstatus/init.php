<?php
    define('SERVER_STATUS_MOD_VERSION', '1.4');

    $modInfo['serverstatus']['name'] = "Server Status";
    $modInfo['serverstatus']['abstract'] = "Shows the status of the Tranquility server, number of players and server time on the front page";
    $modInfo['serverstatus']['about'] = "Version ".SERVER_STATUS_MOD_VERSION." original version by <a href=\"http://www.evekb.org/forum/memberlist.php?mode=viewprofile&u=6523\" target=\"_blank\">Khie3l</a>";

    if(!defined('KB_SITE')) die ("Go Away!");
    
    require_once("mods/serverstatus/class.serverstatus.php");
    event::register("home_context_assembling", "init_serverstatus::handler");
    
    class init_serverstatus
    {
        static function handler(&$home)
        {
            $home->addBehind(config::get('serverstatus_display'), "serverstatus::display");
        }
    }
    
    
?>
