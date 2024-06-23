document.addEventListener("DOMContentLoaded", function() {
    const albumsList = document.getElementById('top-albums-list');
    const apiAlbumsUrl = albumsList.getAttribute('data-api-albums-url');
    const apiAlbumUrlTemplate = albumsList.getAttribute('data-api-album-url');

    function fetchData(url) {
        return fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Erreur HTTP ${response.status} - ${response.statusText}`);
                }
                return response.json();
            })
            .catch(error => {
                console.error(`Erreur avec la récupération de ${url} :`, error);
            });
    }

    function topAlbums() {
        return fetchData(apiAlbumsUrl).then(data => data.data); // Extract albums data
    }

    function album(albumID) {
        const apiAlbumUrl = apiAlbumUrlTemplate.replace('1', albumID);
        return fetchData(apiAlbumUrl).then(data => data); // Extract album details
    }

    topAlbums().then(albums => {
        if (albums) {
            albumsList.innerHTML = ''; // Clear previous elements
            albums.forEach(albums => {
                album(albums.id).then(data => {
                    const li = document.createElement('li');
                    const img = document.createElement('img');
                    img.src = albums.artist.picture_small;
                    img.alt = 'Photo de '+albums.artist.name;
                    const textContainer = document.createElement('p');
                    textContainer.classList.add('album-info');
                    li.appendChild(img);
                    let releaseDate = data.release_date;
                    let [year, month, day] = releaseDate.split('-');
                    let formattedDaterelease = day+'/'+month+'/'+year;
                    textContainer.textContent = "Artiste : " + albums.artist.name + " - Album : " + albums.title + " - Date de sortie : " +formattedDaterelease;
                    li.appendChild(textContainer);
                    albumsList.appendChild(li);
                }).catch(error => {
                    console.error('Erreur avec la récupération des informations de l\'album ' + album.title, error);
                });
            });
        }
    }).catch(error => {
        console.error('Erreur avec la récupération des albums :', error);
    });
});