<?php
declare(strict_types=1);
namespace donquih0te;

use pocketmine\plugin\PluginBase;
use pocketmine\Server;

class Debug extends PluginBase {

    /** @var Debug */
    private static $instance;
    /** @var array */
    public $debugUsers = [];

    public const PREFIX = "§7[§dDEBUG§7]";

    public static function getInstance(): Debug {
        return self::$instance;
    }

    public function onLoad() {
        self::$instance = $this;
    }

    public function onEnable() {
        Server::getInstance()->getPluginManager()->registerEvents(new EventListener(), $this);
        Server::getInstance()->getCommandMap()->register("debug", new DebugCommand());
    }

    public function onDisable() {

    }

}