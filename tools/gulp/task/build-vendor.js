const { series, src, dest } = require('gulp');
const exec = require('child_process').exec;
const del = require('del');
const zip = require('gulp-zip');
const path = require('path');
const workingDir = path.join(__dirname, "..", "..", "..");

function cleanComposer() {
    return del('build/composer/**', { force: true, cwd: workingDir});
}

function copyComposer() {
    return src(
        [
            'src/composer.lock',
            'src/composer.json'   
        ], 
        { 
            cwd: workingDir 
        }
    ).pipe(
        dest('build/composer' ,
        {
            cwd: workingDir, 
        })
    );
}

function composerInstall() {
    return new Promise((resolve, reject) => {
        const composerPath =  path.join(workingDir, 'tools/composer');

        const composer = exec(`php ${composerPath} install --no-dev --prefer-dist`,
            {
                cwd: path.join(workingDir, 'build', 'composer')
            });
        composer.stdout.on('data', (data) => {
            console.log(data.toString().replace(/(\n|\r)+$/, ''));
        });
        // note that composer output messages to stderr
        // see https://github.com/composer/composer/issues/3795
        composer.stderr.on('data', (data) => {
            console.log(data.toString().replace(/(\n|\r)+$/, ''));
        });
        composer.stdout.on('data', (data) => {
            console.log(data.toString().replace(/(\n|\r)+$/, ''));
        });

        composer.on('exit', (code) => {
            if (code == 0) {
                resolve(true);
            } else {
                reject(`composer install failed - exit code = ${code}`);
            }
        });
    });
}

function zipVendor() {
    return src(
        [
            'build/composer/vendor/**'
        ],
        {
            cwd: workingDir
        })
    .pipe(zip('vendor.zip'))
    .pipe(dest('build/zip', {cwd: workingDir}));
}


exports.copyComposer = copyComposer;
exports.composerInstall = composerInstall;
exports.cleanComposer = cleanComposer;
exports.zipVendor = zipVendor;
exports.buildVendor = series(cleanComposer, copyComposer, composerInstall);