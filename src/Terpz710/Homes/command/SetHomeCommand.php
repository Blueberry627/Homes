<?php

declare(strict_types=1);

namespace Terpz710\Homes\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use Terpz710\Homes;

class SetHomeCommand extends Command {

    private $homeManager;

    public function __construct(HomeManager $homeManager) {
        parent::__construct("sethome", "Set your home location");
        $this->setPermission("homes.sethome");
        $this->homeManager = $homeManager;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if ($sender instanceof Player) {
            $player = $sender;

            if (!$this->testPermission($sender)) {
                $sender->sendMessage("You do not have permission to use this command.");
                return true;
            }

            $homeLocation = [
                'x' => $player->getX(),
                'y' => $player->getY(),
                'z' => $player->getZ(),
                'world' => $player->getLevel()->getName(),
            ];

            $this->homeManager->setHome($player, $homeLocation, "home");

            $sender->sendMessage("Your home location 'home' has been set!");
        } else {
            $sender->sendMessage("This command can only be used in-game.");
        }
        return true;
    }
}
