<?php

namespace Jason8831\ClearPlayerUI\Commands;

use Jason8831\ClearPlayerUI\Main;
use jojoe77777\FormAPI\SimpleForm;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\Config;

class ClearUI extends Command
{
public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [])
{
    parent::__construct($name, $description, $usageMessage, $aliases);
}

public function execute(CommandSender $sender, string $commandLabel, array $args)
{

    if ($sender instanceof Player){
        if ($sender->hasPermission("clear.admin")){
            if (!isset($args[0])){
                $sender->sendMessage("§f[§l§4ERROR§r§f]: Veuillez faire /clear [joueur].");
                return;
            }else{
                $target = Server::getInstance()->getPlayerByPrefix($args[0]);
                if ($target instanceof Player){
                    $this->sendMenu($sender, $target);
                    return;
                }else{
                    $sender->sendMessage("§f[§l§4ERROR§r§f]: Le joueur saisie n'existe pas.");
                    return;
                }
            }
        }else{
            $sender->sendMessage("§f[§l§4ERROR§r§f]: Vous n'avez pas la permission d'utiliser cette commande.");
            return;
        }
    }
}

    public function sendMenu(Player $player, Player $target): void{
        $ui = new SimpleForm(function (Player $player, $data) use ($target){
            if (is_null($data)) return;

            $config = new Config(Main::getInstance()->getDataFolder()."config.yml", Config::YAML);
            switch ($data){
                case 0:
                    if ($target instanceof Player){
                        $target->getInventory()->clearAll();
                        $targetmessage = str_replace("{staff}", $player->getName(), $config->get("inventairejoueurmessage"));
                        $target->sendMessage($targetmessage);
                        $playermessage = str_replace("{player}", $target->getName(), $config->get("iventairestaffmessage"));
                        $player->sendMessage($playermessage);
                        return;
                    }else{
                        $player->sendMessage("§f[§l§4ERROR§r§f]: Le joueur n'est plus en ligne.");
                        return;
                    }
                    break;
                case 1:
                    if ($target instanceof Player){
                        $target->getEnderInventory()->clearAll();
                        $targetmessage = str_replace("{staff}", $player->getName(), $config->get("enderchestjoueurmessage"));
                        $target->sendMessage($targetmessage);
                        $playermessage = str_replace("{player}", $target->getName(), $config->get("endercheststaffmessage"));
                        $player->sendMessage($playermessage);
                        return;
                    }else{
                        $player->sendMessage("§f[§l§4ERROR§r§f]: Le joueur n'est plus en ligne.");
                        return;
                    }
                    break;
                case 2:
                    if($target instanceof Player) {
                        $target->getArmorInventory()->clearAll();
                        $targetmessage = str_replace("{staff}", $player->getName(), $config->get("armorjoueurmessage"));
                        $target->sendMessage($targetmessage);
                        $playermessage = str_replace("{player}", $target->getName(), $config->get("armorstaffmessage"));
                        $player->sendMessage($playermessage);
                        return;
                    }else{
                        $player->sendMessage("§f[§l§4ERROR§r§f]: Le joueur n'est plus en ligne.");
                        return;
                    }
                    break;
            }
        });
        $ui->setTitle("Clear");
        $ui->addButton("Clear son inventaire");
        $ui->addButton("Clear son ec");
        $ui->addButton("Clear son armures");
        $ui->sendToPlayer($player);
    }
}