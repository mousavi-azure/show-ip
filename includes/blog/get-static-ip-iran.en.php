<?php
declare(strict_types=1);
return <<<'HTML'
<p>If you want to reach a security camera, DVR, home PC or server from outside your house, you usually need a <strong>static, public IP address</strong>. This guide walks through how to get one and set it up.</p>

<h2>First, find out what kind of IP you have now</h2>
<h3 id="step-1">1) Check your current IP type</h3>
<p>Open the <a href="/en">Show-IP.ir home page</a> and note the public IP. Then open your router panel and check the WAN IP. Three cases:</p>
<ul>
<li><strong>They match and stay the same:</strong> you already have a public IP.</li>
<li><strong>They match but change over time:</strong> you have a public but <a href="/en/blog/static-vs-dynamic-ip">dynamic</a> IP.</li>
<li><strong>They differ (WAN is something like <code>100.64.x.x</code>):</strong> you are behind carrier NAT (CGNAT) and cannot open ports without an extra service.</li>
</ul>

<h2>Getting a static IP from your ISP</h2>
<h3 id="step-2">2) Contact your ISP</h3>
<p>Ask for a "static IP" or "valid / public IP" add-on. Providers use different words for it, and on fixed lines (DSL, fibre) it is usually sold as a monthly extra, while on mobile data it is often only available on business contracts.</p>

<h3 id="step-3">3) Pick the right plan</h3>
<p>For a camera or remote desktop, a static IP on a wired line (DSL/VDSL/fibre) is the most stable option. Fixed-wireless and LTE quality varies with coverage. A static IP on a mobile SIM is the least reliable.</p>

<h2>Configure and test</h2>
<h3 id="step-4">4) Set up the router and port forwarding</h3>
<p>Once the static IP is active, open <em>Port Forwarding / Virtual Server</em> in the router and forward the port you need to the target device's internal IP (for example <code>554</code> or <code>8000</code> for a DVR, or <code>3389</code> for Remote Desktop). Prefer a non-default external port.</p>

<h3 id="step-5">5) Test from outside the network</h3>
<p>Using mobile data (not the same Wi-Fi), open <code>http://your-static-ip:port</code>. If it responds, the setup is correct. To avoid memorising the number, use a <strong>DDNS</strong> service.</p>

<h2>What if the ISP will not give you a static IP?</h2>
<p>The alternative is a small VPS with a static IP and a reverse tunnel: your device connects out to the server, and you reach the device through the server. This bypasses CGNAT without needing an open port on the home line.</p>

<h2>Key takeaways</h2>
<ul>
<li>Compare the site's IP with your router WAN IP to see whether you are behind CGNAT.</li>
<li>Ask for a "static IP" or "valid/public IP" add-on.</li>
<li>The most stable static IPs are on wired lines.</li>
<li>After getting the IP, set up port forwarding on a non-default port.</li>
<li>If a static IP is not possible, a reverse tunnel through a VPS is a solid alternative.</li>
</ul>
HTML;
