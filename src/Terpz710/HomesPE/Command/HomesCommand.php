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

use Terpz710\HomesPE\Main;

class HomesCommand extends Command implements PluginOwned {

    /** @var Config */
    private $config;

    /** @var Plugin */
    private $plugin;

    public function __construct(Config $config, Plugin $plugin) {
        parent::__construct("homes", "List your homes", "/homes", ["listhomes"]);
        $this->config = $config;
        $this->plugin = $plugin;
        $this->setPermission("homespe.homes");
    }

    public function getOwningPlugin(): Plugin {
        return $this->plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if ($sender instanceof Player) {
            if ($sender->hasPermission("homespe.homes")) {
                $playerName = $sender->getName();
                $playerHomes = $this->config->getNested("homespe.$playerName", []);

                if (empty($playerHomes)) {
                    $sender->sendMessage("§c§lYou haven't set any homes. Use §e/sethome [HomeName]§c to set a home");
                } else {
                    $homeList = implode("§f,§a ", array_keys($playerHomes));
                    $sender->sendMessage("§l§aYour homes§f:§a {$homeList}");
                }
            } else {
                $sender->sendMessage("§c§lYou don't have permission to use this command");
            }
        } else {
            $sender->sendMessage("This command can only be used by players.");
        }
        return true;
    }
}
