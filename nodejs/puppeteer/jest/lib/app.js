require('dotenv').config();

module.exports = {
    rootDir: `${__dirname}/..`,
    thisEnv: process.env.NODE_ENV,
    authenticate: {
        username: null,
        password: null,
    },
    launchOptions: {
        headless: true,
        ignoreHTTPSErrors: true,
        args: ['--no-sandbox']
    },
};
