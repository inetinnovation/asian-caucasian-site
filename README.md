# Asian Caucasian — WordPress Theme

Custom theme for [asiancaucasianmusic.com](https://asiancaucasianmusic.com), an Indianapolis pop trio. Single-page layout (hero / about / music player / members / contact) with WordPress as the CMS.

## Architecture

- **Theme root = repo root.** `style.css`, `functions.php`, `header.php`, `footer.php`, `front-page.php`, etc.
- **Real CSS** in `assets/css/main.css` (enqueued from `inc/enqueue.php`). `style.css` is just the WP theme-header registration file.
- **JS** in `assets/js/main.js`. Tracks data is injected via `wp_localize_script` (`window.acTracks`, `window.acAlbumNames`).
- **Sections** are `template-parts/*.php` — each section's markup lives in its own file.
- **Includes** in `inc/`: `enqueue.php`, `cpt-track.php`, `cpt-member.php`, `customizer.php`, `seo-aeo.php`.
- **Legacy static site** preserved under `legacy/` for reference and rollback.

## Content model (editable in `wp-admin`)

| Section | Where to edit |
|---|---|
| Tracks (audio player) | `wp-admin` → **Tracks** (custom post type). Each track has a title, Album taxonomy, and an Audio File URL (Media Library picker). |
| Albums (filter tabs) | `wp-admin` → **Tracks** → **Albums** (taxonomy). |
| Band members | `wp-admin` → **Members** (CPT). Title = name, Featured Image = avatar, Excerpt = bio, "Role" meta box. |
| Hero copy + album thumbnails | `wp-admin` → **Appearance** → **Customize** → **Hero Section**. |
| About body + stats cards | Customize → **About Section**. |
| Marquee strips | Customize → **Marquees** (pipe-separated list). |
| Contact info | Customize → **Contact Section**. |
| Footer | Customize → **Footer**. |

## SEO + AEO

- **Rank Math** plugin handles meta tags, sitemap, robots, and Article schema.
- **Theme** adds `MusicGroup` / `MusicAlbum` / `Person` JSON-LD on the front page (`inc/seo-aeo.php`).
- **`/llms.txt`** route is served by the theme — a citable plain-text summary for AI engines.

## Deploy

The theme lives at `wp-content/themes/asian-caucasian/` on the VPS as a git checkout of this repo.

```bash
ssh root@<server>
cd /home/asian/asiancaucasianmusic.com/html/wp-content/themes/asian-caucasian
git pull
```

WordPress core, plugins, and translations auto-update via WP-CLI / wp-cron (configured in `wp-config.php`).

## Stack

- AlmaLinux 9, Nginx, PHP-FPM 8.1, MySQL 8 (Liquid Web VPS, InterWorx panel)
- WordPress 7.0 (auto-update enabled — core, plugins, themes, translations)
- Rank Math SEO, Wordfence Security
- Let's Encrypt SSL via certbot (auto-renewing)
