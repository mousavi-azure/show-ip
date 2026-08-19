<?php
declare(strict_types=1);
return <<<'HTML'
<p>On a Mac, just like any other OS, your local IP (inside your network) is different from your public IP (what the internet sees). Here are both methods — through Settings and through the Terminal.</p>

<h2>Finding your public IP</h2>
<p>The fastest way is to open the <a href="/en">Show-IP.ir homepage</a> in Safari or any other browser on your Mac — your public IP address, country, city, and ISP show up instantly.</p>

<h2>Finding your local IP via System Settings</h2>
<ol>
<li>Open <strong>System Settings</strong> (or <strong>System Preferences</strong> on older versions of macOS).</li>
<li>Click <strong>Network</strong>.</li>
<li>Select your connected network (Wi-Fi or Ethernet); your local IP address appears right on that screen.</li>
<li>Click <strong>Details…</strong> for more information.</li>
</ol>

<h2>Finding your local IP via Terminal</h2>
<p>Open the Terminal app (search "Terminal" in Spotlight) and run:</p>
<blockquote>ipconfig getifaddr en0</blockquote>
<p>That shows your Wi-Fi local IP. If you're on Ethernet, you may need to replace <code>en0</code> with <code>en1</code>. Alternatively:</p>
<blockquote>ifconfig | grep "inet "</blockquote>

<h2>Key takeaways</h2>
<ul>
<li>The fastest way to see your public IP: open <a href="/en">Show-IP.ir</a>.</li>
<li>Your local IP is visible under System Settings → Network.</li>
<li>From the Terminal, <code>ipconfig getifaddr en0</code> shows your local IP too.</li>
</ul>
HTML;
