# PHP Visibility Markers in Abstract Class

## 1️⃣ public
👉 **Accessible everywhere**
- Inside the class - ✅
- Inside child classes - ✅
- Outside the class - ✅
- ✔️ **Can be abstract**

```php
abstract public function sound();
```

## 2️⃣ protected
👉 **Accessible inside class + child classes only**
- ❌ Not accessible outside
- ✔️ **Can be abstract**

```php
abstract protected function move();
```

## 3️⃣ private
👉 **Accessible only inside the same class**
- ❌ Cannot be abstract ❌

### 💥 Why?
Because abstract methods must be implemented in child classes, but private methods are not visible to child classes.

---

## Full Example

```php
abstract class Animal {

    abstract public function sound();

    abstract protected function move();

    public function eat() {
        echo "Eating<br>";
    }

    private function sleep() {
        echo "Sleeping<br>";
    }
}

class Dog extends Animal {

    public function sound() {
        echo "Woof<br>";
    }

    protected function move() {
        echo "Dog running<br>";
    }
}
```

---



## Overview
Method With Special Name Start With Double Underscore ( `__` )

The important types are:

---

## 1️⃣ `__construct()`
- Called When Object Is Created
- Can be Inherited

### 💡 Key Concept
The `__construct()` method is a special method that implements its code automatically when creating an object.

### Example
```php
class Iphone
{
    public $name;
    public $ram;

    public function __construct($n)
    {
        $this->name = $n;
        echo "Hello " . $n;
    }
}

echo "<pre>";
$phone = new Iphone("Osama");
print_r($phone);
echo "</pre>";
```

**Note:** The `__construct()` method is still a method that can have parameters. If we want to add a parameter, we can write it after creating the object:
```php
$phone = new Iphone("Osama");
```

---

## 2️⃣ `__destruct()`
- Called When Object Is Destroyed
- It ends the object work, for example closing the connection (like database connection) when the script finishes or the object is no longer needed.

---

## 3️⃣ `__call()` Method

### What is it?
It is a Magic Method that is called when you try to use a method that does not exist or is not accessible (like private or protected methods).

### Parameters
- `$method` → the name of the method that was called
- `$params` → the arguments passed to that method

### Example
```php
class Iphone {

    public $name;
    public $ram;

    public function __call($method, $params)
    {
        echo "The method " . $method . " Not Found";
    }
}

$phone = new Iphone();

$phone->sayHello();

echo "<pre>";
print_r($phone);
echo "</pre>";
```

---

## 4️⃣ `__get()` and `__set()` Magic Methods

### `__get()`
- Called when getting a property that is not accessible or not found
- Accepts one parameter: `$prop`

### `__set()`
- Called when setting a value to a property that is not accessible or not found
- Accepts two parameters: `$prop`, `$value`

### Example
```php
class Iphone {

    public $name;
    public $ram;
    private $coloring;

    public function __get($prop)
    {
        return "You tried to access: " . $prop . " (Not found or not accessible)";
    }

    public function __set($prop, $val)
    {
        echo "You tried to set " . $prop . " = " . $val . " (Not found or not accessible)<br>";
    }
}

$phone = new Iphone();

// set
$phone->coloring = "Red";

// get
echo $phone->coloring;
```

---

## 🔥 The Important Question

### If you remove `__get()` and `__set()` and try this:

```php
$phone->coloring = "Red";
echo $phone->coloring;
```

#### This line:
```php
$phone->coloring = "Red";
```
PHP tries to add a property named `coloring` but it is private
- 👉 **Result:** ❌ Error or Warning (you are not allowed to modify it from outside the class)

#### This line:
```php
echo $phone->coloring;
```
PHP tries to read `coloring` which is also private
- 👉 **Result:** ❌ Fatal Error: Cannot access private property

---

## 🧠 Why `__get()` and `__set()` are Important?

**If they exist:**
PHP instead of giving an error, it calls them and says:
> 🙇 "someone tried to read/write something not allowed"

This allows you to handle the access gracefully instead of causing fatal errors!

.
<hr color = "violet">
<hr color = "violet">
.

# Clone in PHP

## 📌 Simple Idea
`clone` means you take an object and make a real copy of it (not just a reference).

Think of it like: you copied a file on your PC → now you have 2 separate files

## 📌 Why We Use It
Sometimes you don't want to use the same object. You want another one with the same data but independent.

## 📌 Code Example

```php
class Iphone {
    public $name;
    public $email;

    public function __construct($n, $e) {
        $this->name = $n;
        $this->email = $e;
    }
}

$main = new Iphone("Osama", "0@0.com");

$copy = clone $main;

$main->name = "Sayed";
$copy->name = "Mahmoud";

print_r($main);
print_r($copy);
```

## 📌 What Happens
- `$copy` starts with the same values as `$main`
- After that, each one is separate
- Changing `$main` → does NOT affect `$copy`
- Changing `$copy` → does NOT affect `$main`

.
<hr color = "violet">
<hr color = "violet">
.

# Static Keyword in PHP

## 💡 Definition
Static properties and methods are used to access data without creating an object (instance) of the class.

## 🔹 Key Points

### Access Without Creating an Object
When you declare a property or method as static, you can access it using the class name directly:

```php
Iphone::$name;
Iphone::sayHello();
```

### No `$this` Inside Static Methods ❌
Static methods are called without an object, so `$this` is NOT available:

```php
public static function test() {
    echo $this->name; // ❌ Error
}
```

Use `self::` instead:

```php
public static function test() {
    echo self::$name; // ✅ Correct
}
```

### Static Properties Should Not Be Accessed Using an Object ❌

**Wrong:**
```php
$phone = new Iphone();
echo $phone->name; // ❌ Error
```

**Correct:**
```php
echo Iphone::$name; // ✅ Correct
```

### Static Methods with Objects (Works but Not Recommended)

**Works but not recommended:**
```php
$phone = new Iphone();
$phone->sayHello(); // ✅ works but ❗ not recommended
```

**Better approach:**
```php
Iphone::sayHello(); // ✅ Recommended
```

## 🔹 Major Benefit
Static properties keep their value during the whole script execution.

.
<hr color = "violet">
<hr color = "violet">
.

# Method Chaining in PHP

## 📌 What is it?
Method Chaining allows calling multiple methods on the same object in one line, when each method returns `$this`.

## ⚙️ Example
```php
$phone->pressPower()->bootPhone()->sayWelcome();
```

## 🧩 Understanding `$this`
- `$this` = current object instance
- Returning `$this` allows chaining methods

## 💡 Code Example

```php
class Iphone {

    public function pressPower() {
        echo "Power pressed<br>";
        return $this;
    }

    public function bootPhone() {
        echo "Booting...<br>";
        return $this;
    }

    public function sayWelcome() {
        echo "Welcome<br>";
        return $this;
    }
}
```

## 🚀 Usage

```php
$phone = new Iphone();

$phone->pressPower()
      ->bootPhone()
      ->sayWelcome();
```

## ❗ Without `return $this`
Chaining will break ❌ — you can't call the next method.

## ✔️ With `return $this`
Methods chain smoothly ✔️ → Cleaner and shorter code!

.
<hr color = "violet">
<hr color = "violet">
.

# Single Inheritance in PHP

## ❌ Multiple Inheritance Not Supported

**The Rule:**
PHP supports **Single Inheritance only**, which means:
- ✔️ You can inherit from **one class only**
- ❌ You cannot inherit from multiple classes

**Not allowed in PHP:**
```php
class C extends A, B { } // ❌ Syntax Error
```

here we solve this problem by
## PHP Traits

# 📌 What is a Trait?
A Trait is used to reuse methods inside multiple classes **without inheritance**.

Traits are a solution for PHP's lack of multiple inheritance support.

## 📌 Individual Traits

### Trait 1: FingerPrint
```php
trait FingerPrint {
    public function feature() {
        echo "Fingerprint Feature<br>";
        return $this;
    }
}
```

### Trait 2: FaceDetect
```php
trait FaceDetect {
    public function faceFeature() {
        echo "Face Detect Feature<br>";
        return $this;
    }
}
```

### Trait 3: ThreeDimensionTouch
```php
trait ThreeDimensionTouch {
    public function threeD() {
        echo "3D Touch Feature<br>";
        return $this;
    }
}
```

## 📦 Combined Trait
You can combine multiple traits into a single trait:

```php
trait AllFeatures {
    use FingerPrint, FaceDetect, ThreeDimensionTouch;
}
```

## 📱 Using Traits in a Class

```php
class AppleDevice {

    use AllFeatures;

    public function sayHello() {
        echo "Hello from Apple Device<br>";
        return $this;
    }
}

$device = new AppleDevice();

$device->feature()
       ->threeD()
       ->faceFeature()
       ->sayHello();
```

## 🎯 Benefits of Traits
- ✅ Reuse code in multiple classes
- ✅ Avoid code duplication
- ✅ Alternative to multiple inheritance
- ✅ Clean and organized code
- ✅ Works well with method chaining (when methods return `$this`)

---

# Trait Priority Rules

## ⚠️ Class Method vs Trait Method

**Priority Rule:** If a method exists in both Class and Trait, the **Class method wins**.

### 💡 Example

```php
trait MyTrait {
    public function sayHello() {
        echo "Hello from Trait<br>";
    }
}

class User {

    use MyTrait;

    public function sayHello() {
        echo "Hello from Class<br>";
    }
}
```

### Usage
```php
$user = new User();
$user->sayHello();
```

**Result:**
```
Hello from Class
```

✔️ Class method overrides Trait method

---

## ⚠️ Conflict Resolution (Multiple Traits)

### 💥 The Problem
Two traits have the same method name → which one should be used?

### Example Conflict

```php
trait A {
    public function test() {
        echo "A";
    }
}

trait B {
    public function test() {
        echo "B";
    }
}
```

### ✔️ Solution 1: `insteadof` (Choose One)

```php
class Demo {

    use A, B {
        A::test insteadof B;
    }
}
```

**Meaning:** Use A version, ignore B

### Usage
```php
$demo = new Demo();
$demo->test(); // Outputs: A
```

### ✔️ Solution 2: `as` (Rename)

```php
class Demo {

    use A, B {
        B::test as testB;
    }
}
```

**Meaning:** Rename B::test to testB, so you can use both

### Usage
```php
$demo = new Demo();

$demo->test();   // from A → Outputs: A
$demo->testB();  // from B → Outputs: B
```
.
<hr color = "violet">
<hr color = "violet">
. 

# PHP Namespaces

## 📌 What is a Namespace?
A Namespace in PHP is used to organize classes into separate logical groups and prevent name conflicts between classes.

## 🧠 Why Do We Use It?
- ✔️ Avoid class name conflicts
- ✔️ Organize large projects
- ✔️ Make code structure cleaner
- ✔️ Required in frameworks like Laravel

## 📦 Example Structure

We separate Apple products into different namespaces:

### 📱 Phones Namespace
```php
namespace Apple\Hardware\Phones;

class CreatePhone {

    public function sayHello() {
        echo "Hello from Apple iPhone<br>";
    }
}
```

### 📱 Tablets Namespace
```php
namespace Apple\Hardware\Tablets;

class CreateTablet {

    public function sayHello() {
        echo "Hello from Apple iPad<br>";
    }
}
```

### 🚀 How to Use Them

```php
use Apple\Hardware\Phones\CreatePhone;
use Apple\Hardware\Tablets\CreateTablet;

$phone = new CreatePhone();
$phone->sayHello();

$tablet = new CreateTablet();
$tablet->sayHello();
```

## 🧠 Key Idea

Namespaces allow you to have:
- ✔️ Same class name in different places
- ✔️ No conflicts in large applications
- ✔️ Clean project structure

<hr color = "violet">
<hr color = "violet">

# Autoload in PHP

## 📌 What is Autoload?
Autoload means PHP automatically loads a class file when you use a class **without manually writing `require` or `include`**.

Instead of loading files one by one, PHP does it for you when needed.

## 🔥 Why We Need Autoload?

### Without Autoload (❌ Messy)
```php
require "classes/Iphone.class.php";
require "classes/User.class.php";
require "classes/Product.class.php";
require "classes/Order.class.php";
// ... and many more
```

In big projects, this becomes annoying and messy.

### With Autoload (✅ Clean)

```php
spl_autoload_register(function ($class) {
    require 'classes/' . $class . '.class.php';
});
```

Now you just use classes without requiring them!

## 🧠 How It Works Step by Step

### Example
```php
$phone = new Iphone();
```

PHP does this automatically:

1. It sees class name: `Iphone`
2. It checks: "Do I know this class?"
3. If NOT found → it calls the autoload function
4. It sends the class name: `"Iphone"`
5. It runs:
   ```php
   require 'classes/Iphone.class.php';
   ```

## 🎯 Benefits
- ✅ No need to manually include files
- ✅ Cleaner code
- ✅ Automatic file loading
- ✅ Essential for large projects and frameworks


