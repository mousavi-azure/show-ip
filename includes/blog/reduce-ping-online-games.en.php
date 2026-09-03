<?php
declare(strict_types=1);
return <<<'HTML'
<p>Ping (latency) is the time it takes a packet to travel from your device to the game server and back, measured in milliseconds. Lower ping means a more responsive game. A fast download speed does not automatically mean low ping — what matters is the <strong>path and quality of the connection to the server</strong>.</p>

<h2>Why ping spikes</h2>
<ul>
<li><strong>Distance to the server:</strong> a server on another continent has a physical floor of 80–150&nbsp;ms no matter what you do.</li>
<li><strong>Poor routing:</strong> your traffic sometimes takes a longer path than the direct one.</li>
<li><strong>ISP congestion:</strong> at peak evening hours the same line's ping can double.</li>
<li><strong>Wi-Fi:</strong> wireless adds jitter and variance.</li>
<li><strong>Other devices:</strong> a download or upload on the same line raises game ping.</li>
</ul>

<h2>What actually lowers ping</h2>
<ol>
<li><strong>Wired instead of Wi-Fi:</strong> the single most effective step for most people. A direct Ethernet cable to the router almost eliminates jitter.</li>
<li><strong>The right server region:</strong> pick the nearest region manually in the game settings instead of leaving it on Auto.</li>
<li><strong>Free up bandwidth:</strong> pause Windows updates, downloads, cloud sync and streaming while playing. If your router has QoS, prioritise the gaming device.</li>
<li><strong>5&nbsp;GHz and close to the router:</strong> if you must use Wi-Fi, use the 5&nbsp;GHz band near the router.</li>
<li><strong>Try a few DNS resolvers:</strong> DNS does not change in-game ping, but it can speed up initial connection and matchmaking.</li>
<li><strong>A VPN only when it gives a better path:</strong> if your ISP's direct route to the server is bad, a VPN with good peering can cut ping — but if the direct route is fine, a VPN almost always makes ping worse. Compare before and after.</li>
</ol>

<h2>How to measure the route</h2>
<p>First check the <a href="/en">Show-IP.ir home page</a> to see your IP and ISP and whether a VPN is active. Then use <code>ping</code> and <code>tracert</code> (Windows) or <code>mtr</code> (Linux) to the game server address to find the hop where ping jumps. If the spike is inside your ISP's network, raise it with support; if it is after leaving the country, your only options are a closer server or a VPN with a better path.</p>

<h2>Realistic expectations</h2>
<p>Ping is bound by the speed of light in fibre, not your internet plan. For a server one continent away, expect roughly 70–120&nbsp;ms as "good" and under 50&nbsp;ms as essentially impossible.</p>

<h2>Key takeaways</h2>
<ul>
<li>Ping depends on route and connection quality, not just download speed.</li>
<li>An Ethernet cable and picking the nearest server manually have the biggest impact.</li>
<li>Cut other bandwidth use while playing.</li>
<li>Keep a VPN only if a before/after test shows it helps.</li>
<li>Use <code>tracert</code> to see whether the spike is local or after leaving the country.</li>
</ul>
HTML;
