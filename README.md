# Transfer Object Converter

### What is this package?
Package helps you get data sent via HTTP POST. If you want to get request body, there are other converters to get it.
It populates the variable which you target it to ( must be some class with properties for it to work ).

### How to use the package?

[Check it here](USAGE.md)

### How to install the package?

````
$ composer require bornfight/transfer-object-converter
````

### Tests & analysis
##### Running tests
````
$ composer test
````

##### Running tests with code coverage generated
````
$ composer ci:test
````

##### Running static analysis
````
$ composer analysis
````

##### Running static analysis with reports
````
$ composer ci:analysis
````

##### Running static analysis on tests
````
$ composer analysis:tests
````

##### Running static analysis with reports on tests
````
$ composer ci:analysis:tests
````

#### License
This library is licensed under the MIT license. Please see [LICENSE](LICENSE.md) for more details.

#### Changelog
Please see [CHANGELOG](CHANGELOG.md) for more details.

#### Contributing
Please see [CONTRIBUTING](CONTRIBUTING.md) for more details.