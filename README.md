## เนื้อหา

1. [วิธีป้องกันการโจมตี Brute Force](#1-วิธีป้องกันการโจมตี-brute-force)
2. [วิธีป้องกัน SQL Injection](#2-วิธีป้องกัน-sql-injection)
3. [ตัวอย่าง Subquery](#3-ตัวอย่าง-subquery)
4. [การเลือกสินค้าจากร้าน](#4-การเลือกสินค้าจากร้าน)
5. [การอัปเดตสถานะสินค้า](#5-การอัปเดตสถานะสินค้า)
6. [การจัดรูปแบบผลลัพธ์ของ SQL Query](#6-การจัดรูปแบบผลลัพธ์ของ-sql-query)
7. [การคำนวณผลลัพธ์ใบเสนอราคา](#7-การคำนวณผลลัพธ์ใบเสนอราคา)

## 1. วิธีป้องกันการโจมตี Brute Force

เพื่อป้องกันการโจมตี Brute Force ในฟอร์มการเข้าสู่ระบบ สามารถใช้วิธีต่อไปนี้ได้:

- **CAPTCHA**: เพิ่มความยากในการโจมตี Brute Force โดยใช้ CAPTCHA เพื่อให้ผู้ใช้ต้องยืนยันตัวตนก่อนเข้าสู่ระบบ
- **ล็อกเอาท์บัญชี**: หลังจากจำนวนครั้งที่พยายามเข้าสู่ระบบผิดพลาดเกินกำหนด ให้ล็อกเอาท์ผู้ใช้เป็นเวลาหนึ่งชั่วโมงหรือเวลาที่กำหนดเพื่อป้องกันการโจมตี Brute Force
- **การเข้ารหัสรหัสผ่าน**: ใช้เทคนิคการเข้ารหัสที่มีความแข็งแกร่งเพื่อเก็บรักษาความปลอดภัยของรหัสผ่าน เช่นการใช้การเข้ารหัสแบบแฮช (hash) แทนรหัสผ่านเป็นข้อความที่อ่านง่าย

## 2. วิธีป้องกัน SQL Injection

เพื่อป้องกันการโจมตี SQL Injection ให้ใช้ parameterized queries หรือ stored procedures ดังตัวอย่างต่อไปนี้:

```sql
-- ตัวอย่าง 1: Parameterized Query
DECLARE @username NVARCHAR(50);
SET @username = 'example_user';
DECLARE @password NVARCHAR(50);
SET @password = 'example_password';

SELECT * FROM users
WHERE username = @username AND password = @password;

-- ตัวอย่าง 2: Stored Procedure
CREATE PROCEDURE AuthenticateUser
    @username NVARCHAR(50),
    @password NVARCHAR(50)
AS
BEGIN
    SET NOCOUNT ON;

    SELECT * FROM users
    WHERE username = @username AND password = @password;
END;
```

## 3. ตัวอย่าง Subquery

Subquery สามารถใช้ได้ในตำแหน่งต่างๆ ของคำสั่ง SQL ดังตัวอย่างต่อไปนี้:

```sql
-- ตัวอย่าง 1: Subquery ใน SELECT
SELECT p.product_name, (SELECT category_name FROM categories WHERE category_id = p.category_id) AS category
FROM products p;

-- ตัวอย่าง 2: Subquery ใน WHERE
SELECT * FROM orders
WHERE customer_id IN (SELECT customer_id FROM customers WHERE country = 'USA');

-- ตัวอย่าง 3: Subquery ใน FROM
SELECT subquery.total_sales, s.shop_name
FROM (SELECT shop_id, SUM(sales_amount) AS total_sales FROM sales GROUP BY shop_id) AS subquery
JOIN shops s ON subquery.shop_id = s.shop_id;
```

## 4. การเลือกสินค้าจากร้าน

เพื่อเลือกสินค้าจากร้านที่มีชื่อ "rudy shop" ใช้โค้ด SQL ต่อไปนี้:

```sql
SELECT p.id, p.name, p.status, p.shop_id
FROM tb_product p
INNER JOIN tb_shop s ON p.shop_id = s.id
WHERE s.name = 'rudy shop';
``

`

## 5. การอัปเดตสถานะสินค้า

เพื่ออัปเดตสถานะ ('0') ของสินค้าทั้งหมดที่เป็นของร้านที่ชื่อ "rudy shop" ใช้โค้ด SQL ต่อไปนี้:

```sql
UPDATE tb_product
SET status = '0'
WHERE shop_id = (SELECT id FROM tb_shop WHERE name = 'rudy shop');
```

## 6. การจัดรูปแบบผลลัพธ์ของ SQL Query

เพื่อจัดรูปแบบผลลัพธ์จาก SQL Query ตามประเภทข้อมูล คุณสามารถสร้างฟังก์ชัน SQL ดังตัวอย่างนี้:

```sql
CREATE FUNCTION FormatData (@data AS VARCHAR(MAX), @data_type AS VARCHAR(20))
RETURNS VARCHAR(MAX)
AS
BEGIN
    DECLARE @formatted_data VARCHAR(MAX);

    IF @data_type = 'date'
    BEGIN
        SET @formatted_data = CONVERT(VARCHAR(10), CAST(@data AS DATE), 103);
    END
    ELSE IF @data_type IN ('float', 'double')
    BEGIN
        SET @formatted_data = FORMAT(CAST(@data AS FLOAT), 'N', 'en-US');
    END
    -- เพิ่มเงื่อนไขประเภทข้อมูลอื่นๆ ที่นี่

    RETURN @formatted_data;
END;
```

## 7. การคำนวณผลลัพธ์ใบเสนอราคา

โค้ด SQL ด้านล่างเป็นตัวอย่างฟังก์ชันในการคำนวณผลลัพธ์ใบเสนอราคาตามราคาสินค้าทั้งหมดและส่วนลด:

```sql
CREATE FUNCTION CalculateQuotation (
    @total_price DECIMAL(18, 2),
    @discount DECIMAL(18, 2)
)
RETURNS TABLE
AS
RETURN
(
    SELECT
        @total_price AS total_product_price,
        @discount AS total_discount,
        (@total_price - @discount) AS product_price_after_discount,
        ((@total_price - @discount) * 0.07) AS vat,
        ((@total_price - @discount) * 1.07) AS total_price
);
```

การใช้งานฟังก์ชัน:

```sql
SELECT * FROM CalculateQuotation(1000.00, 200.00);
```
