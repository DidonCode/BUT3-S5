(() => {
	const firstSong = document.getElementById('first-song');
	const dislikeBtn = document.getElementById('dislike-swipe');
	const likeBtn = document.getElementById('like-swipe');
    const popupConfirmation = document.getElementById('add-to-swipe-playlist-confirmation');
    const closeConfirmation = document.getElementById('close-confirmation');
    const secondSong = document.getElementById('second-song')
    // Bouton de test de confirmation d'ajout d'une musique à la playlist Swipe
    const testBtn = document.getElementById('test-popup');

	/*
    <div id="caca">
        <img src="${data.image}"></img>
    </div>

    async function sounds() {
        let soundsFormData = new FormData();

        soundsFormData.append('type','sounds')
        soundsFormData.append('token', token)
        await apiCall("api/user/activity", soundsFormData, async function(data) {
            if(data != "") {
                const parsedData = JSON.parse(data);

                if(parsedData != null){
                    if(parsedData['error'] != undefined) {
                        routeError(parsedData['error']);
                        return;
                    } else {
                        if(parsedData.lenth == 0) return;

                        document.createElement("caca")
                    }
                }
            }
        })
    }
        */

	function remove(isLiked) {
		// Prends un boolean qui est soit gauche ou droite ce qui adapte l'animation.

		if (isLiked) {
			firstSong.classList.remove('unliked-song');
			firstSong.classList.add('liked-song');
            secondSong.classList.remove('appear-to-right');
			secondSong.classList.add('appear-to-left');
		} else {
			firstSong.classList.remove('liked-song');
			firstSong.classList.add('unliked-song');
            secondSong.classList.remove('appear-to-left');
			secondSong.classList.add('appear-to-right');
			// ajoute à la playlist "Matched"
			// Affiche une alert pour préciser à l'utilisateur qu'elle a été envoyé dans la playlist "Matched"
		}
		// element.remove() pour supprimer la carte actuelle
	}

	dislikeBtn.onclick = function () {
		remove(0);
	};

	likeBtn.onclick = function () {
		remove(1);
	};

    testBtn.onclick = function () {
        popupConfirmation.style.display = 'block';
        setTimeout(hideConfirmation, 5000);
    }

    closeConfirmation.onclick = function () {
        hideConfirmation();
    }

    function hideConfirmation() {
        popupConfirmation.style.display = 'none';
    }
    
})();
