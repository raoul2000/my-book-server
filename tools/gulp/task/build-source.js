const { src, dest, series } = require("gulp");
const rename = require("gulp-rename");
const del = require("del");
const zip = require("gulp-zip");
const fs = require("fs");
const path = require("path");
const chmod = require("gulp-chmod");
const { buildTarget, TARGET_DEV, TARGET_PROD } = require("./target-env.js");

const workingDir = path.join(__dirname, "..", "..", "..");
const pkg = JSON.parse(
    fs.readFileSync(path.join(workingDir, "package.json"))
);
console.log("target  = " + buildTarget);
console.log("version = " + pkg.version);

function createBuildTs() {
    const now = new Date();
    return [
        [
            now.getFullYear(),
            ("0" + (now.getMonth() + 1)).slice(-2),
            ("0" + now.getDate()).slice(-2),
        ].join(""),
        [
            ("0" + now.getHours()).slice(-2),
            ("0" + now.getMinutes()).slice(-2),
            ("0" + now.getSeconds()).slice(-2),
        ].join(""),
    ].join("-");
}
/**
 * Updates the file ./web/index.php for Production purposes
 */
function updateIndex() {
    // @ts-ignore


    return new Promise((resolve, reject) => {
        const filepath = path.join(workingDir, "build/source/web/index.php");
        const buildTs = createBuildTs();

        fs.readFile(filepath, "utf-8", (err, data) => {
            if (err) {
                reject(err);
            } else {
                const result = data
                    .replace(
                        "defined('YII_DEBUG') || define('YII_DEBUG', true);",
                        "//defined('YII_DEBUG') || define('YII_DEBUG', true);"
                    )
                    .replace(
                        "defined('YII_ENV') || define('YII_ENV', 'dev');",
                        "//defined('YII_ENV') || define('YII_ENV', 'dev');"
                    )
                    .replace("%%VERSION%%", pkg.version)
                    .replace("%%BUILD%%", buildTs);

                fs.writeFile(filepath, result, (err) => {
                    if (err) {
                        reject(err);
                    } else {
                        resolve(true);
                    }
                });
            }
        });
    });
}

function preserveEmptyfolders() {
    return new Promise((resolve, reject) => {
        const filepath = path.join(workingDir, "build/source/web/assets/keep");
        fs.writeFile(filepath, "keep this folder", (err) => {
            if (err) {
                reject(err);
            } else {
                resolve(true);
            }
        });
    });
}
function cleanSource() {
    return del("build/source/**", { force: true, cwd: workingDir });
}

function copySource() {
    return src(
        [
            "src/**",
            "!src/README.md",
            "!src/config/db*.php",
            "!src/config/params*.php",
            "!src/config/test*",
            "!src/LICENSE.md",
            "!src/*.yml",
            "!src/composer.*",
            "!src/runtime/*/**",
            "!src/vendor/**/**",
            "!src/web/assets/*/**",
            "!src/web/files/qr-codes/*.*",
            "!src/web/index-test.php",
        ],
        { cwd: workingDir }
    ).pipe(
        dest("build/source", {
            cwd: workingDir,
        })
    );
}

/**
 * Example on how to create an empty folder in build
 */
function createRuntimeFolders() {
    return src("*.*", { read: false })
        .pipe(dest("../../build/source/runtime"))
        .pipe(dest("../../build/source/runtime/tmp"));
}

function copyConfig(cb) {
    if (buildTarget === TARGET_DEV) { // default is DEV - no need to do anything
        cb();
    } else {
        return src(["../../src/config/*." + buildTarget + ".php"], {
            base: "../../src/",
        })
            .pipe(
                rename((filePath) => {
                    filePath.basename = filePath.basename.replace(/\..*$/, "");
                    console.log("copy : " + filePath.basename);
                })
            )
            .pipe(
                dest("build/source", {
                    cwd: workingDir,
                })
            );
    }
}

function zipSource() {
    return src(["build/source/**"], { cwd: workingDir })
        .pipe(chmod(0o755, 0o755))
        .pipe(zip("source-"+ buildTarget + "-" + pkg.version + ".zip"))
        .pipe(dest("build/zip", { cwd: workingDir }));
}

exports.copySource = copySource;
exports.cleanSource = cleanSource;
exports.zipSource = zipSource;
exports.copyConfig = copyConfig;
exports.updateIndex = updateIndex;
exports.createRuntimeFolders = createRuntimeFolders;

exports.buildSource = series(
    cleanSource,
    copySource,
    createRuntimeFolders,
    copyConfig,
    preserveEmptyfolders,
    updateIndex
);
