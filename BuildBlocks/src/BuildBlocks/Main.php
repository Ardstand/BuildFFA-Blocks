<?php

declare(strict_types=1);

namespace BuildBlocks;

use BuildBlocks\Blocks\BreakBlock;
use BuildBlocks\Blocks\GiveBlock;
use BuildBlocks\Blocks\Sandstone1Task;
use BuildBlocks\Blocks\SandstoneTask;
use BuildBlocks\Blocks\SB;
use pocketmine\entity\Entity;
use pocketmine\network\mcpe\protocol\{LevelSoundEventPacket, InventoryTransactionPacket};
use pocketmine\item\enchantment\{Enchantment, EnchantmentInstance};
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\inventory\Inventory;
use pocketmine\inventory\PlayerInventory;
use pocketmine\inventory\ArmorInventory;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\item\ItemFactory;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\scheduler\Task;
use pocketmine\scheduler\PluginTask;
use pocketmine\math\Vector3;
use pocketmine\math\Vector2;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\utils\Utils;
use pocketmine\utils\Config;
use pocketmine\event\entity\EntityLevelChangeEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use onebone\economyapi\EconomyAPI;
use pocketmine\block\Sandstone;
use pocketmine\entity\Effect;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\item\ItemBlock;
use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;
use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
use pocketmine\utils\TextFormat as Color;

class Main extends PluginBase implements Listener {
	
	private static $instance = null;
	private static $scoreboard = null;

	public function onEnable() : void {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getLogger()->info("Enabled");
		//$this->getScheduler()->scheduleRepeatingTask(new ScoreTask($this), 10);
		//$this->getScheduler()->scheduleRepeatingTask(new EntityTask($this), 10);
		$config = new Config($this->getDataFolder() . "/config.yml", Config::YAML);
		if(!$config->get("level")) {
		$this->getLogger()->info("No maps have been set yet, you idiot");
		}else{
		$this->getServer()->loadLevel($config->get("level"));
		}
		$this->saveResource("config.yml");
	}

	public static function getConfigs(string $value) {
		return new Config(self::getInstance()->getDataFolder() . "{$value}.yml", Config::YAML);
	  }

	  public function onChange(EntityLevelChangeEvent $event){
		$player = $event->getEntity();
		$config = new Config($this->getDataFolder() . "/config.yml", Config::YAML);
		if ($config->get('level') != null) {
            if ($player->getLevel() === Server::getInstance()->getLevelByName($config->get('level'))) {
                if ($player instanceof Player) {
                   // $api = BUILD::getScoreboard();
   	              //	$api->remove($player);
                    $player->removeAllEffects();
                    $player->setGamemode(2);
                    $player->setHealth(20);
                    $player->setFood(20);
                    $player->removeAllEffects();
                    $player->getInventory()->clearAll();
                    $player->getArmorInventory()->clearAll();
		}
		}
		}
		}

	public function onBlockPlace(BlockPlaceEvent $event){
		$config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
		if ($event->getPlayer()->getLevel()->getName() == $config->get("level")) {
			$block = $event->getBlock();
			$player = $event->getPlayer();
			$id = $event->getBlock()->getId();
			if($config->get("level") != null){
			if( $player->getLevel() === Server::getInstance()->getLevelByName($config->get("level"))){
			if ($id === 179) {
				$this->getScheduler()->scheduleDelayedTask(new SandstoneTask($this, $block, $player), 100);
				$this->getScheduler()->scheduleDelayedTask(new GiveBlock($this, $player), 100);
				$this->getScheduler()->scheduleDelayedTask(new Sandstone1Task($this, $block), 50);
				$event->setCancelled(false);
			} elseif ($id === 30) {
				$this->getScheduler()->scheduleDelayedTask(new SB($this, $block), 120);
				$event->setCancelled(false);
			} else {
				$event->setCancelled(true);
			}
		}
			}
		}
    }

	public function onBlockBreak(BlockBreakEvent $event){
		$block = $event->getBlock()->getDamage();
		$player = $event->getPlayer();
		$id = $event->getBlock()->getId();
		$config = new Config($this->getDataFolder() . "/config.yml", Config::YAML);
		
		if($config->get("level") != null){
		if( $player->getLevel() === Server::getInstance()->getLevelByName($config->get("level"))){
		 $event->setCancelled(true);
		if ($id === 179) {
		  $player->sendMessage("You can only break this Block!");
			$event->setCancelled(false);
		} else {
		  $player->sendMessage("You cant break these blocks!");
			$event->setCancelled(true);
		}
}
		}
}
}