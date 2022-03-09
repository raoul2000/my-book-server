import { test, expect } from '@playwright/test';

test('test', async ({ page }) => {

  // Go to http://localhost:8080/
  await page.goto('http://localhost:8080/');

  // Click text=Créer un compte
  await page.click('text=Créer un compte');
  await expect(page).toHaveURL('http://localhost:8080/index.php?r=account%2Fcreate');

  // Click text=Se connecter
  await page.click('text=Se connecter');
  await expect(page).toHaveURL('http://localhost:8080/index.php?r=site%2Flogin');

  // Click text=J'ai oublié mon mot de passe
  await page.click('text=J\'ai oublié mon mot de passe');
  await expect(page).toHaveURL('http://localhost:8080/index.php?r=password-reset%2Frequest');

  // Click text=Mes Livresdev
  await page.click('text=Mes Livresdev');
  await expect(page).toHaveURL('http://localhost:8080/index.php');

});