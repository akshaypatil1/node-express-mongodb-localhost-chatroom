1) Copy/install mongodb in C:\
2) install node.js in C:\
3) create empty folder in C:\ with name 'data'
4) create empty folder in C:\data\ with name 'db'
5) copy project folder in xampp\htdocs (or root of server)
	- find 192.168.0.9 replace with your IP-Address in 'chat.php' and 'index.php'
6) open cmd
	- go to path C:\mongodb\bin\
	- run=> mongod (this will start mongodb server)
7) open another cmd
	- go to path C:\mongodb\bin\
	- run=> mongo (this will allow you to fire commands related to mongodb)
8) open another cmd
	- go to path C:\xampp\htdocs\chat\
	- run=> node server.js (this will start node server)
9) don't close these cmd
10) open multiple browser and run chat project
	- name: your name
	- password: don

IMP : you can chat from different PC in LAN using http://YOUT-IP-ADDRESS/chat/
		Example in my case Link is : http://192.168.0.9/chat/