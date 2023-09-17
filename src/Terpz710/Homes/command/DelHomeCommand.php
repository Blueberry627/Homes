<?php

declare(strict_types=1);

namespace Terpz710\Homes\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use Terpz710\Homes;

class DelHomeCommand extends Command {

    private $homeManager;

    public function __construct(HomeManager $homeManager) {
        parent::__construct("delhome", "Delete your home location");
        $this->setPermission("homes.delhome");
        $this->homeManager = $homeManager;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if ($sender instanceof Player) {
            $player = $sender;

            if (!$this->testPermission($sender)) {
                $sender->sendMessage("You do not have permission to use this command.");
                return true;
            }

            if ($this->homeManager->deleteHome($player)) {
                $sender->sendMessage("Your home location has been deleted.");
            } else {
                $sender->sendMessage("You have not set a home location to delete.");
            }
        } else {
            $sender->sendMessage("This command can only be used in-game.");
        }
        return true;
    }
}
