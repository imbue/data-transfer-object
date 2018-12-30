# Data Transfer Objects

A variation / interpretation of the Data Transfer Object (DTO) design pattern (Distribution Pattern). A DTO is nothing more than an object that can hold some data. Most commonly it is used for transporting that data between system layers.

## Installation
You can install the package via composer

```bash
composer require imbue/data-transfer-object
```

## Usage
- [Introduction](#introduction)
- [Accessors & Mutators](#getters-and-setters)
    - [Defining A Getter](#defining-a-getter)
    - [Defining A Setter](#defining-a-setter)
- [Serializing Objects & Collections](#serializing-objects-and-collections)
    - [Serializing To Arrays](#serializing-to-arrays)
    - [Serializing To JSON](#serializing-to-json)
- [Collections](#collections)
- [Helpers](#helpers)
- [Example](#example)


<a name="introduction"></a>
## Introduction

Using getter/setter methods gives the advantage of type hinting all data being set. Thus any data object will be transparent and easy to use without the need of additional documentation, for example the API client you're writing. 

<a name="getters-and-setters"></a>
## Getters & Setters

<a name="defining-a-getter"></a>
### Defining A Getter

To define a getter, simply create a `get...()` method on your data object

```php
class BookData extends DataTransferObject
{
    protected $title;
    protected $author;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return AuthorData
     */
    public function getAuthor(): AuthorData
    {
        return $this->author;
    }
}
```

<a name="defining-a-setter"></a>
### Defining A Setter

To define a setters, simply create a `set...()` method on your data object

```php
class BookData extends DataTransferObject
{
    protected $title;
    protected $author;

    /**
     * @param nullable|string $title
     */
    public function setTitle(?string $title)
    {
        return $this->title;
    }

    /**
     * @param AuthorData $author
     */
    public function setAuthor(AuthorData $author)
    {
        return $this->author;
    }
}
```


<a name="serializing-objects-and-collections"></a>
## Serializing Objects & Collections

<a name="serializing-to-arrays"></a>
### Serializing To Arrays

To convert a value object and its nested objects/collections to an array, you can use the `toArray` method. This method is recursive, so all attributes will be converted to arrays:

```php
return $dataObject->toArray();
```

<a name="serializing-to-json"></a>
### Serializing To JSON

To convert a value object and its nested objects/collections to a JSON object, you can use the `toJson` method. This method is recursive, so all attributes will be converted into JSON:

```php
return $dataObject->toJson();
```

<a name="collections"></a>
## Collections

In some cases you may want to have a collection of multiple data objects. By extending the provided `DataTransferObjectColletion` class, you can easily set up a group of DTOs

```php
$collection = new BooksCollection([
    $bookOne,
    $bookTwo,
    $bookThree
]);

$collection->toArray();
```

#### Auto completion for collections
By overriding the `current()` method and setting the return value, you can enable type hinting.

```php
class BooksCollection extends DataTransferObjectCollection
{
    public function current(): BookData
    {
        return parent::current();
    }
}
```

```php
foreach ($booksCollection as $bookData) {
    $bookData-> // type hinting 
}
```

<a name="helpers"></a>
## Helpers

There are a few helper methods to provide some extra functionality

#### only()
```php
$dataObject
    ->only('title')
    ->toArray();
```

#### except()
```php
$dataObject
    ->except('title')
    ->toArray();
```

##### Immutability
These helpers are immutable, which means they wont affect the original data transfer object.

<a name="example"></a>
## Example

Using the data objects is made as simple as possible
```php
$book = new BookData();
$book->setTitle('Harry Potter: The Goblet of Fire');

$author = new Author();
// ....

$book->setAuthor($author);
```

## Security
If you discover any security related issues, please use the issue tracker.

## Testing
```bash
composer test
```

## Credits
- This package is based on the [data-transfer-object package](https://github.com/spatie/data-transfer-object) from [Spatie](https://github.com/spatie).  
- `Arr` class contains functions copied from [Laravel's](https://github.com/laravel) Arr helper.
