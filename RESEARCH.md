# Comms — Research (Phase 2)

## Job Analysis
- **Title**: Laravel Developer. Internal Communication & Support System
- **Job #**: 4610
- **Client**: Needs structured internal communication platform with compliance/timeline reconstruction
- **Key**: Chat system, support tickets, admin timestamp editing with audit logs
- **Stack**: Laravel, MySQL

## Core Modules
1. Internal Chat (private + group, real-time, file sharing)
2. Support Tickets (workflow statuses, threaded replies, email integration)
3. Admin Controls (timestamp editing with audit trail, user management)

## Competitor/Reference Sites
1. **Slack** — Channel-based messaging, clean sidebar, real-time
2. **Intercom** — Support tickets + chat, clean professional UI
3. **Freshdesk** — Ticket management, status workflows, clean tables
4. **Zendesk** — Support system, professional, dense data
5. **Microsoft Teams** — Chat + channels, sidebar navigation

## Visual Direction
- Light mode — professional, compliance-ready
- Primary: Sky-600 (#0284c7) — communication, trust, professional
- Background: Gray-50/White
- Clean, dense data tables for tickets and audit logs
- Chat bubbles with clear sender/time separation

## Font
- Inter — clean, professional
- 14-15px body, monospace for ticket IDs and timestamps

## Key Demo Claims to Match
1. Private and group chat with message history
2. Support ticket creation with priority/category
3. Ticket status workflow (Open → In Progress → Resolved → Closed)
4. Ticket threading with replies
5. Admin timestamp editing with audit logs
6. User management (create, activate/deactivate)
7. Date dividers in chat
8. Read/unread tracking

## Packages
- Laravel 12, PHP 8.4, SQLite (local) / MySQL (production)
- Blade + Tailwind CDN + Alpine.js CDN
- No build step
