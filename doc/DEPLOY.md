# Build and Deploy

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

