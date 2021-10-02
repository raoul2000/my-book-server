Fixtures are defined as : 

- one class (eg `tests\unit\fixtures\BookFixture`)
- one data file per class.

To play with fixtures, move to the folder `./src`.

- apply the *Book* Fixture
```bash
$ php yii fixture/load Book
```
- remove the *Book* Fixture
```bash
$ php yii fixture/unload Book
```

# Fixture Catalog

## 500 books

Uuser *bob* has 500 *books*
```bash
$ php yii fixture/load UserBook
```