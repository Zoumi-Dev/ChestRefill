<?php

namespace Zoumi\ChestRefill\tasks;

use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use pocketmine\tile\Chest;
use Zoumi\ChestRefill\Main;

class ChestRefillTask extends Task {

    public function onRun(int $currentTick)
    {
        if (--Main::$time === 0){
            foreach (Main::getInstance()->getConfig()->get("chest") as $pos){
                $pos = explode(":", $pos);
                Server::getInstance()->getLevelByName($pos[3])->setBlock(new Vector3($pos[0], $pos[1], $pos[2]), new \pocketmine\block\Chest());
                $tile = Server::getInstance()->getLevelByName($pos[3])->getTile(new Vector3($pos[0], $pos[1], $pos[2]));
                $items = Main::getInstance()->getConfig()->get("items");
                shuffle($items);
                $min = Main::getInstance()->getConfig()->get("item-min-per-chest");
                $max = Main::getInstance()->getConfig()->get("item-max-per-chest");
                foreach ($items as $item){
                    if ($min > $max) break;
                    $rdm = mt_rand(0, 24);
                    if ($tile instanceof Chest) {
                        $tile->getInventory()->setItem($rdm, $i = ChestRefillTask::loadItem(...explode(":", $item)));
                    }
                    $min++;
                }
            }
            foreach (Server::getInstance()->getOnlinePlayers() as $player){
                $packet = new PlaySoundPacket();
                $packet->x = $player->getX();
                $packet->y = $player->getY();
                $packet->z = $player->getZ();
                $packet->volume = 0.5;
                $packet->pitch = 0.5;
                $packet->soundName = Main::getInstance()->getConfig()->get("sound-chestrefill");
                $player->sendDataPacket($packet);
            }
            Main::$time = Main::getInstance()->getConfig()->get("time");
            Server::getInstance()->broadcastMessage("??f(??eChestRefill??f) " . Main::getInstance()->getConfig()->get("chestrefill-broadcast"));
        }elseif (in_array(Main::$time, Main::getInstance()->getConfig()->get("time-before-the-chestrefill"))){
            foreach(Server::getInstance()->getOnlinePlayers() as $player){
                $packet = new PlaySoundPacket();
                $packet->x = $player->getX();
                $packet->y = $player->getY();
                $packet->z = $player->getZ();
                $packet->volume = 0.5;
                $packet->pitch = 0.5;
                $packet->soundName = Main::getInstance()->getConfig()->get("sound-before-the-chestrefill");
                $player->sendDataPacket($packet);
            }
            Server::getInstance()->broadcastMessage("??f(??eChestRefill??f) " . str_replace("{time}", Main::$time, Main::getInstance()->getConfig()->get("before-the-chestrefill")));
        }
    }

    public static function loadItem(int $id, int $damage, int $count, $enchant, int $enchantLevel): Item{
        $item = Item::get($id, $damage, $count);
        if ($enchant !== "none"){
            $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment($enchant), $enchantLevel ?? 0));
        }
        return $item;
    }

}