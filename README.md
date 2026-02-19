![GitHub License](https://img.shields.io/github/license/MarcoConsiglio/bcmath-extended)
![Static Badge](https://img.shields.io/badge/version-v1.0.0-white)
<br>
![Static Badge](https://img.shields.io/badge/91%25-rgb(40%2C%20167%2C%2069)?label=Line%20coverage&labelColor=rgb(255%2C255%2C255))
![Static Badge](https://img.shields.io/badge/94%25-rgb(40%2C%20167%2C%2069)?label=Branch%20coverage&labelColor=rgb(255%2C255%2C255))
![Static Badge](https://img.shields.io/badge/88%25-rgb(255%2C193%2C7)?label=Path%20coverage&labelColor=rgb(255%2C255%2C255))

# bcmath-extended
This PHP library extends the [BCMath PHP estension](https://www.php.net/manual/en/book.bc.php). Since the class [`BCMath\Number`](https://www.php.net/manual/en/class.bcmath-number.php) is a final class, this library extends through composition with a child class ([`Number`](src/Number.php)). 

It was inspired by [krowinski/bcmath-extended](https://github.com/krowinski/bcmath-extended).

# Installation
```
composer require marcoconsiglio/bcmath-extended
```
# Features
## Base features
The following list of features of the `Number` class are the same as those found in `BCMath\Number`:
- Addition
- Subtracion
- Multiplication
- Division
- Exponentiation
- Square root
- Ceil
- Floor
- Round
- Cast to string

## Missing base features
- Spaceship comparison
- Comparison operator overloading
- Serialization/unserialization
- Support for scientific notation

## Added features
- Modulo *
- Power & modulo *
- Division & modulo *
- Absolute
- Min
- Max
- Random
- Equal comparison
- Different comparison
- Greater than comparison
- Greater than or equal comparison
- Less than comparison
- Less than or equal comparison

## * Consideration on modulo operation
As already pointed by *krowinsky* in [PHP issue #76287](https://bugs.php.net/bug.php?id=76287)
```
bcmod() doesn't use floor() but rather truncates towards zero,
which is also defined this way for POSIX fmod(), so that the
result always has the same sign as the dividend.  Therefore, this
is not a bug, but rather a documentation issue.
```
the modulo operation in BCMath extension is not correct in case the modulus is negative.
Therefore in this library the following formula is used:

$$ a \pmod n = a - n \times \left \lfloor {\dfrac{a}{n}} \right \rfloor $$

With this formula a negative modulus $n$ is allowed.

## Input types
The same input type set of BCMath is used:
- `int`
- `string`
- `BCMath\Number`
- `MarcoConsiglio\BCMathExtended\Number`

## String numeric format
Only decimal separator `.` is allowed. Thousand separator is not supported.

For example `"1234567.89"` is allowed while `"1,234,567.89"` is not.
