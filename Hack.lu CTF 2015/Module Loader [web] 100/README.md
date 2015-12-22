#Hack.lu Module Loader [web] 100

##Problem
Since his students never know what date it is and how much time they have until the next homework's deadline, Mr P. H. Porter wrote a little webapp for that.
You can find it [here](https://school.fluxfingers.net:1522).

##Solution
First, I see two modules, **date** and **timer**, in index.php. After clicking the links, it'll show the executing results of the modules below.
![image]("https://github.com/st9140927/writeup/blob/master/Hack.lu CTF 2015/Module Loader [web] 100/1.png")
URL: https://school.fluxfingers.net:1522/?module=**date**

The challenge seems to be an LFI problem, but I still don't know where to traverse to yet.
Let's take a look at the source code. I can see some comments:
![image]("https://github.com/st9140927/writeup/blob/master/Hack.lu CTF 2015/Module Loader [web] 100/2.png")

So I try to enter directory "modules".
![image]("https://github.com/st9140927/writeup/blob/master/Hack.lu CTF 2015/Module Loader [web] 100/3.png")

And I find nothing special in the directory. The only thing I can know is that this directory is under root, since I'll be redirected to index.php after clicking "Parent Directory".
Then I use "../index.php" to be the parameter of module in the URL, and it'll be like this:
![image]("https://github.com/st9140927/writeup/blob/master/Hack.lu CTF 2015/Module Loader [web] 100/4.png")
That proves LFI may works.

Because I don't have any specific files to reach, I try to access robots.txt and .htaccess, and it shows that .htaccess exists. However, I cannot access the file directly, so I try to use LFI from URL to reach the file.
URL: https://school.fluxfingers.net:1522/?module=**../.htaccess**
![image]("https://github.com/st9140927/writeup/blob/master/Hack.lu CTF 2015/Module Loader [web] 100/5.png")

It shows that I can access .htaccess, but nothing special is shown. Then I look at the source code again.
![image]("https://github.com/st9140927/writeup/blob/master/Hack.lu CTF 2015/Module Loader [web] 100/6.png")

Bingo!
The directory with flag.php looks like this:
![image]("https://github.com/st9140927/writeup/blob/master/Hack.lu CTF 2015/Module Loader [web] 100/7.png")

Since accessing "flag.php" directly doesn't work, I try to do LFI again via URL below.
URL: https://school.fluxfingers.net:1522/?module=**../3cdcf3c63dc02f8e5c230943d9f1f4d75a4d88ae/flag.php**

And the flag occurs.
![image]("https://github.com/st9140927/writeup/blob/master/Hack.lu CTF 2015/Module Loader [web] 100/flag.png")

