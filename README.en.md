[فارسی](README.md) · English

# Show-IP.ir

**Your IP, your location, your network — on one page, with no server involved except your own.**

![PHP](https://img.shields.io/badge/PHP-8.1%2B-777BB4?logo=php&logoColor=white)
![No Framework](https://img.shields.io/badge/framework-none-2e7d32)
![No External JS](https://img.shields.io/badge/external%20JS%20libs-zero-2e7d32)
![Bilingual](https://img.shields.io/badge/language-فارسی%20%7C%20English-4f46e5)
![Self--hosted Map](https://img.shields.io/badge/map-self--hosted-0d9488)
![Live](https://img.shields.io/badge/live%20demo-show--ip.ir-0d9488)

Show-IP.ir is a lightweight, framework-free (plain PHP) web tool that shows your public IP address, geographic location, network/ISP details, and connection security status (VPN/proxy/Tor), plus a free subnet calculator. The goal is simple: everything sites like `whatismyip.com` or `ifconfig.me` show you — but **faster, more private, and without depending on any external service that might be slow or blocked for a given visitor.**

## Why this project is different

Most IP-lookup tools embed the location map through an iframe pointed at OpenStreetMap or Google Maps. For a meaningful slice of the world's internet users — including Iranian visitors, who inspired this project — that iframe frequently just... doesn't load, because those services are often slow or outright blocked for certain regions due to sanctions or filtering.

Show-IP.ir solves this by **fully self-hosting the world map** on the same server as the app: a single optimized SVG file, with zero network requests to any external map service. The marker position is calculated with a simple equirectangular projection formula from latitude/longitude and rendered directly — it keeps working even when everything else is filtered.

## Features

### Core
- **Full IP & network lookup**: country, city, ISP, ASN, network route, time zone, currency and language — via [ipdata.co](https://ipdata.co).
- **Connection security check**: Tor, proxy, datacenter/VPN, iCloud Private Relay, known attacker/abuser detection.
- **Subnet calculator**: network address, broadcast address, first/last usable host, total addresses and usable hosts — from an IPv4 address plus a subnet mask or CIDR.
- **CLI/API mode**: exactly like `ifconfig.me` — `curl show-ip.ir` returns your IP as plain text, `curl show-ip.ir/json` returns everything as JSON.

### Map & privacy
- **Fully self-hosted map**: no iframe, no external tiles, no requests to OpenStreetMap or anything like it. Calibrated and verified against dozens of real cities worldwide.
- **Precise location, opt-in**: the "Use my precise location" button uses the browser's own `navigator.geolocation` — those coordinates are only ever rendered on the map inside your own browser, never sent to or stored on any server.
- No tracking cookies, no third-party analytics, no user data storage.

### Experience
- **Automatic time-of-day theme**: light before 6pm, dark after — unless the visitor manually toggles it, which is then remembered in `localStorage`.
- **Genuinely bilingual (Persian/English)**: Persian is the default at `/`; a fully translated English version lives at `/en` and `/en/faq`, hand-written (not machine-translated) for every string and every FAQ answer.
- Responsive design, zero external CSS/JS libraries — the Vazirmatn font and every icon are served locally.

### SEO
- Separate `hreflang` (`fa-IR`, `en`, `x-default`) and `canonical` tags per language.
- Schema.org structured data (`WebSite`, `WebApplication`, `FAQPage`, `BreadcrumbList`) with the correct `inLanguage`.
- `sitemap.xml` with cross-linked `hreflang` entries between the Persian and English version of each page.
- Fully translated titles, meta descriptions, and OG/Twitter tags — not just the UI.

## Requirements

- PHP 8.1+ (no extensions required besides `curl`)
- Apache with `mod_rewrite` (for clean URLs like `/faq`, `/en`, `/en/faq`, `/ip`, `/json`) — optional; without it the site still works via `?lang=en&format=json` and similar query params.

## Getting started

```bash
git clone https://github.com/mousavi-azure/show-ip.git
cd show-ip
cp .env.sample .env   # then add your API_KEY from ipdata.co
php -S localhost:8000
```

Open `http://localhost:8000` in your browser.

## Project structure

```
index.php                  Home page (IP lookup + calculator)
faq.php                    FAQ page
ip_calculator.php          AJAX endpoint for the subnet calculator (bilingual)

includes/
  config.php                 .env loading and app constants
  helpers.php                  Helpers: HTML escaping, client IP detection, language detection, translation
  ipdata.php                     ipdata.co API client
  icons.php                       Local SVG icons (no Font Awesome)
  i18n.fa.php / i18n.en.php        Persian / English UI translation strings
  faq.fa.php / faq.en.php            FAQ content in both languages

assets/
  css/site.css                Full stylesheet (light/dark theme)
  js/site.js                    Client-side logic: map, calculator, theme, copy, clock, geolocation
  img/world-map.svg              Self-hosted world map (see below)
  fonts/                          Vazirmatn font (woff2, self-hosted)
```

## About the local map

`assets/img/world-map.svg` is a compressed (via svgo, ~1.3MB down to roughly 300KB gzipped) version of [BlankMap-World-Equirectangular.svg](https://commons.wikimedia.org/wiki/File:BlankMap-World-Equirectangular.svg) from Wikimedia Commons — by John Harvey, based on CIA World Factbook material, released into the public domain/CC0.

Each point's position is computed with a simple linear (equirectangular) projection from latitude/longitude and placed as a percentage over the image — no map library required:

```
left% = (longitude + 180) / 360 * 100
top%  = (90 - latitude) / 180 * 100
```

This formula has been tested and verified against more than 20 real-world cities, from Tehran and Mashhad to Sydney and Anchorage.

## Environment variables (`.env`)

| Variable | Description |
|---|---|
| `API_KEY` | API key from [ipdata.co](https://ipdata.co) (required) |
| `APP_NAME`, `APP_URL`, `APP_AUTHOR`, `APP_AUTHOR_URL` | Site metadata (optional) |
| `IPDATA_VERIFY_SSL` | Verify the SSL certificate when calling the API (default `true`) |
| `IPDATA_TIMEOUT` | API request timeout in seconds (default `15`) |

## Project philosophy

No Composer, no `vendor/`, no external JS or CSS libraries, no CDN-hosted fonts or icons. Everything the site needs to render a complete page lives in this repository. That means a faster install, a smaller attack surface, and a page that keeps working even with zero connectivity to any third party other than ipdata.co itself for IP data.

## Contributing

Fork it, make your changes on a new branch, and open a pull request.

## License

The project's code is currently released without a formal open-source license; all rights are reserved by [Mostafa Mousavi](https://mousavi.dev).

---

Crafted with ❤ by <a href="https://mousavi.dev">Mostafa Mousavi</a>
