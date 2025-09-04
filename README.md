# Flatsome UX Flip Card

المان بومی **Flatsome UX Builder** برای ساخت "کارت برگردان" (Flip Card) با کنترل‌های حرفه‌ای و UX کاربرپسند.

> نسخهٔ فعلی: **v1.5.0** — ارتفاع ثابت واکنش‌گرا (Desktop/Tablet/Mobile) + تنظیمات سایز ریسپانسیو بدون کدنویسی.

---

## قابلیت‌ها (Highlights)

* **Front/Back** با Overlay و عنوان + یک CTA مشترک
* **Trigger**: Hover یا Click/Tap (برای موبایل)
* **Direction**: افقی (Y) یا عمودی (X)
* **Height Modes**: نسبت تصویر (Aspect Ratio %) یا ارتفاع ثابت (px)
* **Aspect Ratio Presets**: 16:9، 3:2، 4:3، 1:1، 3:4
* **Responsive Fixed Height**: ارتفاع جداگانه برای Desktop/Tablet/Mobile (بدون CSS دستی)
* **Responsive Size Presets/Custom**: ساخت خودکار `sizes` (Compact/Standard/Wide/Hero یا مقادیر سفارشی)
* **Shadow Builder**: Presets (None/Subtle/Soft/Medium/Deep/Lift) + Custom (X/Y/Blur/Spread/Color/Opacity/Inset)
* **Image Quality Modes**: Performance / Auto / Retina (هوشمند با WordPress image sizes + srcset)
* **Fit/Position**: کنترل دقیق کراپ (cover/contain/fill) و نقطهٔ فوکوس
* **Toggle Button (اختیاری)**: دکمهٔ چرخش داخلی (پیش‌فرض: غیرفعال)

## الزامات

* **WordPress** ≥ 6.0
* **PHP** ≥ 7.4
* **Flatsome** (UX Builder فعال)

## نصب / بروزرسانی

1. فایل `flatsome-ux-flip-card-v1.5.0.zip` را از صفحه **Releases** دریافت کنید.
2. پیشخوان وردپرس → **افزونه‌ها → افزودن → بارگذاری افزونه**.
3. فایل ZIP را انتخاب و نصب کنید. در WP ≥ 5.5 روی **Replace current with uploaded** بزنید.
4. **Flatsome → Advanced → Clear UX Builder Cache** سپس رفرش سخت (Ctrl/Cmd + F5).

## شروع سریع (Quick Start)

* UX Builder → **Content → Flip Card**
* اگر می‌خواهید روی موبایل هم عمل کند: **Trigger = Click/Tap**
* **Height Mode = Ratio** برای نسبت‌ها؛ یا **Fixed** و سپس ارتفاع‌های **Desktop/Tablet/Mobile** را ست کنید.
* از **Responsive Size Mode = Preset** برای تیم محتوا استفاده کنید؛ برای کنترل دقیق، حالت Custom.

## گزینه‌ها (UX Builder Options)

**General**

* Trigger: `hover | click`
* Direction: `y | x`
* Show Toggle Button: `no | yes` (پیش‌فرض: no)

**Size & Height**

* Height Mode: `ratio | fixed`
* Aspect Ratio % (در حالت ratio): 16:9 / 3:2 / 4:3 / 1:1 / 3:4
* Fixed Height — Desktop/Tablet/Mobile (px)

**Responsive Sizes (خروجی attribute=sizes)**

* Mode: `preset | custom`
* Preset: `compact | standard | wide | hero`
* Custom: Desktop Slot (px ≥1200) / Tablet Slot (px ≥768) / Mobile Slot (`100vw` یا px)

**Images & Overlays**

* Front/Back Image (مدیریت رسانه)
* Image Size: inherit از Quality Mode یا اندازه‌های WP (`thumbnail | medium | medium_large | large | full`)
* Fit: `cover | contain | fill`
* Position: Center/Top/Bottom/Left/Right/…
* Overlay: `none | dark | light`

**Shadow**

* Mode: `preset | custom`
* Presets: None / Subtle / Soft / Medium / Deep / Lift
* Custom: X(px), Y(px), Blur(px), Spread(px), Color(colorpicker), Opacity(0–1), Inset(yes/no)

**Quality & CTA**

* Image Quality Mode: `performance | auto | retina`
* CTA Text / CTA URL
* Extra class

## شورت‌کد (برای استفادهٔ دستی)

```php
[ux_flip_card
  trigger="hover"
  direction="y"
  height_mode="ratio"
  ratio="66.666%"
  front_image="123" back_image="456"
  front_title="Title" back_title="More"
  front_overlay="dark" back_overlay="dark"
  cta_text="Shop Now" cta_url="/shop"
]
```

**نمونه: ارتفاع ثابت ریسپانسیو**

```php
[ux_flip_card
  height_mode="fixed"
  height_px="420"      ; Desktop ≥1200px
  height_px_t="360"    ; Tablet ≥768px
  height_px_m="300"    ; Mobile <768px
  trigger="click" direction="y"
  front_image="123" back_image="456"
]
```

## سوالات متداول (FAQ)

* **Hover در موبایل؟** در موبایل Hover نداریم؛ از **Trigger=Click/Tap** استفاده کنید.
* **Radius/Shadow اعمال نشد؟** احتمالاً CSS دیگری Override کرده؛ یک `Extra class` بدهید و در صورت نیاز `!important` استفاده کنید.
* **گزینه‌ها را نمی‌بینم؟** کش UX Builder را پاک کنید و صفحه را رفرش سخت کنید.

## دسترسی‌پذیری (A11y)

* تصاویر Lazy-load و `decoding="async"` دارند.
* برای کنترل کیبورد/خوانا: در صورت نیاز **Show Toggle Button = Yes** را فعال کنید تا یک کنترل صریح قابل فوکوس اضافه شود.

## نسخه‌بندی و انتشار

* الگو: **Semantic Versioning (SemVer)**
* Release Notes: صفحه **Releases** را ببینید (تغییرات کلیدی هر نسخه).

## لایسنس

GPL-2.0-or-later — همراستا با اکوسیستم وردپرس.

## مشارکت

Pull Request، Feature Request و گزارش باگ امنیتی پذیرفته می‌شود.
Security: مسئولانه از طریق Issues یا ایمیل درج‌شده در پروفایل.

## نقشهٔ راه (Roadmap کوتاه)

* Variants per-breakpoint برای Shadow/Radius
* Tooltipهای تصویری برای Presetها
* المان Slider بومی با A11y/Perf بالا
