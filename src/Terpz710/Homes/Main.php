<?php

declare(strict_types=1);

namespace Terpz710\Homes;

use pocketmine\plugin\PluginBase;
use Terpz710\Homes\Command\HomeManager;
use Terpz710\Homes\Command\HomeCommand;
use Terpz710\Homes\Command\HomesCommand;
use Terpz710\Homes\Command\SetHomeCommand;
use Terpz710\Homes\Command\DelHomeCommand;

class Main extends PluginBase {

    /** @var HomeManager */
    private $homeManager;

    public function onEnable(): void {
        $this->homeManager = new HomeManager($this);
        $this->getServer()->getCommandMap()->register("sethome", new SetHomeCommand($this->homeManager));
        $this->getServer()->getCommandMap()->register("home", new HomeCommand($this->homeManager));
        $this->getServer()->getCommandMap()->register("delhome", new DelHomeCommand($this->homeManager));
        $this->getServer()->getCommandMap()->register("homes", new HomesCommand($this->homeManager));
    }
}
