<?php
declare(strict_types=1);
return <<<'HTML'
<p>Every time your phone or computer connects to the internet, it's given a unique numeric label called an <strong>IP address</strong> (Internet Protocol address). It does exactly what a postal address does for your house: it tells every other device on the internet exactly where to send data so it reaches you.</p>

<p>Without an IP address, no website would know where to send your search results, and no server would know which device to answer.</p>

<h2>What does an IP address actually look like?</h2>
<p>The most common type you deal with today is <strong>IPv4</strong>, written as four numbers between 0 and 255 separated by dots, for example:</p>
<blockquote>203.0.113.42</blockquote>
<p>A newer version called <strong>IPv6</strong> also exists, covering a vastly larger address space and written as groups of numbers and letters. We cover the differences in full in <a href="/en/blog/ipv4-vs-ipv6">IPv4 vs IPv6</a>.</p>

<h2>Where does your IP address come from?</h2>
<p>When you connect to the internet — over mobile data, home Wi-Fi, or at the office — your internet service provider (ISP) assigns your connection a public IP address. That's the address every website you visit actually sees. Meanwhile, every device inside your home or office network (router, laptop, printer) also has a private IP address that only means something inside that local network. We explain the difference in <a href="/en/blog/private-vs-public-ip">Private vs Public IP</a>.</p>

<h2>Does your IP address ever change?</h2>
<p>Not necessarily. Most ISPs assign IP addresses dynamically, meaning yours might change when you restart your router or after a few days. Some services and servers instead use a static IP that never changes. The full breakdown is in <a href="/en/blog/static-vs-dynamic-ip">Static vs Dynamic IP</a>.</p>

<h2>Why does my IP address reveal my location?</h2>
<p>Blocks of IP addresses are allocated to ISPs and regions and recorded in public databases. That's how a service like this one can estimate your country, city, and ISP from your IP address with reasonably good accuracy — though not GPS-level precision.</p>

<h2>How do I check my current IP address?</h2>
<p>The simplest way is to open the <a href="/en">Show-IP.ir homepage</a> — your public IP address, country, city, ISP, and even connection security status show up instantly, no installation required. If you're on a specific operating system and want to see your local (in-network) IP too, check the platform-specific guide: <a href="/en/blog/find-ip-address-windows">Windows</a>, <a href="/en/blog/find-ip-address-mac">Mac</a>, <a href="/en/blog/find-ip-address-linux">Linux</a>, <a href="/en/blog/find-ip-address-android">Android</a>, and <a href="/en/blog/find-ip-address-iphone">iPhone</a>.</p>

<h2>Key takeaways</h2>
<ul>
<li>An IP address is the numeric identifier for any device on the internet — it works like a postal address for data.</li>
<li>There are two main versions: IPv4 (still the most common) and IPv6 (the newer generation with a much larger address space).</li>
<li>Every device has both a private IP address (inside its local network) and a public IP address (visible to the internet).</li>
<li>An IP address can be static or dynamic, depending on the ISP's or server's configuration.</li>
<li>Checking your current IP address takes seconds — just open the <a href="/en">homepage</a>.</li>
</ul>
HTML;
