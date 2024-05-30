<?php include('./includes/header.inc.php');
include('./includes/side_profile.inc.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecture Cours</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<div style="display:flex;flex-direction:row; column-gap:2%;position:fixed;align-items:center;margin-top:30%;z-index:100000000000000">
<center>
    <div class="center_div" style="margin-left:5%">
                                 
        <button class="btn delete-btn"onclick="quitReading()">Quitter la lecture</button>

    </div>
    <div class="center_div" style="margin-left:5%">
                                            
        <button class="btn main-btn"onclick="nextPage()"><- </button>

    </div>
    <div class="center_div" style="margin-left:5%">
                                            
        <button class="btn main-btn" onclick="previousPage()">-></button>

    </div>
</center>

</div>
<div id="pdfContainer" style="margin-left:25%"></div>
<!-- Pour la bibliotheque pdf.js qui permettra la lecture personnalisee sans option de telechargement-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.js"></script>

<script>
    // Fonctions pour naviguer entre les pages
    let currentPage;

    function nextPage() {
        if (currentPage < document.getElementById('pdfContainer').childElementCount) {
            currentPage++;
            updateVisibility();
        }
    }

    function previousPage() {
        if (currentPage > 1) {
            currentPage--;
            updateVisibility();
        }
    }

    function updateVisibility() {
        let pages = document.getElementById('pdfContainer').children;
        for (let i = 0; i < pages.length; i++) {
            if (i + 1 === currentPage) {
                pages[i].style.display = 'block';
            } else {
                pages[i].style.display = 'none';
            }
        }
    }

    // Charge le fichier PDF
    const urlParams = new URLSearchParams(window.location.search);
    const contenu = urlParams.get('contenu');

    // Construire le chemin vers le fichier PDF en fonction du nom du contenu
    const pdfPath = `./ressources_cours/${contenu}`;

    // Charger le fichier PDF
    pdfjsLib.getDocument(pdfPath).promise.then(function(pdf) {
        // Initialise currentPage à 1 pour afficher la première page par défaut
        currentPage = 1;

        // Boucle à travers chaque page du PDF
        for (let pageNumber = 1; pageNumber <= pdf.numPages; pageNumber++) {
            // Récupère la page
            pdf.getPage(pageNumber).then(function(page) {
                // Crée un canvas pour convertir la page en image
                let canvas = document.createElement('canvas');
                let context = canvas.getContext('2d');
                let viewport = page.getViewport({scale: 1.5});
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                // Convertit la page en image
                page.render({
                    canvasContext: context,
                    viewport: viewport
                }).promise.then(function() {
                    // Ajoute l'image au conteneur
                    document.getElementById('pdfContainer').appendChild(canvas);

                    // Cache toutes les pages sauf la première au début
                    if (pageNumber !== currentPage) {
                        canvas.style.display = 'none';
                    }
                });
            });
        }
    });

    // Fonction pour quitter la lecture
    function quitReading() {
        // Redirection vers une autre page
        window.location.href = document.referrer;

        // Fermeture de l'onglet ou de la fenêtre
        window.close();
    }
</script>

</body>
</html>