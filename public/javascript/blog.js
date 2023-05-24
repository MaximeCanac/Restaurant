// créer un formulaire
const form = document.getElementById('myForm');

form.addEventListener('submit', (event) => {
  event.preventDefault();

  const name = document.getElementById('name').value;
  const message = document.getElementById('message').value;


// enregister le formulaire dans la base de donnée post

  const form = document.getElementById('myForm');

form.addEventListener('submit', (event) => {
  event.preventDefault();

  const name = document.getElementById('name').value;
  const message = document.getElementById('message').value;

  // Envoie une requête POST à la route correspondante
  fetch('/my-form', {
    method: 'POST',
    body: JSON.stringify({ name, email, message })
  })
  .then(response => {
    // Rediriger l'utilisateur vers une page de confirmation
    window.location.href = '/confirmation';
  })
  .catch(error => {
    console.error(error);
  });
});
  
  // Faites quelque chose avec les données du formulaire (par exemple, les envoyer à un serveur)
});

const articles = [
    {
      title: 'Article 1',
      body: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas tincidunt.'
    },
    {
      title: 'Article 2',
      body: 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.'
    },
    {
      title: 'Article 3',
      body: 'Donec nec ligula in nulla dapibus fringilla ac euismod nisi.'
    }
  ];
  
  //récuperer et afficher les information de la base de donnée post
  articles.forEach(article => {
    const articleElement = document.createElement('div');
    articleElement.classList.add('article');
  
    const titleElement = document.createElement('h2');
    titleElement.textContent = article.title;
  
    const bodyElement = document.createElement('p');
    bodyElement.textContent = article.body;
  
    articleElement.appendChild(titleElement);
    articleElement.appendChild(bodyElement);
  
    // Ajoute l'article à la page
    document.getElementById('articles').appendChild(articleElement);
  });
  

  