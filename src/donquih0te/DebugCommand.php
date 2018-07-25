<?php
declare(strict_types=1);
namespace donquih0te;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class DebugCommand extends Command {

    public function __construct() {
        parent::__construct("debug", "on|off debug mode");
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param string[] $args
     *
     * @return mixed
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if(!($sender instanceof Player)) {
            $sender->sendMessage(Debug::PREFIX . " §cYou can use debug command only in game");
            return false;
        }
        if(in_array($sender->getName(), Debug::getInstance()->debugUsers)) {
            unset(Debug::getInstance()->debugUsers[array_search($sender->getName(), Debug::getInstance()->debugUsers)]);
            $sender->sendMessage(Debug::PREFIX . " §cDebug mode is disabled");
        }else{
            Debug::getInstance()->debugUsers[] = $sender->getName();
            $sender->sendMessage(Debug::PREFIX . " §aDebug mode is enabled");
        }
        return true;
    }
}