/* jshint node:true */
//https://github.com/kswedberg/grunt-version
module.exports = {
    options: {
        pkg: {
            version: '<%= package.version %>'
        }
    },
    project: {
        src: [
            'package.json'
        ]
    },
    style: {
        options: {
            prefix: 'Version\\:\\s'
        },
        src: [
            'index.php',
            'css/frontend.css',
        ]
    },
    functions: {
        options: {
            prefix: 'INTERGEO_VERSION\'\,\\s+\''
        },
        src: [
            'index.php',
        ]
    }
};