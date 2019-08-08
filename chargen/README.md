# Avatar and Signature Generator FluxCP Addon

![preview1](http://i.imgur.com/LKgpW9T.png)![preview1](http://i.imgur.com/06ITYK8.png)

This is based on KeyWorld's [@vthibault [Vincent Thibault]](https://github.com/vthibault) ROChargenPHP. I just made some little tweaks to work some things out. The only difference is that it's made into a FluxCP addon instead of having it on a different folder, so you don't have to write down your server's credentials again. 

# Installation

1. After extracting the ZIP file inside the addons folder, put your own GRFs inside 'addons\chargen\grf'. And also, edit the DATA.ini to list your GRFs.
2. You're good to go!
3. There are some settings inside the addon.php (addons\chargen\config\addon.php):

This line changes the cache time for your avatar's status.
```php
'ChargenCacheTime' => 0.1, ////In minutes
```
These are the default backgrounds/border for your avatar/signature in case you didn't click on any of them in the creation menu.
```php
'default_avaBG' => "background00.jpg", //Default Avatar Background BG'default_avaBD' => "border.png", //Default Avatar Border'default_sigBG' => "background01.jpg",
```
You can have your custom INI, just make sure you edit the name here.

```php
 'Data_INI' => "DATA.INI",
 ```
Like on KeyWorld's thread, setting this to true would have an improvement on speed as it's not looking inside the GRFs again and again.
```php
'AutoExtract' => true,
```
These are the file types that the addon will read inside the backgrounds/borders folder.
``` php
'supported_filetypes' => array('gif','jpg','jpeg','png'), //List of supported filetypes for background and border. 
```
You can also edit the default values but it's very unlikely that it will ever be needed at some point.

# Fetching Generated Images
By default you can only fetch images when the data file has been created by the owner of that character. Sorry, but there's no turn off switch for that.
This is how you can fetch an avatar image of a character
 ```
<fluxcp>/?module=chargen&action=avatar&request=<charnamehere> 
 ```
This is for the signature
```
<fluxcp>/?module=chargen&action=signature&request=<charnamehere>
```

# Backgrounds
 To add more backgrounds for the avatar creation just simply add them inside the dedicated folder for it:
```
'addons\chargen\data\avatar\background'
```
To add more borders for the avatar creation simply add them inside the borders folder:
```
'addons\chargen\data\avatar\border'
```
The same is also for the signatures
``` 
addons\chargen\data\signature
```

License:
http://creativecommons.org/licenses/by-nc-sa/3.0/﻿
