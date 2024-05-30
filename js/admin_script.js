/*----------------------------- ADMIN FUNCTIONS ---------------------------- */

/* --------------------- ADMIN TOGGLE TAB ------------------------ */
function openTab(event, tabName)
{
   let tabs = document.querySelectorAll(".ongletContent");
   let tabs_btn = document.querySelectorAll(".items-btn");
   let targetElt = (event.currentTarget.innerText === "Professeur")? document.querySelector('.listeProf') : document.querySelector('.listeEtudiant');

   //Initialisation de tous les class
   tabs.forEach((tab) => {
      tab.style.display = "none";
   });

   tabs_btn.forEach((btn)=> {
      btn.classList.remove("active-item");
   });
   
   //affichage de l'onglet voulu
    if(event.currentTarget.innerText.includes("Message")){
        let boiteRecep = document.querySelector('.boite_recep');
        event.currentTarget.innerHTML = "Message";

        const xhttp = new XMLHttpRequest(); // c'est pour créer un nouveau requête en arrière plan sans charger l'image
        xhttp.onload = function() { // et on va prendre ici le résultat du chargement de la page passé en header
            boiteRecep.innerHTML = this.response;        
        }
        xhttp.open("GET", "admin_message.php"); // on envoie ce header vers cette page
        xhttp.send(); 
   }
   else if(event.currentTarget.innerText != "Générales")
   {    
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            targetElt.innerHTML = this.response;         
        }
        xhttp.open("GET", "EnL_aDmIN/listeUser.php?role="+event.currentTarget.innerText);
        xhttp.send(); 
   }

   document.getElementById(tabName).style.display = "block";
   
   event.currentTarget.classList.add("active-item");
}

/*---------------------- SHOW A PROF'S COURSES --------------------- */
function showBoxVoir_cours(event, ...prof){
    let courseBox = document.querySelector('.coursProf');

    courseBox.style.display="none";

    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        courseBox.innerHTML = this.response;
        courseBox.style.display="block";
    }
    xhttp.open("GET", "EnL_aDmIN/profCourse.php?profId="+prof[0]+"&profName="+prof[1]+"&profImage="+prof[2]);
    xhttp.send();   

}

/*---------------------- SHOW A STUDENT'S FOLLOWED COURSES --------------------- */
function showBoxCours_Suivis(event, ...std){
    let courseBox = document.querySelector('.cours_suivis');

    courseBox.style.display="none";

    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        courseBox.innerHTML = this.response;
        courseBox.style.display="block";
    }
    xhttp.open("GET", "EnL_aDmIN/studentCourse.php?stdId="+std[0]+"&stdName="+std[1]+"&stdImage="+std[2]);
    xhttp.send();   

}
/*---------------------- SHOW CONFIRMATION BOX --------------------- */

function confirmDel(...userInfo){
    $inputId = document.querySelector('.content #userId');
    $inputRole = document.querySelector('.content #userRole');
    $spanConfirm = document.querySelector('.content span');

    $inputId.value = userInfo[0];
    $inputRole.value = userInfo[1];

    $spanConfirm.innerHTML = "Voulez-vous vraiment supprimer cet utilisateur?( "+userInfo[1]+" : "+userInfo[2]+")";

    document.querySelector(".popUp").style.display = "block";
}

function hidePopUp(){document.querySelector(".popUp").style.display = "none";}

/*---------------------- DELETE PROF --------------------- */
function delUser(userId, userRole){
    let targetElt = (userRole === "professeur")? document.querySelector('.listeProf') : document.querySelector('.listeEtudiant');
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        targetElt.innerHTML = this.response;
        let resultMsg = document.querySelector('.liste > span');
        resultMsg.style.display = "block";
        
        targetElt.nextElementSibling.nextElementSibling.style.display = "none";

        setTimeout(()=>{
            resultMsg.innerHTML = "";
            resultMsg.style.display = "none";
        },7000);
    }
    xhttp.open("GET", "EnL_aDmIN/deleteUser.php?id="+userId+"&role="+userRole);
    xhttp.send(); 

    hidePopUp();
}

function open_readMessage(IdExp, dateEnvoie, contenu){
    let boiteRecep = document.querySelector('.boite_recep');

    //get rid of the strong when message is read
    const xhttpUpdate = new XMLHttpRequest();
    xhttpUpdate.onload = function() {
        boiteRecep.innerHTML = this.response;        
    }
    xhttpUpdate.open("GET", "admin_message.php");
    xhttpUpdate.send();

    //sending the message content
    const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            let msg_content = document.querySelector('.msg_content');
            msg_content.innerHTML = this.response;  
            msg_content.style.display = "block";
            console.log(this.response);      
        }
        xhttp.open("GET", "EnL_aDmIN/showMessageContent.php?idExp="+IdExp+"&date_envoie="+dateEnvoie+"&contenu="+contenu);
        xhttp.send(); 
}

//update the property "est_lu"
function update_est_lu(msgId){

    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        console.log("Message lu...");       
    }
    xhttp.open("GET", "process/process_update_message.php?id="+msgId);
    xhttp.send();
}