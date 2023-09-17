<?php

declare(strict_types=1);

namespace Terpz710\Homes\Command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use Terpz710\Homes;

class HomesCommand extends Command {

    private $homeManager;

    public function __construct(HomeManager $homeManager) {
        parent::__construct("homes", "List your available home locations");
        $this->setPermission("homes.homes");
        $this->homeManager = $homeManager;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if ($sender instanceof Player) {
            $player = $sender;

            if (!$this->testPermission($sender)) {
                $sender->sendMessage("You do not have permission to use this command.");
                return true;
            }

            $homes = $this->homeManager->getHomes($player);

            if (empty($homes)) {
                $sender->sendMessage("You have not set any home locations.");
            } else {
                $sender->sendMessage("Your home locations:");
                foreach ($homes as $homeName => $homeLocation) {
                    $sender->sendMessage("- $homeName: X=" . $homeLocation['x'] . ", Y=" . $homeLocation['y'] . ", Z=" . $homeLocation['z'] . ", World=" . $homeLocation['world']);
                }
            }
        } else {
            $sender->sendMessage("This command can only be used in-game.");
        }
        return true;
    }
}
