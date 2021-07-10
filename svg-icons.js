const fs = require('fs');
const watch = require('node-watch');
const webfontsGenerator = require('webfonts-generator');

const iconsFolder = 'resources/svg-icons';
let isWatch = false;

const getFiles = () => {
    const svgFilesDestinations = [];
    fs.readdirSync(iconsFolder).forEach(file => {
        if (!file.includes('.svg')) {
            return;
        }
        svgFilesDestinations.push(iconsFolder + '/' + file);
    });

    return svgFilesDestinations;
};

const generateWebfonts = () => {
    console.log('\x1b[33m%s\x1b[0m', 'Generate webfonts');
    webfontsGenerator({
        files: getFiles(),
        dest: 'public/assets/svg-font-icons',
        cssFontsUrl: '/assets/svg-font-icons',
        cssDest: 'resources/scss/components/_icon.scss',
        fontName: 'svg-font-icons',
        cssTemplate: 'resources/svg-icons/svg-fonts-template.hbs',
        html: false,
        templateOptions: {
            classPrefix: 'icon--',
            baseSelector: '.icon'
        }
    });
};

process.argv.forEach(function (val, index, array) {
    if (val === '--watch') {
        isWatch = true;
    }
})

if (isWatch) {
    watch(iconsFolder, {recursive: false}, function (evt, name) {
        generateWebfonts();
    });
}

generateWebfonts();
