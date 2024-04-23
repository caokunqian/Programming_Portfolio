# Programming_Portfolio

Class CSDS285

Author: Jack Qian
Instructor: Dr. Ronald Loui

- The main page is code in html
- 6 source are code in php/bash

Make sure you log in to CWRU Network:
- url: http://eecslab-22.case.edu/~cxq72/test.html

---
Features
-
-
-

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


