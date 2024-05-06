# Programming Portfolio

**Class:** CSDS285  
**Author:** Jack Qian  
**Instructor:** Dr. Ronald Loui  

Please ensure you are logged into the CWRU Network to access the portfolio:  
- URL: [http://eecslab-22.case.edu/~cxq72/index.php](http://eecslab-22.case.edu/~cxq72/index.php)

## Features

- [Network and Server Health Monitor](http://eecslab-22.case.edu/~cxq72/script1.php) - A tool to view details of the network interface and server health.
- [2048 Game](http://eecslab-22.case.edu/~cxq72/script2.php) - A web-based version of the popular slide puzzle game.
- [Memory Game](http://eecslab-22.case.edu/~cxq72/script3.php) - A simple card matching game to test and improve your memory.
- [Poll Maker](http://eecslab-22.case.edu/~cxq72/script4.php) - An interactive polling tool with real-time result updates.
- [To-Do List](http://eecslab-22.case.edu/~cxq72/script5.php) - Manage your tasks effectively with a dynamic to-do list.
- [Text Analysis Tool](http://eecslab-22.case.edu/~cxq72/script6.php) - Analyze text for the most common words, word count, and sentence count.

## Version Control & AI Tools

This is my first time learning PHP in this class, so all the code was written during this semester. You can view the change log at [GitHub commit history](https://github.com/caokunqian/Programming_Portfolio/commits/main/).

The CSS styles were aided by an AI tool, but all core functions were coded by me.


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


