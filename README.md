# Data Transfer Objects

> A variation / interpretation of the Data Transfer Object (DTO) design pattern (Distribution Pattern). A DTO is nothing more than an object that can hold some data. Most commonly it is used for transporting that data between system layers.

## Installation
You can install the package via composer:

```sh
composer require imbue/data-transfer-object
```

## Usage

### Example

Example DataTransferObject
```php
class BookData extends DataTransferObject
{
    protected $title;
    protected $author;

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @param AuthorData $author
     */
    public function setAuthor(AuthorData $author)
    {
        $this->author = $author;
    }

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

Example structure
```php
$book = new BookData();
$book->setTitle('Harry Potter: The Goblet of Fire');

$author = new Author();
// ....

$book->setAuthor($author);
```

#### Data Collections
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

```
foreach ($booksCollection as $bookData) {
    $bookData-> // type hinting 
}
```

#### Helper functions
```php
$bookData
    ->only('title')
    ->toArray();
    
$bookData
    ->except('title')
    ->toArray();
```

These helpers are immutable, which means they wont affect the original data transfer object.

### Testing
```sh
composer test
```

## Credits
- [Liam](https://github.com/imbue)
- This package is based on the [data-transfer-object package](https://github.com/spatie/data-transfer-object) of [Spatie](https://github.com/spatie).  
- `Arr` class contains functions copied from [Laravel's](https://github.com/laravel) Arr helper.

