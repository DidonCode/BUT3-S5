<div id="report-popup" class="modal" role="dialog">
    <div class="modal-dialog bg-transparent">
        <div class="modal-content">
            <div class="modal-header border-0 primary">
                <h4 id="report-title" class="modal-title contrast-text">Êtes vous sûr de vouloir signaler :</h4>
                <button id="report-popup-close" type="button" class="close my-auto"><i class="fa-solid fa-xmark contrast-text"></i></button>
            </div>
            
            <form id="report-form">  
                <div class="modal-body secondary"> 
                    <div class="mb-3">
                        <h6 class="contrast-text">Raison du signalement :</h6> 
                        <div class="d-flex flex-column mx-auto">
                            <label class="checkWrap">
                                <span class="check-label contrast-text">Nom déplacé ou à connotation négative</span>
                                <input name="report-type" type="radio" value="Nom déplacé ou à connotation négative" hidden>
                                <span class="checkmark"></span>
                            </label>
                            <label class="checkWrap">
                                <span class="check-label contrast-text">Musique dégradante</span>
                                <input name="report-type" type="radio" value="Musique dégradante" hidden>
                                <span class="checkmark"></span>
                            </label>
                            <label class="checkWrap">
                                <span class="check-label contrast-text">Description méchante</span>
                                <input name="report-type" type="radio" value="Description méchante" hidden>
                                <span class="checkmark"></span>
                            </label>
                            <label class="checkWrap">
                                <span class="check-label contrast-text">Autre</span>
                                <input id="report-other" name="report-type" type="radio" value="Autre" hidden>
                                <span class="checkmark"></span>
                            </label>
                        </div> 
                    </div>

                    <div class="mt-3" id="report-other-container" hidden>
                        <h6 class="contrast-text">Raison du signalement :</h6> 
                        <div class="textArea mb-3" id="report-comment">
                            <textarea class="form-control" id="report-other-content" placeholder="Entrer la raison du signalement"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 primary">
                    <button id="report-submit" type="submit" class="btn action clRounded1 clBtnGrad mx-auto">Signaler</button>
                </div>
            </form>
        </div>
    </div>
</div>