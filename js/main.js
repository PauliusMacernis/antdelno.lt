$(document).ready(function () {
    closeAllDIVs();
    $("#content_thanks").delay(2).fadeIn(400);
    $("a.uploaded_image").colorbox({rel: 'uploaded_image', scalePhotos: true, width: "75%", height: "75%"});
});
function closeAllDIVs() {
    $("#content_intro").hide();
    $("#content_questions_answers").hide();
    $("#content_video").hide();
    $("#content_messages").hide();
    $("#content_thanks").hide();
}
function showOrHideOldMessages() {
    if (document.getElementById("show_old_messages").checked) {
        $("li.old_message").show();
    } else {
        $("li.old_message").hide();
    }
    return false;
}
function submitComment() {
    $("div#info_message").show();
    $("div#info_message").html('Jūsų žinutė yra siunčiama, palaukite kol siuntimas bus baigtas.<br />Jeigu kartu su žinute siunčiate daug bylų (pvz. nuotraukų ar kt.), tuomet siuntimas gali užtrukti keletą minučių.<br />Šis pranešimas pradings automatiškai, kai žinutė baigs siųstis.<br /><br /><img src="/images/loading.gif" alt="..." title="Vyksta siuntimas..." />');
    $("form#form_comment").hide();
    document.getElementById("form_comment").submit();
}