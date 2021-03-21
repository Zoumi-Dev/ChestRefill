<?php

namespace Zoumi\ChestRefill\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Zoumi\ChestRefill\Main;

class ChestRefill extends Command {

    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        $sender->sendMessage("§f(§eChestRefill§f) " . str_replace("{time}", Main::$time, Main::getInstance()->getConfig()->get("command-chestrefill-message")));
    }

}