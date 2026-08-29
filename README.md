# Aether - قالب وردپرس پریمیوم ووکامرس

**نسخه:** 1.0.0  
**وضعیت:** Production-Ready Core  
**معماری:** AI-Ready

## معرفی

Aether یک قالب وردپرس/ووکامرس پریمیوم با طراحی مدرن، پشتیبانی کامل RTL و فارسی، و معماری آماده برای اتصال AI Agent در آینده است.

### ویژگی‌های کلیدی

- **Design System** کامل با Color/Typography/Spacing Tokens
- **Header System** حرفه‌ای با Sticky، Topbar، Mobile Menu
- **Footer Builder** چندستونه
- **WooCommerce Integration** کامل
- **Dark Mode** مبتنی بر Token
- **RTL First-Class** با فونت Vazirmatn
- **Theme Options** امن با Sanitization و Capability Check
- **REST API** داخلی برای کنترل از راه دور و AI آینده
- **Theme Schema** machine-readable (`theme-schema.json`)
- **Versioning/Snapshot** برای تنظیمات
- **Accessibility** و Performance-first
- **Admin Dashboard** مدرن

## نیازمندی‌ها

- WordPress 6.0+
- PHP 7.4+ (توصیه ۸.۰+)
- WooCommerce 7.0+ (اختیاری اما توصیه‌شده)
- MySQL 5.7+ / MariaDB 10.3+

## نصب

1. پوشه `theme` را به `wp-content/themes/aether` کپی کنید.
2. از پیشخوان وردپرس تم را فعال کنید.
3. به منوی **Aether** بروید و تنظیمات را پیکربندی کنید.
4. در صورت نیاز WooCommerce را نصب و فعال کنید.

## ساختار پروژه

```
theme-project/
├── theme/                 # قالب اصلی
│   ├── assets/            # CSS, JS, fonts, images
│   ├── inc/               # کلاس‌ها و ماژول‌ها
│   │   ├── core/
│   │   ├── admin/
│   │   ├── frontend/
│   │   ├── woocommerce/
│   │   ├── api/
│   │   ├── security/
│   │   └── compatibility/
│   ├── template-parts/
│   ├── templates/
│   ├── woocommerce/
│   ├── languages/
│   ├── patterns/
│   ├── style.css
│   ├── functions.php
│   └── theme-schema.json
├── plugins/               # افزونه‌های همراه (آینده)
├── demos/
├── docs/
├── tests/
└── README.md
```

## AI-Ready Architecture

تم از ابتدا برای اتصال AI Agent طراحی شده:

1. **Theme Schema** (`theme-schema.json`) تعریف کامل کامپوننت‌ها و properties
2. **REST API** (`/wp-json/aether/v1/...`) برای خواندن/نوشتن تنظیمات
3. **Permission System** محدود به capabilityهای مجاز
4. **Snapshot/Versioning** برای امکان Rollback

AI آینده فقط از طریق API و Schema عمل می‌کند و مستقیماً به فایل‌های PHP یا دیتابیس دسترسی ندارد.

## توسعه‌دهندگان

### هوک‌های مهم

```php
// رندر هدر
do_action( 'aether_header' );

// رندر فوتر
do_action( 'aether_footer' );

// کلاس‌های محتوا
apply_filters( 'aether_content_classes', array() );

// موقعیت سایدبار
apply_filters( 'aether_sidebar_position', 'right' );
```

### دریافت تنظیمات

```php
$value = aether_get_option( 'header_sticky', true );
```

### Child Theme

از Child Theme پشتیبانی کامل می‌شود. فایل `style.css` تم فرزند را با Template: aether تعریف کنید.

## لایسنس

GPL v2 or later

## پشتیبانی

مستندات کامل در پوشه `docs/` و سایت رسمی.

---

ساخته‌شده با تمرکز بر کیفیت Production، امنیت و آمادگی برای آینده AI.
