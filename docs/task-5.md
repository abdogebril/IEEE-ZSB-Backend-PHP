# Website Security in PHP

Security is a state of being protected or safe.

## Why Website Security?
- A website is public, so anyone can access it.
- Users store personal and sensitive information.
- Many users reuse the same password across different websites.
- Security requires long-term learning and experience.
- Software must always be updated because older versions contain security vulnerabilities that are fixed in new versions.
- There is no absolute security.

## What is a Hacker?
Hackers are people who try to break into computer systems or websites.

### Types of Hackers
- White Hat Hacker: Ethical hacker who uses legal methods to find vulnerabilities and report them to companies.
- Black Hat Hacker: Illegal hacker who exploits systems for malicious purposes.

## Social Engineering
Social engineering is a technique used to trick users into giving sensitive information or access voluntarily instead of attacking the system directly.

## Social Engineering Techniques
- Keep Confidential Information Hidden: Do not expose passwords or sensitive data. Even visible exposure can be used against you.
- Trash (Dumpster Diving): Searching through trash or discarded documents to find useful information.
- Keylogger: A tool that records everything typed on a keyboard to steal sensitive data.
- Publicly Available Information: Collecting personal data from social media or public sources.
- Password Reset Security Questions: Guessing or exploiting answers to reset passwords.
- Phishing: Fake messages or links used to trick users into revealing sensitive data.

## Private and Public Folders
### What is the attack?
Sensitive files inside a project may become accessible from the browser if the project is not structured correctly.

### How it happens?
- All files are placed inside a public directory
- The server allows direct access to internal files
- Attackers can view source code or sensitive configuration files

### How to prevent it?
- Create a public folder for accessible files only
- Create a private folder for sensitive files
- Configure the server to expose only the public folder

## Avoid Directory Listing
### What is the issue?
Directory listing allows attackers to view all files inside a folder if no index file exists.

### How it happens?
- Missing index.php or index.html
- Server shows all files in the directory

### How to prevent it?
- Add an empty index.php file in every folder
- Disable directory listing using .htaccess

```apache
Options -Indexes
```

## Using PHP Extensions (Public File Exposure Issue)

###  What is the issue?
This issue happens when sensitive data is stored in publicly accessible files such as JSON or PHP files. It is often misunderstood as a protection method, but it is not real security.

###  How it happens
When a file like `john.json` is placed in a public directory, the browser can access it directly and display its content because it is a static file served by the server.

###  How to prevent it in PHP
Instead of using public JSON files, sensitive data should be handled using PHP files.

If a `.php` file does not use `echo` or output functions, nothing will be displayed in the browser.

###  Example

 JSON file (visible directly)
```json
{
  "name": "John",
  "age": 20
}
```
If opened in browser: `john.json` → data is shown directly

##  PHP file (no output)

### `john.php`
```php
<?php
$name = "John";
$age = 20;
?>
```



#  PHP Code Injection

##  What is the attack?
PHP Code Injection is a security vulnerability that happens when an attacker is able to make the server execute PHP code that was not written by the developer. Instead of running the developer’s code, the server executes code controlled by the attacker.

##  How it happens
This happens when the developer uses `include` or `require` with user input without validation.

```php
$page = $_GET['page'];
include($page . ".php");
```

###  How it happens
- The user controls the value of `page`
- The server directly includes a file based on user input
- The attacker can manipulate the input to include unintended files or execute malicious code

###  How to prevent it
To prevent PHP Code Injection:

- Use whitelist of allowed files
- Validate user input before using it in include or require
- Restrict access to files outside the intended directory
- Prevent directory traversal like `../`

##  Secure Approach

```php
$page = $_GET['page'];

$files = glob("*.php");

if (in_array($page . ".php", $files)) {
    require($page . ".php");
} else {
    echo "couldn't find the file";
}
```

#  Concept: Keep It Simple & Less Points of Entry

We should not put all code in one file because it becomes large and hard to maintain.
Instead, we separate the code into small files, where each file has one responsibility (like login, signup, etc.) inside an `includes` folder.
Then, we use a single entry point (`index.php`) to control which page is loaded.

---

##  Security Benefit
- Reduces number of entry points
- Prevents direct access to internal files
- Gives full control through `index.php`
- Ensures validation before loading any file
- Blocks unauthorized file inclusion

---

##  Solution Code

```php
<?php

$folder = "includes/";
$files = glob($folder . "*.php");

$page = isset($_GET['page']) ? $_GET['page'] : "home";

$file_name = $folder . $page . ".php";

if (in_array($file_name, $files)) {
    include($file_name);
} else {
    include "includes/404.php";
}
```
