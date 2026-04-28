# MVC Framework

## 1. The Controller's Role

**If a user presses the "View Profile" button, what does the Controller do before showing the page?**

The Controller is the part that handles the request first. Its job is to manage the flow between the Model and the View.

It usually does these steps:

* Receives the request from the user.
* Communicates with the Model to get profile information such as name or email.
* Prepares or arranges the returned data if necessary.
* Selects the suitable View file (Profile page).
* Sends the final data to the View so it can appear to the user.

---

## 2. Static HTML vs Dynamic PHP View

**What is the difference between them?**

### Static HTML File:

* Shows the same content every time the page opens.
* Does not react to database data or user information.

### Dynamic PHP View:

* Content can change depending on the situation.
* Can display different usernames, posts, notifications, or records from the database.

---

## 3. Passing Data from Controller to View

**How can the Controller send data to the View?**

The Controller sends values using variables or arrays, then the View uses them for display.

### Example:

```php
$data = ["name" => "Ali"];
return view("profile", $data);
```

Inside the View:

```php
<h1>Welcome, <?php echo $name; ?></h1>
```

This allows the page to show the data received from the Controller.

---

## 4. Reusing Headers and Footers

**How does MVC prevent repeating navbar and footer code on every page?**

MVC improves organization by separating common parts into reusable files.

Examples:

* `header.php`
* `footer.php`

These files can be included inside multiple Views.

```php
include "header.php";
include "footer.php";
```

### Benefit:

* Less repeated code
* Easier editing later
* Cleaner project structure

---

## 5. Why Avoid Heavy Logic Inside Views?

**Why is putting large conditions or loops inside Views considered bad practice?**

Because the View should focus only on presentation.

Problems caused by heavy logic inside Views:

* Breaks the MVC separation principle.
* Makes files harder to understand.
* Slows maintenance and debugging.
* Mixes display code with business logic.

### Best Practice:

Keep calculations and processing in the Controller or Model, and let the View only display results.

---

## Final Summary

* The **Controller** handles requests and connects Model with View.
* **Static HTML** is fixed, while **PHP Views** can change dynamically.
* Data is transferred from Controller to View using variables.
* Shared files like headers and footers reduce repetition.
* Views should stay simple and focus on displaying content only.
