#dropboxlibrary

This is a sample class with the most important functionalities of Dropbox PHP API (Core API).


## Install

* If you don't have composer , install it [here](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx).
* If you have composer add require part from my composer.json to your project and also require-dev part.
* Now copy autoload part in your composer.json and from terminal install the new composer and update .

## require

* Now we are ready for the game.
* Copy "dropbox.php" file in your project's folder.
* Copy "config.json" or create new Dropbox App [here](https://www.dropbox.com/developers) .
* For use my Library in your file PHP add require "dropbox.php"; .
* The url for have the permission from user is [this](https://www.dropbox.com/1/oauth2/authorize?locale=&client_id=l4mtwlebsfmzf5h&response_type=code)(the authorization url) .


##Structure

* Create the object 
```php
//$key is the temporany key that dropbox give to user when he gives  permission
//to your application from the authorization url 
$object=new \Dropboxlib("config.json",$key);
```



