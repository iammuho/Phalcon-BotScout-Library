# Installation

  * Get an API KEY from botscout.com
  * Add that parameters to your config file
  
```
[botscout]
  api_key = "YOUR API KEY"
  test_ip = "XXX.XXX.XX.XX"
```
  * place Botscout.php to your library folder
  * If you want add your bootstrap index.php file class or include from controller
```
   $loader->registerClasses(array(
    "Botscout" => __dir__ . $config->application->libraryDir .
            '/BotScout/Botscout.php',
        ));
  ```
  * On controller get instance with post params
  
  ```
  $botscout = new Botscout(array('username' => $this->request->getPost('username'),'email' => $this->request->getPost('email')));
  $botscout->checkBot();
  ```
  
Botscout will print "this is bot attack" and exit from code. But if you want to make anything you can edit Botscout/checkBot and other functions.


Muhammet Arslan
http://muhammetarslan.com
  


  
