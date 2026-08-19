<?php
declare(strict_types=1);
return <<<'HTML'
<p>Turn a VPN on, and within seconds your public IP address changes. But what's actually happening behind the scenes, and how real is that change?</p>

<h2>What a VPN actually does to your IP</h2>
<p>A VPN (Virtual Private Network) creates an encrypted tunnel between your device and a server somewhere else in the world. All of your internet traffic first passes through that tunnel and exits from the VPN server. As a result:</p>
<ul>
<li>Websites and services you visit see the VPN server's IP address — not your real one.</li>
<li>The location shown also reflects the VPN server's location, not your actual location.</li>
<li>Your ISP can still see that you're connected to a VPN server, but the traffic content itself is encrypted and unreadable.</li>
</ul>

<h2>How is a VPN different from a proxy?</h2>
<p>Both change your apparent IP address, but a proxy usually only routes traffic from one specific app or browser and often doesn't encrypt it, while a VPN routes your device's entire traffic through an encrypted tunnel. That's why a VPN is generally considered more reliable for privacy than a free proxy.</p>

<h2>How do websites detect that an IP belongs to a VPN?</h2>
<p>Specialized services maintain lists of IP ranges belonging to known datacenters and VPN providers. When your IP address appears on one of those lists, it gets flagged as "datacenter/VPN." You can try this yourself right now: open the <a href="/en">Show-IP.ir homepage</a> and check the "Security Check" section — if a VPN is active, "VPN / Datacenter" will usually flip to "Yes."</p>

<h2>Does a VPN completely hide your IP address?</h2>
<p>A VPN hides your real address from the websites you visit, but that's not the same as being completely anonymous — your VPN provider can, in theory, still see your connection unless it has a genuine no-log policy. For a full comparison of ways to hide your IP — including VPN, Tor, and proxies — read <a href="/en/blog/how-to-hide-your-ip">How to Hide Your IP Address</a>.</p>

<h2>Key takeaways</h2>
<ul>
<li>A VPN replaces your real IP address with the VPN server's address and encrypts all your traffic.</li>
<li>The location shown reflects the VPN server's location, not your actual one.</li>
<li>Services can detect a VPN connection by checking known IP ranges.</li>
<li>You can see your IP change and VPN detection status right now on <a href="/en">Show-IP.ir</a>.</li>
</ul>
HTML;
