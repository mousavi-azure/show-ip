<?php
declare(strict_types=1);
return <<<'HTML'
<p>On an Android phone, there's a difference between your local Wi-Fi IP and the public IP the internet sees. You can find both in under a minute.</p>

<h2>Finding your public IP</h2>
<p>Open your phone's browser (Chrome or any other) and go to <a href="/en">Show-IP.ir</a> — your public IP address, country, city, carrier, and even your location on the map show up instantly.</p>

<h2>Finding your local Wi-Fi IP</h2>
<p>The exact path varies slightly by Android version and phone manufacturer (Samsung, Xiaomi, Pixel, etc.), but the general steps are:</p>
<ol>
<li>Open <strong>Settings</strong>.</li>
<li>Go to <strong>Wi-Fi</strong> or <strong>Network &amp; Internet</strong>.</li>
<li>Tap your connected Wi-Fi network (you may need to tap the gear icon or the (i) next to the network name).</li>
<li>In the details, look for <strong>IP address</strong> — that's your phone's local IP.</li>
</ol>

<h2>Alternative: About Phone</h2>
<p>On some phones, you can also see the current IP address under <strong>Settings → About Phone → Status</strong> (or Status information).</p>

<h2>Why is this different from the IP shown on Show-IP.ir?</h2>
<p>Your Wi-Fi IP only means something inside your home or office network, while Show-IP.ir shows your public IP — the address the entire internet sees. The full explanation is in <a href="/en/blog/private-vs-public-ip">Private vs Public IP</a>.</p>

<h2>Key takeaways</h2>
<ul>
<li>Public IP: open <a href="/en">Show-IP.ir</a> in your phone's browser.</li>
<li>Local Wi-Fi IP: Settings → Wi-Fi → tap the connected network.</li>
</ul>
HTML;
