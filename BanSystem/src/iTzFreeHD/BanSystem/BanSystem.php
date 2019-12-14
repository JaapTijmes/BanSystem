<?php


namespace iTzFreeHD\BanSystem;

use iTzFreeHD\BanSystem\provider\ProviderInterface;
use iTzFreeHD\BanSystem\provider\YamlProvider;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\MainLogger;
use pocketmine\utils\TextFormat as c;

class BanSystem extends PluginBase
{
    /** @var ProviderInterface */
    private $provider;

    /** @var Config */
    private $config;

    /** @var BanSystem */
    private static $instance;

    public function onEnable()
    {
        self::$instance = $this;
        $this->getLogger()->info(c::GREEN . "Das Plugin wurde geladen!");

        $this->initConfig();
        $this->setProvider();
    }

    public function onDisable()
    {

    }

    private function initConfig()
    {
        $config = new Config($this->getDataFolder()."config.yml", Config::YAML);
        if (!$config->exists("provider")) {
            $config->setAll([
                "provider" => "YAML",
                "YAML_Path" => "%default%"
            ]);
            $config->save();
        }
        $this->config = $config;
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    private function setProvider()
    {
        $provider = $this->getConfig()->get("provider");

        switch ($provider) {
            case YamlProvider::PROVIDER_NAME:
                $this->provider = new YamlProvider();
                return;
            default:
                MainLogger::getLogger()->error(c::RED."Please set a correct provider name -> config,yml");
                $this->getServer()->getPluginManager()->disablePlugin($this);
                return;
        }
    }

    /**
     * @return BanSystem
     */
    public static function getInstance(): BanSystem
    {
        return self::$instance;
    }

    /**
     * @return ProviderInterface
     */
    public function getProvider(): ProviderInterface
    {
        return $this->provider;
    }

}