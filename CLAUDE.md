# Project Context

**Asian Caucasian** — WordPress theme for [asiancaucasianmusic.com](https://asiancaucasianmusic.com).

## Stack

- WordPress 7.0 on AlmaLinux 9 / Nginx 1.20 / PHP-FPM 8.1 / MySQL 8 (Liquid Web VPS, InterWorx).
- Auto-update enabled for core, plugins, themes, translations (see `wp-config.php`).
- Let's Encrypt SSL via certbot (auto-renewing).
- Plugins: Rank Math SEO, Wordfence (both auto-updating).

## Repo = WordPress theme

This repo is mounted on the server at `wp-content/themes/asian-caucasian/`. The legacy static site (`index.html`, `images/`, `music/`) is preserved under `legacy/` for reference.

## Deploy

```bash
ssh root@67.225.160.82
cd /home/asian/asiancaucasianmusic.com/html/wp-content/themes/asian-caucasian
git pull
```

WordPress core + plugins update themselves; only theme changes ship through git.

## Editing content

Most content is editable in `wp-admin` — Matt does not need to touch code. See [README.md](README.md) for the content model (Tracks CPT, Members CPT, Theme Customizer, Pages).

## Where credentials live

Server-side `/root/wp-asiancaucasian-creds.txt` (0600) holds the DB and WP admin credentials. Retrieve once, store in a password manager, then consider removing from the server.

<!-- IJFW-MEMORY-START (managed -- do not edit manually) -->
<!-- IJFW-MEMORY-END -->
