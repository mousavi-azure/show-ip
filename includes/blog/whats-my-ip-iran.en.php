<?php
declare(strict_types=1);
return <<<'HTML'
<p>When you search "what is my IP", you are really after one number: the address internet servers use to identify your connection. The <a href="/en">Show-IP.ir home page</a> shows it instantly, but the result has several more lines that are worth understanding.</p>

<h2>Which address is your public IP?</h2>
<p>The four-part number at the top, like <code>203.0.113.42</code>, is your <strong>public IP</strong> — the address every website, game server and online service sees. You may also see a longer IPv6 address with letters and colons; the difference is covered in <a href="/en/blog/ipv4-vs-ipv6">IPv4 vs IPv6</a>.</p>
<p>This is not the same as the address in your Windows settings or router (for example <code>192.168.1.5</code>). That one is a <a href="/en/blog/private-vs-public-ip">private IP</a> and only means something inside your home network.</p>

<h2>What each line means</h2>
<ul>
<li><strong>Country and city:</strong> estimated from the IP block and geolocation databases — not GPS. That is why the city is sometimes wrong.</li>
<li><strong>ISP / carrier:</strong> the company the address is registered to.</li>
<li><strong>ASN and route:</strong> the network number your IP lives in. Not important day to day, but useful for diagnosing routing problems.</li>
<li><strong>Time zone and currency:</strong> filled in from the estimated country.</li>
<li><strong>Security status:</strong> whether your IP is known as Tor, a proxy, a datacenter or a VPN.</li>
</ul>

<h2>Why is my location wrong?</h2>
<ul>
<li><strong>Carrier NAT (CGNAT):</strong> many mobile carriers and some ISPs share one public address among hundreds of subscribers, and it may be registered in a different city.</li>
<li><strong>A VPN is on:</strong> the country and city then belong to the VPN server, not you. See <a href="/en/blog/how-vpn-changes-your-ip">how a VPN changes your IP</a>.</li>
<li><strong>Stale database:</strong> when an ISP gets a new block, it takes weeks to appear correctly in global databases.</li>
</ul>
<p>If you need an accurate position, use the "use my precise location" button on the home page. It uses your browser's GPS and sends nothing to the server.</p>

<h2>My IP keeps changing — is that normal?</h2>
<p>Yes. Most home and mobile connections use a <a href="/en/blog/static-vs-dynamic-ip">dynamic IP</a> that changes on a modem restart or on a schedule. If you need a fixed address for a camera or remote access, see <a href="/en/blog/get-static-ip-iran">how to get a static IP from your ISP</a>.</p>

<h2>Key takeaways</h2>
<ul>
<li>The address at the top is your public IP; your router's address is private and different.</li>
<li>Country and city are estimates and are often imprecise behind CGNAT.</li>
<li>If a VPN is on, every detail describes the VPN server, not you.</li>
<li>A home IP changing regularly is completely normal.</li>
</ul>
HTML;
