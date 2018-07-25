<?php
declare(strict_types=1);
namespace donquih0te;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\Server;

class EventListener implements Listener {

    public function onInteract(PlayerInteractEvent $event): void {
        $player = $event->getPlayer();
        $block = $event->getBlock();
        $action = $event->getAction();
        if(in_array($player->getName(), Debug::getInstance()->debugUsers)) {
            if($action == PlayerInteractEvent::LEFT_CLICK_BLOCK) {
                $player->sendMessage("§eInteract§7:\nid: ".$block->getId()."\nmeta: ".$block->getDamage());
            }
        }
    }

    public function onItemHeld(PlayerItemHeldEvent $event): void {
        $player = $event->getPlayer();
        $item = $event->getItem();
        if($item->getId() == 0) {
            return;
        }
        if(in_array($player->getName(), Debug::getInstance()->debugUsers)) {
            $player->sendMessage("§bItemHeld§7:\nid: ".$item->getId()."\nmeta: ".$item->getDamage());
        }
    }

    public function onChat(PlayerChatEvent $event): void {
        $player = $event->getPlayer();
        $message = $event->getMessage();
        if(in_array($player->getName(), Debug::getInstance()->debugUsers)) {
            $m = explode(" ", $message);
            if(empty($m[1])) {
                return;
            }
            $event->setCancelled(true);
            switch($m[0]) {
                case 'w':
                    if(!Server::getInstance()->isLevelGenerated($m[1])) {
                        $player->sendMessage("§cLevel ".$m[1]." not found");
                        return;
                    }
                    Server::getInstance()->loadLevel($m[1]);
                    $level = Server::getInstance()->getLevelByName($m[1]);
                    $player->teleport($level->getSpawnLocation());
                    $player->sendMessage("§eYou are teleported into the  ".$m[1]. " world");
                break;
            }
        }
    }

}