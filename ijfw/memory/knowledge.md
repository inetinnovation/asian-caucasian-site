<!-- ijfw-schema: v1 -->
# Knowledge Base
---
type: decision
summary: Static single-file architecture (no build step)
stored: 2026-06-05T02:42:24.114Z
hash: 1cc27a913b8f
tags: [architecture, static-site, no-build, html]
---
<!-- hash:1cc27a913b8f -->
Site is a single index.html (~1528 lines) with inline &lt;style&gt; and &lt;script&gt;. No build step, no framework, no package manager, no node_modules. Assets live in images/ and music/. Fonts loaded from Google Fonts CDN.

**Why:** Small band marketing site with four content sections (about/music/members/contact) and no dynamic content. A build pipeline would be overhead. Inline keeps the entire site in one editable file.

**How to apply:** Do not propose React/Vite/Tailwind/bundlers unless explicitly asked. Edit index.html directly. Preserve the inline-CSS-then-inline-JS structure. New CSS goes in the existing &lt;style&gt; block; new JS goes in the existing &lt;script&gt; block near the bottom.
---
type: pattern
summary: Design tokens, typography, and scroll-reveal convention
stored: 2026-06-05T02:42:32.302Z
hash: e7904d6ac3f2
tags: [design-system, css-variables, typography, animation]
---
<!-- hash:e7904d6ac3f2 -->
CSS variables on :root — --bg #0a0a0c, --bg2 #111116, --bg3 #18181f, --accent #ff6b35, --accent2 #ffab76, --text #e8e8ee, --muted #7a7a8e, --border rgba(255,255,255,0.07). Fonts: Bebas Neue (--ff-display, used for headings/logo), Inter (--ff-body, body), JetBrains Mono (--ff-mono, nav links and section labels like "// About"). Scroll reveal: add class .reveal, .reveal-left, or .reveal-right plus optional .delay-1..4. An IntersectionObserver near line 1359 toggles .visible automatically.

**Why:** Established visual system used consistently across hero/about/music/members/contact sections. Reusing tokens and the reveal pattern keeps new work visually coherent without bespoke CSS.

**How to apply:** For new UI use the existing CSS variables — never hardcode colors. New animated elements should get a reveal* class; the observer wires them automatically. Section labels use the "// Label" pattern in JetBrains Mono.
---
type: decision
summary: Site content snapshot as of 2026-06-04 (commit b6571aa)
stored: 2026-06-05T02:42:41.600Z
hash: 9d90877ab508
tags: [project-state, content, site-structure]
---
<!-- hash:9d90877ab508 -->
Band: Asian Caucasian, Indianapolis pop trio — Matt, Brad, Charlie (all vocals/producers). Two albums: "Dasher, Dancer, & Prancer" (Christmas) and "The American Dream" (covers, includes bye-bye-bye and yeah-yeah-yeah). 20 MP3s total under music/. Album covers: images/album-cover-1.jpg, images/album-cover-2.jpg. Member photos: matt-1.jpg, brad-1.jpg, charlie-1.jpg. |  | Sections in index.html: hero (line 1069, cinematic dual-album-cover layout), about (1143), music (1187), members (1261), contact (1295). |  | Music player: custom HTML5 audio (replaced ReverbNation embeds in a9d9a62) with album-filter tabs (all / christmas / covers) and Spotify-style track hover (added b6571aa). Player controls live in .ac-player / .now-playing. |  | Contact email: [REDACTED:email]. Location: Indianapolis, Indiana. Footer copyright currently reads "© 2024" — stale, may need bumping.

**Why:** Snapshot of current site state so future sessions know the content shape without re-reading 1500 lines of HTML.

**How to apply:** When asked to add/edit a track, member, or section, reference the structure above. If members, albums, contact email, or footer year change, update this entry. Verify against the actual file before acting on snapshot details — content drifts.
---
type: decision
summary: Repo, hosting unknown, no README/CHANGELOG
stored: 2026-06-05T02:42:47.088Z
hash: 7b2c194426e2
tags: [repo, hosting, docs-gap, open-question]
---
<!-- hash:7b2c194426e2 -->
GitHub remote: https://github.com/inetinnovation/asian-caucasian-site (origin, branch main). No Netlify/Vercel/Cloudflare/GitHub Pages config files exist in the repo root — hosting/deploy target is UNKNOWN. No README.md, no CHANGELOG.md, no docs/ folder. CLAUDE.md and AGENTS.md are IJFW-generated scaffolds with no real content.

**Why:** Need to know what's missing so we don't assume a deploy flow that doesn't exist, and so Matt's global "docs ship with deploys" rule has something to attach to.

**How to apply:** Before claiming the site is "deployed" or running any deploy command, ASK Matt where the site is hosted. Per Matt's global rule (docs ship with deploys), if a meaningful change ships, propose creating a README and CHANGELOG. Update this entry once the hosting target is confirmed.
---
type: decision
summary: Hosted on Liquid Web VPS
stored: 2026-06-08T16:17:31.564Z
hash: 7be2ec441260
tags: [hosting, liquid-web, vps, deploy]
---
<!-- hash:7be2ec441260 -->
Site is hosted on a Liquid Web VPS. No Netlify/Vercel/Pages/Cloudflare involvement. GitHub repo (inetinnovation/asian-caucasian-site, main branch) is the source of truth, but the actual deploy mechanism (git pull on the VPS, rsync, SFTP, CI/CD, etc.) and the document root path are not yet captured here — ask Matt before running anything deploy-related.

**Why:** Supersedes the prior "hosting unknown" entry. Matt confirmed Liquid Web VPS on 2026-06-08.

**How to apply:** When asked to "deploy" or "push live," confirm the deploy mechanism with Matt first (not yet stored). Per Matt's global "docs ship with deploys" rule, after a real deploy ships, update CLAUDE.md / README / CHANGELOG before declaring done. Update this entry once the deploy command and document root are captured.
