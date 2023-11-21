<?php

declare(strict_types=1);

namespace Terpz710\HomesPE\Command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
use pocketmine\plugin\PluginOwned;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use pocketmine\math\Vector3;

use Terpz710\HomesPE\Main;

class SetHomeCommand extends Command implements PluginOwned {

    /** @var Config */
    private $config;

    /** @var Plugin */
    private $plugin;

    public function __construct(Config $config, Plugin $plugin) {
        parent::__construct("sethome", "Set a home location", null, ["setlobby", "setspawn"]);
        $this->config = $config;
        $this->plugin = $plugin;
        $this->setPermission("homespe.sethome");
    }

    public function getOwningPlugin(): Plugin {
        return $this->plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if ($sender instanceof Player) {
            if ($sender->hasPermission("homespe.sethome")) {
                $homeName = strtolower($args[0] ?? "default");
                $position = $sender->getPosition();
                $world = $position->getWorld()->getFolderName();

                $playerName = $sender->getName();
                $playerHomes = $this->config->getNested("homespe.$playerName", []);

                if (isset($playerHomes[$homeName])) {
                    $playerHomes[$homeName] = [
                        "x" => $position->getX(),
                        "y" => $position->getY(),
                        "z" => $position->getZ(),
                        "world" => $world,
                    ];
                    $message = "§l§aHome location §e{$homeName}§a updated";
                } else {
                    $playerHomes[$homeName] = [
                        "x" => $position->getX(),
                        "y" => $position->getY(),
                        "z" => $position->getZ(),
                        "world" => $world,
                    ];
                    $message = "§l§aHome location §e{$homeName}§a set";
                }

                $this->config->setNested("homes.$playerName", $playerHomes);
                $this->config->save();

                $sender->sendMessage($message);
            } else {
                $sender->sendMessage("§l§cYou don't have permission to use this command");
            }
        } else {
            $sender->sendMessage("This command can only be used by players.");
        }
        return true;
    }
}
