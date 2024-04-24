# Programming_Portfolio

Class CSDS285

Author: Jack Qian
Instructor: Dr. Ronald Loui


Make sure you log in to CWRU Network:
- url: http://eecslab-22.case.edu/~cxq72/index.php


---
## Features

- [Network and Server Health Monitor] - A tool to view details of the network interface and server health.
- [2048 Game] - A web-based version of the popular slide puzzle game.
- [Memory Game] - A simple card matching game to test and improve your memory.
- [Poll Maker] - An interactive polling tool with real-time result updates.
- [To-Do List] - Manage your tasks effectively with a dynamic to-do list.
- [Text Analysis Tool] - Analyze text for the most common words, word count, and sentence count.


---
# Version Control & AI tools
- I don't know how to provide it but this class is first time for me to learn php, so all of code are done this semester
you can view change log through https://github.com/caokunqian/Programming_Portfolio/commits/main/
- I only use AI for css style, I coded all core functions
---
## Testing Instruction:

I am using windows computer and do all the testing under WSL(vpn access school server is solve qwq)

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


