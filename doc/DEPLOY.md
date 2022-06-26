# Build and Deploy

First udate the version number in `package.json`:
```json
{
  "name": "my-books",
  "version": "1.2020.6",
  "description": "Manage your book list",
  "main": "index.js",
  ...
```  

Build tasks are based on *gulp*.

From the project folder run :
```
npm run build-<TARGET>
```
Target can have 3 values:
- **dev** : local environment
- **qa** : remote test environment
- **prod** : production environment

When done, the zip file to deploy can be found in `./build/zip/source.zip`.
- upload the zip file to the installation folder on the server
- unzip with `unzip source.zip`

## Deploy to QA
- upload the built package (zip) to `./project/my-books/upload-src`
- open an ssh connecion to the target server
- jump to folder `./project/my-books/upload-src`
- start deploy 
```shell
$ ./install-qa.bash source-qa-VERSION.zip
```

## Post Actions

Once deployement is done, there may be additional tasks to perform like for instance DB migrations tasks. 
This can be achieved on the SSH console via the command:
```shell
~/project/my-books/dev$ php7.4-cli ./yii
```

For example:
- display unapplied migrations
```shell
~/project/my-books/dev$ php7.4-cli ./yii migrate/new

Yii Migration Tool (based on Yii v2.0.43)

Found 1 new migration:
        app\migrations\M220409154900AddReadDateField
```
- apply migrations
```shell
~/project/my-books/dev$ php7.4-cli ./yii migrate/up

Yii Migration Tool (based on Yii v2.0.43)

Total 1 new migration to be applied:
        app\migrations\M220409154900AddReadDateField

Apply the above migration? (yes|no) [no]:yes
*** applying app\migrations\M220409154900AddReadDateField
    > add column read_at date to table {{%user_book}} ... done (time: 0.072s)
*** applied app\migrations\M220409154900AddReadDateField (time: 0.079s)

1 migration was applied.

Migrated up successfully.
```

