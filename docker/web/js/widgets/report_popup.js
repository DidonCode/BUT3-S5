const reportPopup = document.getElementById('report-popup');
const reportPopupClose = document.getElementById('report-popup-close');

const reportTitle = document.getElementById('report-title');

const reportTypes = document.getElementsByName('report-type');
const reportOtherContainer = document.getElementById('report-other-container');
const reportOtherContent = document.getElementById('report-other-content');

const reportSubmit = document.getElementById('report-submit');
const reportForm = document.getElementById('report-form');

function makeReportPopup(callback){
	reportPopup.style.display = 'block';
	reportOtherContent.value = "";
	reportOtherContainer.setAttribute("hidden", "");
	reportTypes[0].checked = true;

	reportPopupClose.onclick = function() {
		reportPopup.style.display = 'none';
	}

	for(let i = 0; i < reportTypes.length; i++){
		reportTypes[i].onchange = function() {
			reportOtherContainer.setAttribute("hidden", "");
			if(reportTypes[i].id === 'report-other') reportOtherContainer.removeAttribute("hidden");
		}
	}

	reportForm.onsubmit = function (e) {
		e.preventDefault();

		reportPopup.style.display = 'none';

		for(let i = 0; i < reportTypes.length; i++){
			if(reportTypes[i].checked){
				if(reportTypes[i].id === 'report-other') {
					callback(reportOtherContent.value);
				}else{
					callback(reportTypes[i].value);
				}
			}
		}
	}
}