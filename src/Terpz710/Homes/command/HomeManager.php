<?php

declare(strict_types=1);

namespace Terpz710\Homes\command;

use pocketmine\player\Player;
use pocketmine\Server;
use Terpz710\Homes;

class HomeManager {

    private $plugin;

    private $homes = [];

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function setHome(Player $player, array $homeLocation, string $homeName) {
        $playerName = $player->getName();

        if (!isset($this->homes[$playerName])) {
            $this->homes[$playerName] = [];
        }

        $this->homes[$playerName][$homeName] = $homeLocation;
    }

    // Modify getHome to accept a home name.
    public function getHome(Player $player, string $homeName) {
        $playerName = $player->getName();

        if (isset($this->homes[$playerName][$homeName])) {
            return $this->homes[$playerName][$homeName];
        }
        return null;
    }

    public function deleteHome(Player $player, string $homeName) {
        $playerName = $player->getName();

        if (isset($this->homes[$playerName][$homeName])) {
            unset($this->homes[$playerName][$homeName]);
            return true;
        }
        return false;
    }

    public function getAllHomes(Player $player) {
        $playerName = $player->getName();
        if (isset($this->homes[$playerName])) {
            return $this->homes[$playerName];
        }
        return [];
    }
}
