<?php
declare(strict_types=1);
return <<<'HTML'
<p>در لینوکس، مثل هر سیستم‌عامل دیگری، بین آی‌پی محلی (داخل شبکه) و آی‌پی عمومی (دیده‌شده توسط اینترنت) تفاوت وجود دارد. در ادامه دستورات ترمینال برای هر دو را می‌بینید.</p>

<h2>پیدا کردن آی‌پی عمومی</h2>
<p>ساده‌ترین راه، بازکردن <a href="/">صفحه اصلی Show-IP.ir</a> در مرورگر است. اگر روی یک سرور بدون رابط گرافیکی کار می‌کنید، همین سایت از خط فرمان هم قابل‌استفاده است — دقیقاً مثل ifconfig.me:</p>
<blockquote>curl show-ip.ir</blockquote>
<p>این دستور بلافاصله آدرس IP عمومی سرور شما را به‌صورت متن ساده برمی‌گرداند. برای دریافت جزئیات کامل به‌صورت JSON:</p>
<blockquote>curl show-ip.ir/json</blockquote>

<h2>پیدا کردن آی‌پی محلی با دستور ip</h2>
<p>در توزیع‌های مدرن لینوکس (اوبونتو، دبیان، فدورا، آرچ)، دستور استاندارد <code>ip</code> است:</p>
<blockquote>ip addr show</blockquote>
<p>یا خلاصه‌تر:</p>
<blockquote>ip -4 addr show | grep inet</blockquote>
<p>آدرس مقابل رابط شبکه فعال (معمولاً <code>eth0</code>، <code>wlan0</code> یا <code>enpXsY</code>) همان آی‌پی محلی شماست.</p>

<h2>روش قدیمی‌تر: ifconfig</h2>
<p>در توزیع‌های قدیمی‌تر یا در صورت نصب‌بودن پکیج <code>net-tools</code>، می‌توانید از دستور زیر هم استفاده کنید:</p>
<blockquote>ifconfig</blockquote>

<h2>دستور hostname</h2>
<p>یک راه سریع دیگر برای دیدن آی‌پی محلی:</p>
<blockquote>hostname -I</blockquote>

<h2>نکات کلیدی</h2>
<ul>
<li>برای آی‌پی عمومی از سرور: <code>curl show-ip.ir</code></li>
<li>برای آی‌پی محلی: <code>ip addr show</code> یا <code>hostname -I</code></li>
<li>برای جزئیات کامل به‌صورت JSON: <code>curl show-ip.ir/json</code></li>
</ul>
HTML;
