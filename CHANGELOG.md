# Changelog

All notable changes to this project are documented in this file.
Format loosely follows [Keep a Changelog](https://keepachangelog.com/), and this project uses [Semantic Versioning](https://semver.org/).

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
