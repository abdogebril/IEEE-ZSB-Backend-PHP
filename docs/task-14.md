 # Object-Oriented Programming (OOP)

 ## Definition
Object-Oriented Programming (OOP) is a programming paradigm that organizes code into classes and objects, making software easier to structure, maintain, and scale.

 - OOP stands for Object-Oriented Programming
 - It groups related data and behavior into classes
 - It improves code reusability and organization

## Example (Class & Object)
```php
class AppleDevice {
    // Properties
    public $ram = '1GB';
    public $inch = '4 Inch';
    public $space = '16GB';
    public $color = 'Silver';
}

$iphone6plus = new AppleDevice();

$iphone6plus->ram = '2GB';
$iphone6plus->inch = '5 Inch';
$iphone6plus->space = '32GB';
$iphone6plus->color = 'Gold';

echo '<pre>';
var_dump($iphone6plus);
echo '</pre>';
```

## Class Properties Concept
- Each object inherits its properties from the base class.
- If a property has a default value → it is used automatically.
- Each object can override its own values.
- OOP helps standardize property names across objects.

## 1️⃣ Class & Object
### Class
A class is a blueprint used to create objects.

### Object
An object is an instance of a class.

### Example Analogy
- Class = Apple design blueprint
- Object = iPhone devices
- Application = Apple ecosystem

## 2️⃣ `self` vs `$this`
### `self`
- Refers to the class itself.
- Used with static properties and constants.
- Accessed using `ClassName::property`.
- Does NOT use `$`.

### `$this`
- Refers to the current object.
- Used inside class only.
- Accesses non-static properties and methods.
- Uses `$` because it represents an object instance.

### Explanation
```php
$this->ownerName;
```
- `$this` refers to the current object instance.
- `ownerName` is a property inside that object.
- This value can be changed because it is a normal (non-static) property.
- Each object can have its own `ownerName` value and it can be modified freely.

```php
self::OWNERNAME;
```
- `self` refers to the class itself.
- `OWNERNAME` is a constant property inside the class.
- This value cannot be changed because it is a constant.
- All objects share the same constant value, and it is read-only.

### Full Example
```php
class AppleDevice {
    public $ownerName;
    const OWNERNAME = 7;

    public function setOwnerName($name) {
        if (strlen($name) < self::OWNERNAME) {
            echo "Owner name can't be less than 7 characters";
        } else {
            $this->ownerName = $name;
            echo "Your name has been set";
        }
    }
}
```

## Key Difference
- `$this` → current object instance (changeable properties)
- `self` → class itself (constants / static members)

## 3️⃣ Access Modifiers (Encapsulation)
### Types
- `public` — Accessible from anywhere.
- `protected` — Accessible inside the class and child classes only.
- `private` — Accessible only inside the same class.

### Why use `private`?
```php
private $lock;

public function changeLock($lo) {
    $this->lock = sha1($lo);
}
```
- Prevent direct modification.
- Force controlled updates through methods.
- Improve security using hashing.

## 4️⃣ Typed Properties
### Definition
Typed properties define the data type of class variables.
```php
public string $name;
public int $age;
```
### Benefits
- Prevent invalid data types.
- Improve code reliability.
- Strong type safety.

## 5️⃣ Constructor (`__construct`)
### Definition
A constructor is a special method that runs automatically when an object is created.

### Why it is useful
- Initializes object data instantly.
- Reduces extra setup steps.
- Makes code cleaner and more readable.

### Example
```php
class User {
    public $name;

    public function __construct($name) {
        $this->name = $name;
    }
}

$user = new User("Abdullah");
```

## Important Notes
- Variable inside class = Property
- Function inside class = Method
- Variable outside class = Variable
- Function outside class = Function
