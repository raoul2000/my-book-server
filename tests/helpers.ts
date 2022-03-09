//import { unlinkSync, readFileSync } from 'fs';
const fs = require('fs');

const emailFolderPath = './src/runtime/logs/e2e-test.log';


const clearEmailFolder = () => {
    fs.unlinkSync(emailFolderPath);
}

const readAccountActivationToken = (username, filePath) => {



    // example: [e2e] activation_token:user-c:RVKsL8R_losoLMV3kVBwv3AA8_3wV8JA
    const re = new RegExp(".*\\[e2e\\] activation_token:" + username + ":(.*)");
    const fileContent = fs.readFileSync(`${emailFolderPath}/${emailFilename}`).toString();
    const token = re.exec(fileContent);
    if(!token) {
        throw new Error('failed to extract token from account activation email');
    }
    console.log("token =", token[1]);
    return token[1];
}

readAccountActivationToken("user-c", emailFolderPath);
/*
export {
    readAccountActivationToken
};
*/