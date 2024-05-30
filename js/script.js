let toggleBtn = document.getElementById('toggle-btn');
let body = document.body;
let darkMode = localStorage.getItem('dark-mode');

const enableDarkMode = () =>{
   toggleBtn.classList.replace('fa-sun', 'fa-moon');
   body.classList.add('dark');
   localStorage.setItem('dark-mode', 'enabled');
}

const disableDarkMode = () =>{
   toggleBtn.classList.replace('fa-moon', 'fa-sun');
   body.classList.remove('dark');
   localStorage.setItem('dark-mode', 'disabled');
}

if(darkMode === 'enabled'){
   enableDarkMode();
}

toggleBtn.onclick = (e) =>{
   darkMode = localStorage.getItem('dark-mode');
   if(darkMode === 'disabled'){
      enableDarkMode();
   }else{
      disableDarkMode();
   }
}

let profile = document.querySelector('.header .flex .profile');

document.querySelector('#user-btn').onclick = () =>{
   profile.classList.toggle('active');
   search.classList.remove('active');
}

let search = document.querySelector('.header .flex .search-form');

document.querySelector('#search-btn').onclick = () =>{
   search.classList.toggle('active');
   profile.classList.remove('active');
}

let sideBar = document.querySelector('.side-bar');

document.querySelector('#menu-btn').onclick = () =>{
   sideBar.classList.toggle('active');
   body.classList.toggle('active');
}

document.querySelector('#close-btn').onclick = () =>{
   sideBar.classList.remove('active');
   body.classList.remove('active');
}

window.onscroll = () =>{
   profile.classList.remove('active');
   search.classList.remove('active');

   if(window.innerWidth < 1200){
      sideBar.classList.remove('active');
      body.classList.remove('active');
   }
}
// Définition de la fonction pour basculer les listes déroulantes
document.addEventListener('DOMContentLoaded', function() {
   toggleDropdowns();
});

function toggleDropdowns() {
   const toggleButtons = document.querySelectorAll('.toggle-dropdown');

   toggleButtons.forEach(button => {
       button.addEventListener('click', function() {
           const dropdownList = this.parentElement.parentElement.nextElementSibling;
           const chapitres = JSON.parse(this.getAttribute('data-chapitres'));

           // Effacer le contenu actuel de la liste déroulante
           dropdownList.innerHTML = '';

           // Vérifier s'il y a des chapitres disponibles
           if (chapitres.length === 0) {
               const messageElement = document.createElement('div');
               messageElement.textContent = 'Aucun élément disponible pour ce cours.';
               dropdownList.appendChild(messageElement);
           } else {
               // Ajouter les chapitres à la liste déroulante
               chapitres.forEach(chapitre => {
                   const chapitreElement = document.createElement('div');
                   chapitreElement.textContent = chapitre.contenu;
                   dropdownList.appendChild(chapitreElement);
               });
           }

           dropdownList.classList.toggle('visible');
       });
   });
}
function confirmDesinscription(idCours) {
   if (confirm("Êtes-vous sûr de vouloir vous désinscrire de ce cours?")) {
      window.location.href = "process/process_desinscription.php?id_cours=" + idCours;
   } else {
      // L'utilisateur a annulé la désinscription, vous pouvez ajouter un traitement supplémentaire ici si nécessaire
   }
}
function toggleDropdowns() {
   const toggleButtons = document.querySelectorAll('.toggle-dropdown');

   toggleButtons.forEach(button => {
       button.addEventListener('click', function() {
           const dropdownList = this.parentElement.parentElement.nextElementSibling;
           const chapitres = JSON.parse(this.getAttribute('data-chapitres'));

           // Effacer le contenu actuel de la liste déroulante
           dropdownList.innerHTML = '';

           // Vérifier s'il y a des chapitres disponibles
           if (chapitres.length === 0) {
               const messageElement = document.createElement('div');
               messageElement.textContent = 'Aucun élément disponible pour ce cours.';
               dropdownList.appendChild(messageElement);
           } else {
               // Ajouter les chapitres à la liste déroulante
               chapitres.forEach(chapitre => {
                   const chapitreElement = document.createElement('div');
                   chapitreElement.textContent = chapitre.contenu;
                   dropdownList.appendChild(chapitreElement);
               });
           }

           dropdownList.classList.toggle('visible');
       });
   });
}

function toggleUnderline(button) {
   let productButtons = document.querySelectorAll('button.productimg');
   productButtons.forEach(btn => {
       if (btn !== button) {
           btn.classList.remove('underline');
       }
   });
   button.classList.toggle('underline');
}
function closeDetails() {
   // Supprimer ou unset le paramètre 'details' de l'URL
   var url = window.location.href.split('?')[0]; // Obtenir l'URL sans les paramètres
   window.location.href = url; // Rediriger vers l'URL sans le paramètre 'details'
}
function markAllAsRead() {
   // Make an AJAX request to update the message status
   var xhr = new XMLHttpRequest();
   xhr.open('POST', '/etudiants_messages.php', true);
   xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
   // Send additional data to indicate the action
   var formData = new FormData();
   formData.append('action', 'markAllAsRead');
   xhr.send(formData);
}
/*----------------------------- ADMIN FUNCTIONS ---------------------------- */
function search_bar(entree){
   var xhr= new XMLHttpRequest();
   xhr.open("POST","search.php",true);
   xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
   xhr.onreadystatechange = function () {
   if (xhr.readyState === XMLHttpRequest.DONE) {
       if (xhr.status === 200) {
           // La requête a réussi, nous recevons la réponse de la requête ici
           // Mettre à jour la dropdown-search-bar avec les résultats de la recherche
           document.getElementById("searchResults").innerHTML = xhr.responseText;
       } else {
           console.error("Erreur lors de la requête : " + xhr.status);
       }
   }
};
   var params ="data=" + encodeURIComponent(entree); 
   xhr.send(params);
}
function afficherContenuMessage(contenu, id) {
   // Mettez à jour le contenu de la popup avec le contenu du message
   document.getElementById('contenuMessage').innerText = contenu;
   // Affichez la popup
   document.getElementById('affichage').style.display = 'flex';

   document.getElementById('id').innerText = id;
   document.getElementById('id').value = id;

}
function markAsRead(id) {
   var xhr = new XMLHttpRequest();
   xhr.open('GET', '../etudiants_messages.php?action=markAsRead&message_id=' + id, true);
   
   xhr.send();
}
function prepareMsg() {
   var contenu = document.getElementById('contenu').value;
   document.getElementById('contenuMsg').value = contenu;
}
