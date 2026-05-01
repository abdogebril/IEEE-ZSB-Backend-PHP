# MVC & PHP Database Concepts

## 1. MVC – Database Responsibility

**In the MVC pattern, the only part allowed to interact directly with the database is the Model. Why?**

- It handles data and business logic
- Keeps the application clean and organized
- Separates concerns between UI, logic, and data

---

## 2. Why Use a Config File for Sensitive Data?

**Sensitive information like database credentials should never be hardcoded.**

### Reasons:

- **🔒 Improves security:** Credentials are not exposed in the codebase
- **🔁 Makes updates easier:** Change database connection without modifying core code
- **🌍 Supports multiple environments:** Different settings for development, testing, and production

---

## 3. What is PDO?

**PDO (PHP Data Objects) is a database access layer in PHP.**

### Why PDO is Preferred:

- Works with multiple databases (MySQL, PostgreSQL, SQLite, etc.)
- Safer with Prepared Statements
- Cleaner and more maintainable code

### Example:

```php
$pdo = new PDO("mysql:host=localhost;dbname=test", "root", "");
```

---

## 4. Prepared Statements & SQL Injection Protection

**Prepared Statements protect your application by separating:**

- SQL query structure
- User input data

### Example:

```php
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
```

### Protection Benefits:

- ✔ User input is treated as data only, not executable SQL
- ✔ Prevents SQL Injection attacks
- ✔ Improves performance through query caching

---

## 5. Single Row vs Multiple Rows

### Single Row Example:

**Used when fetching one specific record (e.g., user profile)**

```sql
SELECT * FROM users WHERE id = 1;
```

Returns one record using:

```php
$row = $stmt->fetch(); // Gets one row
```

### Multiple Rows Example:

**Used when fetching a list (e.g., all products)**

```sql
SELECT * FROM products;
```

Returns multiple records using:

```php
$rows = $stmt->fetchAll(); // Gets all rows
```

---

## Summary

- **Model handles database operations** in MVC
- **Config files improve security and flexibility** for credentials
- **PDO is modern and secure** for database access
- **Prepared Statements prevent SQL Injection** attacks
- **Queries can return single or multiple rows** depending on use case
