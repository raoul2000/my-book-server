# End To End Test

Tests are powered by [Playwright](https://playwright.dev).

Configuration file is `playwright.config.ts` - [read more](https://playwright.dev/docs/test-configuration).

## Record tests

```bash
$ npx playwright codegen http://localhost:8080
```

## Run tests

```bash
$ npx playwright test
# headed browser
$ npx playwright test --headed
```