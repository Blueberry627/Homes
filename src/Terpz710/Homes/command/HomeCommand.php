<?php

declare(strict_types=1);

namespace Terpz710\Homes\Command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\math\Vector3;
use Terpz710\Homes;

class HomeCommand extends Command {

    private $homeManager;

    public function __construct(HomeManager $homeManager) {
        parent::__construct("home", "Teleport to your home location");
        $this->setPermission("homes.home");
        $this->homeManager = $homeManager;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if ($sender instanceof Player) {
            $player = $sender;

            if (!$this->testPermission($sender)) {
                $sender->sendMessage("You do not have permission to use this command.");
                return true;
            }

            $homeLocation = $this->homeManager->getHome($player);

            if ($homeLocation !== null) {
                $x = $homeLocation['x'];
                $y = $homeLocation['y'];
                $z = $homeLocation['z'];
                $worldName = $homeLocation['world'];

                $world = $this->homeManager->getServer()->getLevelByName($worldName);

                if ($world !== null) {
             
                    $homeVector = new Vector3($x, $y, $z);

                    $player->teleport($homeVector, $world);

                    $sender->sendMessage("Teleported to your home location.");
                } else {
                    $sender->sendMessage("The world of your home location no longer exists.");
                }
            } else {
                $sender->sendMessage("You have not set a home location.");
            }
        } else {
            $sender->sendMessage("This command can only be used in-game.");
        }
        return true;
    }
}
