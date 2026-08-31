<?php
declare(strict_types=1);
return <<<'HTML'
<p>Open your home router's settings and you'll probably see an address like <code>192.168.1.1</code>. But open this website, and a completely different address shows up. How are these two related, and why are they different?</p>

<h2>What is a private IP address?</h2>
<p>A private IP address only means something inside one local network (home, office, coffee shop) and isn't reachable from outside that network. Your router assigns a private IP to every device that connects — laptop, phone, printer — so they can talk to each other and to the router.</p>
<p>Three standard ranges are reserved for private IP addresses and are never used on the public internet:</p>
<ul>
<li><code>10.0.0.0</code> to <code>10.255.255.255</code></li>
<li><code>172.16.0.0</code> to <code>172.31.255.255</code></li>
<li><code>192.168.0.0</code> to <code>192.168.255.255</code></li>
</ul>

<h2>What is a public IP address?</h2>
<p>A public IP address is what your ISP assigns to your entire home or office connection, and it's visible and reachable from anywhere on the internet. This is the address websites actually see, and it's what <a href="/en">Show-IP.ir</a> displays.</p>

<h2>So how do multiple devices share one public IP?</h2>
<p>The answer is a process called <strong>NAT</strong> (Network Address Translation). Your router combines all the requests from devices on your network under a single public IP address, and routes the responses back to the right device. That's why five people in the same house can be online at once, yet the internet sees them all under one shared public IP address. NAT is also one of the reasons the internet still works despite the IPv4 address shortage — something we cover in more detail in <a href="/en/blog/ipv4-vs-ipv6">IPv4 vs IPv6</a>.</p>

<h2>Quick comparison</h2>
<table>
<tr><th>Feature</th><th>Private IP</th><th>Public IP</th></tr>
<tr><td>Visible to</td><td>Local network only</td><td>The whole internet</td></tr>
<tr><td>Assigned by</td><td>Your router</td><td>Your ISP</td></tr>
<tr><td>Uniqueness</td><td>Can repeat across different networks</td><td>Globally unique</td></tr>
</table>

<h2>Key takeaways</h2>
<ul>
<li>A private IP address only matters inside your local network and isn't visible from outside.</li>
<li>A public IP address is what the entire internet, including this site, actually sees.</li>
<li>NAT lets multiple devices share a single public IP address.</li>
<li>You can see your current public IP address right now on the <a href="/en">Show-IP.ir homepage</a>.</li>
</ul>
HTML;
