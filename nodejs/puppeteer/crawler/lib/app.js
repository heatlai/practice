require('dotenv').config();

module.exports = {
    rootDir: `${__dirname}/..`,
    thisEnv: process.env.NODE_ENV,
    authenticate: {
        user: null,
        pass: null,
    },
    launchOptions: {
        headless: true,
        ignoreHTTPSErrors: true,
        args: ['--no-sandbox']
    },
};
