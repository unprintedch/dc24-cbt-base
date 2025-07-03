const fs = require('fs');
const path = require('path');

// Fonction pour générer les fonts (intégrée directement)
function generateFonts() {
  try {
    console.log('🔄 Regénération des fonts...');
    
    // Code de génération intégré (copié de generate-fonts.js)
    const themeJsonPath = path.join(__dirname, '../theme.json');
    const fontsCssPath = path.join(__dirname, '../css/fonts.css');
    
    const themeJson = JSON.parse(fs.readFileSync(themeJsonPath, 'utf8'));
    const elements = themeJson.styles.elements;

    // Fonction pour convertir la syntaxe WordPress en variables CSS
    function convertWordPressVar(value) {
        if (typeof value === 'string' && value.startsWith('var:preset|')) {
            return value.replace('var:preset|', 'var(--wp--preset--').replace(/\|/g, '--') + ')';
        }
        return value;
    }

    // Fonction pour obtenir la couleur d'un élément depuis styles.elements
    function getElementColor(elements, element) {
        if (
            elements[element] &&
            elements[element].color &&
            elements[element].color.text
        ) {
            return convertWordPressVar(elements[element].color.text);
        }
        return '#000000';
    }

    // Générer CSS
    let css = '/* ===================================\n';
    css += '   TYPOGRAPHY FROM THEME.JSON ELEMENTS\n';
    css += '   =================================== */\n\n';

    // Styles pour chaque heading et paragraphe
    ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p'].forEach(element => {
        if (elements[element] && elements[element].typography) {
            const typography = elements[element].typography;
            const spacing = elements[element].spacing || {};
            const color = getElementColor(elements, element);

            css += `/* ${element} */\n`;
            css += `${element} {\n`;

            // Typography
            if (typography.fontFamily) {
                css += `    font-family: ${convertWordPressVar(typography.fontFamily)};\n`;
            }
            if (typography.fontSize) {
                css += `    font-size: ${typography.fontSize};\n`;
            }
            if (typography.fontWeight) {
                css += `    font-weight: ${typography.fontWeight};\n`;
            }
            if (typography.lineHeight) {
                css += `    line-height: ${typography.lineHeight};\n`;
            }

            // Spacing
            if (spacing.margin) {
                if (spacing.margin.top) {
                    css += `    margin-top: ${spacing.margin.top};\n`;
                }
                if (spacing.margin.bottom) {
                    css += `    margin-bottom: ${spacing.margin.bottom};\n`;
                }
            }

            // Couleur
            css += `    color: ${color};\n`;
            css += `}\n\n`;
        }
    });

    // Body text
    const bodyColor = (elements.body && elements.body.color && elements.body.color.text)
        ? convertWordPressVar(elements.body.color.text)
        : '#000000';
    css += `/* Body text */\n`;
    css += `body {\n`;
    css += `    font-family: var(--wp--preset--font-family--display);\n`;
    css += `    font-weight: var(--wp--preset--font-weight--400);\n`;
    css += `    line-height: var(--wp--preset--line-height--normal);\n`;
    css += `    color: ${bodyColor};\n`;
    css += `}\n\n`;

    // Responsive spacing
    css += `/* Responsive spacing */\n`;
    css += `@media (max-width: 768px) {\n`;
    css += `    h1, h2, h3, h4, h5, h6, p {\n`;
    css += `        margin-bottom: 0.75rem;\n`;
    css += `    }\n`;
    css += `}\n`;

    // Écrire le fichier
    fs.writeFileSync(fontsCssPath, css);
    console.log('✅ fonts.css generated successfully from theme.json');
    
  } catch (error) {
    console.error('❌ Erreur lors de la régénération des fonts:', error.message);
  }
}

// Fonction pour surveiller le fichier
function watchThemeJson() {
  const themeJsonPath = path.join(__dirname, '../theme.json');
  
  console.log('👀 Surveillance de theme.json pour les fonts...');
  console.log(`📁 Fichier surveillé: ${themeJsonPath}`);

  // Vérifier que le fichier existe
  if (!fs.existsSync(themeJsonPath)) {
    console.error('❌ theme.json introuvable');
    return;
  }

  let lastModified = fs.statSync(themeJsonPath).mtime.getTime();
  let isProcessing = false;

  // Utiliser fs.watch avec gestion d'erreurs
  const watcher = fs.watch(themeJsonPath, (eventType, filename) => {
    if (isProcessing) return; // Éviter les doublons
    
    const currentModified = fs.statSync(themeJsonPath).mtime.getTime();
    
    // Vérifier que le fichier a vraiment changé (éviter les faux positifs)
    if (currentModified > lastModified) {
      isProcessing = true;
      lastModified = currentModified;
      
      console.log(`📝 ${filename} a changé (${eventType})`);
      
      // Petit délai pour s'assurer que le fichier est complètement écrit
      setTimeout(() => {
        generateFonts();
        isProcessing = false;
      }, 100);
    }
  });

  // Gestion des erreurs - redémarrer automatiquement
  watcher.on('error', (error) => {
    console.error('❌ Erreur de surveillance:', error.message);
    console.log('🔄 Tentative de redémarrage de la surveillance...');
    setTimeout(() => {
      watcher.close();
      watchThemeJson();
    }, 1000);
  });

  // Gestion de la fermeture propre
  process.on('SIGINT', () => {
    console.log('\n🛑 Arrêt de la surveillance des fonts...');
    watcher.close();
    process.exit(0);
  });

  // Gestion de la fermeture inattendue - redémarrer
  process.on('exit', (code) => {
    if (code !== 0) {
      console.log('🔄 Redémarrage de la surveillance...');
      setTimeout(watchThemeJson, 1000);
    }
  });

  // Générer les fonts au démarrage
  generateFonts();
}

// Démarrer la surveillance
watchThemeJson(); 