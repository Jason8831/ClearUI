<?php

namespace Jason8831\ClearPlayerUI;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener
{

    public Config $config;

    /**
     * @var Main
     */
    private static $instance;

    public function onEnable(): void
    {
        self::$instance = $this;
        $this->getLogger()->info("§f[§l§4ClearPlayerUI§r§f]: Activée");
        $this->saveResource("config.yml");

        $this->getServer()->getCommandMap()->unregister($this->getServer()->getCommandMap()->getCommand("clear"));
        $this->getServer()->getCommandMap()->registerAll("AllCommands", [
            new Commands\ClearUI(name: "clear", description: "permet d'ouvrir l'ui pour clear les joueur", usageMessage: "clear", aliases: ["clearplayer"])
        ]);
    }

    public static function getInstance(): self{
        return self::$instance;
    }
}