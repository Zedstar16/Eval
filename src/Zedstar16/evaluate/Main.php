<?php

declare(strict_types=1);

namespace Zedstar16\evaluate;

use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use pocketmine\Player;
use pocketmine\utils;
use pocketmine\level\Position;
use pocketmine\math\Vector3;

class Main extends PluginBase
{


    public function onEnable(): void
    {
        $this->saveResource("config.yml");
        $this->saveDefaultConfig();
        $cfg = $this->getConfig();
        if ($cfg->get("require-password-to-run") && ($cfg->get("password") === "password" || strlen($cfg->get("password")) < 4)) {
            $this->getLogger()->critical("The Password to execute /eval must not be \"Password\" and must be more than 4 characters long");
            $plmgr = $this->getServer()->getPluginManager();
            $plmgr->disablePlugin($this);
        }
    }

    public function evaluate(CommandSender $sender, array $args)
    {
        try {
            $code = implode(" ", $args);
            $result = eval($code);
            if ($result !== null) {
                if (!is_string($result)) {
                    $result = json_encode($result, JSON_PRETTY_PRINT);
                }
            } else {
                $result = "§aExecuted, null return";
            }
            $sender->sendMessage($result);
        } catch (\Throwable $error) {
            $errormessage = $error->getMessage();
            $sender->sendMessage("§cError: §f{$errormessage}");
        }
    }


    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        if ($command->getName() === "eval") {
            if (isset($args[0])) {
                if ($this->getConfig()->get("require-password-to-run") === true) {
                    if ($args[0] === $this->getConfig()->get("password")) {
                        array_shift($args);
                        $this->evaluate($sender, $args);
                    } else $sender->sendMessage(TextFormat::RED . "Incorrect password, it is Case-Sensitive");
                } else $this->evaluate($sender, $args);

            } else $sender->sendMessage("Please provide some code to run");
        }
        return true;
    }

}
