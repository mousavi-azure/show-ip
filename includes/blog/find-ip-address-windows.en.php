<?php
declare(strict_types=1);
return <<<'HTML'
<p>On Windows there are two kinds of IP address you might need: your local IP (inside your home or office network) and your public IP (what the internet sees). Here's the fastest way to find each one on Windows 10 and 11.</p>

<h2>Finding your public IP (the fast way)</h2>
<p>To see your public IP address, just open the <a href="/en">Show-IP.ir homepage</a> in your browser — your IP, country, city, ISP, and connection security status show up instantly, no settings or software installation required.</p>

<h2>Finding your local IP via Settings</h2>
<ol>
<li>Click the Wi-Fi or network icon in the taskbar and open <strong>Network &amp; Internet Settings</strong>.</li>
<li>Click on your connected network (Wi-Fi or Ethernet).</li>
<li>Scroll down to the <strong>Properties</strong> section; the address next to <strong>IPv4 address</strong> is your local IP.</li>
</ol>

<h2>Finding your local IP via Command Prompt</h2>
<ol>
<li>Press <code>Win + R</code>, type <code>cmd</code>, and hit Enter.</li>
<li>In the window that opens, type:</li>
</ol>
<blockquote>ipconfig</blockquote>
<p>In the output, look for the <strong>IPv4 Address</strong> line under your active network adapter (Wi-Fi or Ethernet).</p>

<h2>Frequently asked</h2>
<h3>Why is my local IP different from the IP shown on Show-IP.ir?</h3>
<p>Your local IP (like <code>192.168.1.5</code>) only means something inside your home network, while your public IP is what the entire internet sees. We explain the full difference in <a href="/en/blog/private-vs-public-ip">Private vs Public IP</a>.</p>

<h2>Key takeaways</h2>
<ul>
<li>The fastest way to see your public IP: open <a href="/en">Show-IP.ir</a>.</li>
<li>Your local IP is visible via Settings or the <code>ipconfig</code> command in Command Prompt.</li>
<li>These two addresses are always different, and that's completely normal.</li>
</ul>
HTML;
