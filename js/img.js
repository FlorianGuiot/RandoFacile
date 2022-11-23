

function openImg(lienImg,libelleProd){


    $('#modal_vide_large').modal('show');
    $("#titre_modal_large").html(libelleProd);
    $("#contenu_modal_large").html("<img class='img-fluid' src='"+lienImg+"'>");

}