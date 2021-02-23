const searchInput = document.querySelector(".inputChamp");

searchInput.addEventListener("keyup", e => {
    // Le code 13 représente la touche Entrée
    if (e.keyCode === 13) {
      // Annuler le potentiel comportement par défaut
      e.preventDefault();
      // Envoi de l'utilisateur vers la page de recherche avec le paramètre GET
      document.location.href=`/projet_cyberpunk/search.php?q=${e.target.value}`;
    }
});

console.log("hello");