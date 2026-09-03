# Changelog

All notable changes to this project are documented in this file.
Format loosely follows [Keep a Changelog](https://keepachangelog.com/), and this project uses [Semantic Versioning](https://semver.org/).

## [Unreleased]

### Added
- **API-key pool with automatic failover** (`includes/ipdata.php`, `includes/config.php`): `IPDATA_API_KEYS` accepts a comma/space-separated list of ipdata.co keys. `fetchIpDataMulti()` rotates to the next key instantly when one is rejected for quota/auth/rate-limit reasons (403/401/429 or a "quota exceeded" message). The legacy single `API_KEY` / `IPDATA_API_KEY` is still honored and merged into the pool.
- **On-disk IP-lookup cache** (`fetchIpDataCached()`, `.cache/ipdata/`, gitignored): each IP is cached for `IPDATA_CACHE_TTL` seconds (default 1800). Repeat visits are served in ~3 ms and consume zero API quota. `.htaccess` blocks direct access to `.cache`, `.env`, `.git`.
- **4 new bilingual blog articles** targeting high-intent Persian search queries: "آی‌پی من چیست" + reading the lookup result, getting a static IP from Iranian ISPs (with `HowTo` rich-result schema), reducing ping in online games, and checking/fixing IP blacklisting.
- **Blog SEO**: `article:published_time` / `article:modified_time` / `article:author` / `article:section` / `article:tag` OG tags, `og:locale:alternate`, `twitter:*` tags, optional per-article `keywords` meta, `Article` JSON-LD enriched with `dateModified`, `articleSection`, `keywords`, `wordCount`, `ImageObject`; opt-in `HowTo` JSON-LD for step-by-step guides.
- Jalali (Shamsi) publish/update dates with Persian digits on the Persian blog (`jalaliDate()`, `displayDate()` in `includes/helpers.php`); dates now also shown on blog listing cards.
- `blog-meta.*.php` entries support optional `modified`, `keywords`, `section`, `howto` keys; `sitemap.php` uses `modified ?? date` for `lastmod`.
- `content-visibility:auto` on below-the-fold sections and a `prefers-reduced-motion` block in `site.css`.
- Dynamic XML sitemap (`sitemap.php`, served at `/sitemap.xml` via `.htaccess` rewrite): built from the `includes/blog-meta.*.php` registry so new articles and updated dates appear automatically instead of being hand-maintained. Emits reciprocal `hreflang` (`fa-IR`, `fa`, `en`, `x-default`) per URL. The static `sitemap.xml` file was removed.
- Custom styled 404 page (`404.php`, wired via `ErrorDocument 404`): bilingual, `noindex, follow`, with links back to home/blog/FAQ. The local dev router serves the same page for unknown paths.
- Canonical-host redirect in `.htaccess`: `www.show-ip.ir` → `show-ip.ir` (301) to avoid duplicate-content signals.
- `Strict-Transport-Security` (HSTS) response header, now that HTTPS is consistently enforced.
- `X-Robots-Tag: noindex` header on the `/ip` and `/json` API responses (belt-and-braces alongside the existing `robots.txt` disallow).
- `hreflang="fa"` alternate (in addition to `fa-IR`) on the home, FAQ, and blog pages, covering Persian speakers outside Iran.
- Persian display names for API-returned geo values (`includes/geo-fa.php`): country names (all ISO 3166-1 codes) and continent names always localize on the Persian site; region/city localize for all 31 Iranian provinces, ~100 Iranian cities, and ~80 common world/VPN-hub cities — e.g. `Tehran` now renders as `تهران` instead of passing the API's English string straight through. Falls back to the original English value when no translation is known.
- Blog system (`blog.php`, `includes/blog/`, `includes/blog-meta.*.php`): 15 bilingual articles on IP/networking fundamentals, per-OS "find your IP" guides, and Iran-specific practical guides, cross-linked from the homepage, FAQ, and each other.
- RSS feed (`/feed`, `/en/feed` — `rss.php`) for the blog, with `<link rel="alternate" type="application/rss+xml">` discovery tags.
- Security-check summary: a CSS-only donut ring showing checks-passed alongside a plain-language sentence, and hover tooltips explaining what each threat flag (Tor, proxy, datacenter/VPN, etc.) actually means.
- Subtle ambient background gradient and a pulsing ring on the IP badge icon.
- `code-chip` styling for short technical codes (country code, ASN) shown next to their translated labels.

### Fixed
- `.htaccess` had no rewrite rules for `/blog`, `/blog/{slug}`, `/en/blog`, or `/en/blog/{slug}` — every blog link on the site, and every blog URL already listed in `sitemap.xml`, 404'd on a real Apache server.
- `robots.txt` now disallows the plain-text `/ip` and `/json` API endpoints so they aren't crawled/indexed as thin duplicate content.

### Changed
- Preload `Vazirmatn-Regular` (body text) alongside `Vazirmatn-Bold` instead of `Vazirmatn-Black`, so the most-used weight is available on first paint.
- The 780 KB self-hosted world map now loads with `decoding="async" fetchpriority="low"` so it never competes with above-the-fold content.

## [1.0.0] — 2026-07-24

First tagged release. The project was rebuilt from a working prototype into a complete, bilingual, privacy-focused IP lookup tool.

### Added
- Full English translation of the entire site (`/en`, `/en/faq`), hand-written per string and per FAQ answer — Persian (`/`) remains the default.
- `hreflang` (`fa-IR`, `en`, `x-default`) and per-language `canonical` tags, translated meta/OG/Twitter tags, per-language JSON-LD, and a `sitemap.xml` with cross-linked language entries.
- Fully self-hosted world map (SVG) replacing the OpenStreetMap iframe embed, which was frequently slow or blocked for Iranian visitors. Marker position is computed from latitude/longitude with a simple equirectangular projection, verified against 20+ real-world cities.
- Opt-in precise geolocation via `navigator.geolocation` — coordinates are rendered client-side only and never sent to any server.
- Automatic light/dark theme based on the visitor's local time (light 6am–6pm, dark otherwise), overridable via a manual toggle persisted in `localStorage`.
- Bilingual error messages in the subnet calculator backend (`ip_calculator.php`).
- New OG share images (`og-image.png`, `og-image-en.png`) matching the redesigned UI, rendered from the site's own brand assets and fonts.
- `APP_VERSION` constant, shown in the footer and in the `WebApplication` JSON-LD (`softwareVersion`).
- `CHANGELOG.md` and a bilingual `README.md` / `README.en.md`.

### Changed
- Complete UI redesign: replaced the dark neon "cyber" theme with a clean, light-first UI (indigo/teal accent, matching the existing logo), with an optional dark theme.
- Simplified environment loading: removed the `vlucas/phpdotenv` Composer dependency in favor of a small built-in `.env` parser — no more `vendor/`, `composer.json`, or `composer.lock`.

### Fixed
- World map marker misalignment caused by a mismatch between the map SVG's declared `width`/`height` and its internal `viewBox`, which made browsers silently letterbox the map content and shift every marker off its true position.
- Language detection now also reads the `/en` URL path directly (not just the `lang` query parameter), so it keeps working even on servers where the `.htaccess` rewrite rules for `/en` aren't applied.
- `faq.php` previously loaded no client-side JavaScript at all, so it had no working theme toggle; it's now consistent with the home page.

### Removed
- Dead files: `functions.php` (unused duplicate of `includes/helpers.php`), root-level `site.css`/`site.js` (unused duplicates of the `assets/` versions), `Dockerfile`.
