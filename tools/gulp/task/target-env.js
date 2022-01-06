const TARGET_DEV = "dev";
const TARGET_PROD = "prod";
const TARGET_QA = "qa";
const TARGET_DEFAULT = TARGET_DEV;

const targetEnv = process.env.NODE_ENV || TARGET_DEFAULT;

if( [TARGET_DEV, TARGET_QA, TARGET_PROD].indexOf(targetEnv) === -1) {
    throw new Error('invalid build target : ' + targetEnv);

}
exports.buildTarget = targetEnv;
exports.TARGET_DEV = TARGET_DEV;
exports.TARGET_QA = TARGET_QA;
exports.TARGET_PROD = TARGET_PROD;