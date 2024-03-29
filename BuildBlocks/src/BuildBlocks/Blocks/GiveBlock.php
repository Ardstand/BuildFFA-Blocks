<?php


namespace BuildBlocks\Blocks;

use BuildBlocks\Main;
use pocketmine\item\ItemFactory;
use pocketmine\level\Position;
use pocketmine\block\Block;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\scheduler\Task;

class GiveBlock extends Task {

    public $plugin;
    public $player;

    public function __construct(Main $plugin, Player $player){
        $this->plugin = $plugin;
        $this->player = $player;
    }

    public function onRun(int $currentTick){
        $item = ItemFactory::get(179, 0 ,1);
        $this->player->getInventory()->addItem($item);
    }
}