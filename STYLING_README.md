# Invoice Management - Modern Styling System

## 🎨 Overview

Sistem styling modern dan konsisten untuk aplikasi Invoice Management menggunakan Tailwind CSS v3+ dengan dukungan dark mode, komponen reusable, dan animasi yang smooth.

## ✨ Features

- **🌙 Dark Mode**: Toggle antara light dan dark mode dengan Alpine.js
- **🎯 Design System**: Palet warna yang konsisten dan modern
- **📱 Responsive**: Desain yang responsif di semua perangkat
- **⚡ Performance**: Utility-first approach dengan Tailwind CSS
- **🔄 Animations**: Transisi smooth 150-300ms
- **♿ Accessibility**: Focus states dan ARIA labels

## 🎨 Color Palette

### Primary Colors
```css
primary-50: #eff6ff
primary-100: #dbeafe
primary-500: #3b82f6
primary-600: #2563eb
primary-900: #1e3a8a
```

### Secondary Colors
```css
secondary-50: #f8fafc
secondary-100: #f1f5f9
secondary-500: #64748b
secondary-600: #475569
secondary-900: #0f172a
```

### Status Colors
```css
success: #10b981 (emerald-500)
warning: #f59e0b (amber-500)
danger: #ef4444 (red-500)
```

### Dark Mode Colors
```css
neutral-700: #374151
neutral-800: #1f2937
neutral-900: #111827
neutral-950: #030712
```

## 🔧 Typography

### Font Families
- **Primary**: Inter (Google Fonts)
- **Display**: Poppins (Google Fonts)
- **Mono**: ui-monospace, SFMono-Regular

### Font Sizes
```css
text-xs: 12px
text-sm: 14px
text-base: 16px
text-lg: 18px
text-xl: 20px
text-2xl: 24px
text-3xl: 30px
text-4xl: 36px
```

## 🧩 Components

### Buttons
```html
<!-- Primary Button -->
<button class="btn-primary">Primary Action</button>

<!-- Secondary Button -->
<button class="btn-secondary">Secondary Action</button>

<!-- Ghost Button -->
<button class="btn-ghost">Ghost Action</button>

<!-- Danger Button -->
<button class="btn-danger">Delete</button>
```

### Form Elements
```html
<!-- Input Group -->
<div class="form-group">
    <label class="form-label">Email Address</label>
    <input type="email" class="form-input" placeholder="Enter email">
    <p class="form-help">We'll never share your email.</p>
</div>

<!-- Select -->
<select class="form-select">
    <option>Choose option</option>
</select>

<!-- Textarea -->
<textarea class="form-textarea" rows="4"></textarea>
```

### Cards
```html
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Card Title</h3>
        <p class="card-subtitle">Card subtitle</p>
    </div>
    <div class="card-body">
        <p>Card content goes here.</p>
    </div>
    <div class="card-footer">
        <button class="btn-primary">Action</button>
    </div>
</div>
```

### Alerts
```html
<!-- Success Alert -->
<div class="alert-success">
    <i class="fas fa-check-circle"></i>
    Success message here
</div>

<!-- Error Alert -->
<div class="alert-error">
    <i class="fas fa-exclamation-circle"></i>
    Error message here
</div>
```

### Badges
```html
<span class="badge-success">Active</span>
<span class="badge-warning">Pending</span>
<span class="badge-danger">Inactive</span>
```

## 🌙 Dark Mode Implementation

### Setup
1. Alpine.js sudah diinclude otomatis oleh Livewire
2. Dark mode toggle component tersedia
3. Tailwind config sudah diset dengan `darkMode: 'class'`

### Usage
```html
<!-- Dark Mode Toggle -->
@include('components.dark-mode-toggle')

<!-- Dark Mode Classes -->
<div class="bg-white dark:bg-neutral-800">
    <h1 class="text-secondary-900 dark:text-white">Title</h1>
    <p class="text-secondary-600 dark:text-neutral-300">Description</p>
</div>
```

### Color Mapping
| Light Mode | Dark Mode | Usage |
|------------|-----------|-------|
| `bg-white` | `dark:bg-neutral-800` | Card backgrounds |
| `bg-secondary-100` | `dark:bg-neutral-900` | Page backgrounds |
| `text-secondary-900` | `dark:text-white` | Primary text |
| `text-secondary-600` | `dark:text-neutral-300` | Secondary text |
| `border-secondary-200` | `dark:border-neutral-700` | Borders |

## 📁 File Structure

```
resources/
├── css/
│   └── app.css                 # Main CSS with component classes
├── views/
│   ├── components/
│   │   └── dark-mode-toggle.blade.php
│   ├── layouts/
│   │   ├── app.blade.php       # Main layout with dark mode
│   │   └── guest.blade.php     # Guest layout
│   ├── livewire/layout/
│   │   └── sidebar.blade.php   # Sidebar with dark mode
│   └── style-guide.blade.php   # Style guide documentation
└── tailwind.config.js          # Tailwind configuration
```

## 🚀 Getting Started

### 1. Build CSS
```bash
npm run dev
# or for production
npm run build
```

### 2. View Style Guide
Kunjungi `/style-guide` untuk melihat semua komponen dan dokumentasi.

### 3. Implement Dark Mode
Tambahkan dark mode toggle di layout:
```html
@include('components.dark-mode-toggle')
```

## 🎯 Best Practices

### 1. Consistency
- Gunakan komponen yang sudah didefinisikan
- Ikuti palet warna yang telah ditetapkan
- Gunakan spacing scale yang konsisten

### 2. Performance
- Gunakan utility classes daripada custom CSS
- Manfaatkan `@apply` untuk komponen yang sering digunakan
- Purge unused CSS di production

### 3. Accessibility
- Selalu sertakan focus states
- Gunakan semantic HTML
- Pastikan kontras warna yang cukup

### 4. Dark Mode
- Selalu sertakan dark mode variant untuk background dan text
- Test di kedua mode (light dan dark)
- Gunakan transisi untuk perubahan yang smooth

## 🔧 Customization

### Menambah Warna Baru
1. Edit `tailwind.config.js`:
```js
colors: {
  // existing colors...
  brand: {
    50: '#f0f9ff',
    500: '#0ea5e9',
    900: '#0c4a6e'
  }
}
```

2. Gunakan di CSS:
```css
.btn-brand {
  @apply bg-brand-500 hover:bg-brand-600 text-white;
}
```

### Menambah Komponen Baru
1. Tambahkan di `resources/css/app.css`:
```css
.my-component {
  @apply bg-white dark:bg-neutral-800 p-4 rounded-lg shadow-sm;
}
```

2. Dokumentasikan di style guide

## 📚 Resources

- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Alpine.js Documentation](https://alpinejs.dev/)
- [Laravel Blade Documentation](https://laravel.com/docs/blade)

## 🤝 Contributing

1. Ikuti style guide yang ada
2. Test di light dan dark mode
3. Update dokumentasi jika menambah komponen baru
4. Pastikan responsive di semua breakpoint

---

**Dibuat dengan ❤️ untuk Invoice Management System**