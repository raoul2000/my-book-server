import { test, expect } from "@playwright/test";

test("test", async ({ page }) => {

    const username = "user-c";
    const userEmail = "user-c@email.com";

    // Go to http://localhost:8080/
    await page.goto("http://localhost:8080/");

    // Click text=Créer un compte
    await page.click("text=Créer un compte");
    await expect(page).toHaveURL(
        "http://localhost:8080/index.php?r=account%2Fcreate"
    );

    // Click input[name="UserRegistrationForm\[username\]"]
    await page.click('input[name="UserRegistrationForm\\[username\\]"]');

    // Fill input[name="UserRegistrationForm\[username\]"]
    await page.fill(
        'input[name="UserRegistrationForm\\[username\\]"]',
        username
    );

    // Press Tab
    await page.press('input[name="UserRegistrationForm\\[username\\]"]', "Tab");

    // Fill input[name="UserRegistrationForm\[email\]"]
    await page.fill(
        'input[name="UserRegistrationForm\\[email\\]"]',
        userEmail
    );

    // Press Tab
    await page.press('input[name="UserRegistrationForm\\[email\\]"]', "Tab");

    // Fill input[name="UserRegistrationForm\[password\]"]
    await page.fill(
        'input[name="UserRegistrationForm\\[password\\]"]',
        "Password1"
    );

    // Press Tab
    await page.press('input[name="UserRegistrationForm\\[password\\]"]', "Tab");

    // Fill input[name="UserRegistrationForm\[password_confirm\]"]
    await page.fill(
        'input[name="UserRegistrationForm\\[password_confirm\\]"]',
        "Password1"
    );

    // Click text=Créer mon compte
    await Promise.all([
        page.waitForNavigation(/*{ url: 'http://localhost:8080/index.php?r=account%2Fcreate' }*/),
        page.click("text=Créer mon compte"),
    ]);
});
