# 🧠 OOP Concepts in PHP

## 1) Inheritance

### Inheritance Definition:
Inheritance in Object-Oriented Programming (OOP) is a mechanism where a child class acquires the properties and methods of a parent class.

### Main Benefit of Inheritance:
The main benefit of inheritance in OOP is code reuse. It allows a child class to inherit properties and methods from a parent class, reducing redundancy and making code easier to maintain and read.

### Example:
```php
<?php

class AppleDevice {

    public $ram;
    public $color;

    public function setSpec($ra, $co) {
        $this->ram   = $ra;
        $this->color = $co;
    }
}

class Sony extends AppleDevice {

}

$iphone = new AppleDevice();
$iphone->setSpec("2GB", "Silver");
print_r($iphone);

$sony = new Sony();
$sony->setSpec("3GB", "Black");
print_r($sony);

?>
```

We can add the same function `public function setSpec` in the child class with the same parameters and same behavior (no difference).

### Important Differences (that may cause problems):

- **Number of Parameters**
  - If you reduce them → Error
  - You can increase them only if you use default values

- **Arrangement of Parameters**
  - Changing the arrangement may break how the function is used

- **Type of Parameters**
  - Changing types in an incompatible way may cause errors

- **Access Modifier (public / protected / private)**
  - You cannot make it more restrictive (e.g., public → private)


<hr color = "red">

## 2) Final Keyword in OOP

### What happens if you use final?

**Final Class:**
If you put final before a class, it cannot be inherited.

**Final Method:**
If you put final before a method, it cannot be overridden.

### Why would a developer use final?
- To protect the code from being changed or modified
- To make the design more secure and stable

### Simple Example:
```php
<?php

class AppleDevice {

    final public function show() {
        echo "Hello";
    }
}

class Sony extends AppleDevice {

    // ❌ Error: cannot override final method
    public function show() {
        echo "Hi";
    }
}

?>
```

<hr color = "red">

## 3) Overriding Methods

### What does it mean to override a method?
- Overriding a method means redefining a method in the child class that already exists in the parent class using the same name and parameters, but with a different implementation.

### How to call the parent method inside the overridden method?
- In this example, we are not calling the parent method. We are only changing the implementation in the child class.

### Example:
```php
<?php

class AppleDevice {

    public $name;

    public function sayHello($n) {
        $this->name = $n;
        echo "Welcome To " . $n;
    }
}

class Sony extends AppleDevice {

    public $ram = "1GB";

    public function sayHello($n) {
        $this->name = $n;
        echo "Hello From Sony " . $n . " Device Has " . $this->ram . " Ram";
    }
}

$sony = new Sony();
$sony->sayHello("Sony");

?>
```

### Explanation:
In the Sony child class we changed the printing logic (implementation).
This means overriding = changing the implementation of a function, not its name or parameters.

<hr color = "red">

##  Abstract Class (Abstraction)

### What is an Abstract Class?
An abstract class cannot be instantiated, which means you cannot create objects from it.
It is designed to be a base class for other classes to inherit from.

```php
<?php

abstract class MakeDevice {

    abstract public function testPerformance();
    abstract public function sayWelcome($n);
}

$obj = new MakeDevice();

?>
```

❌ This is not allowed because abstract classes cannot be instantiated.
This means you cannot create objects from them.

### Abstract Methods
- Abstract methods are methods declared without a body in the abstract class, and must be implemented in the child class.

### Rule
- We must implement all abstract methods in the child class, it is an obligation.

### Example 1 (Missing Implementation → Error)
```php
<?php

abstract class MakeDevice {

    abstract public function testPerformance();
    abstract public function sayWelcome($n);
}

class Iphone extends MakeDevice {

}

?>
```

❌ **Error:**
Two functions are not implemented:
- testPerformance()
- sayWelcome()

### How to fix it?
We must implement all abstract methods inside the child class.

### Correct Example
```php
<?php

abstract class MakeDevice {

    abstract public function testPerformance();
    abstract public function sayWelcome($n);
}

class Iphone extends MakeDevice {

    public function testPerformance() {
        echo "Performance is good";
    }

    public function sayWelcome($n) {
        echo "Welcome " . $n;
    }
}

?>
```
<hr color = "red">

## 4) Abstract Class vs Interface

Both are used for abstraction but are different.

### 🟩 Abstract Class

**Can contain:**
- Methods with implementation
- Abstract methods

**Idea:** Partial implementation + rules

```php
<?php

abstract class Animal {
    public function sleep() {
        echo "Sleeping";
    }

    abstract public function sound();
}

?>
```

### 🟦 Interface

**Contains only:**
- Method declarations (no implementation)

**Idea:** Only rules (contract)

```php
<?php

interface Animal {
    public function sound();
    public function move();
}

class Cat implements Animal {

    public function sound() {
        echo "Meow";
    }

    public function move() {
        echo "Walk";
    }
}

?>
```

### 📌 Note:
A class can implement multiple interfaces.

<hr color = "red">

## 5) Polymorphism

### 📌 Definition:
Polymorphism means different objects can use the same method name, but each behaves differently.
In simple words: **Same method → different behavior depending on object.**

### 🟦 Using Interface:
```php
<?php

interface Animal {
    public function sound();
}

class Dog implements Animal {
    public function sound() {
        echo "Woof<br>";
    }
}

class Cat implements Animal {
    public function sound() {
        echo "Meow<br>";
    }
}

$dog = new Dog();
$dog->sound();

$cat = new Cat();
$cat->sound();
?>
```

### 🟩 without interface
```php
<?php

class Animal {
    public function sound() {
        echo "Some sound<br>";
    }
}

class Dog extends Animal {
    public function sound() {
        echo "Woof<br>";
    }
}

class Cat extends Animal {
    public function sound() {
        echo "Meow<br>";
    }
}

$dog = new Dog();
$dog->sound();

$cat = new Cat();
$cat->sound();

?>
```

### <span style="color:green;">so the Difference bitween  `Abstraction` & `polymorphism`(interface) is :</span>


- `polymorphism`: only method declarations (no implementation).

- `Abstraction` : mix of implemented methods + abstract methods (partial implementation).