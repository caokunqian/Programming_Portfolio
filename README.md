# Programming_Portfolio

Class CSDS285

Author: Jack Qian
Instructor: Dr. Ronald Loui

- The main page is code in html
- 6 source are code in php/bash

Make sure you log in to CWRU Network:
- url: http://eecslab-22.case.edu/~cxq72/test.html

Required Libraries:

For Task3:
- sudo apt install composer
- composer require erusev/parsedown


---
## Features

- [Network and Server Health Monitor](script1.php) - A tool to view details of the network interface and server health.
- [2048 Game](script2.php) - A web-based version of the popular slide puzzle game.
- [Memory Game](script3.php) - A simple card matching game to test and improve your memory.
- [Poll Maker](script4.php) - An interactive polling tool with real-time result updates.
- [To-Do List](script5.php) - Manage your tasks effectively with a dynamic to-do list.
- [Text Analysis Tool](script6.php) - Analyze text for the most common words, word count, and sentence count.


---
Testing Instruction:

I am using windows computer and do all the testing under WSL

- cd to where main.html is
- sudo apt update
- sudo apt install apache2
check apache2:
- sudo service apache2 status

check ip:
- hostname -I

view port:
- cat /etc/apache2/ports.conf

create symbolic link(otherwise you need put all file under /var/www/html):
- sudo ln -s /mnt/d/[the path to source code] /var/www/html

replace [the path to source code] with yours. 

Example:
sudo ln -s /mnt/d/University/Course/Grade4/CSDS285/Final\ project/code /var/www/html


For each php function(enter url in your brower):

- http:[ip]/filename.php

example like:
- http://172.29.13.23/test.php

Debugging:
add the following to php file:
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


