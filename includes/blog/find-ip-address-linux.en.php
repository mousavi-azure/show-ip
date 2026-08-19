<?php
declare(strict_types=1);
return <<<'HTML'
<p>On Linux, just like any other OS, there's a difference between your local IP (inside your network) and your public IP (what the internet sees). Here are the terminal commands for both.</p>

<h2>Finding your public IP</h2>
<p>The simplest way is to open the <a href="/en">Show-IP.ir homepage</a> in a browser. If you're working on a headless server with no GUI, this site also works straight from the command line — just like ifconfig.me:</p>
<blockquote>curl show-ip.ir</blockquote>
<p>That instantly returns your server's public IP address as plain text. For the full details as JSON:</p>
<blockquote>curl show-ip.ir/json</blockquote>

<h2>Finding your local IP with the ip command</h2>
<p>On modern Linux distributions (Ubuntu, Debian, Fedora, Arch), the standard command is <code>ip</code>:</p>
<blockquote>ip addr show</blockquote>
<p>Or more concisely:</p>
<blockquote>ip -4 addr show | grep inet</blockquote>
<p>The address next to your active network interface (usually <code>eth0</code>, <code>wlan0</code>, or <code>enpXsY</code>) is your local IP.</p>

<h2>The older way: ifconfig</h2>
<p>On older distributions, or if you have the <code>net-tools</code> package installed, you can also use:</p>
<blockquote>ifconfig</blockquote>

<h2>The hostname command</h2>
<p>Another quick way to see your local IP:</p>
<blockquote>hostname -I</blockquote>

<h2>Key takeaways</h2>
<ul>
<li>For your server's public IP: <code>curl show-ip.ir</code></li>
<li>For your local IP: <code>ip addr show</code> or <code>hostname -I</code></li>
<li>For full details as JSON: <code>curl show-ip.ir/json</code></li>
</ul>
HTML;
