# Eval
Pretty simple plugin as always :D

This plugin gives a /eval command

SAFE for use on production server!

/eval is used to execute php code in game, the plugin catches all errors, and sends the error message to you.

By default this command is only available to OPs, however you can edit the config so a password is required to run the command.

You can use most predefined variables in this command such as $this->getServer() or whatever and $sender (You)

In order to import classes you must escape the `\` char

For example `$player->sendMessage(\\pocketmine\\utils\\TextFormat::GREEN."hi");`

## More code examples

- Return a list of all online players separated by 
```php
return implode(", ", array_map(function ($player){
    return $player->getName();
}, $this->getServer()->getOnlinePlayers()));
```

- Run a command as console
```php
 $this->getServer()->dispatchCommand(new \\pocketmine\\command\\ConsoleCommandSender(), 'say hello world');
 ```
 
 - Do some simple addition and send the answer to yourself
```php
return 46+69+21;
```

