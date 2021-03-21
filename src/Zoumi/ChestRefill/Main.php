<?php

namespace Zoumi\ChestRefill;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use Zoumi\ChestRefill\commands\ChestRefill;
use Zoumi\ChestRefill\tasks\ChestRefillTask;

class Main extends PluginBase implements Listener {

    /** @var static $time */
    public static $time;

    /** @var static $instance */
    private static $instance;

    public function onLoad()
    {
        self::$instance = $this;

        $this->saveDefaultConfig();
        $this->checkConfig();
    }

    public function onEnable()
    {

        self::$time = $this->getConfig()->get("time");

        /* Task */
        $this->getScheduler()->scheduleRepeatingTask(new ChestRefillTask(), 20);

        /* Command */
        $this->getServer()->getCommandMap()->registerAll("ChestRefill", [
            new ChestRefill("chestrefill", "Allows you to see when the chests will regenerate.", "/chestrefill", []),
        ]);
    }

    public function checkConfig(): void
    {
        if (empty($this->getConfig()->get("chest"))) {
            $this->getLogger()->warning("No chest set in config.");
            $this->getServer()->getPluginManager()->disablePlugin($this);
            return;
        }

        if (empty($this->getConfig()->get("items"))) {
            $this->getLogger()->warning("No item set in config.");
            $this->getServer()->getPluginManager()->disablePlugin($this);
            return;
        }
    }

    public static function getInstance(): self
    {
        return self::$instance;
    }
}
