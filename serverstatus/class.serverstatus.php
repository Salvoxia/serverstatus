<?php
    use EDK\ESI\ESI;
    use EsiClient\StatusApi;
    use Swagger\Client\ApiException;
    
    if(!defined("KB_SITE")) die ("Go Away!");

    class serverstatus
    {
        static function display()
        {
            $statusBox = new box("Server Status");
            
            $EdkEsi = new ESI();
            $StatusApi = new StatusApi($EdkEsi);
            
            $isServerOnline = false;
            $isVipOnly = false;
            $numberOfPlayers = 0;
            $serverTime = null;
            $isApiDown = false;
            try
            {
                $serverStatus = $StatusApi->getStatus($EdkEsi->getDataSource());
                // no error, the server is up
                $isServerOnline = true;
                $isVipOnly = $serverStatus->getVip();
                $numberOfPlayers = $serverStatus->getPlayers();
            }
            
            catch(ApiException $e)
            {
                // if the server is down, we will se a 503 status code
                if($e->getCode != 503)
                {
                    $isApiDown = true;
                }
            }
            
            if (!$isApiDown)
            {
                if ($isServerOnline)
                {
                    // check for VIP only
                    $onlineString = "ONLINE";
                    if($isVipOnly)
                    {
                        $onlineString = "VIP only";
                    }
                    $statusBox->addOption("caption", "Tranquility is <span class=\"kl-kill\"><strong><font color=green>".$onlineString."</font></strong></span>");
                    $statusBox->addOption("caption", "Players Online: " . $numberOfPlayers);
                }
                else
                {
                    $statusBox->addOption("caption", "Tranquility is <span class=\"kl-loss\"><strong><font color=red>OFFLINE</font></strong></span>");
                }
                if(config::get("serverstatus_displayclock") == "yes")
                {
                    $statusBox->addOption("caption", "EVE Time:  <span class=\"kl-kill\"><strong><font color=orange>" . gmdate("H:i") . "</font></strong></span>");
                }
            }
            else
            {
                $statusBox->addOption("caption", "Tranquility is <span class=\"kl-kill\"><strong><font color=red>UNKNOWN</font></strong></span>");
                $statusBox->addOption("caption", "Players Online: Unknown");
                if(config::get("serverstatus_displayclock") == "yes")
                {
                    $statusBox->addOption("caption", "EVE Time:  <span class=\"kl-kill\"><strong><font color=orange>" . gmdate("H:i") . "</font></strong></span>");
                }
                $statusBox->addOption("caption", "EVE ESI API is <span class=\"kl-kill\"><strong><font color=red>DOWN</font></strong></span>");
            }
            return $statusBox->generate();
        }
    }
?>
