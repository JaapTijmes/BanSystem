<?php


namespace iTzFreeHD\BanSystem;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as c;

class BanSystem extends PluginBase
{

    public function onEnable()
    {
        $this->getLogger()->info(c::GREEN . "Das Plugin wurde geladen!");
    }

    public function onDisable()
    {

    }

}