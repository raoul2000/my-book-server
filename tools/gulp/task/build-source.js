const { src, dest, series } = require("gulp");
const rename = require("gulp-rename");
const del = require("del");
const zip = require("gulp-zip");
const fs = require("fs");
const path = require("path");
const chmod = require('gulp-chmod');

const workingDir = path.join(__dirname, "..", "..", "..");

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
    var pkg = JSON.parse(fs.readFileSync(path.join(workingDir, "package.json")));

    return new Promise((resolve, reject) => {
        const filepath = path.join(workingDir,"build/source/web/index.php");
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
        const filepath = path.join(workingDir,"build/source/web/assets/keep");
        fs.writeFile(filepath, 'keep this folder', (err) => {
            if (err) {
                reject(err);
            } else {
                resolve(true);
            }
        });
    });
}
function cleanSource() {
    return del("build/source/**", { force: true, cwd: workingDir});
}

function copySource() {
    return src(
        [
            "src/**", 
            "!src/README.md", 
            "!src/LICENSE.md", 
            "!src/requirement.php", 
            "!src/*.yml", 
            "!src/composer.*", 
            "!src/runtime/*/**",
            "!src/vendor/**/**",
            "!src/web/assets/*/**",
            "!src/web/index-test.php",
        ],
        { cwd: workingDir }
    ).pipe(
        dest("build/source", {
            cwd: workingDir,
        })
    );
};

/**
 * Example on how to create an empty folder in build
 */
function createSourceFolders() {
    return src("*.*", { read: false })
        .pipe(dest("../../build/src/runtime"))
        .pipe(dest("../../build/src/runtime/cache"))
        .pipe(dest("../../build/src/runtime/logs"));
}


function copyConfig() {
    return src(
        [
            "../../src/config/**",
            "!../../src/config/db.php", // ignore DB params
        ],
        { base: "../../src/" }
    )
        .pipe(
            rename((filePath) => {
                if (filePath.basename.endsWith(".prod")) {
                    console.log(
                        `   renaming PROD file : ${filePath.basename}${filePath.extname}`
                    );
                    filePath.basename = filePath.basename.replace(/\.prod$/, "");
                }
            })
        )
        .pipe(dest("../../build/src"));
}

function zipSource() {
    return src(["build/source/**"], {cwd: workingDir})
        .pipe(chmod(0o755, 0o755))
        .pipe(zip("source.zip"))
        .pipe(dest("build/zip", {cwd: workingDir}));
}

exports.copySource = copySource;
exports.cleanSource = cleanSource;
exports.zipSource = zipSource;
exports.copyConfig = copyConfig;
exports.updateIndex = updateIndex;

exports.buildSource = series(cleanSource, copySource, preserveEmptyfolders,  updateIndex);
