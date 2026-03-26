# Comms — SPEC (Phase 3)

## Job Reference
- **Upwork Job #4610**: "Laravel Developer. Internal Communication & Support System"
- **Demo URL**: https://comms.demo.sbarron.com
- **Client**: Needs internal comms platform with compliance audit trail

## Visual Identity
- Light mode: white/gray-50 backgrounds, sky-600 primary
- Inter font, 14-15px body
- Chat-focused layout with sidebar channels
- Professional, compliance-grade audit tables

## Pages & Routes

| Route | View | Description |
|-------|------|-------------|
| GET / | login | Login form with prefilled credentials |
| POST /login | - | Auth → redirect /chat |
| POST /logout | - | Destroy session → redirect / |
| GET /chat | chat | Main chat interface with channels sidebar |
| GET /tickets | tickets | Support ticket list with status filters |
| GET /tickets/create | ticket-create | New ticket form |
| GET /tickets/{id} | ticket-detail | Ticket thread with replies |
| GET /admin | admin-dashboard | Admin overview stats |
| GET /admin/users | admin-users | User management |
| GET /admin/audit | admin-audit | Audit log of all timestamp modifications |

## Data Model

### users
- Standard Laravel + role field. Seed admin: name="Jordan Blake", email="demo@comms.com", password="demo2026", role="admin"

### channels
| Column | Type | Notes |
|--------|------|-------|
| id | bigint | PK |
| name | string | e.g. "General", "Engineering" |
| type | string | public, private, direct |
| description | string | nullable |

### channel_user (pivot)
| Column | Type |
|--------|------|
| channel_id | bigint FK |
| user_id | bigint FK |

### messages
| Column | Type | Notes |
|--------|------|-------|
| id | bigint | PK |
| channel_id | bigint | FK |
| user_id | bigint | FK |
| body | text | |
| is_pinned | boolean | default false |
| original_created_at | timestamp | nullable (for audit) |
| created_at | timestamp | |
| updated_at | timestamp | |

### tickets
| Column | Type | Notes |
|--------|------|-------|
| id | bigint | PK |
| reference | string | unique, e.g. "TICKET-000001" |
| user_id | bigint | FK (creator) |
| assigned_to | bigint | FK nullable |
| subject | string | |
| description | text | |
| priority | string | low, medium, high, urgent |
| category | string | technical, billing, general, access |
| status | string | open, in_progress, waiting, resolved, closed |

### ticket_replies
| Column | Type | Notes |
|--------|------|-------|
| id | bigint | PK |
| ticket_id | bigint | FK |
| user_id | bigint | FK |
| body | text | |
| original_created_at | timestamp | nullable |

### audit_logs
| Column | Type | Notes |
|--------|------|-------|
| id | bigint | PK |
| admin_id | bigint | FK |
| auditable_type | string | message or ticket_reply |
| auditable_id | bigint | |
| original_timestamp | timestamp | |
| modified_timestamp | timestamp | |
| reason | text | nullable |

### Seed Data
- 5 users (1 admin, 4 regular)
- 4 channels: General, Engineering, Sales, Direct (admin + user)
- 30+ messages across channels with date variety
- 6 tickets in various statuses
- Ticket replies
- 3 audit log entries showing timestamp modifications

## Tech
- Laravel 12, PHP 8.4, SQLite (local) / MySQL (production)
- Blade + Tailwind CDN + Alpine.js CDN
- No build step
