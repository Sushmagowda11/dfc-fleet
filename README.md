# DFC Fleet Management Backend

Backend system for managing fleet operations, driver activity, trips, and financial settlements.

## 🚀 Features

- Driver activity uploads (attendance & working days)
- Driver trip uploads (trip-level data)
- Auto positioning events
- Financial transactions upload with **JSON-based storage**
- Supports 40+ payment-related fields safely
- Aggregation across **4 tables** using `driver_uuid` & `trip_uuid`
- Salary-ready calculations:
  - Total earnings
  - Cash collected
  - Working days
  - Net payable amount

## 🧩 Core Modules

- Driver Activity Uploads
- Driver Trip Events
- Driver Auto Positioning Events
- Driver Financial Transactions

## 🛠 Tech Stack

- Laravel
- PHP 8+
- MySQL
- REST APIs
- CSV Uploads

## 📊 Financial Design

- Uses JSON columns for flexible financial data
- Keeps raw uploaded data for audit (`raw_row_json`)
- Supports driver-wise aggregation and incentives

## 🔑 Key Concepts

- `driver_uuid` → primary driver-level link
- `trip_uuid` → trip-level matching
- LEFT JOIN–based aggregation across tables

## 📌 Status

- Backend APIs implemented
- Financial aggregation queries completed
- Ready for incentive and salary calculation logic

---

Developed as part of the DFC Fleet backend system.
