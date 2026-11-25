# Agent Instructions — TypeScript Desktop Application

## Project Overview
This is a **TypeScript-based desktop application** using the **Tauri 2** framework. The application is a laundry marketplace platform with hybrid architecture:
- **Desktop App**: For App Admin & Store Admin operational roles
- **Web App (PWA)**: For Customer order placement via browser
- **Shared Backend**: Laravel API + PostgreSQL (single source of truth)

## Tech Stack (Fixed)
| Layer | Technology |
|-------|------------|
| Frontend (both) | TypeScript, React 18, Vite, Tailwind CSS, shadcn/ui, Lucide, Motion, Zustand, TanStack Query, React Router |
| Desktop | Tauri 2 (Rust native layer), WebView2 rendering |
| Backend | Laravel 11 (PHP), Laravel Sanctum (API auth), PostgreSQL |
| Styling | Tailwind CSS with primary color: **#10B981** (hijau) |
| State Management | Zustand + TanStack Query |
| Routing | React Router 6 |

## Architecture Principles
1. **Single codebase for UI** — React + TypeScript components shared between desktop & web; only routing & role guards differ
2. **Backend-agnostic frontend** — Frontend calls Laravel REST API via TanStack Query; no direct DB access
3. **Role-based entry points** — Login redirects: App Admin → Desktop dashboard, Store Admin → Desktop dashboard, Customer → Web PWA
4. **Native features only where needed** — Tauri Rust layer for: system tray, custom titlebar, filesystem (export), OS notifications. All business logic in Laravel.

## UI/UX Design Approach (Effective & Modern)
**Use shadcn/ui + Tailwind CSS as the design system foundation.** This gives:
- **Pre-built accessible components** (Radix UI primitives) — no reinventing dialogs, dropdowns, tables
- **Tailwind utility classes** — consistent spacing, color, typography; zero custom CSS files
- **Copy-paste customizable** — components live in your repo (`components/ui/`), not locked in npm
- **Dark mode ready** — though **light mode is default** (kasir-friendly)
- **Motion/Framer Motion** — for micro-animations (fade, slide, chart transitions)

**Color Palette (Enforced):**
```css
--primary: #10B981;        /* Green — positive actions, success, active state */
--secondary: #0F172A;      /* Slate 900 — sidebar, primary text */
--background: #F8FAFC;     /* Slate 50 — app background */
--card: #FFFFFF;           /* White — cards, modals */
--warning: #F59E0B;        /* Amber — pending, in-progress */
--danger: #EF4444;         /* Red — errors, destructive */
--muted: #64748B;          /* Slate 500 — secondary text */
```

**Layout Rules:**
- Sidebar: 240px fixed, grouped **OPERASIONAL** / **MANAJEMEN**
- Top Bar: 56px, left = page title, right = connection status + notification bell + branch selector
- Cards: 8px radius, shadow `0 1px 2px rgba(0,0,0,0.05)`, padding 16px
- Tables: zebra striping, sticky header, hover row highlight
- Forms: 3-step linear for "Buat Pesanan" with progress indicator
- Charts: LineSeries + gradient area, tooltip + crosshair, zoom X

**Typography:** System font stack + Inter for headings. Scale: xs(12) sm(14) md(16) lg(18) xl(20). No truncated text — use `min-width: 0` + `text-wrap: wrap`.

## Role Permissions Matrix
| Feature | App Admin (Desktop) | Store Admin (Desktop) | Customer (Web) |
|---------|---------------------|----------------------|----------------|
| Users & Roles | CRUD | View own store | — |
| Store Settings | CRUD | Update own | — |
| Services & Rates | CRUD | CRUD | View |
| Orders | All stores | Own store | Own only |
| Pickup/Delivery | All | Own | View schedule |
| Complaints | All | Own | Submit + view |
| Reports | System-wide | Own store | — |
| Audit Log | All | Own store | — |
| Profile | Self | Self | Self |

## Development Workflow
1. **Backend first** — Laravel API with Sanctum tokens, policies, resource controllers
2. **Shared UI library** — Build `components/ui` once, use in both Vite apps (web + desktop)
3. **Desktop Tauri config** — `tauri.conf.json` with custom titlebar, tray, updater
4. **Web PWA config** — `vite.config.ts` + manifest, service worker for offline
5. **RBAC middleware** — Laravel `role` middleware + React route guards
6. **Real-time** — Laravel Reverb for order status push (optional Phase 2)

## File Structure (Monorepo Style)
```
TypeScriptDekstopAPP/
├── backend/                 # Laravel API
│   ├── app/
│   ├── routes/api.php
│   └── database/
├── frontend/
│   ├── web/                 # Customer PWA (React + Vite)
│   │   ├── src/
│   │   └── package.json
│   ├── desktop/             # Tauri 2 + React (Admin)
│   │   ├── src/
│   │   ├── src-tauri/
│   │   └── package.json
│   └── shared-ui/           # shadcn/ui components, hooks, types
│       ├── components/ui/
│       ├── lib/
│       └── package.json
└── docker-compose.yml       # PostgreSQL + Laravel (dev)

## Key Implementation Notes
- **Authentication**: Laravel Sanctum token stored in `localStorage` (web) / Tauri secure storage (desktop). Axios/TanStack Query interceptor attaches Bearer token.
- **Notifications**: `NotificationService` (Zustand store) with fields: `id`, `title`, `description`, `category`, `timestamp`, `isRead`, `targetRoute`, `referenceId`. Bell badge counts unread.
- **Offline-first (Web)**: TanStack Query persistence + service worker for cached reads.
- **Export/Print**: Desktop uses Tauri filesystem API; Web uses browser print/Blob download.
- **Testing**: Vitest (unit), Playwright (e2e web), Tauri test harness (desktop).

## Do NOT
- ❌ Use SQLite anywhere
- ❌ Put business logic in Tauri Rust layer
- ❌ Duplicate UI components between web/desktop — import from `shared-ui`
- ❌ Hardcode colors — use Tailwind config + CSS variables
- ❌ Skip RBAC — every endpoint and route must enforce role

## Phase 1 Deliverables (MVP)
1. Laravel API: auth, users, stores, services, orders, complaints, reports
2. Shared UI library: Button, Input, Card, Table, Badge, Dialog, Toast, Progress, Chart wrapper
3. Desktop: Login → Dashboard (metrics, chart, sidebar + TopBar + Notifications)
4. Web: Login/Register → Order flow (3-step) → History → Profile
5. Role guards on both platforms
6. PostgreSQL schema + seeders

## Commands Reference
```bash
# Backend
cd backend && composer install && php artisan migrate --seed

# Shared UI
cd frontend/shared-ui && npm install

# Web
cd frontend/web && npm install && npm run dev

# Desktop
cd frontend/desktop && npm install && npm run tauri dev

# Tests
cd .. && vendor/bin/pest   # PHP tests
cd frontend && npm test   # Vitest/Playwright

# Build
vendor/bin/php artisan optimize   # clear config/cache
npm run build   # Vite build for production
cargo tauri build   # Tauri Windows installer
```

---
*This document is the single source of truth for any agent working on this project. Follow the stack, architecture, and design approach exactly.*