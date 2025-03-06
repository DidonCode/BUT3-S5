(() => {
	window.onload = function () {
		const reportingPopup = document.getElementById('reporting-popup');
		const closePopup = document.getElementById('close-reporting-popup');
		const openPopupBtns = document.getElementsByClassName('open-reporting-popup');
		const otherChoice = document.getElementById('other-choice');
		const reportComment = document.getElementById('report-comment');

		if (openPopupBtns != null) {
			for (let i = 0; i < openPopupBtns.length; i++) {
				openPopupBtns[i].addEventListener('click', showPopup, false);
			}

			closePopup.onclick = function () {
				hidePopup();
			};
		}

		otherChoice.onclick = function () {
			if (otherChoice.checked) {
				reportComment.removeAttribute('hidden');
			} else {
				reportComment.setAttribute('hidden', true);
			}
		};

		function hidePopup() {
			reportingPopup.style.display = 'none';
		}
		function showPopup() {
			reportingPopup.style.display = 'block';
		}
	};
})();
