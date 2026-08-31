<?php
declare(strict_types=1);
return <<<'HTML'
<p>در مک هم مثل هر سیستم‌عامل دیگری، آی‌پی محلی (داخل شبکه) با آی‌پی عمومی (دیده‌شده توسط اینترنت) فرق دارد. در ادامه هر دو روش — از تنظیمات و از ترمینال — را می‌بینید.</p>

<h2>پیدا کردن آی‌پی عمومی</h2>
<p>سریع‌ترین راه، بازکردن <a href="/">صفحه اصلی Show-IP.ir</a> در Safari یا هر مرورگر دیگری روی مک شماست — آدرس IP عمومی، کشور، شهر و ISP بلافاصله نمایش داده می‌شود.</p>

<h2>پیدا کردن آی‌پی محلی از طریق System Settings</h2>
<ol>
<li><strong>System Settings</strong> (یا <strong>System Preferences</strong> در نسخه‌های قدیمی‌تر macOS) را باز کنید.</li>
<li>روی <strong>Network</strong> کلیک کنید.</li>
<li>شبکه متصل‌شده (Wi-Fi یا Ethernet) را انتخاب کنید؛ آدرس IP محلی شما در همان صفحه نمایش داده می‌شود.</li>
<li>برای جزئیات بیشتر می‌توانید روی <strong>Details…</strong> کلیک کنید.</li>
</ol>

<h2>پیدا کردن آی‌پی محلی از طریق ترمینال</h2>
<p>برنامه Terminal را باز کنید (از Spotlight با جست‌وجوی «Terminal») و یکی از دستورات زیر را وارد کنید:</p>
<blockquote>ipconfig getifaddr en0</blockquote>
<p>این دستور آی‌پی محلی مربوط به Wi-Fi را نشان می‌دهد. اگر از کابل شبکه (Ethernet) استفاده می‌کنید، معمولاً باید <code>en0</code> را با <code>en1</code> جایگزین کنید. راه دیگر:</p>
<blockquote>ifconfig | grep "inet "</blockquote>

<h2>نکات کلیدی</h2>
<ul>
<li>سریع‌ترین راه دیدن آی‌پی عمومی: بازکردن <a href="/">Show-IP.ir</a>.</li>
<li>آی‌پی محلی از مسیر System Settings → Network قابل‌مشاهده است.</li>
<li>از ترمینال هم می‌توانید با <code>ipconfig getifaddr en0</code> آی‌پی محلی را ببینید.</li>
</ul>
HTML;
