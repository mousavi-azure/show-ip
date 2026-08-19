<?php
declare(strict_types=1);
return <<<'HTML'
<p>If you've ever looked at an IP address, it probably looked something like <code>203.0.113.42</code> — that's an <strong>IPv4</strong> address. But the internet is gradually moving to a newer generation called <strong>IPv6</strong>. Here's what's different, and why the change is happening at all.</p>

<h2>What is IPv4?</h2>
<p>IPv4 is made of four number blocks between 0 and 255, separated by dots (like <code>192.168.1.10</code>). That structure provides about <strong>4.3 billion</strong> unique addresses — a number that seemed enormous in the 1980s, but has effectively run out given the explosive growth of mobile devices, smart gadgets, and IoT.</p>

<h2>What is IPv6?</h2>
<p>IPv6 was designed to solve exactly that shortage. It uses eight groups of four hexadecimal digits, like:</p>
<blockquote>2001:0db8:85a3:0000:0000:8a2e:0370:7334</blockquote>
<p>That structure provides roughly <strong>340 undecillion</strong> addresses — enough to assign several unique IPv6 addresses to every grain of sand on Earth.</p>

<h2>Key differences</h2>
<table>
<tr><th>Feature</th><th>IPv4</th><th>IPv6</th></tr>
<tr><td>Address length</td><td>32 bits</td><td>128 bits</td></tr>
<tr><td>Format</td><td>Dotted decimal (192.168.1.1)</td><td>Colon-separated hex (2001:db8::1)</td></tr>
<tr><td>Address count</td><td>~4.3 billion</td><td>Effectively unlimited</td></tr>
<tr><td>NAT (address sharing)</td><td>Usually required</td><td>Usually unnecessary</td></tr>
<tr><td>Support today</td><td>Universal</td><td>Growing, not yet universal</td></tr>
</table>

<h2>Why hasn't everyone switched to IPv6 yet?</h2>
<p>A full migration to IPv6 requires updating routers, ISPs, servers, and legacy software — a process that's been underway for years and still isn't finished. To bridge the gap, most networks rely on <strong>NAT</strong> (Network Address Translation) so multiple devices can share one public IPv4 address, which we explain in <a href="/en/blog/private-vs-public-ip">Private vs Public IP</a>.</p>

<h2>Which one am I using?</h2>
<p>Today, many connections use both at once (called dual-stack). To see exactly which address your current device or connection is getting, open the <a href="/en">Show-IP.ir homepage</a> — your current IP address shows up immediately along with full network details.</p>

<h2>Key takeaways</h2>
<ul>
<li>IPv4 is older, more common, and limited to about 4.3 billion addresses.</li>
<li>IPv6 is newer and effectively never runs out of addresses.</li>
<li>Most networks today run both simultaneously (dual-stack).</li>
<li>NAT is what lets IPv4 networks keep working despite the address shortage.</li>
</ul>
HTML;
