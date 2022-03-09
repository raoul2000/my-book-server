import { test, expect } from '@playwright/test';

test('test', async ({ page }) => {
    
  // Go to http://localhost:8080/
  await page.goto('http://localhost:8080/');

  // Click text=Se connecter
  await page.click('text=Se connecter');
  await expect(page).toHaveURL('http://localhost:8080/index.php?r=site%2Flogin');

  // Click input[name="LoginForm\[username\]"]
  await page.click('input[name="LoginForm\\[username\\]"]');

  // Fill input[name="LoginForm\[username\]"]
  await page.fill('input[name="LoginForm\\[username\\]"]', 'admin');

  // Press Tab
  await page.press('input[name="LoginForm\\[username\\]"]', 'Tab');

  // Fill input[name="LoginForm\[password\]"]
  await page.fill('input[name="LoginForm\\[password\\]"]', 'admin');

  // Click button:has-text("Se Connecter")
  await Promise.all([
    page.waitForNavigation(/*{ url: 'http://localhost:8080/index.php' }*/),
    page.click('button:has-text("Se Connecter")')
  ]);

  // Click text=Se déconnecter (admin)
  await page.click('text=Se déconnecter (admin)');
  await expect(page).toHaveURL('http://localhost:8080/index.php');

});