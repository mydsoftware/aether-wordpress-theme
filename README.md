# Aether - قالب وردپرس پریمیوم ووکامرس

**نسخه:** 1.0.0  
**معماری:** AI-Ready + Elementor Demo

## نصب

1. پوشه `theme` را به `wp-content/themes/aether` کپی کنید
2. افزونه `plugins/theme-demo-importer` را به `wp-content/plugins/aether-demo-importer` کپی و فعال کنید
3. WooCommerce و Elementor را نصب/فعال کنید (توصیه‌شده)
4. تم Aether را فعال کنید
5. از منوی **Aether > دموها** دموی «فروشگاه عمومی» را Import کنید

## دموی فروشگاه عمومی شامل

- **صفحات Elementor:** خانه، درباره ما، تماس، FAQ، وبلاگ
- **صفحات ووکامرس:** فروشگاه، سبد، تسویه، حساب کاربری
- **۱۰ محصول** با تصویر واقعی Unsplash
- **۵ دسته‌بندی:** الکترونیک، پوشاک، خانه، زیبایی، ورزش
- **تنظیمات مدرن** تم (رنگ، هدر، فوتر، چیدمان)
- **فرمت:** Elementor JSON در post meta + WooCommerce API — قابل ویرایش در Elementor

## ساختار

```
theme/          # قالب
plugins/
  theme-demo-importer/   # افزونه Import
demos/general/  # داده دمو
```

## AI-Ready

REST API: `/wp-json/aether/v1/`  
Schema: `theme/theme-schema.json`

GPL v2+
