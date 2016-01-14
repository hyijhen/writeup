#D-CTF Final 2015 Paranoia [web] 100

##Problem
We've obtained this and we want to get the flag but it's seems it was developed by ultra-paranoic-php-wannabe-developer.<br>
Help us!<br>
<br>
[Source Code](https://github.com/st9140927/writeup/blob/master/D-CTF Final 2015/Paranoia [web] 100/web100.php)

##Solution
This problem is about bypassing all kinds of PHP code limitation.

After taking a look at the source code, we can get following get variables:

<pre>
<code>
0=0
1[0]=0
2=10932435112
3=%20%20%202E6
4=2E6
5=10
6=%20%2013337
7=2
8=a2g3YnB3bmJ3NDFscGI4ZGFreTd5aDhyN3M%3D
9=%20%20%20%20%20%20%20%20%205
10=%20%20%20%20%20%20%20%20%205
11=O:4:"Flag":1:{}
</code>
</pre>

Some tips:

**1**: Use matrix to bypass <code>strcmp</code> checking.<br>
**2**: The hash value of **"Password147186970!"** is <code>0e153958235710973524115407854157</code>. Due to a bug of php, strings begining with 0e and with no characters will be defined as integer **"0"**. So we just need to find an integer that has a sha1 value begining with <code>0e</code>. <br><br>
**For all intergers**: Add **space(%20)** before the integer, and the strlen will be longer but it'll still be considered as an integer.<br>
**3, 4**: Use <code>2E6</code> to replace **2000000**.<br>
**8**: The string will be <code>"aaa".$GET[8]."aaa"</code>.I use a random generator and brute force attack to find a collision.<br>
**11**: This problem is [Object Injection](https://www.owasp.org/index.php/PHP_Object_Injection). See how <code>serialize</code> and <code>unserialize</code> work, and make the unserialized result be **Flag**. It'll call class **Flag** and return the flag back.
