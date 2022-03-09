//import { unlinkSync, readFileSync } from 'fs';
const fs = require('fs');

const readEmail = () => {
    const regex = /<strong>.*token=(.*)">/s;
    const fileContent = fs.readFileSync('./src/runtime/mail/20220122-231725-3479-3182.eml').toString();
    const token = regex.exec(fileContent);
    if(!token) {
        throw new Error('failed to extract token from account activation email');
    }
    console.log("token =", token[1]);
    return token[1];

}

readEmail();