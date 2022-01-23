//import { unlinkSync, readFileSync } from 'fs';
const fs = require('fs');

const emailFolderPath = './src/runtime/mail';


const clearEmailFolder = () => {
    fs.unlinkSync(emailFolderPath);
}

const readAccountActivationToken = () => {

    const emailFiles = fs.readdirSync(emailFolderPath);
    if(emailFiles.length !== 1) {
        throw new Error('single email file not found : found ' + emailFiles.length + ' file(s) instead of 1');
    }
    const emailFilename = emailFiles[0];

    const regex = /<strong>.*token=(.*)">/s;
    const fileContent = fs.readFileSync(`${emailFolderPath}/${emailFilename}`).toString();
    const token = regex.exec(fileContent);
    if(!token) {
        throw new Error('failed to extract token from account activation email');
    }
    console.log("token =", token[1]);
    return token[1];
}

readAccountActivationToken();
/*
export {
    readAccountActivationToken
};
*/