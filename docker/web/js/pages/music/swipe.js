(() => {
	const firstSong = document.getElementById('first-song');
	const dislikeBtn = document.getElementById('dislike-swipe');
	const likeBtn = document.getElementById('like-swipe');

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
		} else {
			firstSong.classList.remove('liked-song');
			firstSong.classList.add('unliked-song');
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
})();
