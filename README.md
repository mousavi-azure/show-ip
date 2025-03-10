# IP & Location Information Web Application

این پروژه یک اپلیکیشن وب است که اطلاعات مربوط به IP کاربر را نمایش می‌دهد و به کاربران این امکان را می‌دهد که جزئیات شبکه و اطلاعات مربوط به آدرس IP و Subnet خود را تحلیل کنند.

## ویژگی‌ها

- **نمایش اطلاعات IP کاربر**: با استفاده از آدرس IP کاربر، موقعیت جغرافیایی آن را شبیه‌سازی کرده و اطلاعات مربوط به کشور، شهر و ISP آن را نمایش می‌دهد.
- **ابزار تحلیل آدرس IP و Subnet**: ابزارهای مختلفی برای تجزیه و تحلیل آدرس‌های IP و Subnet Mask شامل محاسبه آدرس شبکه، آدرس پخش، اولین و آخرین IP قابل استفاده در Subnet و تعداد میزبان‌ها فراهم می‌کند.
- **رابط کاربری ساده و زیبا**: با طراحی کاربرپسند، کاربران می‌توانند به راحتی آدرس IP خود را وارد کرده و نتایج آن را مشاهده کنند.

## پیش‌نیازها

- **PHP 8.1** یا بالاتر
- **Apache** به همراه ماژول‌های لازم (mod_rewrite)
- **Docker** (اختیاری: برای اجرای پروژه در کانتینر)

## نصب پروژه

برای استفاده از این پروژه، می‌توانید مراحل زیر را دنبال کنید:

### 1. کلون کردن مخزن پروژه

```bash
git clone https://github.com/mousavi-azure/show-ip.git
cd show-ip

composer install
یا
docker-compose up
```

## مشارکت در پروژه

ما از مشارکت شما در این پروژه خوشحال خواهیم شد! اگر می‌خواهید به این پروژه کمک کنید، لطفاً مراحل زیر را دنبال کنید:

1. **فورک کردن پروژه**: ابتدا پروژه را فورک کرده و یک نسخه از آن را به حساب GitHub خود اضافه کنید.
2. **ایجاد تغییرات**: تغییرات و بهبودهای خود را در نسخه فورک شده انجام دهید. از کدنویسی تمیز و بهترین شیوه‌ها پیروی کنید.
3. **ایجاد Pull Request**: پس از اعمال تغییرات، یک Pull Request از شاخه خود به شاخه اصلی پروژه ارسال کنید.
4. **انتظار برای بازخورد**: تیم پروژه تغییرات شما را بررسی کرده و بازخورد لازم را ارائه خواهد داد. در صورت لزوم، اصلاحات اضافی را انجام دهید تا تغییرات شما پذیرفته شوند.

ما به هر گونه پیشنهاد و کمک شما خوش‌آمد می‌گوییم و امیدواریم با همکاری شما این پروژه را بهبود دهیم.

