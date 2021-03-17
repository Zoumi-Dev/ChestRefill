<?php

namespace Zoumi\ChestRefill;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use Zoumi\ChestRefill\commands\ChestRefill;
use Zoumi\ChestRefill\tasks\ChestRefillTask;

class Main extends PluginBase implements Listener {

    /** @var Config $config */
    public Config $config;
    /** @var static $time */
    public static $time;
    /** @var static $instance */
    public static $instance;

    public static function getInstance(): self{
        return self::$instance;
    }

    public function onEnable()
    {
        $this->getLogger()->info("is enable.");
        self::$instance = $this;

        if (!file_exists($this->getDataFolder() . "config.yml")){
            $this->saveResource("config.yml");
        }

        /* Config */
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);

        self::$time = $this->config->get("time");

        /* Task */
        $this->getScheduler()->scheduleRepeatingTask(new ChestRefillTask(), 20);

        /* Command */
        $this->getServer()->getCommandMap()->registerAll("ChestRefill", [
            new ChestRefill("chestrefill", "Allows you to see when the chests will regenerate.", "/chestrefill", []),
        ]);
    }

}