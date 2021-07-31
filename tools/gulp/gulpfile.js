const { src, dest, series, parallel } = require("gulp");
const del = require("del");
const {
    zipVendor,
    buildVendor,
    copyComposer,
    composerInstall,
} = require("./task/build-vendor");
const {
    buildSource,
    updateIndex,
    zipSource,
    copySource,
    copyConfig,
    cleanSource
} = require("./task/build-source");
const {
    cleanSourceVendor,
    mergeSourceVendor,
} = require("./task/merge-source-vendor");
const { deploySFtp } = require("./task/deploy-sftp");
const { deployFtp } = require("./task/deploy-ftp");

const exec = require("child_process").exec;
const path = require("path");

const workingDir = path.join(__dirname, "..", "..", "..");

function cleanBuildDir() {
    return del("build/**", { force: true, cwd: workingDir });
}

function ping() {
    return new Promise((resolve, reject) => {
        exec("ping localhost", function (err, stdout, stderr) {
            if (err) {
                reject(err);
            } else {
                console.log(stdout);
                console.log(stderr);
                resolve(true);
            }
        });
    });
}

//exports.deploySFtp = deploySFtp; // not working
exports.deployFtp = deployFtp;

exports.cleanSourceVendor = cleanSourceVendor;
exports.mergeSourceVendor = mergeSourceVendor;
exports.updateIndex = updateIndex;

exports.cleanBuildDir = cleanBuildDir;
exports.ping = ping;
exports.copyComposer = copyComposer;
exports.composerInstall = composerInstall;
exports.buildVendor = buildVendor;
exports.zipSource = zipSource;
exports.zipVendor = zipVendor;
exports.copySource = copySource;
exports.cleanSource = cleanSource;
exports.buildSource = buildSource;

// default task : build source and vendor and produce a folder ready to deploy
exports.default = series(
    cleanBuildDir,
    parallel(buildSource, buildVendor),
    mergeSourceVendor,
    zipSource
);
