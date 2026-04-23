# Tripzant Project Overview & Documentation

This document provides a comprehensive breakdown of the **Tripzant** project, including its architecture, modules, login panels, and key features.

## 1. Project Introduction
**Tripzant** is an enterprise-grade Travel & Logistics Management System built using the **Laravel 8** framework. It serves as a unified platform for flight bookings, hotel reservations, cargo management, and various other travel-related services for retail customers, agents, and corporate clients.

---

## 2. Technology Stack
-   **Framework**: Laravel 8.x
-   **PHP Version**: ^7.3
-   **Database**: MySQL (compatible with WAMP/XAMPP)
-   **Frontend**: Blade Templating Engine, CSS, JavaScript (Webpack Mix)
-   **Integrations**: Stripe (Payments), Amadeus (Flights), Guzzle (API communication)

---

## 3. Core Modules
The project is divided into several specialized modules:

### ✈️ Flight Module
-   Real-time flight search and booking.
-   Seat selection and passenger management.
-   **Fare Monitoring**: Automated price tracking and notification system.

### 🏨 Hotel Module
-   Global hotel search and reservation system.
-   Partner profiles and guest details management.

### 📦 Cargo & Logistics (Major Module)
-   **Shipment Tracking**: End-to-end tracking of cargo.
-   **Documentation**: Customs declarations, insurance, and shipment documents.
-   **Agent Management**: Specialized dashboards for cargo agents.

### 🤝 Affiliate & B2B
-   Agent registration and management.
-   Commission-based system for travel agents.
-   Wallet-based booking for partners.

### 💼 Corporate Travel
-   Specialized profiles for business clients.
-   Corporate-specific booking workflows and reporting.

### 🌍 Additional Services
-   **Train & Cab**: Local and inter-city transportation bookings.
-   **E-Sim & Insurance**: Value-added services for international travelers.
-   **Money Transfer**: Secure wallet-to-wallet or external transaction system.
-   **Tours & Homestays**: Local experience and alternative stay management.

---

## 4. Login Panels (Access Levels)
The system supports multiple user roles, each with a dedicated dashboard:

| Panel | Description |
| :--- | :--- |
| **Admin Panel** | Full system control, user management, settings, audit logs, and global markups. |
| **User/Agent Panel** | Dashboard for retail customers and travel agents to manage bookings and wallets. |
| **Cargo Agent Panel** | Dedicated interface for managing logistics, shipments, and tracking. |
| **Partner/Supplier** | For tour operators and homestay owners to list and manage their services. |
| **Corporate Panel** | For companies to manage employee travel and expenses. |
| **IATA/Provider** | Specialized access for service providers and regulatory agents. |

---

## 5. Key Features
-   **Unified Booking Engine**: Search and book multiple services (Flight + Hotel + Cab) in one platform.
-   **Wallet System**: Integrated wallet for instant bookings, refunds, and withdrawals.
-   **Markup & Commissions**: Dynamic profit margin control for the admin.
-   **Audit Logs**: Comprehensive logging of all system actions for security and tracking.
-   **Advanced Search**: Map-based exploration and dynamic filters for better user experience.
-   **Security**: CSRF protection, rate limiting, and secure session management.

---

## 6. Directory Structure (High Level)
-   `app/Http/Controllers/`: Contains the logic for all modules (Admin, User, Cargo, etc.).
-   `app/Models/`: Defines the database schema and relationships.
-   `resources/views/`: Contains the UI templates categorized by role (admin, agent, cargo).
-   `routes/`: Defines the web and API endpoints.
-   `public/`: Stores assets like images, CSS, and compiled JS.
