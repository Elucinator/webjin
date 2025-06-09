# WebJin - Website as a Service (WaaS) Platform

WebJin is a multi-tenant Website-as-a-Service platform that allows users to create and manage their own websites using ready-made themes. Each user can launch a site with a few clicks and manage content via a simple dashboard.

---

## 🧱 Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Tailwind CSS 3.x
- **Authentication**: Laravel Breeze
- **Database**: MySQL (single DB, multi-tenant architecture)
- **Billing**: Razorpay (upcoming)
- **Deployment**: Self-managed VPS with HestiaCP (planned)

---

## 🚀 Features (Phase 1)

- User registration and login
- Dashboard to manage site
- Prebuilt themes (switchable)
- Limited-page builder (e.g., Home, About, Contact)
- Theme switching with one-click
- Tenant isolation (single DB, per-user content separation)

---

## 🛠️ Local Setup

1. **Clone the repository**
   ```bash
   git clone https://github.com/Elucinator/webjin.git
   cd webjin
