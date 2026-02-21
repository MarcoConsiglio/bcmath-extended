# Changelog
## v1.2.0 2026-02-21
### Added
- `Number::$value` property to read the value of the parent instance `BcMath\Number`.

## v1.1.0 2026-02-21
### Added
- `Number::toNumber()` method to normalize allowed input types to Number type.
### Changed
- README documentation
- API documentation

## v1.0.0 2026-02-19
### Added
- `BCMathExtended\Number` class that extends the `BCMath\Number` class.
- `BCMathExtended\Number::{`  
&ensp;&ensp;&ensp;&ensp;`getParent`,  
&ensp;&ensp;&ensp;&ensp;`isChild`,  
&ensp;&ensp;&ensp;&ensp;`add` | `plus`,  
&ensp;&ensp;&ensp;&ensp;`subtract` | `sub`,  
&ensp;&ensp;&ensp;&ensp;`multiply` | `mul`,    
&ensp;&ensp;&ensp;&ensp;`divide` | `div`,  
&ensp;&ensp;&ensp;&ensp;`modulo` | `mod`,   
&ensp;&ensp;&ensp;&ensp;`quotientAndRemainder` | `divmod`,  
&ensp;&ensp;&ensp;&ensp;`power` | `pow`,  
&ensp;&ensp;&ensp;&ensp;`powerModulo` | `powmod`,  
&ensp;&ensp;&ensp;&ensp;`squareRoot` | `sqrt`,  
&ensp;&ensp;&ensp;&ensp;`round`,  
&ensp;&ensp;&ensp;&ensp;`floor`,  
&ensp;&ensp;&ensp;&ensp;`ceil`,  
&ensp;&ensp;&ensp;&ensp;`max`,  
&ensp;&ensp;&ensp;&ensp;`min`,  
&ensp;&ensp;&ensp;&ensp;`factorial` | `fact`,  
&ensp;&ensp;&ensp;&ensp;`abs`,  
&ensp;&ensp;&ensp;&ensp;`isPositive`,  
&ensp;&ensp;&ensp;&ensp;`isNegative`,  
&ensp;&ensp;&ensp;&ensp;`isFloat`,  
&ensp;&ensp;&ensp;&ensp;`isInt`,  
&ensp;&ensp;&ensp;&ensp;`isEqual` | `eq`,   
&ensp;&ensp;&ensp;&ensp;`isDifferent` | `not`,  
&ensp;&ensp;&ensp;&ensp;`isGreaterThan` | `gt`,  
&ensp;&ensp;&ensp;&ensp;`isGreaterThanOrEqual` | `gte`,  
&ensp;&ensp;&ensp;&ensp;`isLessThan` | `lt`,  
&ensp;&ensp;&ensp;&ensp;`isLessThanOrEqual` | `lte`,  
&ensp;&ensp;&ensp;&ensp;`__toString`   
`}()` methods.
- `BCMathExtended\Random` class to generate random `BCMathExtended\Number` instances.
- `BCMathExtended\Random::number()` method.