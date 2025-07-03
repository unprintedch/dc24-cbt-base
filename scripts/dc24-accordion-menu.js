// Accordéon pour les menus WordPress
document.addEventListener("DOMContentLoaded", function () {
    
    // Fonction pour gérer l'accordéon des sous-menus
    function initAccordion() {
        const menuItemsWithChildren = document.querySelectorAll('#offcanvas-menu .menu-item-has-children > a');
        
        menuItemsWithChildren.forEach(item => {
            item.addEventListener('click', function(e) {
                // Trouver le bon élément parent (li)
                const menuItem = this.closest('.menu-item');
                const subMenu = menuItem.querySelector('.sub-menu');
                const linkUrl = this.getAttribute('href');
                
                // Vérifier si le clic est sur l'icône (::after) ou sur le texte
                const rect = this.getBoundingClientRect();
                const clickX = e.clientX - rect.left;
                const textWidth = this.querySelector('span') ? this.querySelector('span').offsetWidth : this.offsetWidth;
                const isClickingOnIcon = clickX > textWidth + 10; // 10px de marge
                
                // Si le lien pointe vers une vraie URL (pas # ou vide)
                if (linkUrl && linkUrl !== '#' && linkUrl !== '') {
                    if (isClickingOnIcon) {
                        // Si on clique sur l'icône, empêcher la navigation et toggle l'accordéon
                        e.preventDefault();
                        
                        // Fermer tous les autres accordéons
                        const allOpenItems = document.querySelectorAll('#offcanvas-menu .menu-item-has-children.accordion-open');
                        allOpenItems.forEach(openItem => {
                            if (openItem !== menuItem) {
                                openItem.classList.remove('accordion-open');
                                const openSubMenu = openItem.querySelector('.sub-menu');
                                if (openSubMenu) {
                                    openSubMenu.classList.remove('accordion-open');
                                }
                            }
                        });
                        
                        // Toggle l'accordéon actuel
                        if (menuItem.classList.contains('accordion-open')) {
                            menuItem.classList.remove('accordion-open');
                            if (subMenu) {
                                subMenu.classList.remove('accordion-open');
                            }
                        } else {
                            menuItem.classList.add('accordion-open');
                            if (subMenu) {
                                subMenu.classList.add('accordion-open');
                            }
                        }
                    } else {
                        // Si on clique sur le texte, permettre la navigation normale
                        // Pas de prévention du comportement par défaut
                    }
                } else {
                    // Si pas de vrai lien, empêcher la navigation par défaut et toggle l'accordéon
                    e.preventDefault();
                    
                    // Fermer tous les autres accordéons
                    const allOpenItems = document.querySelectorAll('#offcanvas-menu .menu-item-has-children.accordion-open');
                    allOpenItems.forEach(openItem => {
                        if (openItem !== menuItem) {
                            openItem.classList.remove('accordion-open');
                            const openSubMenu = openItem.querySelector('.sub-menu');
                            if (openSubMenu) {
                                openSubMenu.classList.remove('accordion-open');
                            }
                        }
                    });
                    
                    // Toggle l'accordéon actuel
                    if (menuItem.classList.contains('accordion-open')) {
                        menuItem.classList.remove('accordion-open');
                        if (subMenu) {
                            subMenu.classList.remove('accordion-open');
                        }
                    } else {
                        menuItem.classList.add('accordion-open');
                        if (subMenu) {
                            subMenu.classList.add('accordion-open');
                        }
                    }
                }
            });
        });
    }

    // Initialiser l'accordéon au chargement
    initAccordion();
    
    // Réinitialiser l'accordéon quand l'off-canvas s'ouvre
    const offCanvas = document.getElementById("offcanvas");
    if (offCanvas) {
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    if (!offCanvas.classList.contains("-right-[500px]")) {
                        setTimeout(initAccordion, 100);
                    }
                }
            });
        });

        observer.observe(offCanvas, {
            attributes: true,
            attributeFilter: ['class']
        });
    }
}); 