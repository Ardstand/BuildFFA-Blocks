<?php

namespace BuildBlocks\Blocks;

use pocketmine\block\Block;
use pocketmine\scheduler\Task;
use BuildBlocks\Main;

class SB extends Task{
	public $plugin;
	public $block;

	public function __construct(Main $plugin, Block $block){
		$this->plugin = $plugin;
		$this->block = $block;
	}

	public function onRun(int $currentTick){
		$this->block->getLevel()->setBlockIdAt($this->block->x, $this->block->y, $this->block->z, Block::AIR);
	}
}