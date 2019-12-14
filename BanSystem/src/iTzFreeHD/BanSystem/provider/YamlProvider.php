<?php


namespace iTzFreeHD\BanSystem\provider;


use iTzFreeHD\BanSystem\BanSystem;
use pocketmine\utils\Config;

class YamlProvider implements ProviderInterface
{

    const PROVIDER_NAME = "YAML";

    /** @var string  */
    private $path;

    /** @var Config */
    private $ban_info;

    /** @var Config[] */
    private $message_keys = [];

    public function __construct()
    {
        $config = BanSystem::getInstance()->getConfig();
        $path = $config->get("YAML_Path");
        $this->path = str_replace("%default%", BanSystem::getInstance()->getDataFolder(), $path);

        $this->ban_info = new Config($this->path."info_ban.yml", Config::YAML);
        $this->initBanInfo();
    }

    private function initBanInfo()
    {
        if (!$this->ban_info->exists("BanReasons")) {
            $this->ban_info->setAll([
                "Languages" => [
                    "DE",
                    "EN"
                ]
            ]);
            $this->ban_info->save();
        }
    }

    /**
     * @return string
     */
    public function getPath() :string
    {
        return $this->path;
    }

}