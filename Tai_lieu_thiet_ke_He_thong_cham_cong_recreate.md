
# 📘 Tài liệu thiết kế hệ thống chấm công & tính lương (勤怠管理・給与計算システム)

## 1. 業務要件定義書 / Yêu cầu nghiệp vụ
- **Tên dự án / プロジェクト名**: 勤怠管理・給与計算システム (Hệ thống chấm công & tính lương)
- **Khách hàng / クライアント**: 株式会社サクラ人事（Công ty Sakura HR）
- **Mục tiêu / 目的**:
  - 従業員の勤務時間を管理し、労働時間に基づいた給与を自動計算する。
  - Quản lý thời gian làm việc của nhân viên và tự động tính lương theo giờ.
- **Người dùng / 利用者**:
  - 従業員（Nhân viên）
  - 管理者（Quản trị viên）
- **Môi trường / 使用環境**:
  - Trình duyệt máy tính hoặc điện thoại (PC/スマートフォンのブラウザ)
- **Ngôn ngữ hệ thống / 対応言語**: 日本語・ベトナム語

---

## 2. システム全体設計書 / Thiết kế tổng thể
- **Frontend**: Vue.js
- **Backend**: Laravel (REST API)
- **Database**: MySQL
- **Authentication**: Laravel Sanctum (token)
- **Hosting**: VPS hoặc Heroku

---

## 3. 基本設計書 / Thiết kế cơ bản

### 3.1 画面設計 / Thiết kế màn hình

#### ① Màn hình chấm công（勤怠打刻画面）
- URL: `/attendance`
- Thành phần: Nút 出勤 (check-in), 退勤 (check-out), đồng hồ, trạng thái hiện tại

#### ② Màn hình danh sách nhân viên（従業員一覧画面）
- URL: `/admin/employees`
- Chức năng: Thêm/Sửa/Xóa nhân viên

### 3.2 処理フロー / Luồng xử lý
1. Nhân viên đăng nhập
2. Bấm 出勤 → gọi API check-in → lưu thời gian vào DB
3. Bấm 退勤 → gọi API check-out → lưu thời gian ra vào DB

### 3.3 API仕様 / Thiết kế API
| API | Method | Input | Output |
|-----|--------|-------|--------|
| `/api/attendance/checkin` | POST | token | check_in_time |
| `/api/attendance/checkout` | POST | token | check_out_time |
| `/api/payroll/monthly` | GET | user_id, tháng | bảng lương chi tiết |

### 3.4 テーブル設計 / Thiết kế bảng dữ liệu

#### `users` table:
```sql
id INT,
name VARCHAR,
email VARCHAR,
password VARCHAR,
hourly_wage INT,
role ENUM('admin','staff')
```

#### `attendances` table:
```sql
id INT,
user_id INT,
check_in_time DATETIME,
check_out_time DATETIME,
late_flag BOOLEAN,
leave_early_flag BOOLEAN
```

---

## 4. 詳細設計書 / Thiết kế chi tiết

### 勤怠打刻画面（Màn hình chấm công）
- Thành phần: Đồng hồ thời gian thực, nút 出勤・退勤, trạng thái
- Logic: Nếu đã check-in thì ẩn hoặc vô hiệu hóa nút 出勤

---

## 5. テスト仕様書 / Tài liệu kiểm thử

| Test ID | Chức năng | Điều kiện | Kết quả mong đợi |
|---------|-----------|-----------|------------------|
| TC001 | Check-in | Chưa check-in hôm nay | Ghi thời gian |
| TC002 | Check-out | Đã check-in | Ghi thời gian checkout |
| TC003 | Tính lương | Có dữ liệu trong tháng | Tính đúng tổng giờ và lương |

---

**📌 Ghi chú**: Tài liệu song ngữ Nhật – Việt, phù hợp dùng làm tài liệu giao tiếp giữa BrSE và khách hàng Nhật.
