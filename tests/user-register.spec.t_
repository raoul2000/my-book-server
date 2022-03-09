import { test, expect } from '@playwright/test';
import {readEmail} from './helpers';
import fs from 'fs';

/*
const readEmail = () => {
  const fileContent = fs.readFileSync('./src/runtime/mail/20220122-231725-3479-3182.eml');
  console.log(fileContent);
}
*/

test('create user - no account validation', async ({ page }) => {
  readEmail();
  await page.goto('http://localhost:8080/');
  await page.pause();
  await expect(page).toHaveTitle(/Mes Livres/);
  await page.locator('text=Créer un compte').click();

  // fill user registration form
  await expect(page).toHaveTitle(/Créer mon compte/);
  await page.fill('#userregistrationform-username', 'user1');
  await page.fill('#userregistrationform-email', 'user@email.com');
  await page.fill('#userregistrationform-password', 'Password1');
  await page.fill('#userregistrationform-password_confirm', 'Password1');
  await page.locator('text=Créer mon compte ').click();

  await expect(page.locator('.alert-success').first()).toBeVisible();
  
  // login with newly created user
  await page.locator('text=Se connecter').click();
  await expect(page).toHaveTitle(/Se Connecter/);

  await page.fill('#loginform-username', 'user1');
  await page.fill('#loginform-password', 'Password1');

  await page.locator('Button.btn-primary').click(); // login button
  await expect(page).toHaveTitle(/Mes Livres/);
  const logoutButton = page.locator('Button.logout');
  await expect(logoutButton).toContainText(/Se déconnecter/);

  await logoutButton.click(); // logout

  await expect(page.locator('text=Se connecter')).toBeVisible();
  
});
