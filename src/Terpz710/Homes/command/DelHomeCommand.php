<?php

declare(strict_types=1);

namespace Terpz710\Homes\Command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use Terpz710\Homes;

class SetHomeCommand extends Command {

    private $homesConfig;

    public function __construct(Config $homesConfig) {
        parent::__construct("sethome", "Set your home location");
        $this->setPermission("homeplugin.sethome");
        $this->homesConfig = $homesConfig;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if ($sender instanceof Player) {
            $player = $sender;

            if (!$this->testPermission($sender)) {
                $sender->sendMessage("You do not have permission to use this command.");
                return true;
            }

            $homeName = "home"; // Default home name
            if (!empty($args)) {
                $homeName = $args[0]; // Use the provided home name if available
            }

            $homeLocation = [
                'x' => $player->getX(),
                'y' => $player->getY(),
                'z' => $player->getZ(),
                'world' => $player->getLevel()->getName(),
            ];

            $playerName = $player->getName();
            $this->homesConfig->setNested("$playerName.$homeName", $homeLocation);
            $this->homesConfig->save();

            $sender->sendMessage("Your home location '$homeName' has been set!");
        } else {
            $sender->sendMessage("This command can only be used in-game.");
        }
        return true;
    }
}
