const { series, src, dest } = require('gulp');
const del = require('del');
const path = require('path');
const workingDir = path.join(__dirname, "..", "..", "..");

/**
 * Delete the content of the folder ./build/src/vendor
 */
function cleanSourceVendor() {
    return del('build/source/vendor/**/**', { force: true, cwd: workingDir});
}

/**
 * Copy all vendors files previously created into ./build/src/vendor
 * Prior to this task, the task buildVendor should have been executed
 */
function mergeSourceVendor() {
    return src(
        [
            'build/composer/vendor/**'
        ], 
        { 
            cwd: workingDir 
        })
        .pipe(dest('build/source/vendor', {cwd: workingDir}));
}

exports.cleanSourceVendor = cleanSourceVendor;
exports.mergeSourceVendor = mergeSourceVendor;

exports.merge = series( cleanSourceVendor, mergeSourceVendor);
