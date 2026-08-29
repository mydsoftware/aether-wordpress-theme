# Changelog

## [1.0.0] - 2026-08-29

### Added
- هسته تم Aether با معماری modular و Autoloader
- Design System کامل (Color, Typography, Spacing, Radius, Shadow Tokens)
- سیستم Header با Sticky، Topbar، Mobile Menu، Cart، Search، CTA
- سیستم Footer چندستونه + Payment icons
- Layout Engine (Boxed, Full Width, Sidebar Left/Right, No Sidebar)
- Mega Menu Walker با پشتیبانی Badge
- یکپارچه‌سازی WooCommerce (shop columns, per page, related, breadcrumb, cart fragment)
- قالب‌های WooCommerce (archive-product, single-product, content-product)
- Dark Mode مبتنی بر data-theme و prefers-color-scheme
- پشتیبانی کامل RTL و فارسی با Vazirmatn
- پنل ادمین کامل (Dashboard, Settings, Demos, License)
- Theme Options با Sanitization و Capability Check
- REST API داخلی (`aether/v1`) برای config, settings, header, layouts, schema
- Theme Schema machine-readable (`theme-schema.json`)
- سیستم Snapshot برای versioning تنظیمات
- Security layer (Nonce, Capability, Sanitization, DISALLOW_FILE_EDIT)
- Accessibility (skip link, focus-visible, ARIA, semantic HTML)
- Onboarding redirect بعد از فعال‌سازی
- سازگاری با Elementor و SEO plugins
- قالب‌های Blog (index, single, page, search, comments, 404)
- Assets شرطی و defer برای Performance

### Notes
- Demo Importer کامل در مرحله بعد (منتظر دستور کاربر برای ساختار صفحات)
- License Server connection modular و آماده
- AI Agent در این نسخه فعال نیست (فقط زیرساخت API + Schema)
