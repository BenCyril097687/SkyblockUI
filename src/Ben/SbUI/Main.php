<?php
/*
* Coppyright (C) BenCyril 2020-2021
* 
* Contact: 
*	Email: nguyenben08083508@gmail.com
*/
namespace Ben\SbUI;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\command\{CommandSender, Command};
use jojoe77777\FormAPI\{CustomForm, SimpleForm};

class Main extends PluginBase implements Listener{
	
	public function onEnable(){
		$this->getLogger()->info("§aĐã bật plugin SkyblockUI bởi BenCyril!");
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
	}
	
	public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
		$player = $sender->getPlayer();
		switch($cmd->getName()){
			case "is":
			$this->mainForm($player);
        }
        return true;
    }
	
	public function mainForm($player) {
		if($player instanceof Player) {
			$form = new SimpleForm(function(Player $player, ?int $data) {
				if(is_null($data)) return;
				switch($data) {
					case 0:
					    $this->islandForm($player);
					    break;
                    case 1:
						$this->homeForm($player);
						break;
					case 2:
						$this->getServer()->getCommandMap()->dispatch($player, "sb homes");
						break;
					case 3:
						$this->getServer()->getCommandMap()->dispatch($player, "sb info");
						break;
					case 4:
						$this->helperForm($player);
						break;
					case 5:
						$this->warpForm($player);
						break;
					case 6:
						$this->giveForm($player);
						break;
					}
				});
			$form->setTitle("• SkyBlock •");
			$form->setContent("→ Chọn Button Quản Lý Đảo!");
			$form->addButton("Thêm Đảo", 0, "textures/ui/dev_glyph_color");
			$form->addButton("Về Đảo", 0, "textures/ui/icon_import");
			$form->addButton("Danh Sách Đảo", 0, "textures/ui/copy");
			$form->addButton("Thông Tin Đảo", 0, "textures/ui/infobulb");
            $form->addButton("Người Hỗ Trợ", 0, "textures/ui/dressing_room_customization");
			$form->addButton("Qua Đảo Khác", 0, "textures/ui/World");
			$form->addButton("Chuyển Đảo", 0, "textures/ui/redX1");
			$form->sendToPlayer($player);
		}
	}
	
	public function islandForm($player) {
		if($player instanceof Player) {
			$form = new SimpleForm(function(Player $player, ?int $data) {
				if(is_null($data)) {
					$this->mainForm($player);
					return;
					}
				switch($data) {
					case 0:
						$this->getServer()->getCommandMap()->dispatch($player, "sb auto");
						break;
					case 1:
						$this->getServer()->getCommandMap()->dispatch($player, "sb claim");
						break;
					}
				});
			$form->setTitle("• SkyBlock •");
			$form->setContent("→ Tìm Hoặc Nhận Đảo!");
			$form->addButton("Tìm Đảo", 0, "textures/ui/magnifyingGlass");
			$form->addButton("Nhận Đảo", 0, "textures/ui/realms_slot_check");
			$form->sendToPlayer($player);
		}
	}
			
	public function homeForm($player) {
		if($player instanceof Player) {
				$form = new CustomForm(function(Player $player, ?array $data) {
				if(is_null($data)) {
					$this->mainForm($player);
					return false;
					}
					$this->getServer()->getCommandMap()->dispatch($player, "sb home " . $data[0]);
				});
			$form->setTitle("• SkyBlock •");
			$form->addInput("→ Nhập ID Đảo §7(VD: 1)§r:", "id dao");
			$form->sendToPlayer($player);
		}
	}
	
	public function helperForm($player) {
		if($player instanceof Player) {
			$form = new CustomForm(function(Player $player, ?array $data) {
				if(is_null($data)) {
					$this->mainForm($player);
					return false;
					}
				if($data[1] == null) return true;
				if($data[0] == true) {
					$this->getServer()->getCommandMap()->dispatch($player, "sb removehelper " . $data[1]);
				} else {
					$this->getServer()->getCommandMap()->dispatch($player, "sb addhelper " . $data[1]);
					}
				});
			$form->setTitle("• SkyBlock •");
			$form->addToggle("Thêm/Xóa Người Hỗ Trợ");
			$form->addInput("→ Nhập Tên Người Chơi:", "ten nguoi choi");
			$form->sendToPlayer($player);
		}
	}

	public function warpForm($player) {
		if($player instanceof Player) {
			$form = new CustomForm(function(Player $player, ?array $data) {
				if(is_null($data)) {
					$this->mainForm($player);
					return false;
					}
					$this->getServer()->getCommandMap()->dispatch($player, "sb warp " . $data[0]);
				});
			$form->setTitle("• SkyBlock •");
			$form->addInput("→ Nhập Địa Chỉ Đảo §7(VD: 0;0)§r:", "dia chi dao");
			$form->sendToPlayer($player);
		}
	}
		
	public function giveForm($player) {
		if($player instanceof Player) {
				$form = new CustomForm(function(Player $player, ?array $data) {
				if(is_null($data)) {
					$this->mainForm($player);
					return false;
					}
					$this->getServer()->getCommandMap()->dispatch($player, "sb give " . $data[0]);
				});
			$form->setTitle("• SkyBlock •");
			$form->addInput("→ Nhập Tên Người Chơi:", "ten nguoi choi");
			$form->sendToPlayer($player);
		}
	}
}
